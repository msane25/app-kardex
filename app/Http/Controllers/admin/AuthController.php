<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('utilisateur');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->input('texte'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('magasinier.form'); // redirection après succès
        }

        return redirect()->back()->with('error', 'Identifiants invalides.');
    }
}


