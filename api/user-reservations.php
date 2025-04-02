<?php
require_once '../config/database.php';
session_start();

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        throw new Exception('Utilisateur non connecté');
    }

    $userId = $_SESSION['user']['id'];

    // Récupérer les réservations de l'utilisateur avec les détails de la voiture
    $stmt = $pdo->prepare("
        SELECT 
            r.IdReservation, 
            r.DateDebut, 
            r.DateFin, 
            r.MontantReservation,
            r.Statut,
            r.DateReservation,
            v.IdVoiture,
            v.Modele as ModeleVoiture,
            v.Photo as PhotoVoiture,
            m.NomMarque as MarqueVoiture,
            t.NomType as TypeVoiture
        FROM 
            Reservation r
        JOIN 
            Voiture v ON r.IdVoiture = v.IdVoiture
        JOIN
            MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN
            TypeVehicule t ON v.IdType = t.IdType
        WHERE 
            r.IdClient = :userId
        ORDER BY 
            r.DateReservation DESC
    ");
    
    $stmt->execute([':userId' => $userId]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'reservations' => $reservations
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 