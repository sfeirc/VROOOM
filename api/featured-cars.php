<?php
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    // Vérifier la connexion à la base de données
    if (!isset($pdo)) {
        throw new Exception("Database connection not established");
    }

    $stmt = $pdo->prepare("
        SELECT v.*, m.NomMarque, t.NomType
        FROM Voiture v
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN TypeVehicule t ON v.IdType = t.IdType
        WHERE v.IdStatut = 'STAT001'
        ORDER BY RAND()
        LIMIT 3
    ");
    $stmt->execute();
    $featuredCars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pour déboguer
    error_log("Featured cars: " . json_encode($featuredCars));

    echo json_encode([
        'success' => true,
        'cars' => $featuredCars
    ]);
} catch(Exception $e) {
    error_log("Error loading featured cars: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 