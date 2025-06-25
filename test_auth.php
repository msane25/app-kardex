<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Initialiser Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Test d'authentification ===\n";

// Vérifier si l'utilisateur existe
$user = User::where('email', 'admin@example.com')->first();

if ($user) {
    echo "✅ Utilisateur trouvé: {$user->email} - {$user->name}\n";
    
    // Tester le mot de passe
    $password = 'password';
    if (Hash::check($password, $user->password)) {
        echo "✅ Mot de passe correct\n";
    } else {
        echo "❌ Mot de passe incorrect\n";
    }
} else {
    echo "❌ Utilisateur non trouvé\n";
    
    // Créer l'utilisateur
    echo "Création de l'utilisateur admin...\n";
    $user = User::create([
        'name' => 'Administrateur',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]);
    echo "✅ Utilisateur créé: {$user->email}\n";
}

echo "=== Fin du test ===\n"; 