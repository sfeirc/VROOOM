<?php
require_once '../config/database.php';
// Gestion des en-têtes
header('Content-Type: application/json');
// Gestion des erreurs
try {
    // Vérifier la connexion à la base de données
    if (!isset($pdo)) {
        throw new Exception("Database connection not established");
    }
    // Préparer la requête
    $stmt = $pdo->prepare("
        SELECT v.*, m.NomMarque, t.NomType
        FROM Voiture v
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN TypeVehicule t ON v.IdType = t.IdType
        WHERE v.IdStatut = 'STAT001'
        ORDER BY RAND()
        LIMIT 3
    ");
    // Exécuter la requête
    $stmt->execute();
    // Récupérer les voitures
    $featuredCars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Pour déboguer
    error_log("Featured cars: " . json_encode($featuredCars));
    // Retourner une réponse de succès
    echo json_encode([
        'success' => true,
        'cars' => $featuredCars
    ]);
// Gestion des erreurs
} catch(Exception $e) {
    error_log("Error loading featured cars: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 