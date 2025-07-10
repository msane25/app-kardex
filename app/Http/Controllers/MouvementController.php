<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mouvement;

class MouvementController extends Controller
{
    public function show($id)
    {
        $mouvement = Mouvement::with(['article', 'operation', 'typeMouvement'])->findOrFail($id);
        return view('mouvements.show', compact('mouvement'));
    }
} 