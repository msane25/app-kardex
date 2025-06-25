@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-blue-700 uppercase">Dashboard Administrateur</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-2xl font-bold">{{ $nbUtilisateurs }}</div>
            <div class="text-gray-600">Utilisateurs</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-2xl font-bold">{{ $nbArticles }}</div>
            <div class="text-gray-600">Articles</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-2xl font-bold">{{ $nbMouvements }}</div>
            <div class="text-gray-600">Mouvements</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-2xl font-bold">{{ $nbOrganisations }}</div>
            <div class="text-gray-600">Organisations</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-2xl font-bold">{{ $nbRoles }}</div>
            <div class="text-gray-600">Rôles</div>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4 text-red-700">Articles sous le seuil critique</h2>
        @if($articlesSousSeuil->isEmpty())
            <div class="text-gray-500">Aucun article sous le seuil critique.</div>
        @else
        <table class="min-w-full bg-white border rounded-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Code</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Stock</th>
                    <th class="py-2 px-4 border-b">Seuil</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articlesSousSeuil as $article)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $article->codeArticle }}</td>
                    <td class="py-2 px-4 border-b">{{ $article->description }}</td>
                    <td class="py-2 px-4 border-b">{{ $article->quantiteStock }}</td>
                    <td class="py-2 px-4 border-b">{{ $article->seuilAlerte }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div>
        <h2 class="text-xl font-semibold mb-4 text-blue-700">Derniers mouvements</h2>
        @if($derniersMouvements->isEmpty())
            <div class="text-gray-500">Aucun mouvement récent.</div>
        @else
        <table class="min-w-full bg-white border rounded-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Type</th>
                    <th class="py-2 px-4 border-b">Article</th>
                    <th class="py-2 px-4 border-b">Quantité</th>
                    <th class="py-2 px-4 border-b">Demandeur</th>
                </tr>
            </thead>
            <tbody>
                @foreach($derniersMouvements as $mvt)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $mvt->date_mouvement }}</td>
                    <td class="py-2 px-4 border-b">{{ $mvt->typeMouvement }}</td>
                    <td class="py-2 px-4 border-b">{{ $mvt->codeArticle }}</td>
                    <td class="py-2 px-4 border-b">{{ $mvt->quantiteServis }}</td>
                    <td class="py-2 px-4 border-b">{{ $mvt->demandeur }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection 