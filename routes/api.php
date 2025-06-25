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

// Routes protégées nécessitant une authentification
Route::middleware(['auth:sanctum'])->group(function () {
    // Routes pour les articles
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::get('/articles', [ArticleController::class, 'index']);

    // Routes pour les mouvements
    Route::get('/mouvements/articles', [MouvementController::class, 'getArticles']);
    Route::post('/mouvements', [MouvementController::class, 'store']);

    // Routes pour les opérations
    Route::get('/operations', [OperationController::class, 'index']);
    Route::post('/operations', [OperationController::class, 'store']);
});

// Route de test pour vérifier l'authentification
Route::get('/test', function () {
    return response()->json(['message' => 'API accessible']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Routes pour les articles
    Route::apiResource('articles', ArticleController::class);

    // Routes pour les mouvements
    Route::apiResource('mouvements', MouvementController::class);

    // Routes pour les opérations
    Route::apiResource('operations', OperationController::class);

    // Route pour les types de mouvement
    Route::get('/type-mouvements', [TypeMouvementController::class, 'index']);
    Route::post('/type-mouvements', [TypeMouvementController::class, 'store']);
});