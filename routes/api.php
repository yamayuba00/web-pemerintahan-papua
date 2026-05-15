<?php

use App\Http\Controllers\API\CmsController;
use App\Http\Controllers\API\QuestionnaireController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', 'encrypted'])->group(function () {
    Route::get('/sliders', [CmsController::class, 'getSliders']);

    Route::get('/categories', [CmsController::class, 'fetchCategories']);
    Route::get('/category/{slug}', [CmsController::class, 'fetchNewsBySlugCategories']);

    Route::get('/news/{slug}', [CmsController::class, 'fetchNewsBySlug']);
    Route::get('/articles/{slug}', [CmsController::class, 'fetchArticlesBySlug']);

    Route::get('/news', [CmsController::class, 'fetchNews']);
    Route::get('/articles', [CmsController::class, 'fetchArticles']);
    Route::get('/complaints', [CmsController::class, 'fetchComplaints']);

    Route::get('/tourisms', [CmsController::class, 'fetchTourisms']);
    Route::get('/tourisms/{slug}', [CmsController::class, 'fetchTourismBySlug']);

    Route::get('/application-services', [CmsController::class, 'fetchApplicationServices']);

    Route::get('/settings', [CmsController::class, 'fetchSettings']);

    Route::post('contact', [CmsController::class, 'submitContactForm']);

    // Questionnaire
    Route::get('/questionnaires', [QuestionnaireController::class, 'index']);
    Route::get('/questionnaires/{slug}', [QuestionnaireController::class, 'show']);
    Route::post('/questionnaires/{slug}/submit', [QuestionnaireController::class, 'submit']);
    Route::get('/questionnaires/{slug}/statistics', [QuestionnaireController::class, 'statistics']);
});
