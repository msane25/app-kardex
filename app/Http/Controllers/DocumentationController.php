<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function manuelUtilisateur()
    {
        return response()->view('documentation.manuel-utilisateur')
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }
} 