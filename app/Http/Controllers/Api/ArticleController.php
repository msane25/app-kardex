<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Créer un nouvel article
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'codeArticle' => 'required|string|unique:articles,codeArticle',
                'description' => 'required|string',
                'uniteDeMesure' => 'required|string',
                'quantiteInitiale' => 'required|integer|min:0',
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
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez être connecté pour effectuer cette action.'
                ], 401);
            }

            $article = Article::create([
                'codeArticle' => $request->codeArticle,
                'description' => $request->description,
                'uniteDeMesure' => $request->uniteDeMesure,
                'quantiteInitiale' => $request->quantiteInitiale,
                'quantiteStock' => $request->quantiteStock,
                'seuilAlerte' => $request->seuilAlerte,
                'idOrganisation' => $request->idOrganisation,
                'prixUnitaire' => $request->prixUnitaire ?? 0
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
            $articles = Article::all();
            return response()->json([
                'success' => true,
                'data' => $articles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des articles',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}