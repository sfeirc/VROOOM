<?php

// Charger les variables d'environnement
function loadEnv($path = '../.env') {
    // Vérifier si le fichier .env existe
    if (!file_exists($path)) {
        throw new Exception('.env file not found');
    }
    // Lire le fichier .env
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    // Parcourir les lignes
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        // Décomposer la ligne en nom et valeur
        list($name, $value) = explode('=', $line, 2);
        // Nettoyer le nom et la valeur
        $name = trim($name);
        $value = trim($value);
        // Vérifier si la variable d'environnement existe
        if (!array_key_exists($name, $_ENV)) {
            // Ajouter la variable d'environnement
            putenv(sprintf('%s=%s', $name, $value));
            // Ajouter la variable d'environnement à $_ENV
            $_ENV[$name] = $value;
            // Ajouter la variable d'environnement à $_SERVER
            $_SERVER[$name] = $value;
        }
    }
} 