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
    
    // Parse PhotosSupplementaires JSON field if it exists
    if (isset($car['PhotosSupplementaires']) && !empty($car['PhotosSupplementaires'])) {
        // Log the raw PhotosSupplementaires value
        error_log("Raw PhotosSupplementaires: " . $car['PhotosSupplementaires']);
        
        // Try to decode the JSON string
        $decoded = json_decode($car['PhotosSupplementaires'], true);
        
        // Log any JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON decode error: " . json_last_error_msg());
            $car['PhotoSupplementairesArray'] = [];
        } else {
            $car['PhotoSupplementairesArray'] = $decoded;
            error_log("Decoded PhotoSupplementairesArray: " . print_r($decoded, true));
        }
    } else {
        $car['PhotoSupplementairesArray'] = [];
        error_log("No PhotosSupplementaires found or empty");
    }
    
    // Log the final car data being sent
    error_log("Final car data being sent: " . print_r($car, true));
    
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