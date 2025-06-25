<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'magasinier') {
                return redirect('/magasinier');
            } elseif ($user->role === 'responsable') {
                return redirect()->route('responsable.dashboard');
            }

            Auth::logout();
            return redirect()->route('login.form')->with('error', "Rôle utilisateur non reconnu.");
        }

        return redirect()->route('login.form')->with('error', 'Email ou mot de passe incorrect.');
    }

    public function showLoginForm()
    {
        return view('login'); // ou 'utilisateur' si tu gardes ce nom
    }
}
