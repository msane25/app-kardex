<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MagasinierController extends Controller
{
    public function showForm()
    {
        return view('magasinier'); // charge la fiche KARDEX
    }

    public function store(Request $request)
    {
        // Enregistrement en base ici
        return back()->with('success', 'Fiche KARDEX enregistrée avec succès.');
    }
}

