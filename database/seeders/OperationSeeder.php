<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Operation;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $operations = [
            [
                'type_operation' => 'Sortie diverses',
                'libelle' => 'Sortie de stock pour usage interne'
            ],
            [
                'type_operation' => 'Transfert Inter-Organisation',
                'libelle' => 'Transfert entre organisations'
            ],
            [
                'type_operation' => 'Retour / Reversement',
                'libelle' => 'Retour de marchandises'
            ],
            [
                'type_operation' => 'Réception fournisseur',
                'libelle' => 'Réception de marchandises du fournisseur'
            ],
            [
                'type_operation' => 'Achat',
                'libelle' => 'Achat de marchandises'
            ],
            [
                'type_operation' => 'Don',
                'libelle' => 'Don de marchandises'
            ],
            [
                'type_operation' => 'Perte',
                'libelle' => 'Perte de marchandises'
            ],
            [
                'type_operation' => 'Inventaire',
                'libelle' => 'Correction d\'inventaire'
            ]
        ];

        foreach ($operations as $operation) {
            Operation::updateOrCreate(
                ['type_operation' => $operation['type_operation']],
                $operation
            );
        }
    }
}
