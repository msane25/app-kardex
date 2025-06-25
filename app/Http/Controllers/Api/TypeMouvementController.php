<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeMouvement;

class TypeMouvementController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => TypeMouvement::all(['id_type_mouvement', 'mouvement'])
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mouvement' => 'required|in:Entrée,Sortie,Retour'
        ]);
        $typeMouvement = new \App\Models\TypeMouvement();
        $typeMouvement->mouvement = $request->mouvement;
        $typeMouvement->save();
        return response()->json(['success' => true, 'data' => $typeMouvement], 201);
    }
}
