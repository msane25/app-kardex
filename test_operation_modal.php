<?php
/**
 * Script de test pour vérifier le chargement des types de mouvement
 * dans le modal "Créer une nouvelle opération"
 */

// Configuration
$baseUrl = 'http://localhost/stockDb/public'; // Ajustez selon votre configuration

// Fonction pour tester un endpoint
function testEndpoint($url, $description) {
    echo "=== Test: $description ===\n";
    echo "URL: $url\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_error($ch)) {
        echo "Erreur cURL: " . curl_error($ch) . "\n";
    } else {
        echo "Code HTTP: $httpCode\n";
        
        if ($httpCode === 200) {
            $data = json_decode($response, true);
            if ($data) {
                echo "Succès: " . ($data['success'] ? 'Oui' : 'Non') . "\n";
                
                // Vérifier la structure de la réponse
                if (isset($data['data'])) {
                    echo "Structure de données: OK (data présent)\n";
                    echo "Nombre d'éléments: " . count($data['data']) . "\n";
                    
                    // Afficher les premiers éléments
                    if (count($data['data']) > 0) {
                        echo "Premier élément:\n";
                        $first = $data['data'][0];
                        echo "  - id_type_mouvement: " . ($first['id_type_mouvement'] ?? 'N/A') . "\n";
                        echo "  - mouvement: " . ($first['mouvement'] ?? 'N/A') . "\n";
                    }
                } else {
                    echo "ERREUR: Structure 'data' manquante\n";
                    echo "Structure reçue: " . json_encode(array_keys($data)) . "\n";
                }
                
                // Vérifier la pagination si présente
                if (isset($data['pagination'])) {
                    echo "Pagination présente: Oui\n";
                    echo "  - Page actuelle: " . $data['pagination']['current_page'] . "\n";
                    echo "  - Total: " . $data['pagination']['total'] . "\n";
                } else {
                    echo "Pagination présente: Non\n";
                }
            } else {
                echo "Erreur: Réponse JSON invalide\n";
                echo "Réponse brute: " . substr($response, 0, 200) . "...\n";
            }
        } else {
            echo "Erreur HTTP: $httpCode\n";
            echo "Réponse: " . substr($response, 0, 200) . "...\n";
        }
    }
    
    curl_close($ch);
    echo "\n";
}

// Tests pour le modal d'opération
echo "Tests pour le modal 'Créer une nouvelle opération'\n";
echo "================================================\n\n";

// Test 1: Types de mouvement - endpoint principal
testEndpoint(
    "$baseUrl/api/type-mouvements",
    "Types de mouvement - Endpoint principal"
);

// Test 2: Types de mouvement - avec pagination
testEndpoint(
    "$baseUrl/api/type-mouvements?page=1&per_page=10",
    "Types de mouvement - Avec pagination"
);

// Test 3: Types de mouvement - sans pagination (pour compatibilité)
testEndpoint(
    "$baseUrl/api/type-mouvements?per_page=100",
    "Types de mouvement - Sans pagination (100 éléments)"
);

// Test 4: Vérifier que les données sont bien structurées
echo "=== Vérification de la structure des données ===\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$baseUrl/api/type-mouvements");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    $data = json_decode($response, true);
    if ($data && isset($data['data'])) {
        echo "✅ Structure correcte: data présent\n";
        echo "📊 Nombre de types de mouvement: " . count($data['data']) . "\n";
        
        if (count($data['data']) > 0) {
            echo "📋 Exemples de types de mouvement:\n";
            foreach (array_slice($data['data'], 0, 3) as $index => $type) {
                echo "  " . ($index + 1) . ". ID: " . ($type['id_type_mouvement'] ?? 'N/A') . 
                     " - Libellé: " . ($type['mouvement'] ?? 'N/A') . "\n";
            }
        }
    } else {
        echo "❌ ERREUR: Structure incorrecte\n";
        echo "Structure reçue: " . json_encode(array_keys($data ?? [])) . "\n";
    }
} else {
    echo "❌ ERREUR: Impossible de récupérer les données\n";
}

echo "\nTests terminés.\n";
echo "\nInstructions pour tester manuellement:\n";
echo "1. Ouvrez l'application dans votre navigateur\n";
echo "2. Cliquez sur le bouton 'Operation'\n";
echo "3. Vérifiez que le select 'Type de Mouvement' se remplit\n";
echo "4. Ouvrez la console du navigateur (F12) pour voir les logs\n";
?> 