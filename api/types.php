<?php
// Gestion des erreurs
require_once '../config/database.php';
// Gestion des en-têtes
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
// Gestion des erreurs
try {
    // Préparer la requête
    $stmt = $pdo->prepare("
        SELECT DISTINCT t.IdType, t.NomType
        FROM TypeVehicule t
        ORDER BY t.NomType ASC
    ");
    $stmt->execute();
    $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Retourner une réponse de succès
    echo json_encode([
        'success' => true,
        'types' => $types
    ]);
// Gestion des erreurs
} catch(PDOException $e) {
    // Log l'erreur
    error_log("Erreur API types: " . $e->getMessage());
    // Retourner un code 500 et le message d'erreur
    http_response_code(500);
    // Retourner une réponse d'erreur
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 