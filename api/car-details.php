<?php
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    if (!isset($_GET['id'])) {
        throw new Exception('ID de voiture manquant');
    }

    $carId = $_GET['id'];

    // Récupérer les détails de la voiture avec les informations de marque et type
    $stmt = $pdo->prepare("
        SELECT v.*, m.NomMarque, t.NomType
        FROM Voiture v
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN TypeVehicule t ON v.IdType = t.IdType
        WHERE v.IdVoiture = :id
    ");

    $stmt->execute([':id' => $carId]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        throw new Exception('Voiture non trouvée');
    }

    echo json_encode([
        'success' => true,
        'car' => $car
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 