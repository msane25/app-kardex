<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

   
        <nav class="bg-blue-600 p-4 text-white shadow-md flex items-center justify-between">
    <div class="flex items-center space-x-3">
        <img src="{{ asset('images/img6.jpg') }}" alt="Logo Senelec" class="h-10 w-auto">
        <span class="text-xl font-bold">Application de Gestion de Stock</span>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg transition">
            Déconnexion
        </button>
    </form>
</nav>
    <main class="py-6 px-4">
        @yield('content')
    </main>

</body>
</html>
