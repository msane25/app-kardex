<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Données Stock - KARDEX</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Styles pour la barre de défilement */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
            border: 3px solid #f1f5f9;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        /* Pour Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #3b82f6 #f1f5f9;
        }

        /* Styles pour les conteneurs avec défilement */
        .scroll-container {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-blue-700">Données Stock KARDEX</h1>
            <a href="/stockDb/public/magasinier" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Nouvelle Fiche
            </a>
        </div>

        <!-- Articles -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="mb-4 text-right text-blue-700 font-bold">
                Date du jour : {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </div>
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Articles en Stock</h2>
            <div class="overflow-x-auto scroll-container">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Code Article</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Quantité Initiale</th>
                            <th class="px-4 py-2 text-left">Quantité Stock</th>
                            <th class="px-4 py-2 text-left">Unité</th>
                            <th class="px-4 py-2 text-left">Seuil Alerte</th>
                            <th class="px-4 py-2 text-left">Date Création</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $index => $article)
                            <tr class="border-b hover:bg-gray-50 @if($index === 0) bg-blue-50 font-bold @endif">
                                <td class="px-4 py-2 font-medium">{{ $article->code_article }}</td>
                                <td class="px-4 py-2">{{ $article->description }}</td>
                                <td class="px-4 py-2">{{ $article->quantite_stock }}</td>
                                <td class="px-4 py-2">{{ $article->quantite_stock }}</td>
                                <td class="px-4 py-2">{{ $article->unite_mesure }}</td>
                                <td class="px-4 py-2">{{ $article->seuil_critique }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $article->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">Aucun article enregistré</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mouvements -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Mouvements de Stock</h2>
            <div class="overflow-x-auto scroll-container">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th>Date Mouvement</th>
                            <th>Mouvement</th>
                            <th>Opération</th>
                            <th>Code Article</th>
                            <th>Désignation</th>
                            <th>Demandeur / Direction</th>
                            <th>Fournisseur</th>
                            <th>N° Commande</th>
                            <th>Doc Associé</th>
                            <th>Quantité Servis</th>
                            <th>Réceptionnaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mouvements as $mouvement)
                            <tr>
                                <td>{{ $mouvement->date_mouvement }}</td>
                                <td>{{ $mouvement->typeMouvement ? $mouvement->typeMouvement->mouvement : '' }}</td>
                                <td>{{ $mouvement->operation->libelle ?? '' }}</td>
                                <td>{{ $mouvement->article ? $mouvement->article->code_article : '' }}</td>
                                <td>{{ $mouvement->designation ?? '' }}</td>
                                <td>{{ $mouvement->demandeur }} / {{ $mouvement->direction }}</td>
                                <td>{{ $mouvement->fournisseur }}</td>
                                <td>{{ $mouvement->document_number ?? '' }}</td>
                                <td>{{ $mouvement->document_number }}</td>
                                <td>{{ $mouvement->quantiteServis }}</td>
                                <td>{{ $mouvement->receptionnaire }}</td>
                                <!-- Boutons d'action (ex: voir, éditer, supprimer) -->
                                <!-- <a href="{{ route('mouvements.show', $mouvement->idMouvement) }}">Voir</a> -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-4 py-4 text-center text-gray-500">Aucun mouvement enregistré</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tableau de récupération des Types de Mouvement --}}
        {{-- Fin du bloc à supprimer --}}

        {{-- Tableau de récupération des Opérations --}}
        {{-- Fin du bloc à supprimer --}}
    </div>
</body>
</html>