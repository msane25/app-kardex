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
        $mouvements = Mouvement::with(['article', 'operation'])->get();
        return response()->json($mouvements);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_mouvement' => 'required|date',
            'type_mouvement_id' => 'required|exists:type_mouvements,id_type_mouvement',
            'quantite' => 'required|integer|min:1',
            'article_id' => 'required|exists:articles,id',
            'operation_id' => 'required|exists:operations,id',
            'destination' => 'nullable|string',
            'fournisseur' => 'nullable|string',
            'document_number' => 'required|string|unique:mouvements'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $article = Article::findOrFail($request->article_id);
            $quantite = $request->quantite;

            // Récupérer le type de mouvement
            $typeMouvement = $request->type_mouvement_id;
            $type = DB::table('type_mouvements')->where('id_type_mouvement', $typeMouvement)->value('mouvement');

            // Mise à jour du stock en fonction du type de mouvement
            if ($type === 'Entrée') {
                $article->quantite_stock += $quantite;
            } elseif ($type === 'Sortie') {
                if ($article->quantite_stock < $quantite) {
                    return response()->json([
                        'error' => 'Stock insuffisant pour cette sortie'
                    ], 400);
                }
                $article->quantite_stock -= $quantite;
            } // Pour "Retour", à adapter selon la logique métier

            $article->save();

            $mouvement = Mouvement::create($request->all());

            DB::commit();

            return response()->json($mouvement, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erreur lors de l\'enregistrement du mouvement'], 500);
        }
    }

    public function show(Mouvement $mouvement)
    {
        return response()->json($mouvement->load(['article', 'operation']));
    }

    public function update(Request $request, Mouvement $mouvement)
    {
        $validator = Validator::make($request->all(), [
            'date_mouvement' => 'required|date',
            'type_mouvement_id' => 'required|exists:type_mouvements,id_type_mouvement',
            'quantite' => 'required|integer|min:1',
            'article_id' => 'required|exists:articles,id',
            'operation_id' => 'required|exists:operations,id',
            'destination' => 'nullable|string',
            'fournisseur' => 'nullable|string',
            'document_number' => 'required|string|unique:mouvements,document_number,' . $mouvement->id
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Annuler l'ancien mouvement
            $article = Article::findOrFail($mouvement->article_id);
            if ($mouvement->type_mouvement === 'entree') {
                $article->quantite_stock -= $mouvement->quantite;
            } else {
                $article->quantite_stock += $mouvement->quantite;
            }

            // Appliquer le nouveau mouvement
            if ($request->type_mouvement === 'entree') {
                $article->quantite_stock += $request->quantite;
            } else {
                if ($article->quantite_stock < $request->quantite) {
                    return response()->json([
                        'error' => 'Stock insuffisant pour cette sortie'
                    ], 400);
                }
                $article->quantite_stock -= $request->quantite;
            }

            $article->save();
            $mouvement->update($request->all());

            DB::commit();

            return response()->json($mouvement);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erreur lors de la mise à jour du mouvement'], 500);
        }
    }

    public function destroy(Mouvement $mouvement)
    {
        try {
            DB::beginTransaction();

            $article = Article::findOrFail($mouvement->article_id);
            
            // Annuler l'effet du mouvement sur le stock
            if ($mouvement->type_mouvement === 'entree') {
                $article->quantite_stock -= $mouvement->quantite;
            } else {
                $article->quantite_stock += $mouvement->quantite;
            }

            $article->save();
            $mouvement->delete();

            DB::commit();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erreur lors de la suppression du mouvement'], 500);
        }
    }
}