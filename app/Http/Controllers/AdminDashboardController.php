<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Utilisateur;
use App\Models\Article;
use App\Models\Mouvement;
use App\Models\Organisation;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $nbUtilisateurs = Utilisateur::count();
        $nbArticles = Article::count();
        $nbMouvements = Mouvement::count();
        $nbOrganisations = Organisation::count();
        $nbRoles = Role::count();

        $articlesSousSeuil = Article::whereColumn('quantiteStock', '<', 'seuilAlerte')->get();
        $derniersMouvements = Mouvement::orderBy('date_mouvement', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'nbUtilisateurs', 'nbArticles', 'nbMouvements', 'nbOrganisations', 'nbRoles',
            'articlesSousSeuil', 'derniersMouvements'
        ));
    }
}
