<?php
// Gestion des erreurs
require_once '../config/database.php';
// Gestion des sessions
session_start();
// Gestion des en-têtes
header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        throw new Exception('Utilisateur non connecté');
    }
    // Récupérer l'ID de l'utilisateur
    $userId = $_SESSION['user']['id'];
    // Préparer la requête
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
            r.IdUser = :userId
        ORDER BY 
            r.DateReservation DESC
    ");
    // Exécuter la requête
    $stmt->execute([':userId' => $userId]);
    // Récupérer les réservations
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Retourner une réponse de succès
    echo json_encode([
        'success' => true,
        'reservations' => $reservations
    ]);
// Gestion des erreurs
} catch (Exception $e) {
    // Log l'erreur
    error_log("Erreur API user-reservations: " . $e->getMessage());
    // Retourner un code 400 et le message d'erreur
    http_response_code(400);
    // Retourner une réponse d'erreur
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 