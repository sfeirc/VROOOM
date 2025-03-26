<?php
require_once '../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

try {
    // Récupérer toutes les marques
    $checkQuery = "SELECT * FROM MarqueVoiture ORDER BY NomMarque ASC";
    $checkStmt = $pdo->query($checkQuery);
    $allBrands = $checkStmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("All brands in database: " . print_r($allBrands, true));

    // récupérer les marques qui ont des voitures
    $stmt = $pdo->prepare("
        SELECT DISTINCT m.IdMarque, m.NomMarque
        FROM MarqueVoiture m
        JOIN Voiture v ON m.IdMarque = v.IdMarque
        WHERE v.IdStatut = 'STAT001'
        ORDER BY m.NomMarque ASC
    ");
    $stmt->execute();
    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Brands with available cars: " . print_r($brands, true));

    echo json_encode([
        'success' => true,
        'brands' => $brands,
        'debug' => [
            'all_brands' => $allBrands,
            'brands_with_cars' => $brands
        ]
    ]);
} catch(PDOException $e) {
    error_log("Error in brands.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 