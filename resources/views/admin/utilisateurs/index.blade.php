@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Gestion des Utilisateurs</h1>
        <a href="{{ route('admin.utilisateurs.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">+ Ajouter un utilisateur</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-4 py-2 text-left">Matricule</th>
                    <th class="px-4 py-2 text-left">Prénom</th>
                    <th class="px-4 py-2 text-left">Nom</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Rôle</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($utilisateurs as $utilisateur)
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-4 py-2">{{ $utilisateur->Matricule }}</td>
                        <td class="px-4 py-2">{{ $utilisateur->prénom }}</td>
                        <td class="px-4 py-2">{{ $utilisateur->nom }}</td>
                        <td class="px-4 py-2">{{ $utilisateur->Email }}</td>
                        <td class="px-4 py-2">{{ $utilisateur->role->libelle ?? '-' }}</td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <a href="{{ route('admin.utilisateurs.edit', $utilisateur->Matricule) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">Éditer</a>
                            <form action="{{ route('admin.utilisateurs.destroy', $utilisateur->Matricule) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Aucun utilisateur trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 