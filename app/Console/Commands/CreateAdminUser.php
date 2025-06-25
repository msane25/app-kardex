<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Vérifier si l'utilisateur existe déjà
        $existingUser = User::where('email', 'admin@example.com')->first();
        
        if ($existingUser) {
            $this->info('L\'utilisateur admin@example.com existe déjà.');
            return;
        }

        // Créer l'utilisateur admin
        $user = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->info('Utilisateur admin créé avec succès !');
        $this->info('Email: admin@example.com');
        $this->info('Mot de passe: password');
    }
}
