<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireAnswer extends Model
{
    protected $fillable = [
        'response_id',
        'question_id',
        'answer',
        'answer_array',
    ];

    protected $casts = [
        'answer_array' => 'array',
    ];

    public function response()
    {
        return $this->belongsTo(QuestionnaireResponse::class, 'response_id');
    }

    public function question()
    {
        return $this->belongsTo(QuestionnaireQuestion::class, 'question_id');
    }
}
