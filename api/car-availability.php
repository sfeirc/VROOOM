<?php
require_once '../config/database.php';
// Gestion des en-têtes
header('Content-Type: application/json');
// Gestion des erreurs
try {
    // Get car ID from request
    $carId = isset($_GET['car_id']) ? $_GET['car_id'] : null;
    // Vérifier si l'ID de la voiture est fourni
    if (!$carId) {
        throw new Exception('Car ID is required');
    }
    // Vérifier si la voiture existe
    $carStmt = $pdo->prepare("SELECT IdVoiture FROM Voiture WHERE IdVoiture = :carId");
    // Exécuter la requête
    $carStmt->execute([':carId' => $carId]);
    // Récupérer la voiture
    $car = $carStmt->fetch(PDO::FETCH_ASSOC);
    // Vérifier si la voiture existe
    if (!$car) {
        throw new Exception('Car not found');
    }
    // Récupérer toutes les réservations actives pour cette voiture
    $reservationsStmt = $pdo->prepare("
        SELECT DateDebut, DateFin 
        FROM Reservation 
        WHERE IdVoiture = :carId 
        AND Statut NOT IN ('Annulée')
        ORDER BY DateDebut ASC
    ");
    $reservationsStmt->execute([':carId' => $carId]);
    $reservations = $reservationsStmt->fetchAll(PDO::FETCH_ASSOC);
    // Préparer le résultat
    $bookedPeriods = [];
    foreach ($reservations as $reservation) {
        $bookedPeriods[] = [
            'start' => $reservation['DateDebut'],
            'end' => $reservation['DateFin']
        ];
    }
    // Retourner une réponse de succès
    echo json_encode([
        'success' => true,
        'car_id' => $carId,
        'booked_periods' => $bookedPeriods
    ]);
} catch (Exception $e) {
    // Gérer les erreurs
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 