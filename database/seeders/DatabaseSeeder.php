<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Operation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Création de l'utilisateur admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Création de quelques articles
        $articles = [
            [
                'designation' => 'Ordinateur portable',
                'code_article' => 'ORD-001',
                'prix_unitaire' => 1200.00,
                'unite_mesure' => 'unité',
                'quantite_stock' => 10,
                'seuil_critique' => 3,
                'description' => 'Ordinateur portable professionnel'
            ],
            [
                'designation' => 'Imprimante laser',
                'code_article' => 'IMP-001',
                'prix_unitaire' => 300.00,
                'unite_mesure' => 'unité',
                'quantite_stock' => 5,
                'seuil_critique' => 2,
                'description' => 'Imprimante laser noir et blanc'
            ],
            [
                'designation' => 'Papier A4',
                'code_article' => 'PAP-001',
                'prix_unitaire' => 5.00,
                'unite_mesure' => 'rame',
                'quantite_stock' => 100,
                'seuil_critique' => 20,
                'description' => 'Rame de papier A4 80g/m²'
            ]
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }

        // Création de quelques types d'opérations
        $operations = [
            [
                'type_operation' => 'Réception fournisseur',
                'date_operation' => now(),
                'description' => 'Réception de marchandises'
            ],
            [
                'type_operation' => 'Sortie diverses',
                'date_operation' => now(),
                'description' => 'Sortie pour consommation interne'
            ],
            [
                'type_operation' => 'Retour / Reversement',
                'date_operation' => now(),
                'description' => 'Retour de matériel non utilisé'
            ]
        ];

        foreach ($operations as $operation) {
            Operation::create($operation);
        }
    }
}
