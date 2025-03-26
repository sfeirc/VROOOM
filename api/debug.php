<?php
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    // vérifier la marque BMW
    $brandStmt = $pdo->prepare("SELECT * FROM MarqueVoiture WHERE NomMarque = 'BMW'");
    $brandStmt->execute();
    $bmwBrand = $brandStmt->fetch(PDO::FETCH_ASSOC);

    // vérifier les voitures BMW
    $carsStmt = $pdo->prepare("
        SELECT v.*, m.NomMarque, t.NomType
        FROM Voiture v
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN TypeVehicule t ON v.IdType = t.IdType
        WHERE m.NomMarque = 'BMW'
    ");
    $carsStmt->execute();
    $bmwCars = $carsStmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'bmw_brand' => $bmwBrand,
        'bmw_cars' => $bmwCars
    ]);
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 