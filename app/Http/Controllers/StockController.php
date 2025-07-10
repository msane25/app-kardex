<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Mouvement;
use App\Models\Operation;

class StockController extends Controller
{
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'nomenclature' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'date' => 'required|date',
            'prix_unitaire' => 'nullable|numeric|min:0',
            'unite_mesure' => 'nullable|string|max:50',
            'quantite_stock' => 'nullable|integer|min:0',
            'seuil_critique' => 'nullable|integer|min:0',
            'document' => 'nullable|string|max:255',
            'fournisseur' => 'nullable|string|max:255',
            'entrees' => 'nullable|integer|min:0',
            'sorties' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'type_mouvement' => 'nullable|string|max:255',
            'type_operation' => 'nullable|string|max:255',
            'destination_operation' => 'nullable|string|max:255',
        ]);

        try {
            // Créer ou mettre à jour l'article
            $article = Article::updateOrCreate(
                ['code_article' => $request->nomenclature],
                [
                    'description' => $request->designation,
                    'quantite_stock' => $request->quantite_stock ?? 0,
                    'unite_mesure' => $request->unite_mesure ?? 'Unité',
                    'seuil_critique' => $request->seuil_critique ?? 0,
                    'prix_unitaire' => $request->prix_unitaire ?? 0,
                ]
            );

            // Créer un mouvement si des entrées/sorties sont spécifiées
            if ($request->entrees || $request->sorties) {
                // Générer le numéro de document automatiquement
                $documentNumber = $this->generateDocumentNumber($request->type_mouvement);
                
                // Récupérer l'ID de l'opération
                $operationId = $this->getOperationId($request->type_mouvement);
                
                if (!$operationId) {
                    throw new \Exception('Type d\'opération non trouvé dans la base de données');
                }
                
                Mouvement::create([
                    'date_mouvement' => $request->date,
                    'document_number' => $documentNumber,
                    'quantiteServis' => $request->entrees ?? $request->sorties ?? 0,
                    'type_mouvement_id' => 1, // Type par défaut
                    'designation' => $request->designation,
                    'demandeur' => auth()->user()->name ?? 'Admin',
                    'fournisseur' => $request->fournisseur ?? 'Non spécifié',
                    'matricule' => auth()->user()->matricule ?? 'ADMIN001',
                    'article_id' => $article->id,
                    'operation_id' => $operationId,
                    'destination' => $request->destination_operation ?? 'Non spécifiée',
                ]);
            }

            return redirect()->back()->with('success', 'Fiche KARDEX enregistrée avec succès ! Numéro de document: ' . ($documentNumber ?? 'N/A'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
        }
    }

    /**
     * Génère un numéro de document automatiquement basé sur le type de mouvement
     */
    private function generateDocumentNumber($typeMouvement)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        // Déterminer le préfixe selon le type de mouvement
        $prefix = $this->getDocumentPrefix($typeMouvement);
        
        // Trouver le dernier numéro pour ce type de mouvement ce mois-ci
        $lastDocument = Mouvement::where('document_number', 'like', $prefix . $currentYear . $currentMonth . '%')
            ->orderBy('document_number', 'desc')
            ->first();
        
        if ($lastDocument) {
            // Extraire le numéro séquentiel et l'incrémenter
            $lastNumber = (int) substr($lastDocument->document_number, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        // Format: PREFIX + AAAA + MM + NNNN (4 chiffres)
        return $prefix . $currentYear . $currentMonth . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Retourne le préfixe approprié selon le type de mouvement
     */
    private function getDocumentPrefix($typeMouvement)
    {
        switch ($typeMouvement) {
            case 'Sortie diverses':
                return 'SD';
            case 'Transfert Inter-Organisation':
                return 'TI';
            case 'Retour / Reversement':
                return 'RR';
            case 'Réception fournisseur':
                return 'RF';
            default:
                return 'MV'; // Mouvement par défaut
        }
    }

    public function storeRequest(Request $request)
    {
        // Alias pour la méthode store
        return $this->store($request);
    }

    private function getOperationId($typeMouvement)
    {
        if (!$typeMouvement) {
            // Si aucun type de mouvement n'est spécifié, utiliser une opération par défaut
            $defaultOperation = Operation::first();
            return $defaultOperation ? $defaultOperation->id_operation : null;
        }
        
        $operation = Operation::where('libelle', $typeMouvement)->first();
        
        if (!$operation) {
            // Si l'opération n'existe pas, la créer automatiquement
            $operation = Operation::create([
                'libelle' => $typeMouvement
            ]);
        }
        
        return $operation->id_operation;
    }

    public function index()
    {
        $articles = Article::all();
        $mouvements = Mouvement::with(['article', 'operation', 'typeMouvement'])->orderBy('date_mouvement', 'desc')->get();
        
        return view('stock.index', compact('articles', 'mouvements'));
    }
}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // ✅ Connexion réussie → redirection vers KARDEX
            return redirect()->route('login.form');
        }

        // ❌ Échec
        return back()->with('error', 'Email ou mot de passe incorrect');
    }
}
