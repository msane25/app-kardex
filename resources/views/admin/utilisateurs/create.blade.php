@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <h1 class="text-2xl font-bold text-blue-700 mb-6">Ajouter un utilisateur</h1>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.utilisateurs.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="Matricule" class="block text-sm font-medium text-gray-700">Matricule</label>
            <input type="text" name="Matricule" id="Matricule" value="{{ old('Matricule') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
        </div>
        <div>
            <label for="prénom" class="block text-sm font-medium text-gray-700">Prénom</label>
            <input type="text" name="prénom" id="prénom" value="{{ old('prénom') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
        </div>
        <div>
            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
        </div>
        <div>
            <label for="Email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="Email" id="Email" value="{{ old('Email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
        </div>
        <div>
            <label for="idRole" class="block text-sm font-medium text-gray-700">Rôle</label>
            <select name="idRole" id="idRole" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                <option value="">-- Sélectionner un rôle --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->idRole }}" {{ old('idRole') == $role->idRole ? 'selected' : '' }}>{{ $role->libelle }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.utilisateurs.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Annuler</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Enregistrer</button>
        </div>
    </form>
</div>
@endsection 