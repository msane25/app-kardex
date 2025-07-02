<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ArticlesImport;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'web']);
    }

    public function index()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    /**
     * Store a newly created article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codeArticle' => 'required|string|max:50|unique:articles,code_article',
            'description' => 'required|string|max:255',
            'uniteDeMesure' => 'required|string|max:50',
            'quantiteStock' => 'required|integer|min:0',
            'seuilAlerte' => 'required|integer|min:0',
            'prixUnitaire' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article = Article::create([
            'code_article' => $request->codeArticle,
            'description' => $request->description,
            'unite_mesure' => $request->uniteDeMesure,
            'quantite_stock' => $request->quantiteStock,
            'seuil_critique' => $request->seuilAlerte,
            'prix_unitaire' => $request->prixUnitaire ?? 0,
        ]);
        return response()->json(['success' => true, 'data' => $article], 201);
    }

    public function show(Article $article)
    {
        return response()->json($article);
    }

    public function update(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'codeArticle' => 'required|string|max:50|unique:articles,code_article,' . $article->id,
            'description' => 'required|string|max:255',
            'uniteDeMesure' => 'required|string|max:50',
            'quantiteStock' => 'required|integer|min:0',
            'seuilAlerte' => 'required|integer|min:0',
            'prixUnitaire' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article->update([
            'code_article' => $request->codeArticle,
            'description' => $request->description,
            'unite_mesure' => $request->uniteDeMesure,
            'quantite_stock' => $request->quantiteStock,
            'seuil_critique' => $request->seuilAlerte,
            'prix_unitaire' => $request->prixUnitaire,
        ]);
        return response()->json($article);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }

    /**
     * Import articles from an Excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new ArticlesImport, $request->file('excel_file'));
            return response()->json(['success' => true, 'message' => 'Importation réussie.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'importation : ' . $e->getMessage()], 500);
        }
    }
}