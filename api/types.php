<?php
require_once '../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

try {
    $stmt = $pdo->prepare("
        SELECT DISTINCT t.IdType, t.NomType
        FROM TypeVehicule t
        ORDER BY t.NomType ASC
    ");
    $stmt->execute();
    $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'types' => $types
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 