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
        width: 90%;
        max-width: 500px;
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
    <h1 class="uppercase text-center font-extrabold text-3xl mt-8 tracking-wider text-blue-800 drop-shadow-lg">Bienvenue MR / Mme</h1>
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
                <form class="space-y-4">
                <div>
                    <label for="modal_code_article" class="block text-sm font-medium text-gray-700">Code Article *</label>
                    <input type="text" id="modal_code_article" name="modal_code_article" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                
                <div>
                    <label for="modal_description" class="block text-sm font-medium text-gray-700">Description *</label>
                    <input type="text" id="modal_description" name="modal_description" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                
                <div>
                    <label for="modal_unite_mesure" class="block text-sm font-medium text-gray-700">Unité de Mesure *</label>
                    <select id="modal_unite_mesure" name="modal_unite_mesure" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Sélectionner --</option>
                        <option value="Unité">Unité</option>
                        <option value="Kilogramme">Kilogramme</option>
                        <option value="Litre">Litre</option>
                        <option value="Mètre">Mètre</option>
                        <option value="Pièce">Pièce</option>
                        <option value="Carton">Carton</option>
                        <option value="Boîte">Boîte</option>
                    </select>
                </div>

                <div>
                    <label for="modal_quantite_stock" class="block text-sm font-medium text-gray-700">Quantité Stock *</label>
                    <input type="number" id="modal_quantite_stock" name="modal_quantite_stock" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="modal_seuil_alerte" class="block text-sm font-medium text-gray-700">Seuil Alerte *</label>
                    <input type="number" id="modal_seuil_alerte" name="modal_seuil_alerte" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="modal_organisation_id" class="block text-sm font-medium text-gray-700">Organisation *</label>
                    <select id="modal_organisation_id" name="modal_organisation_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Sélectionner --</option>
                        <option value="1">Direction Générale</option>
                        <option value="2">Service Informatique</option>
                        <option value="3">Service Financier</option>
                    </select>
                </div>
                
                </form>
            </div>

            <div class="modal-footer">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeArticleModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="button" onclick="saveArticle()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Créer l'article
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
                        <label for="modal_code_article_mvt" class="block text-sm font-medium text-gray-700">Code Article *</label>
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
                        <label for="modal_doc_associe" class="block text-sm font-medium text-gray-700">Doc Associé</label>
                        <input type="text" id="modal_doc_associe" name="modal_doc_associe" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Ex: Facture, Bon de livraison...">
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
                        Créer le mouvement
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
                        Créer l'opération
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
                <form class="space-y-4">
                    <div>
                        <label for="modal_type_mouvement_value" class="block text-sm font-medium text-gray-700">Type de Mouvement *</label>
                        <select id="modal_type_mouvement_value" name="modal_type_mouvement_value" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Sélectionner --</option>
                            <option value="Entrée">Entrée</option>
                            <option value="Sortie">Sortie</option>
                            <option value="Retour">Retour</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeTypeMouvementModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="button" onclick="saveTypeMouvement()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Créer le type de mouvement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-5xl border border-blue-200">
            <h2 class="text-4xl font-extrabold mb-10 text-center text-blue-700 uppercase tracking-widest drop-shadow">FICHE KARDEX</h2>

            <!-- Date & Document en haut -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" readonly required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
                </div>
                <div>
                    <label for="document" class="block text-sm font-medium text-gray-700">Numéro de Document</label>
                    <input type="text" id="document" name="document" readonly class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100" placeholder="Généré automatiquement lors de l'enregistrement">
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-row justify-center mb-10">
                <div class="flex flex-col gap-6 items-center w-full max-w-lg mx-auto">
                    <button onclick="openOperationModal()" class="w-full inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-xl shadow-md hover:bg-red-700 transition-all duration-200 text-lg font-semibold justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="w-full text-center">Nouvelle Opération</span>
                    </button>
                    <button onclick="openArticleModal()" class="w-full inline-flex items-center px-6 py-3 bg-yellow-500 text-white rounded-xl shadow-md hover:bg-yellow-600 transition-all duration-200 text-lg font-semibold justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="w-full text-center">Nouvel Article</span>
                    </button>
                    <button onclick="openMouvementModal()" class="w-full inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 transition-all duration-200 text-lg font-semibold justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="w-full text-center">Nouveau Mouvement</span>
                    </button>
                    <button onclick="openTypeMouvementModal()" class="w-full inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl shadow-md hover:bg-green-700 transition-all duration-200 text-lg font-semibold justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="w-full text-center">Nouveau Type Mouvement</span>
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
                    <h3 class="text-xl font-bold text-blue-800 mb-4 uppercase">Aperçu de la Fiche KARDEX</h3>
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

                    <div>
                        <label for="destination_operation" class="block text-sm font-medium text-gray-700">Destination Opération</label>
                        <input type="text" id="destination_operation" name="destination_operation" placeholder="Ex: Service IT, Direction..." class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
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
                <title>Fiche KARDEX - Impression</title>
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
                    <h1>FICHE KARDEX</h1>
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
                            <label>Numéro de Document:</label>
                            <span class="value">${formData.document || 'Non renseigné'}</span>
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
        document.getElementById('articleModal').style.display = 'block';
    }

    function closeArticleModal() {
        document.getElementById('articleModal').style.display = 'none';
    }

    function saveArticle() {
        const codeArticle = document.getElementById('modal_code_article').value;
        const description = document.getElementById('modal_description').value;
        const uniteDeMesure = document.getElementById('modal_unite_mesure').value;
        const quantiteStock = document.getElementById('modal_quantite_stock').value;
        const seuilAlerte = document.getElementById('modal_seuil_alerte').value;
        const idOrganisation = document.getElementById('modal_organisation_id').value;

        // Vérification uniquement des champs vraiment obligatoires
        if (codeArticle && description && uniteDeMesure && quantiteStock && seuilAlerte && idOrganisation) {
            const formData = new FormData();
            formData.append('codeArticle', codeArticle);
            formData.append('description', description);
            formData.append('uniteDeMesure', uniteDeMesure);
            formData.append('quantiteStock', quantiteStock);
            formData.append('quantiteInitiale', quantiteStock); // valeur par défaut identique
            formData.append('seuilAlerte', seuilAlerte);
            formData.append('idOrganisation', idOrganisation);
            // Ne pas envoyer prixUnitaire si non présent
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
                    window.location.reload();
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
        const select = document.getElementById('fournisseur');
        select.addEventListener('change', updateFields);
        updateFields(); // appel initial

        // Fermer le modal en cliquant en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('articleModal');
            if (event.target == modal) {
                closeArticleModal();
            }
        }

        // Vérifier s'il y a un message de succès avec un numéro de document
        const successMessage = document.querySelector('.bg-green-100');
        if (successMessage && successMessage.textContent.includes('Numéro de document:')) {
            const match = successMessage.textContent.match(/Numéro de document: ([A-Z0-9]+)/);
            if (match) {
                document.getElementById('document').value = match[1];
            }
        }
    });

    // Fonctions pour le modal de mouvement
    function openMouvementModal() {
        document.getElementById('mouvementModal').style.display = 'block';
        // Charger les articles dans le select
        loadArticles();
        loadTypeMouvements();
    }

    function closeMouvementModal() {
        document.getElementById('mouvementModal').style.display = 'none';
    }

    function loadArticles() {
        // Cette fonction devrait faire un appel AJAX pour récupérer la liste des articles
        fetch('/api/articles')
            .then(response => response.json())
            .then(result => {
                const articles = result.data || result;
                const select = document.getElementById('modal_code_article_mvt');
                select.innerHTML = '<option value="">-- Sélectionner --</option>';
                articles.forEach(article => {
                    select.innerHTML += `<option value="${article.id}">${article.codeArticle} - ${article.description}</option>`;
                });
            });
    }

    function loadTypeMouvements() {
        fetch('/api/type-mouvements')
            .then(response => response.json())
            .then(result => {
                const types = result.data || result;
                const select = document.getElementById('modal_type_mouvement');
                select.innerHTML = '<option value="">-- Sélectionner --</option>';
                types.forEach(type => {
                    select.innerHTML += `<option value="${type.id_type_mouvement}">${type.mouvement}</option>`;
                });
            });
    }

    function saveMouvement() {
        const dateMouvement = document.getElementById('modal_date_mouvement').value;
        const typeMouvement = document.getElementById('modal_type_mouvement').value;
        const designation = document.getElementById('modal_designation_mvt').value;
        const demandeur = document.getElementById('modal_demandeur').value;
        const fournisseur = document.getElementById('modal_fournisseur').value;
        const quantiteServis = document.getElementById('modal_quantite_servis').value;
        const codeArticle = document.getElementById('modal_code_article_mvt').value;
        const operation = document.getElementById('modal_operation').value;
        const numCommande = document.getElementById('modal_num_commande').value;
        const docAssocie = document.getElementById('modal_doc_associe').value;
        const receptionnaire = document.getElementById('modal_receptionnaire').value;

        if (dateMouvement && typeMouvement && designation && quantiteServis && codeArticle && operation) {
            fetch('/api/mouvements', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    date_mouvement: dateMouvement,
                    type_mouvement_id: parseInt(typeMouvement),
                    quantite: parseInt(quantiteServis),
                    article_id: parseInt(codeArticle),
                    operation_id: parseInt(operation),
                    destination: demandeur || null,
                    fournisseur: fournisseur || null,
                    document_number: numCommande || `MVT-${Date.now()}`
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
        } else {
            alert('Veuillez remplir tous les champs obligatoires.');
        }
    }

    // Fonctions pour le modal d'opération
    function openOperationModal() {
        document.getElementById('operationModal').style.display = 'block';
        loadTypeMouvementsForOperation();
    }

    function loadTypeMouvementsForOperation() {
        fetch('/api/type-mouvements')
            .then(response => response.json())
            .then(result => {
                const types = result.data || result;
                const select = document.getElementById('modal_type_mouvement_operation');
                if (!select) return;
                select.innerHTML = '<option value="">-- Sélectionner --</option>';
                types.forEach(type => {
                    select.innerHTML += `<option value="${type.id_type_mouvement}">${type.mouvement}</option>`;
                });
            });
    }

    function closeOperationModal() {
        document.getElementById('operationModal').style.display = 'none';
    }

    function saveOperation() {
        const libelleOperation = document.getElementById('modal_libelle_operation').value;
        const typeMouvementId = document.getElementById('modal_type_mouvement_operation').value;

        if (libelleOperation && typeMouvementId) {
            fetch('/api/operations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    libelleOperation,
                    type_mouvement_id: parseInt(typeMouvementId)
                })
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.indexOf('application/json') !== -1) {
                    const data = await response.json();
                    if (data.success) {
                        alert('Opération créée avec succès !');
                        closeOperationModal();
                        window.location.reload();
                    } else {
                        alert('Erreur lors de la création de l\'opération : ' + (data.message || 'Erreur inconnue'));
                    }
                } else {
                    // Réponse non JSON (probablement HTML)
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
                alert('Erreur lors de la création de l\'opération : ' + error.message);
            });
        } else {
            alert('Veuillez remplir tous les champs obligatoires.');
        }
    }

    function showForm(type) {
        // Masquer tous les modals si ouverts
        closeArticleModal();
        closeMouvementModal();
        closeOperationModal();
        // Afficher le formulaire correspondant dans le conteneur de droite
        let formHtml = '';
        if (type === 'operation') {
            formHtml = document.getElementById('operationModal').querySelector('.modal-body').innerHTML;
        } else if (type === 'article') {
            formHtml = document.getElementById('articleModal').querySelector('.modal-body').innerHTML;
        } else if (type === 'mouvement') {
            formHtml = document.getElementById('mouvementModal').querySelector('.modal-body').innerHTML;
        }
        document.getElementById('form-container').innerHTML = formHtml;
    }

    // Mettre à jour l'événement window.onclick pour inclure le nouveau modal
    window.onclick = function(event) {
        if (event.target == document.getElementById('articleModal')) {
            closeArticleModal();
        }
        if (event.target == document.getElementById('mouvementModal')) {
            closeMouvementModal();
        }
        if (event.target == document.getElementById('operationModal')) {
            closeOperationModal();
        }
        if (event.target == document.getElementById('typeMouvementModal')) {
            closeTypeMouvementModal();
        }
    }

    function openTypeMouvementModal() {
        document.getElementById('typeMouvementModal').style.display = 'block';
    }
    function closeTypeMouvementModal() {
        document.getElementById('typeMouvementModal').style.display = 'none';
    }
    function saveTypeMouvement() {
        const typeMouvementValue = document.getElementById('modal_type_mouvement_value').value;
        if (typeMouvementValue) {
            fetch('/api/type-mouvements', {
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
                        window.location.reload();
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
    </script>
</body>
</html>
