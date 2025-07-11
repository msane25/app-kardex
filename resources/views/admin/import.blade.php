<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import des Articles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="file" :value="__('Fichier Excel')" />
                            <input type="file" 
                                   id="file" 
                                   name="file" 
                                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                   accept=".xlsx,.xls,.csv" 
                                   required />
                            <p class="mt-2 text-sm text-gray-500">
                                Format attendu : fichier Excel (.xlsx, .xls) ou CSV avec les colonnes suivantes :
                                <br>code_article, description, unite_de_mesure, organisationid
                            </p>
                            <p class="mt-2 text-sm text-gray-600">
                                Note : Les colonnes doivent être nommées exactement comme indiqué ci-dessus.
                                <br>Les valeurs par défaut seront appliquées pour :
                                <ul class="list-disc list-inside ml-4">
                                    <li>quantiteStock : 0</li>
                                    <li>seuilAlerte : 10</li>
                                    <li>quantiteInitiale : 0</li>
                                    <li>prixUnitaire : 0</li>
                                </ul>
                            </p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Importer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 