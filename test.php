<?php
echo "Test WAMP - Laravel fonctionne !";
echo "<br>Dossier actuel : " . __DIR__;
echo "<br>Fichier index.php existe : " . (file_exists(__DIR__ . '/index.php') ? 'OUI' : 'NON');
echo "<br>Fichier public/index.php existe : " . (file_exists(__DIR__ . '/public/index.php') ? 'OUI' : 'NON');
?> 