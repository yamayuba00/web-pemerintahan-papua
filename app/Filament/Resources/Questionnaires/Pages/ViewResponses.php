<?php

namespace App\Filament\Resources\Questionnaires\Pages;

use App\Filament\Resources\Questionnaires\QuestionnaireResource;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResponse;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ViewResponses extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = QuestionnaireResource::class;

    protected string $view = 'filament.pages.questionnaire-responses';

    protected Width|string|null $maxContentWidth = Width::Full;

    public Questionnaire $record;

    public function getTitle(): string
    {
        return 'Hasil Kuesioner: ' . $this->record->title;
    }

    public function downloadCsv()
    {
        $stats = $this->getStatistics();
        $questions = $stats['question_labels'];
        $filename = 'skm-' . $this->record->slug . '-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($stats, $questions) {
            $file = fopen('php://output', 'w');

            // BOM for Excel UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Title
            fputcsv($file, ['PENGOLAHAN DATA SURVEI KEPUASAN MASYARAKAT']);
            fputcsv($file, ['Kuesioner: ' . $this->record->title]);
            fputcsv($file, []);

            // Header row
            $header = ['NO. RESP'];
            foreach ($questions as $i => $q) {
                $header[] = 'U' . ($i + 1);
            }
            fputcsv($file, $header);

            // Data rows
            foreach ($stats['skm_table'] as $rIndex => $row) {
                $csvRow = [$rIndex + 1];
                foreach ($row['values'] as $val) {
                    $csvRow[] = $val;
                }
                fputcsv($file, $csvRow);
            }

            // Summary rows
            fputcsv($file, []);

            $sumRow = ['ΣNilai/Unsur'];
            foreach ($stats['unsur_totals'] as $total) {
                $sumRow[] = $total;
            }
            fputcsv($file, $sumRow);

            $nrrRow = ['NRR/Unsur'];
            foreach ($stats['nrr_per_unsur'] as $nrr) {
                $nrrRow[] = number_format($nrr, 3, ',', '.');
            }
            fputcsv($file, $nrrRow);

            $nrrTRow = ['NRR Tertimbang/Unsur'];
            foreach ($stats['nrr_tertimbang'] as $nrrt) {
                $nrrTRow[] = number_format($nrrt, 3, ',', '.');
            }
            $nrrTRow[] = number_format($stats['total_nrr_tertimbang'], 3, ',', '.');
            fputcsv($file, $nrrTRow);

            fputcsv($file, []);
            fputcsv($file, ['IKM Unit Pelayanan', $stats['ikm']]);
            if ($stats['mutu']) {
                fputcsv($file, ['Mutu Pelayanan', $stats['mutu']['grade'] . ' (' . $stats['mutu']['label'] . ')']);
            }

            fputcsv($file, []);
            fputcsv($file, ['Keterangan Unsur:']);
            foreach ($questions as $i => $q) {
                fputcsv($file, ['U' . ($i + 1), $q]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function table(Table $table): Table
    {
        $questions = $this->record->questions()->orderBy('order')->get();

        $columns = [
            TextColumn::make('respondent_name')
                ->label('Nama')
                ->default('Anonim')
                ->searchable(),
            TextColumn::make('respondent_email')
                ->label('Email')
                ->default('-')
                ->searchable(),
            TextColumn::make('created_at')
                ->label('Tanggal')
                ->dateTime('d M Y, H:i')
                ->sortable(),
        ];

        return $table
            ->query(
                QuestionnaireResponse::query()
                    ->where('questionnaire_id', $this->record->id)
                    ->with('answers.question')
            )
            ->columns($columns)
            ->defaultSort('created_at', 'desc');
    }

    public function getStatistics(): array
    {
        $questions = $this->record->questions()->orderBy('order')->with('answers')->get();
        $responses = $this->record->responses()
            ->with(['answers'])
            ->orderBy('created_at', 'asc')
            ->get();

        $totalResponses = $responses->count();
        $scoringType = $this->record->scoring_type ?? 'skm';
        $maxScale = $scoringType === 'skm' ? 4 : 5;

        // Build SKM table data
        $skmTable = [];
        $unsurTotals = [];

        foreach ($questions as $qIndex => $question) {
            $unsurTotals[$qIndex] = 0;
        }

        foreach ($responses as $rIndex => $response) {
            $row = [];
            foreach ($questions as $qIndex => $question) {
                $answer = $response->answers->firstWhere('question_id', $question->id);
                $value = $this->getNumericValue($question, $answer);
                $row[] = $value;
                $unsurTotals[$qIndex] += $value;
            }
            $skmTable[] = [
                'respondent' => $response->respondent_name ?? ('Responden ' . ($rIndex + 1)),
                'values' => $row,
            ];
        }

        // Hitung NRR, NRR Tertimbang, IKM
        $nrrPerUnsur = [];
        $nrrTertimbangPerUnsur = [];
        $scorableCount = $questions->whereIn('type', ['rating', 'radio', 'dropdown'])->count();
        $bobot = $scorableCount > 0 ? round(1 / $scorableCount, 3) : 0;

        foreach ($questions as $qIndex => $question) {
            if (in_array($question->type, ['rating', 'radio', 'dropdown']) && $totalResponses > 0) {
                $nrr = round($unsurTotals[$qIndex] / $totalResponses, 3);
                $nrrTertimbang = round($nrr * $bobot, 3);
            } else {
                $nrr = 0;
                $nrrTertimbang = 0;
            }
            $nrrPerUnsur[$qIndex] = $nrr;
            $nrrTertimbangPerUnsur[$qIndex] = $nrrTertimbang;
        }

        $totalNrrTertimbang = round(array_sum($nrrTertimbangPerUnsur), 3);
        $ikm = $scoringType === 'skm' ? round($totalNrrTertimbang * 25, 2) : round($totalNrrTertimbang, 2);

        $mutu = null;
        if ($scoringType === 'skm' && $totalResponses > 0 && $scorableCount > 0) {
            if ($ikm >= 88.31) $mutu = ['grade' => 'A', 'label' => 'Sangat Baik', 'color' => '#10b981'];
            elseif ($ikm >= 76.61) $mutu = ['grade' => 'B', 'label' => 'Baik', 'color' => '#3b82f6'];
            elseif ($ikm >= 65.00) $mutu = ['grade' => 'C', 'label' => 'Kurang Baik', 'color' => '#f59e0b'];
            else $mutu = ['grade' => 'D', 'label' => 'Tidak Baik', 'color' => '#ef4444'];
        }

        // Question stats for summary tab
        $questionStats = [];
        foreach ($questions as $qIndex => $question) {
            $answers = $question->answers;
            $stat = [
                'id' => $question->id,
                'question' => $question->question,
                'type' => $question->type,
                'options' => $question->options,
                'total_answers' => $answers->count(),
                'summary' => [],
            ];

            if ($question->type === 'rating') {
                $ratings = $answers->pluck('answer')->filter()->map(fn($v) => (int) $v);
                $distribution = [];
                for ($i = $maxScale; $i >= 1; $i--) {
                    $distribution[$i] = $ratings->filter(fn($v) => $v === $i)->count();
                }
                $stat['summary'] = [
                    'average' => $nrrPerUnsur[$qIndex],
                    'max_scale' => $maxScale,
                    'distribution' => $distribution,
                ];
            } elseif (in_array($question->type, ['dropdown', 'radio'])) {
                $stat['summary'] = $answers->pluck('answer')->filter()->countBy()->sortDesc()->toArray();
            } elseif ($question->type === 'checkbox') {
                $stat['summary'] = $answers->pluck('answer_array')->filter()->flatten()->countBy()->sortDesc()->toArray();
            } elseif ($question->type === 'text') {
                $stat['summary'] = $answers->pluck('answer')->filter()->take(20)->toArray();
            }

            $questionStats[] = $stat;
        }

        // Individual responses for detail tab
        $responseList = $responses->map(function ($response) use ($questions) {
            $answers = [];
            foreach ($questions as $question) {
                $answer = $response->answers->firstWhere('question_id', $question->id);
                $answers[] = [
                    'question' => $question->question,
                    'type' => $question->type,
                    'answer' => $answer?->answer,
                    'answer_array' => $answer?->answer_array,
                ];
            }
            return [
                'id' => $response->id,
                'name' => $response->respondent_name ?? 'Anonim',
                'email' => $response->respondent_email,
                'date' => $response->created_at->format('d M Y, H:i'),
                'answers' => $answers,
            ];
        })->toArray();

        return [
            'total_responses' => $totalResponses,
            'scoring_type' => $scoringType,
            'max_scale' => $maxScale,
            'ikm' => $ikm,
            'mutu' => $mutu,
            'bobot' => $bobot,
            'questions' => $questionStats,
            'responses' => $responseList,
            // SKM Table
            'skm_table' => $skmTable,
            'unsur_totals' => $unsurTotals,
            'nrr_per_unsur' => $nrrPerUnsur,
            'nrr_tertimbang' => $nrrTertimbangPerUnsur,
            'total_nrr_tertimbang' => $totalNrrTertimbang,
            'question_labels' => $questions->pluck('question')->toArray(),
        ];
    }

    /**
     * Convert answer to numeric value for SKM calculation.
     * - Rating: langsung angka
     * - Radio/Dropdown: posisi opsi yang dipilih (1-based)
     * - Lainnya: 0
     */
    private function getNumericValue($question, $answer): int
    {
        if (!$answer || !$answer->answer) {
            return 0;
        }

        if ($question->type === 'rating') {
            return (int) $answer->answer;
        }

        if (in_array($question->type, ['radio', 'dropdown'])) {
            $options = $question->options ?? [];
            $index = array_search($answer->answer, $options);
            if ($index !== false) {
                return $index + 1; // 1-based: opsi pertama = 1, kedua = 2, dst
            }
        }

        return 0;
    }
}
