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

// Route de test pour vérifier que l'API fonctionne
Route::get('/test', function () {
    return response()->json(['message' => 'API fonctionne correctement']);
});

// --------------------------------------------------
// Routes publiques pour le test des modals
// --------------------------------------------------
Route::get('/type-mouvements', [TypeMouvementController::class, 'index']);
Route::post('/type-mouvements', [TypeMouvementController::class, 'store']);
Route::put('/type-mouvements/{id}', [TypeMouvementController::class, 'update']);
Route::delete('/type-mouvements/{id}', [TypeMouvementController::class, 'destroy']);

// Articles - temporairement public
Route::get('/articles', [ArticleController::class, 'index']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::put('/articles/{article}', [ArticleController::class, 'update']);
Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);

// Mouvements - temporairement public
Route::get('/mouvements', [MouvementController::class, 'index']);
Route::post('/mouvements', [MouvementController::class, 'store']);
Route::put('/mouvements/{id}', [MouvementController::class, 'update']);
Route::delete('/mouvements/{id}', [MouvementController::class, 'destroy']);

// Opérations - temporairement public
Route::get('/operations', [OperationController::class, 'index']);
Route::post('/operations', [OperationController::class, 'store']);
Route::put('/operations/{id}', [OperationController::class, 'update']);
Route::delete('/operations/{id}', [OperationController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// --------------------------------------------------
// Authenticated API routes (commentées temporairement)
// --------------------------------------------------
/*
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
    Route::apiResource('operations', OperationController::class);
});

// Opérations - route accessible sans authentification
Route::post('/operations', [OperationController::class, 'store']);
*/