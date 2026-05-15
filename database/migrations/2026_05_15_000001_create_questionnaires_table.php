<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('scoring_type', ['rating_5', 'skm'])->default('skm');
            $table->timestamps();
        });

        Schema::create('questionnaire_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained()->cascadeOnDelete();
            $table->string('question');
            $table->enum('type', ['text', 'dropdown', 'checkbox', 'radio', 'rating']);
            $table->json('options')->nullable(); // untuk dropdown, checkbox, radio
            $table->boolean('is_required')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('questionnaire_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained()->cascadeOnDelete();
            $table->string('respondent_name')->nullable();
            $table->string('respondent_email')->nullable();
            $table->timestamps();
        });

        Schema::create('questionnaire_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('questionnaire_responses')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questionnaire_questions')->cascadeOnDelete();
            $table->text('answer')->nullable(); // text, single value
            $table->json('answer_array')->nullable(); // untuk checkbox (multiple)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questionnaire_answers');
        Schema::dropIfExists('questionnaire_responses');
        Schema::dropIfExists('questionnaire_questions');
        Schema::dropIfExists('questionnaires');
    }
};
