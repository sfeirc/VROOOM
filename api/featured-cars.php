<?php
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        SELECT v.*, m.NomMarque, t.NomType
        FROM Voiture v
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN TypeVehicule t ON v.IdType = t.IdType
        WHERE v.IdStatut = 'STAT001'
        ORDER BY RAND()
        LIMIT 6
    ");
    $stmt->execute();
    $featuredCars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($featuredCars);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?> 