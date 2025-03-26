<?php
require_once '../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

try {
    $stmt = $pdo->prepare("
        SELECT DISTINCT BoiteVitesse
        FROM Voiture
        WHERE BoiteVitesse IS NOT NULL
        ORDER BY BoiteVitesse ASC
    ");
    $stmt->execute();
    $transmissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode([
        'success' => true,
        'transmissions' => $transmissions
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 