<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MagasinierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the magasinier dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('magasinier');
    }

    public function store(Request $request)
    {
        // Enregistrement en base ici
        return back()->with('success', 'Fiche KARDEX enregistrée avec succès.');
    }

    public function showForm()
    {
        return view('magasinier');
    }
}

