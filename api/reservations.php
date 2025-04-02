<?php
require_once '../config/database.php';
session_start();

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Méthode non autorisée');
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'create_reservation') {
        throw new Exception('Action non spécifiée');
    }

    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        throw new Exception('Utilisateur non connecté');
    }

    // Vérifier les paramètres requis
    $requiredParams = ['car_id', 'start_date', 'end_date'];
    foreach ($requiredParams as $param) {
        if (!isset($_POST[$param]) || empty($_POST[$param])) {
            throw new Exception("Paramètre $param manquant");
        }
    }

    $carId = $_POST['car_id'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $userId = $_SESSION['user']['id'];
    
    // Use provided amount if available, otherwise calculate
    $totalAmount = isset($_POST['amount']) && !empty($_POST['amount']) 
        ? floatval($_POST['amount']) 
        : null;

    // Log debugging information
    error_log("Reservation data: " . json_encode([
        'carId' => $carId,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'userId' => $userId,
        'totalAmount' => $totalAmount
    ]));

    // Vérifier la disponibilité de la voiture
    $availabilityStmt = $pdo->prepare("
        SELECT COUNT(*) as count
        FROM Reservation
        WHERE IdVoiture = :carId
        AND (
            (DateDebut BETWEEN :startDate AND :endDate)
            OR (DateFin BETWEEN :startDate AND :endDate)
            OR (:startDate BETWEEN DateDebut AND DateFin)
        )
        AND Statut NOT IN ('Annulée')
    ");

    $availabilityStmt->execute([
        ':carId' => $carId,
        ':startDate' => $startDate,
        ':endDate' => $endDate
    ]);

    $result = $availabilityStmt->fetch(PDO::FETCH_ASSOC);
    if ($result['count'] > 0) {
        throw new Exception('La voiture n\'est pas disponible pour ces dates');
    }

    // If amount wasn't provided, calculate it
    if ($totalAmount === null) {
        // Récupérer le prix journalier de la voiture
        $priceStmt = $pdo->prepare("SELECT PrixLocation FROM Voiture WHERE IdVoiture = :carId");
        $priceStmt->execute([':carId' => $carId]);
        $priceResult = $priceStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$priceResult) {
            throw new Exception('Voiture non trouvée');
        }
        
        $price = $priceResult['PrixLocation'];

        // Calculer le nombre de jours
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = $start->diff($end);
        $days = $interval->days + 1; // +1 pour inclure le dernier jour

        // Calculer le montant total
        $totalAmount = $price * $days;
    }

    // Générer un ID de réservation unique
    $reservationId = 'RES' . date('YmdHis') . rand(1000, 9999);

    // Créer la réservation
    $stmt = $pdo->prepare("
        INSERT INTO Reservation (
            IdReservation, DateDebut, DateFin, MontantReservation,
            Statut, IdClient, IdVoiture, DateReservation
        ) VALUES (
            :id, :startDate, :endDate, :amount,
            'En attente', :userId, :carId, NOW()
        )
    ");

    $stmt->execute([
        ':id' => $reservationId,
        ':startDate' => $startDate,
        ':endDate' => $endDate,
        ':amount' => $totalAmount,
        ':userId' => $userId,
        ':carId' => $carId
    ]);

    echo json_encode([
        'success' => true,
        'reservationId' => $reservationId,
        'message' => 'Réservation créée avec succès'
    ]);

} catch (Exception $e) {
    error_log("Reservation error: " . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 