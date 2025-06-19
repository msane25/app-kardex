<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAGASINIER</title>

    <style>
    input, select, textarea {
        background-color: #fff9c4; /* Jaune clair */
    }

    input:focus, select:focus, textarea:focus {
        background-color: #fff59d; /* Jaune plus vif au focus */
        outline: none;
        border-color: #fbc02d;
        box-shadow: 0 0 0 2px rgba(251, 192, 45, 0.3);
    }
</style>

</head>
<!-- ... HEAD et STYLES inchangés ... -->
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
    const printContent = document.getElementById('preview').innerHTML;
    const originalContent = document.body.innerHTML;

    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    location.reload();
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

document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('fournisseur');
    select.addEventListener('change', updateFields);
    updateFields(); // appel initial
});
</script>


<script>
    function updateFields() {
        const fournisseur = document.getElementById('fournisseur').value;
        const entrees = document.getElementById('entrees');
        const sorties = document.getElementById('sorties');

        if (fournisseur === 'Émetteur') {
            sorties.disabled = true;
            entrees.disabled = false;
        } else if (fournisseur === 'Fournisseur') {
            entrees.disabled = true;
            sorties.disabled = false;
        } else {
            entrees.disabled = false;
            sorties.disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('fournisseur');
        select.addEventListener('change', updateFields);
        updateFields(); // appel initial
    });
</script>



<body>
    <h1 class="uppercase text-center font-bold text-xl">BIENVENUE MR / Mme</h1>
    @extends('layout.app')
    @section('content')

<div class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-6xl">
        <h2 class="text-3xl font-bold mb-8 text-center text-blue-700 uppercase">FICHE KARDEX</h2>
                <div class="flex justify-center">
    <div class="w-1/3">
        <label for="seuil_critique" class="block text-sm font-semibold text-red-700 text-center uppercase">Seuil Critique</label>
        <input 
            type="number" 
            id="seuil_critique" 
            name="seuil_critique" 
            class="mx-auto block w-2/3 px-3 py-2 bg-red-100 border border-red-500 text-red-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 text-center">
    </div>
</div>

        <form action="{{ route('stock.request.store') }}" method="POST" class="space-y-6 uppercase">
            @csrf

             <!-- Aperçu -->
            <div id="preview" class="hidden mt-10 bg-white p-6 rounded-xl shadow-lg border border-blue-300 text-left">
                <h3 class="text-xl font-bold text-blue-800 mb-4 uppercase">Aperçu de la Fiche KARDEX</h3>
                <div id="preview-content" class="space-y-2 text-gray-800 font-medium"></div>
            </div>
            
            <!-- Infos principales -->
            <div>
                <h3 class="text-lg font-semibold text-gray-600 mb-4 border-b pb-2">Informations générales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nomenclature" class="block text-sm font-medium uppercase">Code ARTICLE</label>
                        <input type="text" id="nomenclature" name="nomenclature" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label for="designation" class="block text-sm font-medium uppercase">Désignation</label>
                        <input type="text" id="designation" name="designation" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" required>
                    </div>
                </div>
            </div>

            <!-- Date & Document -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="date" name="date" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="document" class="block text-sm font-medium text-gray-700">Numéro de Document</label>
                    <input type="text" id="document" name="document" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <!-- Nouvelle position : seuil, prix, unité, stock -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
                
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
            </div>

            <!-- Mouvement -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6">
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
                    <label for="type_mouvement" class="block text-sm font-medium text-gray-700">Type de Mouvement</label>
                    <select id="type_mouvement" name="type_mouvement" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Sélectionner --</option>
                        <option value="Entrée">Entrée</option>
                        <option value="Sortie">Sortie</option>
                        <option value="Transfert">Transfert</option>
                        <option value="Retour">Retour</option>
                    </select>
                </div>

                <div>
                    <label for="type_operation" class="block text-sm font-medium text-gray-700">Type d’Opération</label>
                    <input type="text" id="type_operation" name="type_operation" placeholder="Ex: Achat, Don..." class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <!-- Boutons -->
            <div class="text-center pt-8 space-x-4">
                <button type="button" onclick="showPreview()" class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition text-lg font-semibold">
                    Voir un aperçu
                </button>
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
@endsection
</body>
</html>
