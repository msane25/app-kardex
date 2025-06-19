<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\StockController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AuthController;

// ✅ Page d’accueil publique (welcome.blade.php)
Route::get('/', function () {
    return view('welcome');
});

// ✅ Page de login admin
Route::get('/utilisateur', function () {
    return view('utilisateur');
})->name('utilisateur.form');

Route::post('/utilisateur/login', [AuthController::class, 'login'])->name('admin.login');

// ✅ Page du magasinier
Route::get('/magasinier', function () {
    return view('magasinier');
})->name('magasinier');

// ✅ Page du Responsable (protégée si besoin plus tard)
Route::get('/responsable', function () {
    return view('responsable');
})->name('responsable');

// ✅ Page du CHEF DE SERVICE (protégée si besoin plus tard)
Route::get('/chefservice', function () {
    return view('chefservice');
})->name('chefservice');

// ✅ Route de déconnexion propre
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// ✅ Route de soumission du formulaire stock (protégée par auth)
Route::middleware('auth')->group(function () {
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
});

// ✅ Routes Breeze / Laravel Auth (si Breeze est installé)
require __DIR__.'/auth.php';


// RETOUR VERS LA PAGE WELCOME BLADE ACCEUIL
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


// ✅ Page du Responsable (protégée si besoin plus tard)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');



// ✅ Page DASHBOARD (protégée si besoin plus tard)
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
->name('dashboard');

Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [CustomAuthController::class, 'login'])->name('login.process');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/magasinier/dashboard', fn() => view('magasinier.dashboard'))->name('magasinier.dashboard');
    Route::get('/responsable/dashboard', fn() => view('responsable.dashboard'))->name('responsable.dashboard');
});

Route::post('/stock/request', [StockController::class, 'storeRequest'])->name('stock.request.store');




