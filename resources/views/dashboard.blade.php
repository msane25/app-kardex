<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
</head>
<body>
@extends('layout.app')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold text-center mb-6">DASHBOARD GRAPHIQUE</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-center">
        <div class="bg-white p-4 shadow rounded-lg">
            <h2 class="text-gray-600 font-semibold">Articles</h2>
            <p class="text-blue-600 text-2xl font-bold">{{ $totalArticles }}</p>
        </div>
        <div class="bg-white p-4 shadow rounded-lg">
            <h2 class="text-gray-600 font-semibold">Nombre Total Entrées</h2>
            <p class="text-green-600 text-2xl font-bold">{{ $totalEntrees }}</p>
        </div>
        <div class="bg-white p-4 shadow rounded-lg">
            <h2 class="text-gray-600 font-semibold">Sorties</h2>
            <p class="text-red-600 text-2xl font-bold">{{ $totalSorties }}</p>
        </div>
    </div>

    <div class="bg-white p-6 shadow rounded-lg">
        <h3 class="text-xl font-bold mb-4">Évolution des Entrées / Sorties (6 derniers mois)</h3>
        <canvas id="stockChart" width="400" height="200"></canvas>
    </div> 
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('stockChart').getContext('2d');

    const stockChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Entrées',
                    data: @json($chartEntrées),
                    backgroundColor: 'rgba(34, 197, 94, 0.7)', // vert
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Sorties',
                    data: @json($chartSorties),
                    backgroundColor: 'rgba(239, 68, 68, 0.7)', // rouge
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    }
                }
            }
        }
    });
</script>
@endsection


</body>
</html>