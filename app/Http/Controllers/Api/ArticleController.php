<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    // Suppression temporaire du middleware auth pour permettre l'accès aux modals
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    /**
     * Créer un nouvel article
     */
    public function store(Request $request)
    {
        try {
            $code = $request->input('codeArticle') ?? $request->input('reference');
            if (Article::where('code_article', '=', $code)->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Un article avec ce code existe déjà.'
                ], 422);
            }

            $validator = Validator::make($request->all(), [
                'codeArticle' => 'required|string',
                'description' => 'required|string',
                'uniteDeMesure' => 'required|string',
                'quantiteStock' => 'required|integer|min:0',
                'seuilAlerte' => 'required|integer|min:0',
                'idOrganisation' => 'required|integer|min:1',
                'prixUnitaire' => 'nullable|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Vérifier si l'utilisateur est authentifié
            /*
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez être connecté pour effectuer cette action.'
                ], 401);
            }
            */

            $article = Article::create([
                'code_article' => $code,
                'description' => $request->description,
                'unite_mesure' => $request->uniteDeMesure,
                'quantite_stock' => $request->quantiteStock,
                'seuil_critique' => $request->seuilAlerte,
                'idOrganisation' => $request->idOrganisation,
                'prix_unitaire' => $request->prixUnitaire ?? 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Article créé avec succès',
                'data' => $article
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer la liste des articles
     */
    public function index()
    {
        try {
            $articles = \App\Models\Article::all();
            return response()->json(['success' => true, 'data' => $articles]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Mettre à jour un article
     */
    public function update(Request $request, Article $article)
    {
        try {
            $validator = Validator::make($request->all(), [
                'codeArticle' => 'required|string|unique:articles,codeArticle,' . $article->id,
                'description' => 'required|string',
                'uniteDeMesure' => 'required|string',
                'quantiteStock' => 'required|integer|min:0',
                'seuilAlerte' => 'required|integer|min:0',
                'idOrganisation' => 'required|integer|min:1',
                'prixUnitaire' => 'nullable|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $article->update([
                'codeArticle' => $request->codeArticle,
                'description' => $request->description,
                'uniteDeMesure' => $request->uniteDeMesure,
                'quantiteStock' => $request->quantiteStock,
                'seuilAlerte' => $request->seuilAlerte,
                'idOrganisation' => $request->idOrganisation,
                'prixUnitaire' => $request->prixUnitaire ?? 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Article modifié avec succès',
                'data' => $article
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification de l\'article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un article
     */
    public function destroy(Article $article)
    {
        try {
            $article->delete();
            return response()->json([
                'success' => true,
                'message' => 'Article supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'article',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}