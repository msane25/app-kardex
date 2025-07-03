<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Mouvement - KARDEX</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-blue-700">Détails du Mouvement</h1>
            <a href="{{ route('stock.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Retour au Stock
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Informations Générales</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium text-gray-700">Date du Mouvement:</span>
                            <span class="ml-2">{{ $mouvement->date_mouvement }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Type de Mouvement:</span>
                            <span class="ml-2">{{ $mouvement->typeMouvement ? $mouvement->typeMouvement->mouvement : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Opération:</span>
                            <span class="ml-2">{{ $mouvement->operation ? $mouvement->operation->libelle : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Quantité:</span>
                            <span class="ml-2">{{ $mouvement->quantiteServis }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Document Number:</span>
                            <span class="ml-2">{{ $mouvement->document_number }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Informations Article</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium text-gray-700">Code Article:</span>
                            <span class="ml-2">{{ $mouvement->article ? $mouvement->article->code_article : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Désignation:</span>
                            <span class="ml-2">{{ $mouvement->designation }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Demandeur:</span>
                            <span class="ml-2">{{ $mouvement->demandeur }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Fournisseur:</span>
                            <span class="ml-2">{{ $mouvement->fournisseur }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Destination:</span>
                            <span class="ml-2">{{ $mouvement->destination }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 