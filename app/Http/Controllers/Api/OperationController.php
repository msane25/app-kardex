<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperationController extends Controller
{
    /**
     * Créer une nouvelle opération
     */
    public function store(Request $request)
    {
        // Vérifier l'authentification (Laravel renverra 401 automatiquement, mais on force le JSON)
        if (!$request->user()) {
            return response()->json(['success' => false, 'message' => 'Non authentifié'], 401);
        }

        // Adapter les noms de champs attendus depuis le frontend
        $data = $request->all();
        $typeOperation = $data['typeOperation'] ?? $data['type_operation'] ?? null;
        $destinationOperation = $data['destinationOperation'] ?? $data['destination_operation'] ?? null;
        $libelleOperation = $data['libelleOperation'] ?? $data['libelle_operation'] ?? null;

        // Validation
        $validator = Validator::make([
            'type_operation' => $typeOperation,
            'destination_operation' => $destinationOperation,
            'description' => $libelleOperation,
            'date_operation' => now()->toDateString(), // Ajout automatique de la date
        ], [
            'type_operation' => 'required|string|max:255',
            'destination_operation' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_operation' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Création de l'opération
        $operation = Operation::create([
            'type_operation' => $typeOperation,
            'destination_operation' => $destinationOperation,
            'description' => $libelleOperation,
            'date_operation' => now()->toDateString(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Opération créée avec succès',
            'data' => $operation
        ], 201);
    }

    /**
     * Récupérer la liste des opérations
     */
    public function index()
    {
        $operations = Operation::with('mouvements')->get();
        return response()->json($operations);
    }

    public function show(Operation $operation)
    {
        return response()->json($operation->load('mouvements'));
    }

    public function update(Request $request, Operation $operation)
    {
        $validator = Validator::make($request->all(), [
            'type_operation' => 'required|string|max:255',
            'date_operation' => 'required|date',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $operation->update($request->all());
        return response()->json($operation);
    }

    public function destroy(Operation $operation)
    {
        $operation->delete();
        return response()->json(null, 204);
    }
}