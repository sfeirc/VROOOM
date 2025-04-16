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
    
    // Initialiser les données utilisateur et voiture
    $userData = [
        'Nom' => 'Non disponible',
        'Prenom' => 'Non disponible',
        'Email' => 'Non disponible',
        'Tel' => 'Non disponible',
        'Adresse' => 'Non disponible'
    ];
    
    $carData = [
        'Modele' => 'Non disponible',
        'Annee' => 'N/A',
        'Couleur' => 'Non disponible',
        'Energie' => 'Non disponible',
        'Puissance' => 'N/A',
        'NbPlaces' => 'N/A',
        'Prix' => $reservation['MontantReservation'] ?? 0,
        'Description' => 'Non disponible',
        'Photo' => 'assets/images/placeholder.jpg',
        'IdStatut' => 'STAT001',
        'NomMarque' => 'Non disponible',
        'NomType' => 'Non disponible'
    ];
    
    // 2. Essayer de récupérer les informations de l'utilisateur
    try {
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE IdUser = :id");
        $stmt->execute([':id' => $reservation['IdUser']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $userData = [
                'Nom' => $user['Nom'] ?? 'Non disponible',
                'Prenom' => $user['Prenom'] ?? 'Non disponible',
                'Email' => $user['Email'] ?? 'Non disponible',
                'Tel' => $user['Tel'] ?? 'Non disponible',
                'Adresse' => $user['Adresse'] ?? 'Non disponible'
            ];
        }
    } catch (PDOException $e) {
        error_log("Erreur récupération utilisateur: " . $e->getMessage());
    }
    
    // 3. Essayer de récupérer les informations de la voiture
    try {
        $stmt = $pdo->prepare("SELECT * FROM Voiture WHERE IdVoiture = :id");
        $stmt->execute([':id' => $reservation['IdVoiture']]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($car) {
            $carData = [
                'Modele' => $car['Modele'] ?? 'Non disponible',
                'Annee' => $car['Annee'] ?? 'N/A',
                'Couleur' => $car['Couleur'] ?? 'Non disponible',
                'Energie' => $car['Energie'] ?? 'Non disponible',
                'Puissance' => $car['Puissance'] ?? 'N/A',
                'NbPlaces' => $car['NbPlaces'] ?? 'N/A',
                'Prix' => $car['Prix'] ?? ($reservation['MontantReservation'] ?? 0),
                'Description' => $car['Description'] ?? 'Non disponible',
                'Photo' => $car['Photo'] ?? 'assets/images/placeholder.jpg',
                'IdStatut' => $car['IdStatut'] ?? 'STAT001',
                'NomMarque' => 'Non disponible',
                'NomType' => 'Non disponible'
            ];
            
            // 4. Essayer de récupérer la marque (si disponible)
            try {
                $stmt = $pdo->prepare("SELECT * FROM MarqueVoiture WHERE IdMarque = :id");
                $stmt->execute([':id' => $car['IdMarque']]);
                $brand = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($brand) {
                    $carData['NomMarque'] = $brand['NomMarque'];
                }
            } catch (PDOException $e) {
                error_log("Erreur récupération marque: " . $e->getMessage());
            }
            
            // On saute la récupération du type car TypeVoiture n'existe pas
        }
    } catch (PDOException $e) {
        error_log("Erreur récupération voiture: " . $e->getMessage());
    }
    
    // Fusionner toutes les données
    $result = array_merge(
        $reservation,
        $userData,
        $carData
    );
    
    echo json_encode([
        'success' => true,
        'reservation' => $result
    ]);
    
} catch (PDOException $e) {
    error_log("Erreur API détails réservation super simple: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erreur de base de données: ' . $e->getMessage()
    ]);
} 