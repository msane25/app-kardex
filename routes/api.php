<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\MouvementController;
use App\Http\Controllers\Api\OperationController;
use App\Http\Controllers\Api\TypeMouvementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --------------------------------------------------
// TypeMouvement routes (public, not in any group!)
// --------------------------------------------------
Route::get('/type-mouvements', [TypeMouvementController::class, 'index']);
Route::post('/type-mouvements', [TypeMouvementController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// --------------------------------------------------
// Authenticated API routes
// --------------------------------------------------
Route::middleware(['auth:sanctum'])->group(function () {
    // Articles
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::apiResource('articles', ArticleController::class);

    // Mouvements
    Route::get('/mouvements/articles', [MouvementController::class, 'getArticles']);
    Route::post('/mouvements', [MouvementController::class, 'store']);
    Route::apiResource('mouvements', MouvementController::class);

    // Opérations
    Route::get('/operations', [OperationController::class, 'index']);
    Route::post('/operations', [OperationController::class, 'store']);
    Route::apiResource('operations', OperationController::class);
});