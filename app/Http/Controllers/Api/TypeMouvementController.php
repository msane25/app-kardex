<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeMouvement;

class TypeMouvementController extends Controller
{
    public function index()
    {
        $types = \App\Models\TypeMouvement::all();
        return response()->json(['success' => true, 'data' => $types]);
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

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'mouvement' => 'required|string|max:255'
            ]);

            $typeMouvement = TypeMouvement::findOrFail($id);
            
            // Vérifier unicité (sauf pour l'enregistrement actuel)
            $existing = TypeMouvement::where('mouvement', $request->mouvement)
                                   ->where('id_type_mouvement', '!=', $id)
                                   ->first();
            if ($existing) {
                return response()->json(['success' => false, 'message' => 'Ce type de mouvement existe déjà.'], 409);
            }

            $typeMouvement->mouvement = $request->mouvement;
            $typeMouvement->save();

            return response()->json([
                'success' => true,
                'data' => $typeMouvement,
                'message' => 'Type de mouvement modifié avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification du type de mouvement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $typeMouvement = TypeMouvement::findOrFail($id);
            
            // Vérifier s'il y a des mouvements associés
            $mouvementsCount = $typeMouvement->mouvements()->count();
            if ($mouvementsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer ce type de mouvement car il est utilisé par ' . $mouvementsCount . ' mouvement(s).'
                ], 400);
            }

            $typeMouvement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Type de mouvement supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du type de mouvement: ' . $e->getMessage()
            ], 500);
        }
    }


}
