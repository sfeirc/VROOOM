<?php
require_once '../config/database.php';

header('Content-Type: application/json');
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

try {
    // Vérifier l'authentification
    checkAdminAuth();
    
    // Récupérer la liste des tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $database = [];
    
    // Pour chaque table, récupérer sa structure
    foreach ($tables as $table) {
        $stmt = $pdo->query("DESCRIBE `$table`");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $database[$table] = $columns;
    }
    
    echo json_encode([
        'success' => true,
        'database' => $database
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 