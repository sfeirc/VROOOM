<?php
require_once '../config/database.php';

header('Content-Type: application/json');
session_start();

// Get the reservation ID from the request
$reservationId = $_REQUEST['id'] ?? '';

if (empty($reservationId)) {
    echo json_encode([
        'success' => false,
        'message' => 'ID de réservation requis'
    ]);
    exit;
}

try {
    // 1. Récupérer la réservation basique
    $stmt = $pdo->prepare("
        SELECT * FROM Reservation WHERE IdReservation = :id
    ");
    $stmt->execute([':id' => $reservationId]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$reservation) {
        echo json_encode([
            'success' => false,
            'message' => 'Réservation non trouvée'
        ]);
        exit;
    }
    
    // 2. Récupérer les informations de l'utilisateur
    $stmt = $pdo->prepare("
        SELECT * FROM Users WHERE IdUser = :id
    ");
    $stmt->execute([':id' => $reservation['IdUser']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // 3. Récupérer les informations de la voiture
    $stmt = $pdo->prepare("
        SELECT * FROM Voiture WHERE IdVoiture = :id
    ");
    $stmt->execute([':id' => $reservation['IdVoiture']]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // 4. Récupérer la marque
    if ($car) {
        $stmt = $pdo->prepare("
            SELECT * FROM MarqueVoiture WHERE IdMarque = :id
        ");
        $stmt->execute([':id' => $car['IdMarque']]);
        $brand = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $brand = null;
    }
    
    // 5. Récupérer le type
    if ($car) {
        $stmt = $pdo->prepare("
            SELECT * FROM TypeVoiture WHERE IdType = :id
        ");
        $stmt->execute([':id' => $car['IdType']]);
        $type = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $type = null;
    }
    
    // Fusionner toutes les données
    $result = array_merge(
        $reservation,
        [
            // Données utilisateur
            'Nom' => $user['Nom'] ?? null,
            'Prenom' => $user['Prenom'] ?? null,
            'Email' => $user['Email'] ?? null,
            'Tel' => $user['Tel'] ?? null,
            'Adresse' => $user['Adresse'] ?? null,
            
            // Données voiture
            'Modele' => $car['Modele'] ?? null,
            'Annee' => $car['Annee'] ?? null,
            'Couleur' => $car['Couleur'] ?? null,
            'Energie' => $car['Energie'] ?? null,
            'Puissance' => $car['Puissance'] ?? null,
            'NbPlaces' => $car['NbPlaces'] ?? null,
            'Prix' => $car['Prix'] ?? null,
            'Description' => $car['Description'] ?? null,
            'Photo' => $car['Photo'] ?? null,
            'IdStatut' => $car['IdStatut'] ?? null,
            
            // Données marque
            'IdMarque' => $brand['IdMarque'] ?? null,
            'NomMarque' => $brand['NomMarque'] ?? null,
            
            // Données type
            'IdType' => $type['IdType'] ?? null,
            'NomType' => $type['NomType'] ?? null
        ]
    );
    
    echo json_encode([
        'success' => true,
        'reservation' => $result
    ]);
    
} catch (PDOException $e) {
    error_log("Erreur API détails réservation: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erreur de base de données: ' . $e->getMessage()
    ]);
} 