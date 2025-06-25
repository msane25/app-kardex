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
            'mouvement' => 'required|string|max:255'
        ]);
        // Vérifier unicité
        $existing = TypeMouvement::where('mouvement', $request->mouvement)->first();
        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Ce type de mouvement existe déjà.'], 409);
        }
        $typeMouvement = new \App\Models\TypeMouvement();
        $typeMouvement->mouvement = $request->mouvement;
        $typeMouvement->save();
        return response()->json(['success' => true, 'data' => $typeMouvement], 201);
    }
}
