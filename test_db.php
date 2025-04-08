<?php
// Charger les variables d'environnement depuis le fichier .env
$env = parse_ini_file('.env');

// Récupérer les informations de connexion
$host = $env['DB_HOST'];
$db_name = $env['DB_NAME'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];

// Tenter d'établir une connexion
try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Configurer PDO pour qu'il lance des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base de données réussie! ✅\n";
    
    // Afficher quelques informations sur la base de données
    echo "Version du serveur: " . $conn->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";
    
    // Compter le nombre de tables dans la base de données
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Nombre de tables: " . count($tables) . "\n";
    
    // Lister les tables
    echo "Tables dans la base de données:\n";
    foreach ($tables as $table) {
        echo " - $table\n";
    }
    
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: ❌\n" . $e->getMessage();
}
?> 