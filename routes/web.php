<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MagasinierController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TypeMouvementController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\MouvementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Page d'accueil avec la vidéo
Route::get('/', function () {
    return view('welcome');
});

// Routes pour l'authentification utilisateur
Route::get('/utilisateur', [AuthController::class, 'showLoginForm'])->name('utilisateur.form');
Route::post('/utilisateur', [AuthController::class, 'login'])->name('utilisateur.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées par l'authentification
Route::middleware(['auth'])->group(function () {
    // Route du magasinier
    Route::get('/magasinier', [MagasinierController::class, 'index'])->name('magasinier.index');

    // Routes pour les articles
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

    // Importation d'articles via Excel
    Route::post('/articles/import', [ArticleController::class, 'import'])->name('articles.import');

    // Routes pour le stock
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

// Routes pour les mouvements
Route::get('/mouvements/{mouvement}', [MouvementController::class, 'show'])->name('mouvements.show');

    // Routes pour la documentation
    Route::get('/documentation/manuel-utilisateur', [DocumentationController::class, 'manuelUtilisateur'])->name('documentation.manuel');

    // Routes pour l'importation
    Route::get('/admin/import', [ImportController::class, 'showImportForm'])->name('admin.import.form');
    Route::post('/admin/import', [ImportController::class, 'import'])->name('admin.import');

    // Routes pour le profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); // <-- Ajout de l'accolade fermante ici


Route::post('/stock', [StockController::class, 'store'])->name('stock.store');

Route::get('/type-mouvements', [App\Http\Controllers\TypeMouvementController::class, 'index'])->name('type_mouvements.index');

Route::get('/type-mouvements/{id}/edit', [App\Http\Controllers\TypeMouvementController::class, 'edit'])->name('type_mouvements.edit');
Route::delete('/type-mouvements/{id}', [App\Http\Controllers\TypeMouvementController::class, 'destroy'])->name('type_mouvements.destroy');

Route::resource('type-mouvements', App\Http\Controllers\TypeMouvementController::class);
Route::resource('operations', App\Http\Controllers\OperationController::class);

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
