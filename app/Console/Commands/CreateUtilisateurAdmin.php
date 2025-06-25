<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Utilisateur;
use App\Models\Connexion;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateUtilisateurAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utilisateur:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin utilisateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Vérifier si l'utilisateur existe déjà
        $existingUser = Utilisateur::where('Email', 'admin@example.com')->first();
        
        if ($existingUser) {
            $this->info('L\'utilisateur admin@example.com existe déjà avec le matricule: ' . $existingUser->Matricule);
            
            // Vérifier si la connexion existe
            $connexion = Connexion::where('matricule', $existingUser->Matricule)->first();
            if (!$connexion) {
                Connexion::create([
                    'matricule' => $existingUser->Matricule,
                    'password' => Hash::make('password'),
                ]);
                $this->info('Connexion créée pour l\'utilisateur existant.');
            }
            return;
        }

        // Créer ou récupérer le rôle admin
        $role = Role::firstOrCreate(['libelle' => 'Administrateur']);

        // Générer un matricule unique
        $matricule = 'ADMIN' . date('YmdHis');

        // Créer l'utilisateur
        $utilisateur = Utilisateur::create([
            'Matricule' => $matricule,
            'prénom' => 'Admin',
            'nom' => 'Administrateur',
            'Email' => 'admin@example.com',
            'idRole' => $role->idRole,
        ]);

        // Créer la connexion
        Connexion::create([
            'matricule' => $matricule,
            'password' => Hash::make('password'),
        ]);

        $this->info('Utilisateur admin créé avec succès !');
        $this->info('Email: admin@example.com');
        $this->info('Mot de passe: password');
        $this->info('Matricule: ' . $matricule);
    }
}
