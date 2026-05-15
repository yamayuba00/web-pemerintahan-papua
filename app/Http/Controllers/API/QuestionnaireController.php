<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\QuestionnaireAnswer;
use App\Models\QuestionnaireResponse;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    /**
     * List semua kuesioner aktif
     */
    public function index()
    {
        $questionnaires = Questionnaire::where('is_active', true)
            ->select('id', 'title', 'slug', 'description', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved questionnaires',
            'data' => $questionnaires,
        ]);
    }

    /**
     * Detail kuesioner + pertanyaan (untuk render form di frontend)
     */
    public function show($slug)
    {
        $questionnaire = Questionnaire::where('slug', $slug)
            ->where('is_active', true)
            ->with(['questions' => function ($q) {
                $q->orderBy('order')->select('id', 'questionnaire_id', 'question', 'type', 'options', 'is_required', 'order');
            }])
            ->first();

        if (!$questionnaire) {
            return response()->json([
                'status' => 404,
                'message' => 'Questionnaire not found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved questionnaire',
            'data' => [
                'id' => $questionnaire->id,
                'title' => $questionnaire->title,
                'slug' => $questionnaire->slug,
                'description' => $questionnaire->description,
                'questions' => $questionnaire->questions->map(function ($q) {
                    return [
                        'id' => $q->id,
                        'question' => $q->question,
                        'type' => $q->type,
                        'options' => $q->options,
                        'is_required' => $q->is_required,
                        'order' => $q->order,
                    ];
                }),
            ],
        ]);
    }

    /**
     * Submit jawaban kuesioner
     */
    public function submit(Request $request, $slug)
    {
        $questionnaire = Questionnaire::where('slug', $slug)
            ->where('is_active', true)
            ->with('questions')
            ->first();

        if (!$questionnaire) {
            return response()->json([
                'status' => 404,
                'message' => 'Questionnaire not found',
                'data' => null,
            ], 404);
        }

        $request->validate([
            'respondent_name' => 'nullable|string|max:255',
            'respondent_email' => 'nullable|email|max:255',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questionnaire_questions,id',
            'answers.*.answer' => 'nullable|string',
            'answers.*.answer_array' => 'nullable|array',
        ]);

        // Validasi required questions
        $requiredQuestionIds = $questionnaire->questions
            ->where('is_required', true)
            ->pluck('id')
            ->toArray();

        $answeredIds = collect($request->answers)->pluck('question_id')->toArray();

        foreach ($requiredQuestionIds as $requiredId) {
            if (!in_array($requiredId, $answeredIds)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Semua pertanyaan wajib harus dijawab.',
                    'data' => null,
                ], 422);
            }

            $answer = collect($request->answers)->firstWhere('question_id', $requiredId);
            if (empty($answer['answer']) && empty($answer['answer_array'])) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Semua pertanyaan wajib harus dijawab.',
                    'data' => null,
                ], 422);
            }
        }

        // Simpan response
        $response = QuestionnaireResponse::create([
            'questionnaire_id' => $questionnaire->id,
            'respondent_name' => $request->respondent_name,
            'respondent_email' => $request->respondent_email,
        ]);

        // Simpan answers
        foreach ($request->answers as $answerData) {
            QuestionnaireAnswer::create([
                'response_id' => $response->id,
                'question_id' => $answerData['question_id'],
                'answer' => $answerData['answer'] ?? null,
                'answer_array' => $answerData['answer_array'] ?? null,
            ]);
        }

        return response()->json([
            'status' => 201,
            'message' => 'Jawaban berhasil disimpan. Terima kasih!',
        ], 201);
    }

    /**
     * Statistik hasil kuesioner (public) - termasuk chart data
     * Query params: ?days=1 (default), ?days=7, ?days=30, ?days=all
     */
    public function statistics($slug)
    {
        $questionnaire = Questionnaire::where('slug', $slug)
            ->with(['questions'])
            ->first();

        if (!$questionnaire) {
            return response()->json([
                'status' => 404,
                'message' => 'Questionnaire not found',
                'data' => null,
            ], 404);
        }

        // Filter by days
        $days = request('days', 1);
        $dateFilter = null;
        if ($days !== 'all' && is_numeric($days)) {
            $dateFilter = now()->subDays((int) $days);
        }

        // Get filtered responses
        $responsesQuery = $questionnaire->responses();
        if ($dateFilter) {
            $responsesQuery->where('created_at', '>=', $dateFilter);
        }
        $responseIds = $responsesQuery->pluck('id');
        $totalResponses = $responseIds->count();

        $scoringType = $questionnaire->scoring_type ?? 'skm';
        $questions = [];
        $nrrValues = [];
        $chartData = [];

        foreach ($questionnaire->questions as $question) {
            // Filter answers by response IDs
            $answers = $question->answers()->whereIn('response_id', $responseIds)->get();

            $stat = [
                'id' => $question->id,
                'question' => $question->question,
                'type' => $question->type,
                'options' => $question->options,
                'total_answers' => $answers->count(),
                'summary' => null,
            ];

            if ($question->type === 'rating') {
                $ratings = $answers->pluck('answer')->filter()->map(fn($v) => (int) $v);
                $maxScale = $scoringType === 'skm' ? 4 : 5;
                $avg = $ratings->count() > 0 ? round($ratings->avg(), 3) : 0;
                $nrrValues[] = $avg;

                $distribution = [];
                for ($i = $maxScale; $i >= 1; $i--) {
                    $distribution[$i] = $ratings->filter(fn($v) => $v === $i)->count();
                }

                $stat['summary'] = [
                    'average' => $avg,
                    'max_scale' => $maxScale,
                    'distribution' => $distribution,
                ];

                $chartData[] = [
                    'label' => $question->question,
                    'value' => $avg,
                    'max' => $maxScale,
                ];
            } elseif (in_array($question->type, ['dropdown', 'radio'])) {
                $answerValues = $answers->pluck('answer')->filter();
                $counted = $answerValues->countBy()->sortDesc()->toArray();
                $stat['summary'] = $counted;

                $options = $question->options ?? [];
                $numericValues = $answerValues->map(function ($ans) use ($options) {
                    $idx = array_search($ans, $options);
                    return $idx !== false ? $idx + 1 : 0;
                })->filter();
                $avg = $numericValues->count() > 0 ? round($numericValues->avg(), 3) : 0;
                $nrrValues[] = $avg;

                $chartData[] = [
                    'label' => $question->question,
                    'value' => $avg,
                    'max' => count($options),
                    'distribution' => $counted,
                ];
            } elseif ($question->type === 'checkbox') {
                $allChoices = $answers->pluck('answer_array')->filter()->flatten();
                $stat['summary'] = $allChoices->countBy()->sortDesc()->toArray();
            } elseif ($question->type === 'text') {
                $stat['summary'] = $answers->pluck('answer')->filter()->values()->toArray();
            }

            $questions[] = $stat;
        }

        // Hitung IKM
        $ikm = null;
        $mutu = null;
        $ratingCount = count($nrrValues);

        if ($scoringType === 'skm' && $ratingCount > 0) {
            $bobot = 1 / $ratingCount;
            $totalNrrTertimbang = collect($nrrValues)->sum(fn($nrr) => $nrr * $bobot);
            $ikm = round($totalNrrTertimbang * 25, 2);

            if ($ikm >= 88.31) $mutu = ['grade' => 'A', 'label' => 'Sangat Baik'];
            elseif ($ikm >= 76.61) $mutu = ['grade' => 'B', 'label' => 'Baik'];
            elseif ($ikm >= 65.00) $mutu = ['grade' => 'C', 'label' => 'Kurang Baik'];
            else $mutu = ['grade' => 'D', 'label' => 'Tidak Baik'];
        } elseif ($scoringType === 'rating_5' && $ratingCount > 0) {
            $ikm = round(collect($nrrValues)->avg(), 2);
        }

        // Response per bulan (untuk chart trend)
        $trendQuery = $questionnaire->responses();
        if ($dateFilter) {
            $trendQuery->where('created_at', '>=', $dateFilter);
        }
        $responsesPerMonth = $trendQuery
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m')")
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved questionnaire statistics',
            'data' => [
                'title' => $questionnaire->title,
                'description' => $questionnaire->description,
                'scoring_type' => $scoringType,
                'total_responses' => $totalResponses,
                'filter_days' => $days,
                'ikm' => $ikm,
                'mutu' => $mutu,
                'chart' => [
                    'per_question' => $chartData,
                    'responses_per_month' => $responsesPerMonth,
                ],
                'questions' => $questions,
            ],
        ]);
    }
}
