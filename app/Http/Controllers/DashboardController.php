<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArticles = 12;
        $totalEntrees = 100;
        $totalSorties = 80;

        // Données pour le graphique (par exemple, entrées vs sorties par mois)
        $chartLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'];
        $chartEntrées = [10, 20, 30, 25, 15, 20];
        $chartSorties = [5, 15, 25, 20, 10, 15];

        return view('dashboard', compact(
            'totalArticles',
            'totalEntrees',
            'totalSorties',
            'chartLabels',
            'chartEntrées',
            'chartSorties'
        ));
    }
}
