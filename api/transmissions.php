<?php
// Gestion des erreurs
require_once '../config/database.php';
// Gestion des en-têtes
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
// Gestion des erreurs
try {
    $stmt = $pdo->prepare("
        SELECT DISTINCT BoiteVitesse
        FROM Voiture
        WHERE BoiteVitesse IS NOT NULL
        ORDER BY BoiteVitesse ASC
    ");
    $stmt->execute();
    $transmissions = $stmt->fetchAll(PDO::FETCH_COLUMN);
    // Retourner une réponse de succès
    echo json_encode([
        'success' => true,
        'transmissions' => $transmissions
    ]);
// Gestion des erreurs
} catch(PDOException $e) {
    // Log l'erreur
    error_log("Erreur API transmissions: " . $e->getMessage());
    // Retourner un code 500 et le message d'erreur
    http_response_code(500);
    // Retourner une réponse d'erreur
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 