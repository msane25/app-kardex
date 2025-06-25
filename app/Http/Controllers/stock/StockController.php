<?php

namespace App\Http\Controllers\stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    public function store(Request $request)
    {
        // Valider et enregistrer les données ici
        return redirect('/')->with('success', 'Stock enregistré avec succès');
    }
}
