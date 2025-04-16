<?php
require_once '../config/database.php';
// Gestion des en-têtes
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
// Gestion des erreurs
try {
    $stmt = $pdo->prepare("
        SELECT DISTINCT Energie
        FROM Voiture
        WHERE Energie IS NOT NULL
        ORDER BY Energie ASC
    ");
    $stmt->execute();
    $energies = $stmt->fetchAll(PDO::FETCH_COLUMN);
    // Retourner une réponse de succès
    echo json_encode([
        'success' => true,
        'energies' => $energies
    ]);
// Gestion des erreurs
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 