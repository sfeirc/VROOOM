<?php
require_once '../config/database.php';
// Gestion des en-têtes
header('Content-Type: application/json');
// Gestion des sessions
session_start();
// Vérifier si l'utilisateur est un administrateur
function checkAdminAuth() {
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode([
            'success' => false,
            'message' => 'Accès non autorisé. Vous devez être connecté en tant qu\'administrateur.'
        ]);
        exit;
    }
}
// Gestion des erreurs
try {
    // Vérifier l'authentification
    checkAdminAuth();
    // Récupérer la liste des tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    // Préparer le résultat
    $database = [];

    // Pour chaque table, récupérer sa structure
    foreach ($tables as $table) {
        $stmt = $pdo->query("DESCRIBE `$table`");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Ajouter la table et ses colonnes au résultat
        $database[$table] = $columns;
    }
    // Retourner une réponse de succès
    echo json_encode([
        'success' => true,
        'database' => $database
    ]);
// Gestion des erreurs
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 