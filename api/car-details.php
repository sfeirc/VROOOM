<?php
require_once '../config/database.php';
// Gestion des en-têtes
header('Content-Type: application/json');
// Gestion des erreurs
try {
    if (!isset($_GET['id'])) {
        throw new Exception('ID de voiture manquant');
    }
    // Récupérer l'ID de la voiture
    $carId = $_GET['id'];
    // Préparer la requête
    // Récupérer les détails de la voiture avec les informations de marque et type
    $stmt = $pdo->prepare("
        SELECT v.*, m.NomMarque, t.NomType
        FROM Voiture v
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN TypeVehicule t ON v.IdType = t.IdType
        WHERE v.IdVoiture = :id
    ");
    // Exécuter la requête
    $stmt->execute([':id' => $carId]);
    // Récupérer les détails de la voiture
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    // Vérifier si la voiture existe
    if (!$car) {
        throw new Exception('Voiture non trouvée');
    }
    
    echo json_encode([
        'success' => true,
        'car' => $car
    ]);

} catch (Exception $e) {
    // Gérer les erreurs
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 