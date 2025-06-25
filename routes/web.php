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

    // Routes pour le stock
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

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


require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
