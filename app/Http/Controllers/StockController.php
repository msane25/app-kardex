<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    //
}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // ✅ Connexion réussie → redirection vers KARDEX
            return redirect()->route('login.form');
        }

        // ❌ Échec
        return back()->with('error', 'Email ou mot de passe incorrect');
    }
}
