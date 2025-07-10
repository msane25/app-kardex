<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use App\Models\TypeMouvement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperationController extends Controller
{
    /**
     * Créer une nouvelle opération
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        // Log des données reçues
        \Log::info('Données reçues pour création opération:', $data);
        
        // Nouvelle logique : on attend 'libelle' et 'id_type_mouvement' du frontend
        $libelle = $data['libelle'] ?? $data['libelleOperation'] ?? $data['libelle_operation'] ?? null;
        $idTypeMouvement = $data['id_type_mouvement'] ?? $data['idTypeMouvement'] ?? $data['type_mouvement_id'] ?? null;

        // Log des données extraites
        \Log::info('Données extraites:', [
            'libelle' => $libelle,
            'id_type_mouvement' => $idTypeMouvement
        ]);

        $validator = Validator::make([
            'libelle' => $libelle,
            'id_type_mouvement' => $idTypeMouvement,
        ], [
            'libelle' => 'required|string|max:255|unique:operations,libelle',
            'id_type_mouvement' => 'nullable|integer|exists:type_mouvements,id_type_mouvement',
        ]);

        if ($validator->fails()) {
            \Log::error('Erreur de validation:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
                'debug_data' => [
                    'received_data' => $data,
                    'extracted_data' => [
                        'libelle' => $libelle,
                        'id_type_mouvement' => $idTypeMouvement
                    ]
                ]
            ], 422);
        }

        $operation = Operation::create([
            'libelle' => $libelle,
            'id_type_mouvement' => $idTypeMouvement,
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
        $operations = \App\Models\Operation::with('typeMouvement')->get();
        return response()->json(['success' => true, 'data' => $operations]);
    }

    public function show(Operation $operation)
    {
        return response()->json([
            'success' => true,
            'data' => $operation->load(['mouvements', 'article'])
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $libelle = $data['libelle'] ?? $data['libelleOperation'] ?? $data['libelle_operation'] ?? null;
            $idTypeMouvement = $data['id_type_mouvement'] ?? $data['idTypeMouvement'] ?? $data['type_mouvement_id'] ?? null;

            $validator = Validator::make([
                'libelle' => $libelle,
                'id_type_mouvement' => $idTypeMouvement,
            ], [
                'libelle' => 'required|string|max:255|unique:operations,libelle,' . $id . ',id_operation',
                'id_type_mouvement' => 'required|integer|exists:type_mouvements,id_type_mouvement',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $operation = Operation::findOrFail($id);
            
            // Vérifier unicité (sauf pour l'enregistrement actuel)
            $existing = Operation::where('libelle', $libelle)
                               ->where('id_operation', '!=', $id)
                               ->first();
            if ($existing) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Cette opération existe déjà.'
                ], 409);
            }

            $operation->update([
                'libelle' => $libelle,
                'id_type_mouvement' => $idTypeMouvement,
            ]);

            return response()->json([
                'success' => true,
                'data' => $operation,
                'message' => 'Opération modifiée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification de l\'opération: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $operation = Operation::findOrFail($id);
            
            // Vérifier s'il y a des mouvements associés
            $mouvementsCount = $operation->mouvements()->count();
            if ($mouvementsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer cette opération car elle est utilisée par ' . $mouvementsCount . ' mouvement(s).'
                ], 400);
            }

            $operation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Opération supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'opération: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer toutes les opérations sans pagination (pour les modals)
     */
    public function all()
    {
        try {
            $operations = \App\Models\Operation::with('typeMouvement')->get();
            
            return response()->json([
                'success' => true, 
                'data' => $operations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Erreur lors de la récupération des opérations: ' . $e->getMessage()
            ], 500);
        }
    }
}