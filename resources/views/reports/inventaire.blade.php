<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport d'Inventaire - {{ date('d/m/Y') }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-item {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        
        .summary-item h3 {
            margin: 0 0 10px 0;
            color: #475569;
            font-size: 14px;
        }
        
        .summary-item p {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #475569;
        }
        
        .status-available {
            background-color: #dcfce7;
            color: #166534;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
        }
        
        .status-alert {
            background-color: #fed7aa;
            color: #9a3412;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
        }
        
        .status-empty {
            background-color: #fecaca;
            color: #991b1b;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .no-print {
            margin-bottom: 20px;
        }
        
        .btn-print {
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-print:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">Imprimer le Rapport</button>
        <button class="btn-print" onclick="window.history.back()">Retour</button>
    </div>

    <div class="header">
        <h1>RAPPORT D'INVENTAIRE MATÉRIEL</h1>
        <p>Gestion de Stock KARDEX</p>
        <p>Date de génération : {{ date('d/m/Y à H:i') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <h3>Total Articles</h3>
            <p>{{ $inventaireComplet->count() }}</p>
        </div>
        <div class="summary-item">
            <h3>Valeur Totale</h3>
            <p>{{ number_format($valeurTotaleStock ?? 0, 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="summary-item">
            <h3>Articles en Alerte</h3>
            <p>{{ $inventaireComplet->where('quantiteStock', '<=', DB::raw('seuilAlerte'))->where('quantiteStock', '>', 0)->count() }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Code Article</th>
                <th>Description</th>
                <th>Unité</th>
                <th>Prix Unitaire</th>
                <th>Quantité Stock</th>
                <th>Valeur Stock</th>
                <th>Seuil Critique</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventaireComplet as $article)
                <tr>
                    <td><strong>{{ $article->codeArticle }}</strong></td>
                    <td>{{ $article->description }}</td>
                    <td>{{ $article->uniteDeMesure }}</td>
                    <td>{{ number_format($article->prixUnitaire ?? 0, 0, ',', ' ') }} FCFA</td>
                    <td><strong>{{ $article->quantiteStock }}</strong></td>
                    <td><strong>{{ number_format(($article->prixUnitaire ?? 0) * $article->quantiteStock, 0, ',', ' ') }} FCFA</strong></td>
                    <td>{{ $article->seuilAlerte }}</td>
                    <td>
                        @if($article->quantiteStock <= 0)
                            <span class="status-empty">Épuisé</span>
                        @elseif($article->quantiteStock <= $article->seuilAlerte)
                            <span class="status-alert">Alerte</span>
                        @else
                            <span class="status-available">Disponible</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #666;">Aucun article enregistré</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Rapport généré automatiquement par le système de gestion de stock KARDEX</p>
        <p>Page 1 sur 1</p>
    </div>
</body>
</html> 