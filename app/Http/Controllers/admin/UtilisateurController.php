<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Role;

class UtilisateurController extends Controller
{
    // Afficher la liste des utilisateurs
    public function index()
    {
        $utilisateurs = Utilisateur::with('role')->get();
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        $roles = Role::all();
        return view('admin.utilisateurs.create', compact('roles'));
    }

    // Enregistrer un nouvel utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'Matricule' => 'required|unique:utilisateurs,Matricule',
            'prénom' => 'required',
            'nom' => 'required',
            'Email' => 'required|email|unique:utilisateurs,Email',
            'idRole' => 'required|exists:roles,idRole',
        ]);
        Utilisateur::create($request->all());
        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $roles = Role::all();
        return view('admin.utilisateurs.edit', compact('utilisateur', 'roles'));
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $request->validate([
            'prénom' => 'required',
            'nom' => 'required',
            'Email' => 'required|email|unique:utilisateurs,Email,' . $id . ',Matricule',
            'idRole' => 'required|exists:roles,idRole',
        ]);
        $utilisateur->update($request->all());
        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->delete();
        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
} 