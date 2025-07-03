<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion de Stock KARDEX</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-blue-700">Dashboard - Gestion de Stock</h1>
            <div class="flex space-x-4">
                <a href="{{ route('stock.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Voir Stock
                </a>
                <a href="/stockDb/public/magasinier" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Nouvelle Fiche
                </a>
                <a href="{{ route('dashboard.report') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                    Rapport PDF
                </a>
                <a href="{{ route('documentation.manuel') }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                    📖 Manuel PDF
                </a>
            </div>
        </div>

        <!-- Métriques principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Total Articles</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalArticles ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">En Stock</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $articlesEnStock ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Alerte Stock</h3>
                        <p class="text-3xl font-bold text-red-600">{{ $articlesAlerte ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Mouvements</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalMouvements ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques et analyses -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Graphique des mouvements par mois -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Mouvements par Mois</h3>
                <canvas id="mouvementsChart" width="400" height="200"></canvas>
            </div>

            <!-- Graphique des articles par catégorie -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Répartition des Articles</h3>
                <div class="flex justify-center">
                    <div style="width: 300px; height: 300px;">
                        <canvas id="articlesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rapports détaillés -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Articles en alerte -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Articles en Alerte Stock</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-red-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Code Article</th>
                                <th class="px-4 py-2 text-left">Description</th>
                                <th class="px-4 py-2 text-left">Stock Actuel</th>
                                <th class="px-4 py-2 text-left">Seuil Critique</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articlesAlerteList ?? [] as $article)
                                <tr class="border-b hover:bg-red-50">
                                    <td class="px-4 py-2 font-medium text-red-600">{{ $article->code_article }}</td>
                                    <td class="px-4 py-2">{{ $article->description }}</td>
                                    <td class="px-4 py-2 font-bold text-red-600">{{ $article->quantiteStock }}</td>
                                    <td class="px-4 py-2">{{ $article->seuilAlerte }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">Aucun article en alerte</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mouvements récents -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Mouvements Récents</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Article</th>
                                <th class="px-4 py-2 text-left">Type</th>
                                <th class="px-4 py-2 text-left">Quantité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mouvementsRecents ?? [] as $mouvement)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm">{{ is_string($mouvement->date_mouvement) ? $mouvement->date_mouvement : $mouvement->date_mouvement->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">{{ $mouvement->article->description ?? $mouvement->designation ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $mouvement->typeMouvement && $mouvement->typeMouvement->mouvement === 'Entrée' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $mouvement->typeMouvement ? $mouvement->typeMouvement->mouvement : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $mouvement->quantiteServis }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">Aucun mouvement récent</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Inventaire matériel -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Inventaire Matériel - Rapport Complet</h3>
                <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Imprimer Rapport
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <h4 class="font-semibold text-blue-800">Valeur Totale du Stock</h4>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($valeurTotaleStock ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <h4 class="font-semibold text-green-800">Articles Disponibles</h4>
                    <p class="text-2xl font-bold text-green-600">{{ $articlesDisponibles ?? 0 }}</p>
                </div>
                <div class="text-center p-4 bg-orange-50 rounded-lg">
                    <h4 class="font-semibold text-orange-800">Articles Épuisés</h4>
                    <p class="text-2xl font-bold text-orange-600">{{ $articlesEpuises ?? 0 }}</p>
                </div>
            </div>

            <div class="overflow-x-auto scroll-container">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Code Article</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Unité</th>
                            <th class="px-4 py-2 text-left">Prix Unitaire</th>
                            <th class="px-4 py-2 text-left">Quantité Stock</th>
                            <th class="px-4 py-2 text-left">Valeur Stock</th>
                            <th class="px-4 py-2 text-left">Seuil Critique</th>
                            <th class="px-4 py-2 text-left">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventaireComplet ?? [] as $article)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-medium">{{ $article->code_article }}</td>
                                <td class="px-4 py-2">{{ $article->description }}</td>
                                <td class="px-4 py-2">{{ $article->uniteDeMesure }}</td>
                                <td class="px-4 py-2">{{ number_format($article->prixUnitaire ?? 0, 0, ',', ' ') }} FCFA</td>
                                <td class="px-4 py-2 font-bold">{{ $article->quantiteStock }}</td>
                                <td class="px-4 py-2 font-semibold">{{ number_format(($article->prixUnitaire ?? 0) * $article->quantiteStock, 0, ',', ' ') }} FCFA</td>
                                <td class="px-4 py-2">{{ $article->seuilAlerte }}</td>
                                <td class="px-4 py-2">
                                    @if($article->quantiteStock <= 0)
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Épuisé</span>
                                    @elseif($article->quantiteStock <= $article->seuilAlerte)
                                        <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Alerte</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Disponible</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-4 text-center text-gray-500">Aucun article enregistré</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Graphique des mouvements par mois
        const mouvementsCtx = document.getElementById('mouvementsChart').getContext('2d');
        new Chart(mouvementsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($mouvementsParMoisLabels ?? ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin']) !!},
                datasets: [{
                    label: 'Mouvements',
                    data: {!! json_encode($mouvementsParMoisData ?? [12, 19, 3, 5, 2, 3]) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Graphique des articles par catégorie
        const articlesCtx = document.getElementById('articlesChart').getContext('2d');
        new Chart(articlesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Disponible', 'Alerte', 'Épuisé'],
                datasets: [{
                    data: [
                        {{ $articlesDisponibles ?? 0 }},
                        {{ $articlesAlerte ?? 0 }},
                        {{ $articlesEpuises ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(251, 146, 60)',
                        'rgb(239, 68, 68)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>