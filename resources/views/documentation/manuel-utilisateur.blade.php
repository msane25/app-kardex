<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manuel Utilisateur - Systeme de Gestion de Stock KARDEX</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .page-break { page-break-before: always; }
        }
        
        body {
            font-family: 'Times New Roman', serif;
            margin: 20px;
            line-height: 1.6;
            color: #333;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        
        .toc {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #2563eb;
        }
        
        .toc h2 {
            color: #2563eb;
            margin-top: 0;
        }
        
        .toc ul {
            list-style-type: none;
            padding-left: 0;
        }
        
        .toc li {
            margin: 8px 0;
            padding-left: 20px;
            position: relative;
        }
        
        .toc li:before {
            content: "•";
            color: #2563eb;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        
        h2 {
            color: #2563eb;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-top: 30px;
        }
        
        h3 {
            color: #475569;
            margin-top: 25px;
        }
        
        .feature-box {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #2563eb;
        }
        
        .feature-box h4 {
            margin-top: 0;
            color: #1e293b;
        }
        
        .url-box {
            background: #e0f2fe;
            padding: 10px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            border: 1px solid #0288d1;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #475569;
        }
        
        .warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        
        .info {
            background: #dbeafe;
            border: 1px solid #3b82f6;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        
        .success {
            background: #dcfce7;
            border: 1px solid #16a34a;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .no-print {
            margin-bottom: 20px;
        }
        
        .btn-print {
            background: #2563eb;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        
        .btn-print:hover {
            background: #1d4ed8;
        }
        
        .screenshot {
            text-align: center;
            margin: 20px 0;
            font-style: italic;
            color: #666;
        }
        
        .screenshot:before {
            content: "[SCREENSHOT]";
            display: block;
            background: #f1f5f9;
            padding: 40px;
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">Imprimer le Manuel</button>
        <button class="btn-print" onclick="window.history.back()">Retour</button>
    </div>

    <div class="header">
        <h1>Manuel Utilisateur</h1>
        <h2>Systeme de Gestion de Stock KARDEX</h2>
        <p>Version 1.0 - {{ date('d/m/Y') }}</p>
        <p>Documentation complete du systeme de gestion de stock</p>
    </div>

    <div class="toc">
        <h2>Table des Matieres</h2>
        <ul>
            <li><strong>1. Introduction</strong></li>
            <li><strong>2. Architecture du Systeme</strong></li>
            <li><strong>3. Fonctionnalites Principales</strong></li>
            <li><strong>4. Guide d'Utilisation</strong></li>
            <li><strong>5. Dashboard et Rapports</strong></li>
            <li><strong>6. Gestion des Articles</strong></li>
            <li><strong>7. Gestion des Mouvements</strong></li>
            <li><strong>8. Configuration Technique</strong></li>
            <li><strong>9. Depannage</strong></li>
            <li><strong>10. Support et Maintenance</strong></li>
        </ul>
    </div>

    <h2>1. Introduction</h2>
    
    <div class="feature-box">
        <h4>Objectif du Systeme</h4>
        <p>Le systeme de gestion de stock KARDEX est une application web developpee en Laravel permettant de gerer efficacement l'inventaire materiel d'une organisation. Il offre un suivi en temps reel des articles, des mouvements de stock et des alertes automatiques.</p>
    </div>

    <h3>1.1 Avantages du Systeme</h3>
    <ul>
        <li><strong>Suivi en temps reel</strong> : Connaissance instantanee des stocks</li>
        <li><strong>Alertes automatiques</strong> : Notifications quand les stocks sont bas</li>
        <li><strong>Rapports detailles</strong> : Analyses et statistiques completes</li>
        <li><strong>Interface intuitive</strong> : Facile a utiliser pour tous les utilisateurs</li>
        <li><strong>Securite</strong> : Authentification et autorisations par role</li>
    </ul>

    <h2 class="page-break">2. Architecture du Systeme</h2>
    
    <h3>2.1 Technologies Utilisees</h3>
    <table>
        <tr>
            <th>Composant</th>
            <th>Technologie</th>
            <th>Description</th>
        </tr>
        <tr>
            <td>Backend</td>
            <td>Laravel 10</td>
            <td>Framework PHP pour la logique metier</td>
        </tr>
        <tr>
            <td>Base de donnees</td>
            <td>MySQL</td>
            <td>Systeme de gestion de base de donnees</td>
        </tr>
        <tr>
            <td>Frontend</td>
            <td>Tailwind CSS</td>
            <td>Framework CSS pour l'interface utilisateur</td>
        </tr>
        <tr>
            <td>Graphiques</td>
            <td>Chart.js</td>
            <td>Bibliotheque JavaScript pour les visualisations</td>
        </tr>
    </table>

    <h3>2.2 Structure de la Base de Donnees</h3>
    
    <h4>Table Articles</h4>
    <table>
        <tr>
            <th>Champ</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        <tr>
            <td>codeArticle</td>
            <td>VARCHAR</td>
            <td>Code unique de l'article (cle primaire)</td>
        </tr>
        <tr>
            <td>description</td>
            <td>VARCHAR</td>
            <td>Description detaillee de l'article</td>
        </tr>
        <tr>
            <td>uniteDeMesure</td>
            <td>VARCHAR</td>
            <td>Unite de mesure (pieces, kg, litres, etc.)</td>
        </tr>
        <tr>
            <td>prixUnitaire</td>
            <td>DECIMAL(10,2)</td>
            <td>Prix unitaire en FCFA</td>
        </tr>
        <tr>
            <td>quantiteStock</td>
            <td>INTEGER</td>
            <td>Quantite actuelle en stock</td>
        </tr>
        <tr>
            <td>seuilAlerte</td>
            <td>INTEGER</td>
            <td>Seuil critique pour les alertes</td>
        </tr>
        <tr>
            <td>quantiteInitiale</td>
            <td>INTEGER</td>
            <td>Quantite initiale lors de la creation</td>
        </tr>
        <tr>
            <td>idOrganisation</td>
            <td>FOREIGN KEY</td>
            <td>Reference vers l'organisation</td>
        </tr>
    </table>

    <h4>Table Mouvements</h4>
    <table>
        <tr>
            <th>Champ</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        <tr>
            <td>idMouvement</td>
            <td>BIGINT</td>
            <td>Identifiant unique du mouvement</td>
        </tr>
        <tr>
            <td>date_mouvement</td>
            <td>DATE</td>
            <td>Date du mouvement</td>
        </tr>
        <tr>
            <td>document_number</td>
            <td>VARCHAR</td>
            <td>Numero de document associe</td>
        </tr>
        <tr>
            <td>operation</td>
            <td>VARCHAR</td>
            <td>Type d'operation effectuee</td>
        </tr>
        <tr>
            <td>typeMouvement</td>
            <td>VARCHAR</td>
            <td>Entree ou Sortie</td>
        </tr>
        <tr>
            <td>designation</td>
            <td>VARCHAR</td>
            <td>Description du mouvement</td>
        </tr>
        <tr>
            <td>demandeur</td>
            <td>VARCHAR</td>
            <td>Service demandeur</td>
        </tr>
        <tr>
            <td>direction</td>
            <td>VARCHAR</td>
            <td>Direction concernee</td>
        </tr>
        <tr>
            <td>fournisseur</td>
            <td>VARCHAR</td>
            <td>Fournisseur</td>
        </tr>
        <tr>
            <td>numeroCommande</td>
            <td>VARCHAR</td>
            <td>Numero de commande</td>
        </tr>
        <tr>
            <td>quantiteServis</td>
            <td>INTEGER</td>
            <td>Quantite servie</td>
        </tr>
        <tr>
            <td>receptionnaire</td>
            <td>VARCHAR</td>
            <td>Personne qui recoit</td>
        </tr>
        <tr>
            <td>codeArticle</td>
            <td>FOREIGN KEY</td>
            <td>Reference vers l'article</td>
        </tr>
    </table>

    <h2 class="page-break">3. Fonctionnalites Principales</h2>
    
    <div class="feature-box">
        <h4>Dashboard Analytique</h4>
        <p>Vue d'ensemble complete avec metriques en temps reel, graphiques interactifs et alertes automatiques.</p>
    </div>

    <div class="feature-box">
        <h4>Gestion des Articles</h4>
        <p>Creation, modification et suivi des articles avec codes uniques, descriptions et seuils d'alerte.</p>
    </div>

    <div class="feature-box">
        <h4>Gestion des Mouvements</h4>
        <p>Enregistrement des entrees et sorties de stock avec tracabilite complete.</p>
    </div>

    <div class="feature-box">
        <h4>Rapports et Analyses</h4>
        <p>Generation de rapports detailles, inventaires et analyses statistiques.</p>
    </div>

    <div class="feature-box">
        <h4>Systeme d'Alertes</h4>
        <p>Notifications automatiques quand les stocks atteignent les seuils critiques.</p>
    </div>

    <h2>4. Guide d'Utilisation</h2>
    
    <h3>4.1 Acces au Systeme</h3>
    
    <div class="info">
        <strong>URL d'acces :</strong> <span class="url-box">http://localhost/stockDb/public/</span>
    </div>

    <h4>Pages Principales</h4>
    <table>
        <tr>
            <th>Page</th>
            <th>URL</th>
            <th>Fonction</th>
        </tr>
        <tr>
            <td>Dashboard</td>
            <td>/dashboard</td>
            <td>Vue d'ensemble et statistiques</td>
        </tr>
        <tr>
            <td>Stock</td>
            <td>/stock</td>
            <td>Liste des articles et mouvements</td>
        </tr>
        <tr>
            <td>Magasinier</td>
            <td>/magasinier</td>
            <td>Interface pour les operations de stock</td>
        </tr>
        <tr>
            <td>Rapport PDF</td>
            <td>/dashboard/report</td>
            <td>Rapport d'inventaire imprimable</td>
        </tr>
    </table>

    <h2 class="page-break">5. Dashboard et Rapports</h2>
    
    <h3>5.1 Metriques Principales</h3>
    
    <div class="screenshot">Dashboard - Metriques principales</div>
    
    <p>Le dashboard affiche quatre metriques cles :</p>
    <ul>
        <li><strong>Total Articles</strong> : Nombre total d'articles enregistres</li>
        <li><strong>En Stock</strong> : Articles avec quantite > 0</li>
        <li><strong>Alerte Stock</strong> : Articles en dessous du seuil critique</li>
        <li><strong>Mouvements</strong> : Total des mouvements de stock</li>
    </ul>

    <h3>5.2 Graphiques Interactifs</h3>
    
    <h4>Graphique des Mouvements par Mois</h4>
    <p>Visualise l'evolution des mouvements de stock sur les 12 derniers mois.</p>
    
    <h4>Repartition des Articles</h4>
    <p>Graphique circulaire montrant la repartition : Disponible, Alerte, Epuise.</p>

    <h3>5.3 Rapports Detailles</h3>
    
    <h4>Articles en Alerte</h4>
    <p>Liste des articles necessitant un reapprovisionnement urgent.</p>
    
    <h4>Mouvements Recents</h4>
    <p>Derniers mouvements de stock avec statuts colores (Entree/Sortie).</p>

    <h3>5.4 Inventaire Materiel</h3>
    
    <div class="success">
        <strong>Fonctionnalite cle :</strong> Le systeme calcule automatiquement la valeur totale du stock en FCFA.
    </div>
    
    <p>L'inventaire complet inclut :</p>
    <ul>
        <li>Code et description de chaque article</li>
        <li>Prix unitaire et valeur totale</li>
        <li>Quantite en stock et seuil critique</li>
        <li>Statut visuel (Disponible/Alerte/Epuise)</li>
    </ul>

    <h2 class="page-break">6. Gestion des Articles</h2>
    
    <h3>6.1 Creation d'un Article</h3>
    
    <div class="warning">
        <strong>Important :</strong> Chaque article doit avoir un code unique.
    </div>
    
    <p>Pour creer un nouvel article :</p>
    <ol>
        <li>Acceder a la page Magasinier</li>
        <li>Remplir le formulaire avec :
            <ul>
                <li>Code article unique</li>
                <li>Description detaillee</li>
                <li>Unite de mesure</li>
                <li>Prix unitaire</li>
                <li>Quantite initiale</li>
                <li>Seuil d'alerte</li>
            </ul>
        </li>
        <li>Valider la creation</li>
    </ol>

    <h3>6.2 Modification d'un Article</h3>
    <p>Les articles peuvent etre modifies via l'interface d'administration.</p>

    <h3>6.3 Seuils d'Alerte</h3>
    <p>Le systeme genere automatiquement des alertes quand :</p>
    <ul>
        <li>Quantite ≤ Seuil critique</li>
        <li>Quantite = 0 (epuise)</li>
    </ul>

    <h2>7. Gestion des Mouvements</h2>
    
    <h3>7.1 Types de Mouvements</h3>
    
    <div class="info">
        <strong>Entree :</strong> Reception de marchandises (achat, retour, etc.)<br>
        <strong>Sortie :</strong> Distribution de marchandises (consommation, vente, etc.)
    </div>

    <h3>7.2 Enregistrement d'un Mouvement</h3>
    
    <p>Chaque mouvement doit inclure :</p>
    <ul>
        <li>Date du mouvement</li>
        <li>Type d'operation</li>
        <li>Article concerne</li>
        <li>Quantite</li>
        <li>Demandeur/Service</li>
        <li>Fournisseur (pour les entrees)</li>
        <li>Numero de document</li>
        <li>Receptionnaire</li>
    </ul>

    <h3>7.3 Tracabilite</h3>
    <p>Le systeme maintient un historique complet de tous les mouvements pour assurer la tracabilite.</p>

    <h2 class="page-break">8. Configuration Technique</h2>
    
    <h3>8.1 Prerequis Systeme</h3>
    <table>
        <tr>
            <th>Composant</th>
            <th>Version</th>
            <th>Description</th>
        </tr>
        <tr>
            <td>PHP</td>
            <td>8.1+</td>
            <td>Langage de programmation</td>
        </tr>
        <tr>
            <td>MySQL</td>
            <td>5.7+</td>
            <td>Base de donnees</td>
        </tr>
        <tr>
            <td>Composer</td>
            <td>2.0+</td>
            <td>Gestionnaire de dependances</td>
        </tr>
        <tr>
            <td>Node.js</td>
            <td>16+</td>
            <td>Pour les assets frontend</td>
        </tr>
    </table>

    <h3>8.2 Installation</h3>
    
    <div class="url-box">
        # Cloner le projet<br>
        git clone [url-du-projet]<br>
        cd stockDb<br><br>
        
        # Installer les dependances PHP<br>
        composer install<br><br>
        
        # Installer les dependances Node.js<br>
        npm install<br><br>
        
        # Copier le fichier d'environnement<br>
        cp .env.example .env<br><br>
        
        # Configurer la base de donnees dans .env<br>
        DB_CONNECTION=mysql<br>
        DB_HOST=127.0.0.1<br>
        DB_PORT=3306<br>
        DB_DATABASE=stockdb<br>
        DB_USERNAME=root<br>
        DB_PASSWORD=<br><br>
        
        # Generer la cle d'application<br>
        php artisan key:generate<br><br>
        
        # Executer les migrations<br>
        php artisan migrate<br><br>
        
        # Compiler les assets<br>
        npm run build
    </div>

    <h3>8.3 Configuration de la Base de Donnees</h3>
    <p>Assurez-vous que la base de donnees MySQL est configuree et accessible.</p>

    <h2>9. Depannage</h2>
    
    <h3>9.1 Problemes Courants</h3>
    
    <div class="warning">
        <strong>Erreur 404 :</strong> Verifiez que les routes sont correctement definies et que le serveur web fonctionne.
    </div>
    
    <div class="warning">
        <strong>Erreur de base de donnees :</strong> Verifiez la connexion et que toutes les migrations ont ete executees.
    </div>
    
    <div class="warning">
        <strong>Erreur de colonne manquante :</strong> Executez <code>php artisan migrate</code> pour creer les tables manquantes.
    </div>

    <h3>9.2 Commandes Utiles</h3>
    
    <div class="url-box">
        # Voir les routes disponibles<br>
        php artisan route:list<br><br>
        
        # Vider le cache des routes<br>
        php artisan route:clear<br><br>
        
        # Vider le cache de configuration<br>
        php artisan config:clear<br><br>
        
        # Voir les logs d'erreur<br>
        tail -f storage/logs/laravel.log
    </div>

    <h2 class="page-break">10. Support et Maintenance</h2>
    
    <h3>10.1 Sauvegarde</h3>
    <p>Effectuez regulierement des sauvegardes de :</p>
    <ul>
        <li>Base de donnees MySQL</li>
        <li>Fichiers du projet</li>
        <li>Fichiers de configuration</li>
    </ul>

    <h3>10.2 Maintenance Preventive</h3>
    <ul>
        <li>Surveiller l'espace disque</li>
        <li>Verifier les logs d'erreur</li>
        <li>Mettre a jour les dependances</li>
        <li>Tester les sauvegardes</li>
    </ul>

    <h3>10.3 Securite</h3>
    <div class="info">
        <strong>Recommandations :</strong>
        <ul>
            <li>Utiliser des mots de passe forts</li>
            <li>Limiter l'acces aux fichiers sensibles</li>
            <li>Maintenir le systeme a jour</li>
            <li>Surveiller les tentatives d'acces</li>
        </ul>
    </div>

    <div class="footer">
        <p><strong>Manuel Utilisateur - Systeme de Gestion de Stock KARDEX</strong></p>
        <p>Version 1.0 - Genere le {{ date('d/m/Y a H:i') }}</p>
        <p>Documentation technique complete pour l'utilisation et la maintenance du systeme</p>
        <p>Copyright 2025 - Tous droits reserves</p>
    </div>
</body>
</html> 