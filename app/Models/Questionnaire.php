<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Questionnaire extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_active',
        'scoring_type',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function questions()
    {
        return $this->hasMany(QuestionnaireQuestion::class)->orderBy('order');
    }

    public function responses()
    {
        return $this->hasMany(QuestionnaireResponse::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Questionnaire $questionnaire) {
            if (empty($questionnaire->slug)) {
                $questionnaire->slug = Str::slug($questionnaire->title);
            }
        });
    }
}
