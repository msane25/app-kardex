<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MAGASINIER</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
    input, select, textarea {
        background-color: #e3f2fd; /* Bleu clair */
    }

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

    input:focus, select:focus, textarea:focus {
        background-color: #bbdefb; /* Bleu plus vif au focus */
        outline: none;
        border-color: #2196f3;
        box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.3);
    }

    /* Exception pour le seuil critique qui reste en rouge */
    #seuil_critique {
        background-color: #ffebee !important; /* Rouge clair */
    }

    #seuil_critique:focus {
        background-color: #ffcdd2 !important; /* Rouge plus vif au focus */
        border-color: #f44336 !important;
        box-shadow: 0 0 0 2px rgba(244, 67, 54, 0.3) !important;
    }

    /* Styles pour le modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 2% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 95%;
        max-width: 1100px;
        max-height: 90vh;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }

    .modal-header {
        position: sticky;
        top: 0;
        background-color: #fefefe;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
        z-index: 10;
    }

    .modal-body {
        overflow-y: auto;
        padding: 15px 0;
        flex-grow: 1;
    }

    .modal-footer {
        position: sticky;
        bottom: 0;
        background-color: #fefefe;
        padding-top: 15px;
        border-top: 1px solid #e5e7eb;
        z-index: 10;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <h1 class="uppercase text-center font-extrabold text-3xl mt-8 tracking-wider text-blue-800 drop-shadow-lg">Bienvenue</h1>
    <nav class="bg-blue-700 p-6 text-white shadow-xl flex items-center justify-between rounded-b-2xl mb-8">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/img7.png') }}" alt="Logo KARDEX" class="h-14 w-auto rounded-xl shadow-md border-2 border-white">
            <span class="text-2xl font-extrabold tracking-wide">Application de Gestion de Stock</span>
        </div>
        <div class="flex flex-col items-end space-y-4">
            <form method="POST" action="{{ url('/logout') }}" class="ml-4">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-all duration-200 text-lg">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>
    <div class="flex justify-center mb-8">
        <a href="{{ route('stock.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-xl shadow-md hover:bg-gray-700 transition-all duration-200 text-lg font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Voir les données enregistrées
        </a>
    </div>
    <!-- Modal pour créer un article -->
    <div id="articleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-blue-700">Créer un nouvel article</h2>
                    <span class="close" onclick="closeArticleModal()">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form class="space-y-4" id="articleForm" method="POST" action="{{ route('articles.store') }}">
                    @csrf
                    <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                        <tbody>
                            <tr class="bg-blue-50">
                                <td class="px-6 py-3 font-bold text-blue-800 border-b border-blue-100 text-right w-1/3">Code Article *</td>
                                <td class="px-6 py-3 border-b border-blue-100"><input type="text" id="code_article" name="code_article" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300"></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 font-bold text-blue-800 border-b border-blue-100 text-right">Description *</td>
                                <td class="px-6 py-3 border-b border-blue-100"><input type="text" id="modal_description" name="modal_description" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300"></td>
                            </tr>
                            <tr class="bg-blue-50">
                                <td class="px-6 py-3 font-bold text-blue-800 border-b border-blue-100 text-right">Unité de Mesure *</td>
                                <td class="px-6 py-3 border-b border-blue-100">
                                    <input type="text" id="modal_unite_mesure" name="modal_unite_mesure" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300">
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 font-bold text-blue-800 text-right">Quantité Stock *</td>
                                <td class="px-6 py-3 border-b border-blue-100"><input type="number" id="modal_quantite_stock" name="modal_quantite_stock" required min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300"></td>
                            </tr>
                            <tr class="bg-blue-50">
                                <td class="px-6 py-3 font-bold text-blue-800 text-right">Prix Unitaire *</td>
                                <td class="px-6 py-3 border-b border-blue-100"><input type="number" id="modal_prix_unitaire" name="modal_prix_unitaire" required min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300"></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 font-bold text-blue-800 text-right">Seuil Alerte *</td>
                                <td class="px-6 py-3 border-b border-blue-100"><input type="number" id="modal_seuil_alerte" name="modal_seuil_alerte" required min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300"></td>
                            </tr>
                            <tr class="bg-blue-50">
                                <td class="px-6 py-3 font-bold text-blue-800 border-b border-blue-100 text-right">Organisation *</td>
                                <td class="px-6 py-3 border-b border-blue-100">
                                    <select id="modal_organisation_id" name="modal_organisation_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300">
                                        <option value="">-- Sélectionner --</option>
                                        <option value="1">Direction Générale</option>
                                        <option value="2">Service Informatique</option>
                                        <option value="3">Service Financier</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 font-bold text-blue-800 text-right">Date de Création *</td>
                                <td class="px-6 py-3"><input type="date" id="modal_date_creation" name="modal_date_creation" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300" value="{{ date('Y-m-d') }}"></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeArticleModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="button" onclick="saveArticle()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Enregistrer
                    </button>
                    <button type="button" onclick="editArticle()" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                        Modifier
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour créer un mouvement -->
    <div id="mouvementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-blue-700">Créer un nouveau mouvement</h2>
                    <span class="close" onclick="closeMouvementModal()">&times;</span>
                </div>
            </div>
            
            <div class="modal-body">
                <form class="space-y-4">
                    <div>
                        <label for="modal_date_mouvement" class="block text-sm font-medium text-gray-700">Date Mouvement *</label>
                        <input type="date" id="modal_date_mouvement" name="modal_date_mouvement" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" value="{{ date('Y-m-d') }}">
                    </div>

                    <div>
                        <label for="modal_type_mouvement" class="block text-sm font-medium text-gray-700">Mouvement *</label>
                        <select id="modal_type_mouvement" name="modal_type_mouvement" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Sélectionner --</option>
                            <!-- Les types de mouvement seront chargés dynamiquement -->
                        </select>
                    </div>
                    
                    <div>
                        <label for="modal_operation" class="block text-sm font-medium text-gray-700">Opération *</label>
                        <select id="modal_operation" name="modal_operation" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Sélectionner --</option>
                            <option value="Sortie diverses">Sortie diverses (Sortie)</option>
                            <option value="Transfert Inter-Organisation">Transfert Inter-Organisation (Sortie)</option>
                            <option value="Retour / Reversement">Retour / Reversement (Entrée)</option>
                            <option value="Réception fournisseur">Réception fournisseur (Entrée)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="code_article_mvt" class="block text-sm font-medium text-gray-700">Code Article *</label>
                        <select id="modal_code_article_mvt" name="modal_code_article_mvt" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Sélectionner --</option>
                            <!-- Les articles seront chargés dynamiquement -->
                        </select>
                    </div>

                    <div>
                        <label for="modal_designation_mvt" class="block text-sm font-medium text-gray-700">Désignation *</label>
                        <input type="text" id="modal_designation_mvt" name="modal_designation_mvt" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="modal_demandeur" class="block text-sm font-medium text-gray-700">Demandeur (SERVICE) / DIRECTION</label>
                        <input type="text" id="modal_demandeur" name="modal_demandeur" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="modal_fournisseur" class="block text-sm font-medium text-gray-700">Fournisseur</label>
                        <input type="text" id="modal_fournisseur" name="modal_fournisseur" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="modal_num_commande" class="block text-sm font-medium text-gray-700">N° Commande 2025</label>
                        <input type="text" id="modal_num_commande" name="modal_num_commande" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Ex: CMD-2025-001">
                    </div>

                    <div>
                        <label for="modal_doc_associe" class="block text-sm font-medium text-gray-700">Doc Associé (PDF uniquement)</label>
                        <input type="file" id="modal_doc_associe" name="modal_doc_associe" accept="application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label for="modal_quantite_servis" class="block text-sm font-medium text-gray-700">Quantité Servis *</label>
                        <input type="number" id="modal_quantite_servis" name="modal_quantite_servis" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="modal_receptionnaire" class="block text-sm font-medium text-gray-700">RECEPTIONNAIRE</label>
                        <input type="text" id="modal_receptionnaire" name="modal_receptionnaire" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Nom du réceptionnaire">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeMouvementModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="button" onclick="saveMouvement()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Enregistrer
                    </button>
                    <button type="button" onclick="editMouvement()" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                        Modifier
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour créer une opération -->
    <div id="operationModal" class="modal flex items-center justify-center">
        <div class="modal-content">
            <div class="modal-header">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-red-700">Créer une nouvelle opération</h2>
                    <span class="close" onclick="closeOperationModal()">&times;</span>
                </div>
            </div>
            
            <div class="modal-body">
                <form class="space-y-4">
                    <div>
                        <label for="modal_libelle_operation" class="block text-sm font-medium text-gray-700">Libellé Opération *</label>
                        <input type="text" id="modal_libelle_operation" name="modal_libelle_operation" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Ex: Achat, Don, Inventaire...">
                    </div>
                    <div>
                        <label for="modal_type_mouvement_operation" class="block text-sm font-medium text-gray-700">Type de Mouvement *</label>
                        <select id="modal_type_mouvement_operation" name="modal_type_mouvement_operation" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Sélectionner --</option>
                            <!-- Les types de mouvement seront chargés dynamiquement -->
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeOperationModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="button" onclick="saveOperation()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Enregistrer
                    </button>
                    <button type="button" onclick="editOperation()" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                        Modifier
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour créer un type de mouvement -->
    <div id="typeMouvementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-green-700">Créer un nouveau type de mouvement</h2>
                    <span class="close" onclick="closeTypeMouvementModal()">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form class="space-y-4" onsubmit="event.preventDefault(); saveTypeMouvement();">
                    <div>
                        <label for="modal_type_mouvement_value" class="block text-sm font-medium text-gray-700">Type de Mouvement *</label>
                        <input type="text" id="modal_type_mouvement_value" name="modal_type_mouvement_value" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Ex: Entrée, Sortie, Retour...">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeTypeMouvementModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="button" onclick="saveTypeMouvement()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-5xl border border-blue-200">
            <h2 class="text-4xl font-extrabold mb-10 text-center text-blue-700 uppercase tracking-widest drop-shadow">APP STOCK</h2>

            <!-- Date & Document en haut -->
            <div class="w-full flex justify-center mb-6">
                <div class="flex flex-col items-center">
                    <label for="date" class="block text-lg font-bold text-blue-700 mb-1 tracking-wide">Date</label>
                    <div class="bg-blue-50 border-2 border-blue-300 rounded-xl px-8 py-3 shadow-lg text-2xl font-extrabold text-blue-800 tracking-widest text-center">
                        {{ date('d/m/Y') }}
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-row justify-center mb-10">
                <div class="flex flex-col gap-6 items-center w-full max-w-lg mx-auto">
                    <button onclick="openArticleModal()" class="w-full inline-flex items-center px-6 py-3 bg-yellow-500 text-white rounded-xl shadow-md hover:bg-yellow-600 transition-all duration-200 text-lg font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="w-full text-center">Article</span>
                    </button>
                    <button onclick="openTypeMouvementModal()" class="w-full inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl shadow-md hover:bg-green-700 transition-all duration-200 text-lg font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="w-full text-center">Type Mouvement</span>
                    </button>
                    <button onclick="openOperationModal()" class="w-full inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-xl shadow-md hover:bg-red-700 transition-all duration-200 text-lg font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="w-full text-center">Operation</span>
                    </button>
                    <button onclick="openMouvementModal()" class="w-full inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 transition-all duration-200 text-lg font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="w-full text-center">Mouvement</span>
                    </button>
                </div>
            </div>

            <!-- Messages de succès/erreur -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <strong>Succès !</strong> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <strong>Erreur !</strong> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <strong>Erreurs de validation :</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('stock.store') }}" method="POST" class="space-y-6 uppercase">
                @csrf

                <!-- Aperçu -->
                <div id="preview" class="hidden mt-10 bg-white p-6 rounded-xl shadow-lg border border-blue-300 text-left">
                    <h3 class="text-xl font-bold text-blue-800 mb-4 uppercase">Aperçu de l'APP STOCK</h3>
                    <div id="preview-content" class="space-y-2 text-gray-800 font-medium"></div>
                </div>

                <!-- Nouvelle position : seuil, prix, unité, stock -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-4 hidden" id="article-infos-fields">
                    <div>
                        <label for="prix_unitaire" class="block text-sm font-medium text-gray-700">Prix Unitaire</label>
                        <input type="number" id="prix_unitaire" name="prix_unitaire" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="unite_mesure" class="block text-sm font-medium text-gray-700">Unité de Mesure</label>
                        <input type="text" id="unite_mesure" name="unite_mesure" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="quantite_stock" class="block text-sm font-medium text-gray-700">Quantité en Stock</label>
                        <input type="number" id="quantite_stock" name="quantite_stock" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="seuil_critique" class="block text-sm font-semibold text-red-700 uppercase">Seuil Critique</label>
                        <input type="number" id="seuil_critique" name="seuil_critique" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <!-- Mouvement (masqué) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6 hidden" id="mouvement-fields">
                    <div>
                        <label for="fournisseur" class="block text-sm font-medium text-gray-700">Émetteur / Fournisseur</label>
                        <select id="fournisseur" name="fournisseur" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Sélectionner --</option>
                            <option value="Émetteur">Émetteur</option>
                            <option value="Fournisseur">Fournisseur</option>
                        </select>
                    </div>

                    <div>
                        <label for="entrees" class="block text-sm font-medium text-gray-700">Entrées</label>
                        <input type="number" id="entrees" name="entrees" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="sorties" class="block text-sm font-medium text-gray-700">Sorties</label>
                        <input type="number" id="sorties" name="sorties" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" id="stock" name="stock" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="type_mouvement" class="block text-sm font-medium text-gray-700">Type Operation</label>
                        <select id="type_mouvement" name="type_mouvement" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Sélectionner --</option>
                            <option value="Sortie diverses">Sortie diverses (Sortie)</option>
                            <option value="Transfert Inter-Organisation">Transfert Inter-Organisation (Sortie)</option>
                            <option value="Retour / Reversement">Retour / Reversement (Entrée)</option>
                            <option value="Réception fournisseur">Réception fournisseur (Entrée)</option>
                        </select>
                    </div>

                    <div>
                        <label for="type_operation" class="block text-sm font-medium text-gray-700">Mouvement</label>
                        <input type="text" id="type_operation" name="type_operation" placeholder="Ex: Achat, Don..." class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <!-- Boutons -->
                <div class="text-center pt-8 space-x-4">
                    <button type="button" onclick="printPreview()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition text-lg font-semibold">
                        Imprimer
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-lg font-semibold">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau de récupération des articles -->
    <div class="min-h-screen flex items-center justify-center p-6 mt-8">
        <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-7xl border border-blue-200">
            <h2 class="text-4xl font-extrabold mb-10 text-center text-blue-700 uppercase tracking-widest drop-shadow">TABLEAU DE RÉCUPÉRATION DES ARTICLES</h2>

            <!-- Filtres pour articles -->
            <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Filtres Articles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="filter_article_code" class="block text-sm font-medium text-gray-700 mb-2">Code Article</label>
                        <input type="text" id="filter_article_code" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300" placeholder="Rechercher par code...">
                    </div>
                    <div>
                        <label for="filter_article_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <input type="text" id="filter_article_description" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300" placeholder="Rechercher par description...">
                    </div>
                    <div>
                        <label for="filter_article_organisation" class="block text-sm font-medium text-gray-700 mb-2">Organisation</label>
                        <select id="filter_article_organisation" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300">
                            <option value="">Toutes les organisations</option>
                            <option value="1">Direction Générale</option>
                            <option value="2">Service Informatique</option>
                            <option value="3">Service Financier</option>
                        </select>
                    </div>
                    <div>
                        <label for="filter_article_stock" class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                        <select id="filter_article_stock" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300">
                            <option value="">Tous</option>
                            <option value="en_stock">En stock</option>
                            <option value="stock_faible">Stock faible</option>
                            <option value="rupture">Rupture</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <button onclick="applyArticleFilters()" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Appliquer les filtres
                    </button>
                    <button onclick="clearArticleFilters()" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Effacer les filtres
                    </button>
                    <button onclick="refreshArticleTable()" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        Actualiser
                    </button>
                </div>
            </div>

            <!-- Tableau des articles -->
            <div class="overflow-x-auto">
                <table id="articlesTable" class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden shadow-lg">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Code Article</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Unité de Mesure</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantité Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Prix Unitaire</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Seuil Alerte</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Organisation</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Date Création</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="articlesTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Les données seront chargées dynamiquement -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination pour articles -->
            <div class="mt-6 flex items-center justify-center gap-2">
                <button onclick="previousArticlePage()" id="prevArticleBtn" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50" disabled>
                    Précédent
                </button>
                <span id="currentArticlePage" class="px-3 py-1 bg-blue-600 text-white rounded">1</span>
                <button onclick="nextArticlePage()" id="nextArticleBtn" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50" disabled>
                    Suivant
                </button>
            </div>
        </div>
    </div>

    <!-- Tableau de récupération des types de mouvement -->
    <div class="min-h-screen flex justify-center p-6 mt-8">
        <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-7xl border border-green-200">
            <h2 class="text-3xl font-extrabold mb-8 text-center text-green-700 uppercase tracking-widest drop-shadow">TABLEAU DE RÉCUPÉRATION DES TYPES DE MOUVEMENT</h2>
            <!-- Filtres pour types de mouvement -->
            <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Filtres Types de Mouvement</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="filter_type_mvt_id" class="block text-sm font-medium text-gray-700 mb-2">ID</label>
                        <input type="text" id="filter_type_mvt_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300" placeholder="Rechercher par ID...">
                    </div>
                    <div>
                        <label for="filter_type_mvt_libelle" class="block text-sm font-medium text-gray-700 mb-2">Libellé</label>
                        <input type="text" id="filter_type_mvt_libelle" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300" placeholder="Rechercher par libellé...">
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <button onclick="applyTypeMouvementFilters()" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        Appliquer les filtres
                    </button>
                    <button onclick="clearTypeMouvementFilters()" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Effacer les filtres
                    </button>
                    <button onclick="refreshTypeMouvementTable()" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Actualiser
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="typeMouvementsTable" class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden shadow-lg">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Libellé</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Date de création</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="typeMouvementsTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Les données seront chargées dynamiquement -->
                    </tbody>
                </table>
            </div>
            <!-- Pagination pour types de mouvement -->
            <div class="mt-6 flex items-center justify-center gap-2">
                <button onclick="previousTypeMouvementPage()" id="prevTypeMouvementBtn" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50" disabled>
                    Précédent
                </button>
                <span id="currentTypeMouvementPage" class="px-3 py-1 bg-green-600 text-white rounded">1</span>
                <button onclick="nextTypeMouvementPage()" id="nextTypeMouvementBtn" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50" disabled>
                    Suivant
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de modification de type de mouvement -->
    <div id="typeMouvementEditModal" class="modal" style="display:none;">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-green-700">Modifier le type de mouvement</h2>
                    <span class="close" onclick="closeTypeMouvementEditModal()">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="typeMouvementEditForm" class="space-y-4" onsubmit="event.preventDefault(); saveTypeMouvementEdit();">
                    <input type="hidden" id="edit_type_mvt_id">
                    <div>
                        <label for="edit_type_mvt_libelle" class="block text-sm font-medium text-gray-700">Libellé *</label>
                        <input type="text" id="edit_type_mvt_libelle" name="edit_type_mvt_libelle" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                </form>
            </div>
            <div class="modal-footer flex justify-end space-x-3">
                <button type="button" onclick="closeTypeMouvementEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Annuler</button>
                <button type="submit" form="typeMouvementEditForm" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Enregistrer</button>
            </div>
        </div>
    </div>

    <!-- Tableau de récupération des opérations -->
    <div class="min-h-screen flex justify-center p-6 mt-8">
        <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-7xl border border-red-200">
            <h2 class="text-3xl font-extrabold mb-8 text-center text-red-700 uppercase tracking-widest drop-shadow">TABLEAU DE RÉCUPÉRATION DES OPÉRATIONS</h2>
            <!-- Filtres pour opérations -->
            <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Filtres Opérations</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="filter_operation_id" class="block text-sm font-medium text-gray-700 mb-2">ID</label>
                        <input type="text" id="filter_operation_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-red-300" placeholder="Rechercher par ID...">
                    </div>
                    <div>
                        <label for="filter_operation_libelle" class="block text-sm font-medium text-gray-700 mb-2">Libellé</label>
                        <input type="text" id="filter_operation_libelle" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-red-300" placeholder="Rechercher par libellé...">
                    </div>
                    <div>
                        <label for="filter_operation_type_mvt" class="block text-sm font-medium text-gray-700 mb-2">Type Mouvement</label>
                        <input type="text" id="filter_operation_type_mvt" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-red-300" placeholder="Rechercher par type...">
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <button onclick="applyOperationFilters()" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        Appliquer les filtres
                    </button>
                    <button onclick="clearOperationFilters()" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Effacer les filtres
                    </button>
                    <button onclick="refreshOperationTable()" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Actualiser
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="operationsTable" class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden shadow-lg">
                    <thead class="bg-red-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Libellé</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Type Mouvement</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Date de création</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="operationsTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Les données seront chargées dynamiquement -->
                    </tbody>
                </table>
            </div>
            <!-- Pagination pour opérations -->
            <div class="mt-6 flex items-center justify-center gap-2">
                <button onclick="previousOperationPage()" id="prevOperationBtn" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50" disabled>
                    Précédent
                </button>
                <span id="currentOperationPage" class="px-3 py-1 bg-red-600 text-white rounded">1</span>
                <button onclick="nextOperationPage()" id="nextOperationBtn" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50" disabled>
                    Suivant
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de modification d'opération -->
    <div id="operationEditModal" class="modal" style="display:none;">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-red-700">Modifier l'opération</h2>
                    <span class="close" onclick="closeOperationEditModal()">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="operationEditForm" class="space-y-4" onsubmit="event.preventDefault(); saveOperationEdit();">
                    <input type="hidden" id="edit_operation_id">
                    <div>
                        <label for="edit_operation_libelle" class="block text-sm font-medium text-gray-700">Libellé *</label>
                        <input type="text" id="edit_operation_libelle" name="edit_operation_libelle" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="edit_operation_type_mvt" class="block text-sm font-medium text-gray-700">Type Mouvement *</label>
                        <input type="text" id="edit_operation_type_mvt" name="edit_operation_type_mvt" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                </form>
            </div>
            <div class="modal-footer flex justify-end space-x-3">
                <button type="button" onclick="closeOperationEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Annuler</button>
                <button type="submit" form="operationEditForm" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Enregistrer</button>
            </div>
        </div>
    </div>

    <!-- Tableau de récupération des mouvements -->
    <div class="min-h-screen flex justify-center p-6 mt-8">
        <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-7xl border border-blue-200">
            <h2 class="text-3xl font-extrabold mb-8 text-center text-green-700 uppercase tracking-widest drop-shadow">TABLEAU DE RÉCUPÉRATION DES MOUVEMENTS</h2>
            <!-- Filtres pour mouvements -->
            <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Filtres Mouvements</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <div>
                        <label for="filter_mvt_date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" id="filter_mvt_date" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300">
                    </div>
                    <div>
                        <label for="filter_mvt_code_article" class="block text-sm font-medium text-gray-700 mb-2">Code Article</label>
                        <input type="text" id="filter_mvt_code_article" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300" placeholder="Rechercher par code...">
                    </div>
                    <div>
                        <label for="filter_mvt_type_mouvement" class="block text-sm font-medium text-gray-700 mb-2">Type Mouvement</label>
                        <input type="text" id="filter_mvt_type_mouvement" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300" placeholder="Type...">
                    </div>
                    <div>
                        <label for="filter_mvt_operation" class="block text-sm font-medium text-gray-700 mb-2">Opération</label>
                        <input type="text" id="filter_mvt_operation" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300" placeholder="Opération...">
                    </div>
                    <div>
                        <label for="filter_mvt_demandeur" class="block text-sm font-medium text-gray-700 mb-2">Demandeur</label>
                        <input type="text" id="filter_mvt_demandeur" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300" placeholder="Demandeur...">
                    </div>
                    <div>
                        <label for="filter_mvt_fournisseur" class="block text-sm font-medium text-gray-700 mb-2">Fournisseur</label>
                        <input type="text" id="filter_mvt_fournisseur" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300" placeholder="Fournisseur...">
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <button onclick="applyMouvementFilters()" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        Appliquer les filtres
                    </button>
                    <button onclick="clearMouvementFilters()" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Effacer les filtres
                    </button>
                    <button onclick="refreshMouvementTable()" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Actualiser
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="mouvementsTable" class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden shadow-lg">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Date Mouvement</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Code Article</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Désignation</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantité</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Type Mouvement</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Opération</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Demandeur</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Fournisseur</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Matricule</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="mouvementsTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Les données seront chargées dynamiquement -->
                    </tbody>
                </table>
            </div>
            <!-- Pagination pour mouvements -->
            <div class="mt-6 flex items-center justify-center gap-2">
                <button onclick="previousMouvementPage()" id="prevMouvementBtn" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50" disabled>
                    Précédent
                </button>
                <span id="currentMouvementPage" class="px-3 py-1 bg-green-600 text-white rounded">1</span>
                <button onclick="nextMouvementPage()" id="nextMouvementBtn" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50" disabled>
                    Suivant
                </button>
            </div>
        </div>
    </div>

    <!-- Début du bloc JavaScript -->
    <script>
    function showPreview() {
        const fields = [
            'nomenclature', 'designation', 'prix_unitaire', 'unite_mesure', 'quantite_stock', 'seuil_critique',
            'date', 'document',
            'entrees', 'sorties', 'stock', 'type_mouvement', 'type_operation', 'fournisseur'
        ];

        let html = '<ul class="space-y-1 list-disc pl-5">';
        fields.forEach(id => {
            const element = document.getElementById(id);
            if (element && element.value) {
                const label = element.previousElementSibling?.textContent || id;
                html += `<li><strong>${label} :</strong> ${element.value}</li>`;
            }
        });
        html += '</ul>';

        document.getElementById('preview-content').innerHTML = html;
        document.getElementById('preview').classList.remove('hidden');
        document.getElementById('preview').scrollIntoView({ behavior: 'smooth' });
    }

    function printPreview() {
        // Récupérer toutes les données du formulaire
        const formData = {};
        const fields = [
            'nomenclature', 'designation', 'prix_unitaire', 'unite_mesure', 'quantite_stock', 'seuil_critique',
            'date', 'document', 'entrees', 'sorties', 'stock', 'type_mouvement', 'type_operation', 'fournisseur'
        ];

        fields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                formData[id] = element.value;
            }
        });

        // Créer le contenu HTML pour l'impression
        let printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>APP STOCK - Impression</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                    .section { margin-bottom: 20px; }
                    .section h3 { color: #2563eb; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
                    .field { margin-bottom: 10px; }
                    .field label { font-weight: bold; display: inline-block; width: 200px; }
                    .field value { color: #333; }
                    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
                    @media print {
                        body { margin: 0; }
                        .no-print { display: none; }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>APP STOCK</h1>
                    <p>Date d'impression: ${new Date().toLocaleDateString('fr-FR')}</p>
                </div>

                <div class="section">
                    <h3>INFORMATIONS GÉNÉRALES</h3>
                    <div class="grid">
                        <div class="field">
                            <label>Code Article:</label>
                            <span class="value">${formData.nomenclature || 'Non renseigné'}</span>
                        </div>
                        <div class="field">
                            <label>Désignation:</label>
                            <span class="value">${formData.designation || 'Non renseigné'}</span>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <h3>DÉTAILS TECHNIQUES</h3>
                    <div class="grid">
                        <div class="field">
                            <label>Prix Unitaire:</label>
                            <span class="value">${formData.prix_unitaire || 'Non renseigné'}</span>
                        </div>
                        <div class="field">
                            <label>Unité de Mesure:</label>
                            <span class="value">${formData.unite_mesure || 'Non renseigné'}</span>
                        </div>
                        <div class="field">
                            <label>Quantité en Stock:</label>
                            <span class="value">${formData.quantite_stock || 'Non renseigné'}</span>
                        </div>
                        <div class="field">
                            <label>Seuil Critique:</label>
                            <span class="value">${formData.seuil_critique || 'Non renseigné'}</span>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <h3>INFORMATIONS DE MOUVEMENT</h3>
                    <div class="grid">
                        <div class="field">
                            <label>Date:</label>
                            <span class="value">${formData.date || 'Non renseigné'}</span>
                        </div>
                        <div class="field">
                            <label>Émetteur/Fournisseur:</label>
                            <span class="value">${formData.fournisseur || 'Non renseigné'}</span>
                        </div>
                        <div class="field">
                            <label>Type d'Opération:</label>
                            <span class="value">${formData.type_mouvement || 'Non renseigné'}</span>
                        </div>
                        <div class="field">
                            <label>Entrées:</label>
                            <span class="value">${formData.entrees || '0'}</span>
                        </div>
                        <div class="field">
                            <label>Sorties:</label>
                            <span class="value">${formData.sorties || '0'}</span>
                        </div>
                        <div class="field">
                            <label>Stock:</label>
                            <span class="value">${formData.stock || 'Non renseigné'}</span>
                        </div>
                        <div class="field">
                            <label>Mouvement:</label>
                            <span class="value">${formData.type_operation || 'Non renseigné'}</span>
                        </div>
                    </div>
                </div>

                <div class="no-print" style="margin-top: 30px; text-align: center;">
                    <button onclick="window.print()" style="padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 5px; cursor: pointer;">Imprimer</button>
                    <button onclick="window.close()" style="padding: 10px 20px; background: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">Fermer</button>
                </div>
            </body>
            </html>
        `;

        // Ouvrir une nouvelle fenêtre pour l'impression
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        printWindow.document.write(printContent);
        printWindow.document.close();
        // Attendre que le contenu soit chargé avant d'imprimer
        printWindow.onload = function() {
            printWindow.focus();
            // L'utilisateur peut cliquer sur le bouton Imprimer ou utiliser Ctrl+P
        };
    }

    function updateFields() {
        const fournisseur = document.getElementById('fournisseur').value;
        const entrees = document.getElementById('entrees');
        const sorties = document.getElementById('sorties');
        if (fournisseur === 'Émetteur') {
            sorties.disabled = true;
            entrees.disabled = false;
            sorties.value = '';
        } else if (fournisseur === 'Fournisseur') {
            entrees.disabled = true;
            sorties.disabled = false;
            entrees.value = '';
        } else {
            entrees.disabled = false;
            sorties.disabled = false;
        }
    }

    // Fonctions pour le modal
    function openArticleModal() {
        console.log('Tentative d\'ouverture du modal Article');
        try {
            const modal = document.getElementById('articleModal');
            if (modal) {
                modal.style.display = 'block';
                console.log('Modal Article ouvert avec succès');
            } else {
                console.error('Modal Article non trouvé');
                alert('Erreur: Modal Article non trouvé');
            }
        } catch (error) {
            console.error('Erreur lors de l\'ouverture du modal Article:', error);
            alert('Erreur lors de l\'ouverture du modal Article: ' + error.message);
        }
    }
    
    function closeArticleModal() {
        try {
            const modal = document.getElementById('articleModal');
            if (modal) {
                modal.style.display = 'none';
            }
        } catch (error) {
            console.error('Erreur lors de la fermeture du modal Article:', error);
        }
    }

    function saveArticle() {
        const codeArticle = document.getElementById('code_article').value;
        const description = document.getElementById('modal_description').value;
        const uniteDeMesure = document.getElementById('modal_unite_mesure').value;
        const quantiteStock = document.getElementById('modal_quantite_stock').value;
        const seuilAlerte = document.getElementById('modal_seuil_alerte').value;
        const idOrganisation = document.getElementById('modal_organisation_id').value;
        const prixUnitaire = document.getElementById('modal_prix_unitaire').value;

        // Vérification uniquement des champs vraiment obligatoires
        if (codeArticle && description && uniteDeMesure && quantiteStock && seuilAlerte && idOrganisation) {
            const formData = new FormData();
            formData.append('codeArticle', codeArticle);
            formData.append('description', description);
            formData.append('uniteDeMesure', uniteDeMesure);
            formData.append('quantiteStock', quantiteStock);
            formData.append('seuilAlerte', seuilAlerte);
            formData.append('idOrganisation', idOrganisation);
            if (prixUnitaire) formData.append('prixUnitaire', prixUnitaire);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('{{ route("articles.store") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 401) {
                        window.location.href = '/login';
                        throw new Error('Vous devez être connecté pour effectuer cette action.');
                    }
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('modal_unite_mesure').value = uniteDeMesure;
                    document.getElementById('modal_quantite_stock').value = quantiteStock;
                    document.getElementById('modal_seuil_alerte').value = seuilAlerte;
                    closeArticleModal();
                    alert('Article créé avec succès !');
                    // Ajout dynamique dans le select du mouvement
                    const selectMvt = document.getElementById('modal_code_article_mvt');
                    if (selectMvt) {
                        // Ajoute la nouvelle option
                        const newOption = document.createElement('option');
                        // On suppose que l'API retourne l'id et le codeArticle/description dans data.data
                        const article = data.data || {};
                        if (article.id) {
                            newOption.value = article.id; // Toujours l'id numérique
                            newOption.text = (article.codeArticle || codeArticle) + ' - ' + (article.description || description);
                            selectMvt.appendChild(newOption);
                            selectMvt.value = article.id;
                        } else {
                            // fallback si pas d'id
                            newOption.value = '';
                            newOption.text = (article.codeArticle || codeArticle) + ' - ' + (article.description || description);
                            selectMvt.appendChild(newOption);
                            selectMvt.value = '';
                        }
                    } else {
                        // Si le select n'existe pas, on recharge la liste
                        if (typeof loadArticles === 'function') loadArticles();
                    }
                } else {
                    throw new Error(data.message || 'Erreur lors de la création de l\'article');
                }
            })
            .catch(error => {
                let errorMessage = 'Erreur lors de la création de l\'article';
                if (error.message) {
                    errorMessage += ': ' + error.message;
                }
                if (error.errors) {
                    errorMessage += '\n' + Object.values(error.errors).join('\n');
                }
                alert(errorMessage);
            });
        } else {
            alert('Veuillez remplir tous les champs obligatoires.');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        console.log('Page chargée, initialisation des événements...');
        
        // Vérifier que tous les modals existent
        const modals = ['articleModal', 'mouvementModal', 'operationModal', 'typeMouvementModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal) {
                console.log(`Modal ${modalId} trouvé`);
            } else {
                console.error(`Modal ${modalId} NON TROUVÉ`);
            }
        });

        // Vérifier que tous les boutons existent
        const buttons = [
            { id: 'openArticleModal', onclick: 'openArticleModal()' },
            { id: 'openMouvementModal', onclick: 'openMouvementModal()' },
            { id: 'openOperationModal', onclick: 'openOperationModal()' },
            { id: 'openTypeMouvementModal', onclick: 'openTypeMouvementModal()' }
        ];

        // Initialiser les événements pour les boutons
        const select = document.getElementById('fournisseur');
        if (select) {
            select.addEventListener('change', updateFields);
            updateFields(); // appel initial
        }

        // Fermer le modal en cliquant en dehors
        window.onclick = function(event) {
            const modals = ['articleModal', 'mouvementModal', 'operationModal', 'typeMouvementModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target == modal) {
                    if (modalId === 'articleModal') closeArticleModal();
                    if (modalId === 'mouvementModal') closeMouvementModal();
                    if (modalId === 'operationModal') closeOperationModal();
                    if (modalId === 'typeMouvementModal') closeTypeMouvementModal();
                }
            });
        }

        // Vérifier s'il y a un message de succès avec un numéro de document
        const successMessage = document.querySelector('.bg-green-100');
        if (successMessage && successMessage.textContent.includes('Numéro de document:')) {
            const match = successMessage.textContent.match(/Numéro de document: ([A-Z0-9]+)/);
            if (match) {
                const documentField = document.getElementById('document');
                if (documentField) {
                    documentField.value = match[1];
                }
            }
        }

        console.log('Initialisation terminée');
        
        // Charger le tableau des articles
        loadArticlesTable();
        loadMouvementsTable();
        loadTypeMouvementsTable();
        loadOperationsTable();
    });

    // Fonctions pour le modal de mouvement
    function openMouvementModal() {
        console.log('Tentative d\'ouverture du modal Mouvement');
        try {
            const modal = document.getElementById('mouvementModal');
            if (modal) {
                modal.style.display = 'block';
                console.log('Modal Mouvement ouvert avec succès');
                // Charger les articles dans le select
                loadArticles();
                loadTypeMouvements();
                loadOperations(); // Ajout du chargement dynamique des opérations
            } else {
                console.error('Modal Mouvement non trouvé');
                alert('Erreur: Modal Mouvement non trouvé');
            }
        } catch (error) {
            console.error('Erreur lors de l\'ouverture du modal Mouvement:', error);
            alert('Erreur lors de l\'ouverture du modal Mouvement: ' + error.message);
        }
    }

    function closeMouvementModal() {
        try {
            const modal = document.getElementById('mouvementModal');
            if (modal) {
                modal.style.display = 'none';
            }
        } catch (error) {
            console.error('Erreur lors de la fermeture du modal Mouvement:', error);
        }
    }

    function loadArticles() {
        fetch(getApiUrl('/api/articles'))
            .then(response => response.json())
            .then(result => {
                console.log('Données articles reçues:', result);
                const articles = result.data || result;
                const select = document.getElementById('modal_code_article_mvt');
                if (select) {
                    select.innerHTML = '<option value="">-- Sélectionner --</option>';
                    if (Array.isArray(articles)) {
                        articles.forEach(article => {
                            if (article.code_article) {
                                select.innerHTML += `<option value="${article.code_article}">${article.code_article} - ${article.description}</option>`;
                            }
                        });
                        console.log(`${articles.length} articles chargés`);
                    } else {
                        console.error('Les articles ne sont pas un tableau:', articles);
                    }
                } else {
                    console.error('Select modal_code_article_mvt non trouvé');
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des articles:', error);
                alert('Erreur lors du chargement des articles: ' + error.message);
            });
    }

    function loadTypeMouvements() {
        console.log('Chargement des types de mouvement...');
        const apiUrl = getApiUrl('/api/type-mouvements');
        console.log('URL API types de mouvement:', apiUrl);
        
        fetch(apiUrl)
            .then(response => {
                console.log('Réponse API types de mouvement:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })
            .then(result => {
                console.log('Données types de mouvement reçues:', result);
                const types = result.data || result;
                const select = document.getElementById('modal_type_mouvement');
                if (select) {
                    select.innerHTML = '<option value="">-- Sélectionner --</option>';
                    if (Array.isArray(types)) {
                        types.forEach(type => {
                            select.innerHTML += `<option value="${type.id_type_mouvement}">${type.mouvement}</option>`;
                        });
                        console.log(`${types.length} types de mouvement chargés`);
                    } else {
                        console.error('Les types de mouvement ne sont pas un tableau:', types);
                    }
                } else {
                    console.error('Select modal_type_mouvement non trouvé');
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des types de mouvement:', error);
                alert('Erreur lors du chargement des types de mouvement: ' + error.message);
            });
    }

    function loadOperations(selectedId = null) {
        console.log('Chargement des opérations...');
        const apiUrl = getApiUrl('/api/operations');
        console.log('URL API opérations:', apiUrl);
        
        fetch(apiUrl)
            .then(response => {
                console.log('Réponse API opérations:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })
            .then(result => {
                console.log('Données opérations reçues:', result);
                const operations = result.data || result;
                const select = document.getElementById('modal_operation');
                if (select) {
                    select.innerHTML = '<option value="">-- Sélectionner --</option>';
                    if (Array.isArray(operations)) {
                        operations.forEach(operation => {
                            select.innerHTML += `<option value="${operation.id_operation}">${operation.libelle}</option>`;
                        });
                        if (selectedId) select.value = selectedId;
                        console.log(`${operations.length} opérations chargées`);
                    } else {
                        console.error('Les opérations ne sont pas un tableau:', operations);
                    }
                } else {
                    console.error('Select modal_operation non trouvé');
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des opérations:', error);
                alert('Erreur lors du chargement des opérations: ' + error.message);
            });
    }

    function saveMouvement() {
        const dateMouvement = document.getElementById('modal_date_mouvement').value;
        const typeMouvement = document.getElementById('modal_type_mouvement').value;
        const designation = document.getElementById('modal_designation_mvt').value;
        const demandeur = document.getElementById('modal_demandeur').value;
        const fournisseur = document.getElementById('modal_fournisseur').value;
        const quantite = document.getElementById('modal_quantite_servis').value;
        console.log('Valeur Quantité Servis:', quantite);
        const articleId = document.getElementById('modal_code_article_mvt').value;
        const operationId = document.getElementById('modal_operation').value;
        const numCommande = document.getElementById('modal_num_commande').value;
        const docAssocie = document.getElementById('modal_doc_associe').value;
        const receptionnaire = document.getElementById('modal_receptionnaire').value;
        const destination = document.getElementById('modal_destination') ? document.getElementById('modal_destination').value : '';
        const matricule = document.getElementById('modal_matricule') ? document.getElementById('modal_matricule').value : null;

        // Liste des champs obligatoires et leurs ids
        const requiredFields = [
            {id: 'modal_date_mouvement', label: 'Date Mouvement'},
            {id: 'modal_type_mouvement', label: 'Mouvement'},
            {id: 'modal_operation', label: 'Opération'},
            {id: 'modal_code_article_mvt', label: 'Code Article'},
            {id: 'modal_designation_mvt', label: 'Désignation'},
            {id: 'modal_quantite_servis', label: 'Quantité Servis'}
        ];
        let missing = [];
        // Récupère la liste des ids valides d'articles
        const selectArticle = document.getElementById('modal_code_article_mvt');
        const validArticleIds = Array.from(selectArticle.options)
            .map(opt => opt.value)
            .filter(val => val && !isNaN(Number(val)) && Number(val) > 0);
        requiredFields.forEach(field => {
            const el = document.getElementById(field.id);
            if (field.id === 'modal_code_article_mvt') {
                // Nouvelle validation : accepte toute valeur non vide
                if (!el.value || el.value === "") {
                    missing.push(field.label);
                    el.classList.add('border-red-500', 'bg-red-100');
                } else {
                    el.classList.remove('border-red-500', 'bg-red-100');
                }
            } else {
                if (!el.value) {
                    missing.push(field.label);
                    el.classList.add('border-red-500', 'bg-red-100');
                } else {
                    el.classList.remove('border-red-500', 'bg-red-100');
                }
            }
        });
        if (missing.length > 0) {
            alert('Veuillez remplir les champs obligatoires suivants :\n' + missing.join(', '));
            return;
        }

        fetch(getApiUrl('/api/mouvements'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                date_mouvement: dateMouvement,
                type_mouvement_id: parseInt(typeMouvement),
                quantite: parseInt(quantite),
                quantiteServis: parseInt(quantite),
                code_article: articleId,
                operation_id: parseInt(operationId),
                destination: destination || demandeur || null,
                fournisseur: fournisseur || null,
                document_number: numCommande || `MVT-${Date.now()}`,
                designation: designation || null,
                receptionnaire: receptionnaire || null,
                demandeur: demandeur || null
                // matricule supprimé
            })
        })
        .then(async response => {
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.indexOf('application/json') !== -1) {
                const data = await response.json();
                if (data.success || response.status === 201) {
                    alert('Mouvement créé avec succès !');
                    closeMouvementModal();
                    window.location.reload();
                } else {
                    alert('Erreur lors de la création du mouvement : ' + (data.message || JSON.stringify(data)));
                }
            } else {
                const text = await response.text();
                if (response.status === 401) {
                    alert('Vous n\'êtes pas authentifié. Veuillez vous reconnecter.');
                    window.location.href = '/login';
                } else {
                    alert('Erreur serveur inattendue (réponse non JSON). Détail :\n' + text.substring(0, 300));
                }
            }
        })
        .catch(error => {
            alert('Erreur lors de la création du mouvement : ' + error.message);
        });
    }

    // Fonctions pour le modal d'opération
    function openOperationModal() {
        console.log('Tentative d\'ouverture du modal Operation');
        try {
            const modal = document.getElementById('operationModal');
            if (modal) {
                modal.style.display = 'block';
                console.log('Modal Operation ouvert avec succès');
                loadTypeMouvementsForOperation();
            } else {
                console.error('Modal Operation non trouvé');
                alert('Erreur: Modal Operation non trouvé');
            }
        } catch (error) {
            console.error('Erreur lors de l\'ouverture du modal Operation:', error);
            alert('Erreur lors de l\'ouverture du modal Operation: ' + error.message);
        }
    }

    function closeOperationModal() {
        try {
            const modal = document.getElementById('operationModal');
            if (modal) {
                modal.style.display = 'none';
            }
        } catch (error) {
            console.error('Erreur lors de la fermeture du modal Operation:', error);
        }
    }

    function loadTypeMouvementsForOperation(selectedId = null) {
        fetch(getApiUrl('/api/type-mouvements'))
            .then(response => response.json())
            .then(result => {
                const types = result.data || result;
                const select = document.getElementById('modal_type_mouvement_operation');
                select.innerHTML = '<option value="">-- Sélectionner --</option>';
                types.forEach(type => {
                    select.innerHTML += `<option value="${type.id_type_mouvement}" ${selectedId == type.id_type_mouvement ? 'selected' : ''}>${type.mouvement}</option>`;
                });
            });
    }

    function saveOperation() {
        const libelleOperation = document.getElementById('modal_libelle_operation').value;
        const typeMouvement = document.getElementById('modal_type_mouvement_operation').value;

        if (libelleOperation && typeMouvement) {
            fetch(getApiUrl('/api/operations'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    libelle: libelleOperation,
                    idTypeMouvement: parseInt(typeMouvement),
                    id_type_mouvement: parseInt(typeMouvement),
                    type_mouvement_id: parseInt(typeMouvement)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Opération créée avec succès !');
                    closeOperationModal();
                    // Ajout dynamique dans la liste Opération* du mouvement
                    const select = document.getElementById('modal_operation');
                    if (select) {
                        const newOption = document.createElement('option');
                        newOption.value = data.data && data.data.id ? data.data.id : '';
                        newOption.text = data.data && data.data.libelle ? data.data.libelle : libelleOperation;
                        select.appendChild(newOption);
                        select.value = newOption.value;
                    } else {
                        loadOperations(data.data && data.data.id ? data.data.id : null);
                    }
                } else {
                    alert('Erreur lors de la création de l\'opération : ' + (data.message || JSON.stringify(data)));
                }
            })
            .catch(error => {
                alert('Erreur lors de la création de l\'opération : ' + error.message);
            });
        } else {
            alert('Veuillez remplir tous les champs obligatoires.');
        }
    }

    // Fonctions pour le modal type mouvement
    function openTypeMouvementModal() {
        console.log('Tentative d\'ouverture du modal TypeMouvement');
        try {
            const modal = document.getElementById('typeMouvementModal');
            if (modal) {
                modal.style.display = 'block';
                console.log('Modal TypeMouvement ouvert avec succès');
            } else {
                console.error('Modal TypeMouvement non trouvé');
                alert('Erreur: Modal TypeMouvement non trouvé');
            }
        } catch (error) {
            console.error('Erreur lors de l\'ouverture du modal TypeMouvement:', error);
            alert('Erreur lors de l\'ouverture du modal TypeMouvement: ' + error.message);
        }
    }
    
    function closeTypeMouvementModal() {
        try {
            const modal = document.getElementById('typeMouvementModal');
            if (modal) {
                modal.style.display = 'none';
            }
        } catch (error) {
            console.error('Erreur lors de la fermeture du modal TypeMouvement:', error);
        }
    }

    function saveTypeMouvement() {
        const typeMouvementValue = document.getElementById('modal_type_mouvement_value').value;
        if (typeMouvementValue) {
            fetch(getApiUrl('/api/type-mouvements'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    mouvement: typeMouvementValue
                })
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.indexOf('application/json') !== -1) {
                    const data = await response.json();
                    if (data.success || response.status === 201) {
                        alert('Type de mouvement créé avec succès !');
                        closeTypeMouvementModal();
                        // Recharge dynamiquement la liste dans le select du modal opération et auto-sélectionne le nouveau type
                        if (data.data && data.data.id_type_mouvement) {
                            loadTypeMouvementsForOperation(data.data.id_type_mouvement);
                        } else {
                            loadTypeMouvementsForOperation();
                        }
                        // Efface le champ input
                        document.getElementById('modal_type_mouvement_value').value = '';
                    } else {
                        alert('Erreur lors de la création du type de mouvement : ' + (data.message || JSON.stringify(data)));
                    }
                } else {
                    const text = await response.text();
                    alert('Erreur serveur inattendue (réponse non JSON). Détail :\n' + text.substring(0, 300));
                }
            })
            .catch(error => {
                alert('Erreur lors de la création du type de mouvement : ' + error.message);
            });
        } else {
            alert('Veuillez sélectionner un type de mouvement.');
        }
    }

    // Fonction utilitaire pour gérer l'URL d'API dynamiquement
    function getApiUrl(path) {
        // Utiliser l'URL de base de la page actuelle
        const baseUrl = window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '');
        
        console.log('Base URL:', baseUrl);
        console.log('Path:', path);
        
        // Construire l'URL complète
        let apiUrl;
        
        // Si on est dans /stockDb/public/
        if (window.location.pathname.includes('/stockDb/public/')) {
            apiUrl = window.location.origin + '/stockDb/public' + path;
        }
        // Si on est dans /stockDb/ mais pas /public/
        else if (window.location.pathname.includes('/stockDb/') && !window.location.pathname.includes('/public/')) {
            apiUrl = window.location.origin + '/stockDb/public' + path;
        }
        // Si on est directement dans /public/
        else if (window.location.pathname.includes('/public/')) {
            apiUrl = window.location.origin + '/public' + path;
        }
        // Sinon, ajouter /public par défaut
        else {
            apiUrl = window.location.origin + '/public' + path;
        }
        
        console.log('Generated API URL:', apiUrl);
        return apiUrl;
    }

    // Gestion des overlays (fermeture modale au clic extérieur)
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('articleModal')) closeArticleModal();
        if (event.target === document.getElementById('mouvementModal')) closeMouvementModal();
        if (event.target === document.getElementById('operationModal')) closeOperationModal();
        if (event.target === document.getElementById('typeMouvementModal')) closeTypeMouvementModal();
    });

    // Corrige le bug d'ouverture des modals sur les boutons d'action
    // (RESTAURATION) : SUPPRESSION du bloc qui réécrit les onclick des boutons d'action
    // On garde les attributs onclick="openArticleModal()" etc. sur les boutons principaux
    // et on ne les remplace plus dynamiquement par JS.

    function editArticle() {
        // Fonction pour modifier un article (à implémenter selon vos besoins)
        alert('Fonction de modification d\'article à implémenter');
    }

    function editMouvement() {
        // Fonction pour modifier un mouvement (à implémenter selon vos besoins)
        alert('Fonction de modification de mouvement à implémenter');
    }

    function editOperation() {
        // Fonction pour modifier une opération (à implémenter selon vos besoins)
        alert('Fonction de modification d\'opération à implémenter');
    }

    // Variables globales pour le tableau
    let currentPage = 1;
    let itemsPerPage = 10;
    let totalMouvements = 0;
    let allMouvements = [];
    let filteredMouvements = [];

    // Variables globales pour le tableau des articles
    let currentArticlePage = 1;
    let allArticles = [];
    let filteredArticles = [];

    // Variables globales pour le tableau des types de mouvement
    let allTypeMouvements = [];
    let filteredTypeMouvements = [];

    // Variables globales pour la pagination des types de mouvement
    let currentTypeMouvementPage = 1;
    let typeMouvementsPerPage = 10;

    // Variables globales pour le tableau des opérations
    let allOperations = [];
    let filteredOperations = [];
    let currentOperationPage = 1;
    let operationsPerPage = 10;

    // Variables globales pour le tableau des mouvements
    let currentMouvementPage = 1;
    let mouvementsPerPage = 10;

    // Fonctions pour le tableau de récupération
    function loadArticlesTable() {
        console.log('Chargement du tableau des articles...');
        const apiUrl = getApiUrl('/api/articles');
        console.log('URL API articles:', apiUrl);
        
        fetch(apiUrl)
            .then(response => {
                console.log('Réponse API articles:', response.status, response.statusText);
                console.log('Headers:', response.headers);
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status} ${response.statusText}`);
                }
                return response.text().then(text => {
                    console.log('Réponse brute:', text.substring(0, 200));
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Réponse non-JSON reçue: ' + text.substring(0, 100));
                    }
                });
            })
            .then(result => {
                console.log('Données articles reçues:', result);
                allArticles = result.data || result;
                filteredArticles = [...allArticles];
                displayArticles();
                updateArticlePagination();
            })
            .catch(error => {
                console.error('Erreur lors du chargement des articles:', error);
                alert('Erreur lors du chargement des articles: ' + error.message);
            });
    }

    function displayArticles() {
        const tbody = document.getElementById('articlesTableBody');
        tbody.innerHTML = '';

        if (filteredArticles.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                        Aucun article trouvé
                    </td>
                </tr>
            `;
            return;
        }

        filteredArticles.forEach(article => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${article.codeArticle || article.code_article || '-'}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${article.description}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${article.unite_mesure}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${article.quantite_stock}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${article.prix_unitaire}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${article.seuil_alerte}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${article.organisation}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${formatDate(article.created_at)}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                    <button onclick="editArticleFromTable(${article.id})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                        Modifier
                    </button>
                    <button onclick="deleteArticleFromTable(${article.id})" class="text-red-600 hover:text-red-900">
                        Supprimer
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('fr-FR');
    }

    function applyArticleFilters() {
        const codeFilter = document.getElementById('filter_article_code').value;
        const descriptionFilter = document.getElementById('filter_article_description').value;
        const organisationFilter = document.getElementById('filter_article_organisation').value;
        const stockFilter = document.getElementById('filter_article_stock').value;

        filteredArticles = allArticles.filter(article => {
            let matches = true;

            if (codeFilter && article.codeArticle.toLowerCase().indexOf(codeFilter.toLowerCase()) === -1) {
                matches = false;
            }
            if (descriptionFilter && article.description.toLowerCase().indexOf(descriptionFilter.toLowerCase()) === -1) {
                matches = false;
            }
            if (organisationFilter && article.organisation !== organisationFilter) {
                matches = false;
            }
            if (stockFilter && article.stock_status !== stockFilter) {
                matches = false;
            }

            return matches;
        });

        currentArticlePage = 1;
        displayArticles();
        updateArticlePagination();
    }

    function clearArticleFilters() {
        document.getElementById('filter_article_code').value = '';
        document.getElementById('filter_article_description').value = '';
        document.getElementById('filter_article_organisation').value = '';
        document.getElementById('filter_article_stock').value = '';
        
        filteredArticles = [...allArticles];
        currentArticlePage = 1;
        displayArticles();
        updateArticlePagination();
    }

    function refreshArticleTable() {
        loadArticlesTable();
    }

    function updateArticlePagination() {
        const totalPages = Math.ceil(filteredArticles.length / itemsPerPage);
        document.getElementById('currentArticlePage').textContent = currentArticlePage;
        document.getElementById('prevArticleBtn').disabled = currentArticlePage === 1;
        document.getElementById('nextArticleBtn').disabled = currentArticlePage === totalPages || totalPages === 0;
    }

    function previousArticlePage() {
        if (currentArticlePage > 1) {
            currentArticlePage--;
            displayArticles();
            updateArticlePagination();
        }
    }

    function nextArticlePage() {
        const totalPages = Math.ceil(filteredArticles.length / itemsPerPage);
        if (currentArticlePage < totalPages) {
            currentArticlePage++;
            displayArticles();
            updateArticlePagination();
        }
    }

    function editArticleFromTable(articleId) {
        // Trouver l'article dans les données
        const article = allArticles.find(a => a.id === articleId);
        if (!article) {
            alert('Article non trouvé');
            return;
        }

        // Remplir le modal avec les données de l'article
        document.getElementById('code_article').value = article.code_article;
        document.getElementById('modal_description').value = article.description;
        document.getElementById('modal_unite_mesure').value = article.unite_mesure;
        document.getElementById('modal_quantite_stock').value = article.quantite_stock;
        document.getElementById('modal_prix_unitaire').value = article.prix_unitaire;
        document.getElementById('modal_seuil_alerte').value = article.seuil_alerte;
        document.getElementById('modal_organisation_id').value = article.organisation;
        document.getElementById('modal_date_creation').value = formatDate(article.date_creation);

        // Ouvrir le modal
        openArticleModal();
        
        // Changer le bouton pour indiquer qu'on modifie
        const saveBtn = document.querySelector('#articleModal button[onclick="saveArticle()"]');
        saveBtn.textContent = 'Modifier';
        saveBtn.onclick = () => updateArticle(articleId);
    }

    function updateArticle(articleId) {
        // Récupérer les données du formulaire
        const formData = {
            codeArticle: document.getElementById('code_article').value,
            description: document.getElementById('modal_description').value,
            uniteDeMesure: document.getElementById('modal_unite_mesure').value,
            quantiteStock: document.getElementById('modal_quantite_stock').value,
            seuilAlerte: document.getElementById('modal_seuil_alerte').value,
            idOrganisation: document.getElementById('modal_organisation_id').value,
            prixUnitaire: document.getElementById('modal_prix_unitaire').value,
        };

        // Envoyer la requête de mise à jour
        fetch(getApiUrl(`/api/articles/${articleId}`), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success || response.ok) {
                alert('Article modifié avec succès !');
                closeArticleModal();
                refreshArticleTable();
            } else {
                alert('Erreur lors de la modification de l\'article : ' + (data.message || JSON.stringify(data)));
            }
        })
        .catch(error => {
            alert('Erreur lors de la modification de l\'article : ' + error.message);
        });
    }

    function deleteArticleFromTable(articleId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
            fetch(getApiUrl(`/api/articles/${articleId}`), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Article supprimé avec succès !');
                    refreshArticleTable();
                } else {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Erreur lors de la suppression');
                    });
                }
            })
            .catch(error => {
                alert('Erreur lors de la suppression de l\'article : ' + error.message);
            });
        }
    }

    // Ajout du JS pour charger les mouvements dynamiquement
    function loadMouvementsTable() {
        fetch(getApiUrl('/api/mouvements'))
            .then(response => response.json())
            .then(result => {
                allMouvements = result.data || result;
                filteredMouvements = [...allMouvements];
                displayMouvements();
                updateMouvementPagination();
            })
            .catch(error => {
                const tbody = document.getElementById('mouvementsTableBody');
                tbody.innerHTML = `<tr><td colspan="10" class="px-6 py-4 text-center text-red-500">Erreur lors du chargement des mouvements : ${error.message}</td></tr>`;
            });
    }

    function displayMouvements() {
        const tbody = document.getElementById('mouvementsTableBody');
        tbody.innerHTML = '';
        const start = (currentMouvementPage - 1) * mouvementsPerPage;
        const end = Math.min(start + mouvementsPerPage, filteredMouvements.length);
        const pageMouvements = filteredMouvements.slice(start, end);
        if (pageMouvements.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="px-6 py-4 text-center text-gray-500">
                        Aucun mouvement trouvé
                    </td>
                </tr>
            `;
            return;
        }
        pageMouvements.forEach(mvt => {
            tbody.innerHTML += `
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${formatDate(mvt.date_mouvement)}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${mvt.code_article || mvt.codeArticle || (mvt.article && mvt.article.code_article) || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${mvt.designation || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${mvt.quantite || mvt.quantiteServis || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${mvt.type_mouvement_id || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${mvt.operation_id || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${mvt.demandeur || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${mvt.fournisseur || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${mvt.matricule || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                        <button onclick="editMouvementFromTable(${mvt.id})" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</button>
                        <button onclick="deleteMouvementFromTable(${mvt.id})" class="text-red-600 hover:text-red-900">Supprimer</button>
                    </td>
                </tr>
            `;
        });
    }

    function updateMouvementPagination() {
        const totalPages = Math.ceil(filteredMouvements.length / mouvementsPerPage);
        document.getElementById('currentMouvementPage').textContent = currentMouvementPage;
        document.getElementById('prevMouvementBtn').disabled = currentMouvementPage === 1;
        document.getElementById('nextMouvementBtn').disabled = currentMouvementPage === totalPages;
    }

    function previousMouvementPage() {
        if (currentMouvementPage > 1) {
            currentMouvementPage--;
            displayMouvements();
            updateMouvementPagination();
        }
    }

    function nextMouvementPage() {
        const totalPages = Math.ceil(filteredMouvements.length / mouvementsPerPage);
        if (currentMouvementPage < totalPages) {
            currentMouvementPage++;
            displayMouvements();
            updateMouvementPagination();
        }
    }

    function applyMouvementFilters() {
        const dateFilter = document.getElementById('filter_mvt_date').value;
        const codeFilter = document.getElementById('filter_mvt_code_article').value;
        const typeMvtFilter = document.getElementById('filter_mvt_type_mouvement').value;
        const operationFilter = document.getElementById('filter_mvt_operation').value;
        const demandeurFilter = document.getElementById('filter_mvt_demandeur').value;
        const fournisseurFilter = document.getElementById('filter_mvt_fournisseur').value;
        filteredMouvements = allMouvements.filter(mvt => {
            let matches = true;
            if (dateFilter && (!mvt.date_mouvement || !mvt.date_mouvement.startsWith(dateFilter))) matches = false;
            if (codeFilter && String(mvt.codeArticle || mvt.code_article || '').toLowerCase().indexOf(codeFilter.toLowerCase()) === -1) matches = false;
            if (typeMvtFilter && String(mvt.type_mouvement_id || '').toLowerCase().indexOf(typeMvtFilter.toLowerCase()) === -1) matches = false;
            if (operationFilter && String(mvt.operation_id || '').toLowerCase().indexOf(operationFilter.toLowerCase()) === -1) matches = false;
            if (demandeurFilter && String(mvt.demandeur || '').toLowerCase().indexOf(demandeurFilter.toLowerCase()) === -1) matches = false;
            if (fournisseurFilter && String(mvt.fournisseur || '').toLowerCase().indexOf(fournisseurFilter.toLowerCase()) === -1) matches = false;
            return matches;
        });
        currentMouvementPage = 1;
        displayMouvements();
        updateMouvementPagination();
    }

    function clearMouvementFilters() {
        document.getElementById('filter_mvt_date').value = '';
        document.getElementById('filter_mvt_code_article').value = '';
        document.getElementById('filter_mvt_type_mouvement').value = '';
        document.getElementById('filter_mvt_operation').value = '';
        document.getElementById('filter_mvt_demandeur').value = '';
        document.getElementById('filter_mvt_fournisseur').value = '';
        filteredMouvements = [...allMouvements];
        currentMouvementPage = 1;
        displayMouvements();
        updateMouvementPagination();
    }

    function refreshMouvementTable() {
        loadMouvementsTable();
    }

    function editMouvementFromTable(mvtId) {
        alert('Fonction de modification de mouvement à implémenter');
    }

    function deleteMouvementFromTable(mvtId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce mouvement ?')) {
            fetch(getApiUrl(`/api/mouvements/${mvtId}`), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Mouvement supprimé avec succès !');
                    refreshMouvementTable();
                } else {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Erreur lors de la suppression');
                    });
                }
            })
            .catch(error => {
                alert('Erreur lors de la suppression du mouvement : ' + error.message);
            });
        }
    }

    function loadTypeMouvementsTable() {
        fetch(getApiUrl('/api/type-mouvements'))
            .then(response => response.json())
            .then(result => {
                allTypeMouvements = result.data || result;
                filteredTypeMouvements = [...allTypeMouvements];
                displayTypeMouvements();
            })
            .catch(error => {
                const tbody = document.getElementById('typeMouvementsTableBody');
                tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Erreur lors du chargement des types de mouvement : ${error.message}</td></tr>`;
            });
    }

    function displayTypeMouvements() {
        const tbody = document.getElementById('typeMouvementsTableBody');
        tbody.innerHTML = '';
        const start = (currentTypeMouvementPage - 1) * typeMouvementsPerPage;
        const end = Math.min(start + typeMouvementsPerPage, filteredTypeMouvements.length);
        const pageTypeMouvements = filteredTypeMouvements.slice(start, end);
        if (pageTypeMouvements.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        Aucun type de mouvement trouvé
                    </td>
                </tr>
            `;
            return;
        }
        pageTypeMouvements.forEach(type => {
            tbody.innerHTML += `
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${type.id_type_mouvement || type.id || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${type.mouvement || type.libelle || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${formatDate(type.created_at)}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                        <button onclick="editTypeMouvementFromTable(${type.id_type_mouvement || type.id}, '${(type.mouvement || type.libelle || '').replace(/'/g, '\'')}' )" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</button>
                        <button onclick="deleteTypeMouvementFromTable(${type.id_type_mouvement || type.id})" class="text-red-600 hover:text-red-900">Supprimer</button>
                    </td>
                </tr>
            `;
        });
        updateTypeMouvementPagination();
    }

    function applyTypeMouvementFilters() {
        const idFilter = document.getElementById('filter_type_mvt_id').value;
        const libelleFilter = document.getElementById('filter_type_mvt_libelle').value;
        filteredTypeMouvements = allTypeMouvements.filter(type => {
            let matches = true;
            if (idFilter && String(type.id_type_mouvement || type.id || '').toLowerCase().indexOf(idFilter.toLowerCase()) === -1) matches = false;
            if (libelleFilter && String(type.mouvement || type.libelle || '').toLowerCase().indexOf(libelleFilter.toLowerCase()) === -1) matches = false;
            return matches;
        });
        currentTypeMouvementPage = 1;
        displayTypeMouvements();
        updateTypeMouvementPagination();
    }

    function clearTypeMouvementFilters() {
        document.getElementById('filter_type_mvt_id').value = '';
        document.getElementById('filter_type_mvt_libelle').value = '';
        filteredTypeMouvements = [...allTypeMouvements];
        currentTypeMouvementPage = 1;
        displayTypeMouvements();
        updateTypeMouvementPagination();
    }

    function refreshTypeMouvementTable() {
        loadTypeMouvementsTable();
        currentTypeMouvementPage = 1;
    }

    function editTypeMouvementFromTable(typeId, libelle) {
        document.getElementById('edit_type_mvt_id').value = typeId;
        document.getElementById('edit_type_mvt_libelle').value = libelle;
        document.getElementById('typeMouvementEditModal').style.display = 'block';
    }

    function deleteTypeMouvementFromTable(typeId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce type de mouvement ?')) {
            fetch(getApiUrl(`/api/type-mouvements/${typeId}`), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Type de mouvement supprimé avec succès !');
                    refreshTypeMouvementTable();
                } else {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Erreur lors de la suppression');
                    });
                }
            })
            .catch(error => {
                alert('Erreur lors de la suppression du type de mouvement : ' + error.message);
            });
        }
    }

    function saveTypeMouvementEdit() {
        const typeId = document.getElementById('edit_type_mvt_id').value;
        const libelle = document.getElementById('edit_type_mvt_libelle').value;
        if (!libelle) {
            alert('Le libellé est obligatoire.');
            return;
        }
        fetch(getApiUrl(`/api/type-mouvements/${typeId}`), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                mouvement: libelle
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Type de mouvement modifié avec succès !');
                closeTypeMouvementEditModal();
                refreshTypeMouvementTable();
            } else {
                alert('Erreur lors de la modification : ' + (data.message || JSON.stringify(data)));
            }
        })
        .catch(error => {
            alert('Erreur lors de la modification : ' + error.message);
        });
    }

    function closeTypeMouvementEditModal() {
        document.getElementById('typeMouvementEditModal').style.display = 'none';
    }

    function updateTypeMouvementPagination() {
        const totalPages = Math.ceil(filteredTypeMouvements.length / typeMouvementsPerPage);
        document.getElementById('currentTypeMouvementPage').textContent = currentTypeMouvementPage;
        document.getElementById('prevTypeMouvementBtn').disabled = currentTypeMouvementPage === 1;
        document.getElementById('nextTypeMouvementBtn').disabled = currentTypeMouvementPage === totalPages || totalPages === 0;
    }

    function previousTypeMouvementPage() {
        if (currentTypeMouvementPage > 1) {
            currentTypeMouvementPage--;
            displayTypeMouvements();
            updateTypeMouvementPagination();
        }
    }

    function nextTypeMouvementPage() {
        const totalPages = Math.ceil(filteredTypeMouvements.length / typeMouvementsPerPage);
        if (currentTypeMouvementPage < totalPages) {
            currentTypeMouvementPage++;
            displayTypeMouvements();
            updateTypeMouvementPagination();
        }
    }

    function loadOperationsTable() {
        fetch(getApiUrl('/api/operations'))
            .then(response => response.json())
            .then(result => {
                allOperations = result.data || result;
                filteredOperations = [...allOperations];
                displayOperations();
                updateOperationPagination();
            })
            .catch(error => {
                const tbody = document.getElementById('operationsTableBody');
                tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Erreur lors du chargement des opérations : ${error.message}</td></tr>`;
            });
    }

    function displayOperations() {
        const tbody = document.getElementById('operationsTableBody');
        tbody.innerHTML = '';
        const start = (currentOperationPage - 1) * operationsPerPage;
        const end = Math.min(start + operationsPerPage, filteredOperations.length);
        const pageOperations = filteredOperations.slice(start, end);
        if (pageOperations.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Aucune opération trouvée
                    </td>
                </tr>
            `;
            return;
        }
        pageOperations.forEach(op => {
            tbody.innerHTML += `
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${op.id_operation || op.id || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${op.libelle || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${op.id_type_mouvement || op.type_mouvement_id || '-'}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${formatDate(op.created_at)}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                        <button onclick="editOperationFromTable(${op.id_operation || op.id}, '${(op.libelle || '').replace(/'/g, '\'')}', '${op.id_type_mouvement || op.type_mouvement_id || ''}')" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</button>
                        <button onclick="deleteOperationFromTable(${op.id_operation || op.id})" class="text-red-600 hover:text-red-900">Supprimer</button>
                    </td>
                </tr>
            `;
        });
    }

    function updateOperationPagination() {
        const totalPages = Math.ceil(filteredOperations.length / operationsPerPage);
        document.getElementById('currentOperationPage').textContent = currentOperationPage;
        document.getElementById('prevOperationBtn').disabled = currentOperationPage === 1;
        document.getElementById('nextOperationBtn').disabled = currentOperationPage === totalPages || totalPages === 0;
    }

    function previousOperationPage() {
        if (currentOperationPage > 1) {
            currentOperationPage--;
            displayOperations();
            updateOperationPagination();
        }
    }

    function nextOperationPage() {
        const totalPages = Math.ceil(filteredOperations.length / operationsPerPage);
        if (currentOperationPage < totalPages) {
            currentOperationPage++;
            displayOperations();
            updateOperationPagination();
        }
    }

    function applyOperationFilters() {
        const idFilter = document.getElementById('filter_operation_id').value;
        const libelleFilter = document.getElementById('filter_operation_libelle').value;
        const typeMvtFilter = document.getElementById('filter_operation_type_mvt').value;
        filteredOperations = allOperations.filter(op => {
            let matches = true;
            if (idFilter && String(op.id_operation || op.id || '').toLowerCase().indexOf(idFilter.toLowerCase()) === -1) matches = false;
            if (libelleFilter && String(op.libelle || '').toLowerCase().indexOf(libelleFilter.toLowerCase()) === -1) matches = false;
            if (typeMvtFilter && String(op.id_type_mouvement || op.type_mouvement_id || '').toLowerCase().indexOf(typeMvtFilter.toLowerCase()) === -1) matches = false;
            return matches;
        });
        currentOperationPage = 1;
        displayOperations();
        updateOperationPagination();
    }

    function clearOperationFilters() {
        document.getElementById('filter_operation_id').value = '';
        document.getElementById('filter_operation_libelle').value = '';
        document.getElementById('filter_operation_type_mvt').value = '';
        filteredOperations = [...allOperations];
        currentOperationPage = 1;
        displayOperations();
        updateOperationPagination();
    }

    function refreshOperationTable() {
        loadOperationsTable();
        currentOperationPage = 1;
    }

    function editOperationFromTable(opId, libelle, typeMvt) {
        document.getElementById('edit_operation_id').value = opId;
        document.getElementById('edit_operation_libelle').value = libelle;
        document.getElementById('edit_operation_type_mvt').value = typeMvt;
        document.getElementById('operationEditModal').style.display = 'block';
    }
    function closeOperationEditModal() {
        document.getElementById('operationEditModal').style.display = 'none';
    }
    function saveOperationEdit() {
        const opId = document.getElementById('edit_operation_id').value;
        const libelle = document.getElementById('edit_operation_libelle').value;
        const typeMvt = document.getElementById('edit_operation_type_mvt').value;
        if (!libelle || !typeMvt) {
            alert('Tous les champs sont obligatoires.');
            return;
        }
        fetch(getApiUrl(`/api/operations/${opId}`), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                libelle: libelle,
                id_type_mouvement: typeMvt
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Opération modifiée avec succès !');
                closeOperationEditModal();
                refreshOperationTable();
            } else {
                alert('Erreur lors de la modification : ' + (data.message || JSON.stringify(data)));
            }
        })
        .catch(error => {
            alert('Erreur lors de la modification : ' + error.message);
        });
    }
    function deleteOperationFromTable(opId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette opération ?')) {
            fetch(getApiUrl(`/api/operations/${opId}`), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Opération supprimée avec succès !');
                    refreshOperationTable();
                } else {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Erreur lors de la suppression');
                    });
                }
            })
            .catch(error => {
                alert('Erreur lors de la suppression de l\'opération : ' + error.message);
            });
        }
    }
    </script>
</body>
</html>