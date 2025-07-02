<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Mouvement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques principales
        $totalArticles = Article::count();
        $articlesEnStock = Article::where('quantite_stock', '>', 0)->count();
        $articlesAlerte = Article::where('quantite_stock', '<=', DB::raw('seuil_critique'))
                                ->where('quantite_stock', '>', 0)->count();
        $totalMouvements = Mouvement::count();

        // Articles par statut
        $articlesDisponibles = Article::where('quantite_stock', '>', DB::raw('seuil_critique'))->count();
        $articlesEpuises = Article::where('quantite_stock', '<=', 0)->count();

        // Valeur totale du stock
        $valeurTotaleStock = Article::sum(DB::raw('prix_unitaire * quantite_stock'));

        // Articles en alerte (liste détaillée)
        $articlesAlerteList = Article::where('quantite_stock', '<=', DB::raw('seuil_critique'))
                                    ->where('quantite_stock', '>', 0)
                                    ->orderBy('quantite_stock', 'asc')
                                    ->limit(10)
                                    ->get();

        // Mouvements récents
        $mouvementsRecents = Mouvement::with('article')
                                    ->orderBy('date_mouvement', 'desc')
                                    ->limit(10)
                                    ->get();

        // Inventaire complet
        $inventaireComplet = Article::orderBy('code_article')->get();

        // Données pour les graphiques
        $mouvementsParMois = $this->getMouvementsParMois();
        $mouvementsParMoisLabels = $mouvementsParMois['labels'];
        $mouvementsParMoisData = $mouvementsParMois['data'];

        return view('dashboard', compact(
            'totalArticles',
            'articlesEnStock',
            'articlesAlerte',
            'totalMouvements',
            'articlesDisponibles',
            'articlesEpuises',
            'valeurTotaleStock',
            'articlesAlerteList',
            'mouvementsRecents',
            'inventaireComplet',
            'mouvementsParMoisLabels',
            'mouvementsParMoisData'
        ));
    }

    private function getMouvementsParMois()
    {
        $mouvements = Mouvement::selectRaw('MONTH(date_mouvement) as mois, COUNT(*) as total')
                              ->whereYear('date_mouvement', date('Y'))
                              ->groupBy('mois')
                              ->orderBy('mois')
                              ->get();

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $mois = Carbon::create()->month($i)->format('M');
            $labels[] = $mois;
            
            $mouvement = $mouvements->where('mois', $i)->first();
            $data[] = $mouvement ? $mouvement->total : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    // Méthode pour générer un rapport PDF (optionnel)
    public function generateReport()
    {
        $inventaireComplet = Article::orderBy('code_article')->get();
        $valeurTotaleStock = Article::sum(DB::raw('prix_unitaire * quantite_stock'));
        
        // Ici vous pourriez intégrer une bibliothèque PDF comme DomPDF
        // Pour l'instant, on retourne une vue spéciale pour l'impression
        
        return view('reports.inventaire', compact('inventaireComplet', 'valeurTotaleStock'));
    }
}
