<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function store(Request $request)
    {
        // Valider et enregistrer les données ici
        return redirect('/')->with('success', 'Stock enregistré avec succès');
    }
}
