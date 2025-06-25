<?php

namespace App\Imports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArticlesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Valeurs par défaut pour les champs obligatoires non présents dans l'Excel
        return new Article([
            'codeArticle' => $row['code_article'],
            'description' => $row['description'],
            'uniteDeMesure' => $row['unite_de_mesure'],
            'idOrganisation' => $row['organisationid'],
            'quantiteStock' => 0, // Valeur par défaut
            'seuilAlerte' => 10, // Valeur par défaut
            'quantiteInitiale' => 0, // Valeur par défaut
            'prixUnitaire' => 0 // Valeur par défaut
        ]);
    }
} 