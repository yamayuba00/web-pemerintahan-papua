<?php

use App\Http\Controllers\API\CmsController;
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


    Route::get('/settings', [CmsController::class, 'fetchSettings']);

    Route::post('contact', [CmsController::class, 'submitContactForm']);
});
