<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Application de gestion de stock professionnelle">
    <meta name="author" content="Mamadou SANE">

    <title>{{ config('app.name', 'Gestion de Stock') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">


    <!-- Logo en haut de page -->
    <div class="p-4 bg-white shadow-md flex justify-center">
        <img src="{{ asset('images/img7.png') }}" alt="Logo" class="h-20 object-contain">
    </div>

    @yield('content')

    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Header -->
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Main Content -->
    <main class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 shadow mt-10">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ now()->year }} {{ config('app.name', 'Gestion de Stock') }}. Tous droits réservés.
        </div>
    </footer>

</body>
</html>
