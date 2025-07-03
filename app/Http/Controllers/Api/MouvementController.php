<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mouvement;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MouvementController extends Controller
{
    public function index()
    {
        $mouvements = \App\Models\Mouvement::with(['typeMouvement', 'operation', 'article'])->get();
        return response()->json(['data' => $mouvements]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_mouvement' => 'required|date',
            'type_mouvement_id' => 'required|integer|exists:type_mouvements,id_type_mouvement',
            'quantite' => 'required|numeric',
            'quantiteServis' => 'required|numeric',
            'code_article' => 'required|string|exists:articles,code_article',
            'operation_id' => 'required|integer|exists:operations,id_operation',
            'destination' => 'nullable|string',
            'fournisseur' => 'nullable|string',
            'document_number' => 'nullable|string',
            'designation' => 'nullable|string',
            'receptionnaire' => 'nullable|string',
            'demandeur' => 'nullable|string',
        ]);

        // Mapping automatique si 'quantite' est présent
        if (isset($validated['quantite'])) {
            $validated['quantiteServis'] = $validated['quantite'];
        }

        $mouvement = Mouvement::create($validated);

        return response()->json(['success' => true, 'data' => $mouvement], 201);
    }

    public function show($id)
    {
        $mouvement = Mouvement::with('operation')->findOrFail($id);
        return response()->json($mouvement);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date_mouvement' => 'required|date',
                'type_mouvement_id' => 'required|exists:type_mouvements,id_type_mouvement',
                'quantite' => 'required|integer|min:1',
                'article_id' => 'required|exists:articles,id',
                'operation_id' => 'required|exists:operations,id',
                'destination' => 'nullable|string',
                'fournisseur' => 'nullable|string',
                'document_number' => 'required|string|unique:mouvements,document_number,' . $id
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $mouvement = Mouvement::findOrFail($id);
            $article = Article::findOrFail($request->article_id);
            $quantite = $request->quantite;

            // Récupérer le type de mouvement
            $typeMouvement = $request->type_mouvement_id;
            $type = DB::table('type_mouvements')->where('id_type_mouvement', $typeMouvement)->value('mouvement');

            // Annuler l'ancien mouvement
            $oldTypeMouvement = DB::table('type_mouvements')->where('id_type_mouvement', $mouvement->type_mouvement_id)->value('mouvement');
            if ($oldTypeMouvement === 'Entrée') {
                $article->quantite_stock -= $mouvement->quantite;
            } elseif ($oldTypeMouvement === 'Sortie') {
                $article->quantite_stock += $mouvement->quantite;
            }

            // Appliquer le nouveau mouvement
            if ($type === 'Entrée') {
                $article->quantite_stock += $quantite;
            } elseif ($type === 'Sortie') {
                if ($article->quantite_stock < $quantite) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Stock insuffisant pour cette sortie'
                    ], 400);
                }
                $article->quantite_stock -= $quantite;
            }

            $article->save();
            $mouvement->update($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $mouvement,
                'message' => 'Mouvement modifié avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification du mouvement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $mouvement = Mouvement::findOrFail($id);
            $article = Article::findOrFail($mouvement->article_id);
            
            // Récupérer le type de mouvement
            $typeMouvement = DB::table('type_mouvements')->where('id_type_mouvement', $mouvement->type_mouvement_id)->value('mouvement');
            
            // Annuler l'effet du mouvement sur le stock
            if ($typeMouvement === 'Entrée') {
                $article->quantite_stock -= $mouvement->quantite;
            } elseif ($typeMouvement === 'Sortie') {
                $article->quantite_stock += $mouvement->quantite;
            }

            $article->save();
            $mouvement->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mouvement supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du mouvement: ' . $e->getMessage()
            ], 500);
        }
    }
}