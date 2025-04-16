<?php
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    // Get car ID from request
    $carId = isset($_GET['car_id']) ? $_GET['car_id'] : null;
    
    if (!$carId) {
        throw new Exception('Car ID is required');
    }
    
    // Verify if the car exists
    $carStmt = $pdo->prepare("SELECT IdVoiture FROM Voiture WHERE IdVoiture = :carId");
    $carStmt->execute([':carId' => $carId]);
    $car = $carStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$car) {
        throw new Exception('Car not found');
    }
    
    // Get all active reservations for this car
    $reservationsStmt = $pdo->prepare("
        SELECT DateDebut, DateFin 
        FROM Reservation 
        WHERE IdVoiture = :carId 
        AND Statut NOT IN ('Annulée')
        ORDER BY DateDebut ASC
    ");
    $reservationsStmt->execute([':carId' => $carId]);
    $reservations = $reservationsStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Prepare the result
    $bookedPeriods = [];
    foreach ($reservations as $reservation) {
        $bookedPeriods[] = [
            'start' => $reservation['DateDebut'],
            'end' => $reservation['DateFin']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'car_id' => $carId,
        'booked_periods' => $bookedPeriods
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 