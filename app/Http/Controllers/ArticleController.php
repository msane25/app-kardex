<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

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
            'codeArticle' => 'required|string|max:50|unique:articles,codeArticle',
            'description' => 'required|string|max:255',
            'uniteDeMesure' => 'required|string|max:50',
            'quantiteStock' => 'required|integer|min:0',
            'seuilAlerte' => 'required|integer|min:0',
            'quantiteInitiale' => 'required|integer|min:0',
            'idOrganisation' => 'required|integer|min:1',
            'prixUnitaire' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article = Article::create([
            'codeArticle' => $request->codeArticle,
            'description' => $request->description,
            'uniteDeMesure' => $request->uniteDeMesure,
            'quantiteStock' => $request->quantiteStock,
            'seuilAlerte' => $request->seuilAlerte,
            'quantiteInitiale' => $request->quantiteInitiale,
            'idOrganisation' => $request->idOrganisation,
            'prixUnitaire' => $request->prixUnitaire ?? 0,
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
            'codeArticle' => 'required|string|max:50|unique:articles,codeArticle,' . $article->id,
            'description' => 'required|string|max:255',
            'uniteDeMesure' => 'required|string|max:50',
            'quantiteStock' => 'required|integer|min:0',
            'seuilAlerte' => 'required|integer|min:0',
            'quantiteInitiale' => 'required|integer|min:0',
            'idOrganisation' => 'required|integer|min:1',
            'prixUnitaire' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article->update([
            'codeArticle' => $request->codeArticle,
            'description' => $request->description,
            'uniteDeMesure' => $request->uniteDeMesure,
            'quantiteStock' => $request->quantiteStock,
            'seuilAlerte' => $request->seuilAlerte,
            'quantiteInitiale' => $request->quantiteInitiale,
            'idOrganisation' => $request->idOrganisation,
            'prixUnitaire' => $request->prixUnitaire,
        ]);
        return response()->json($article);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }
}