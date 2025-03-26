<?php
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    // Conditions de base pour les voitures actives
    $conditions = ['v.IdStatut = :status'];
    $params = [':status' => 'STAT001'];

    // Filtre par marque
    if (!empty($_GET['marque'])) {
        $conditions[] = 'v.IdMarque = :marque';
        $params[':marque'] = $_GET['marque'];
    }

    // Filtre par type de véhicule
    if (!empty($_GET['type'])) {
        $conditions[] = 'v.IdType = :type';
        $params[':type'] = $_GET['type'];
    }

    // Filtres de prix (minimum et maximum)
    if (!empty($_GET['prix_min'])) {
        $conditions[] = 'v.PrixLocation >= :prix_min';
        $params[':prix_min'] = $_GET['prix_min'];
    }
    if (!empty($_GET['prix_max'])) {
        $conditions[] = 'v.PrixLocation <= :prix_max';
        $params[':prix_max'] = $_GET['prix_max'];
    }

    // Filtre par année du véhicule
    if (!empty($_GET['annee_min'])) {
        $conditions[] = 'v.Annee >= :annee_min';
        $params[':annee_min'] = $_GET['annee_min'];
    }

    // Filtre par type de carburant
    if (!empty($_GET['energie'])) {
        $conditions[] = 'v.Energie = :energie';
        $params[':energie'] = $_GET['energie'];
    }

    // Filtre par type de transmission
    if (!empty($_GET['boite'])) {
        $conditions[] = 'v.BoiteVitesse = :boite';
        $params[':boite'] = $_GET['boite'];
    }

    // Construction de la clause WHERE avec toutes les conditions
    $whereClause = implode(' AND ', $conditions);

    // Options de tri
    $orderBy = 'v.PrixLocation ASC'; // Tri par défaut par prix croissant
    if (!empty($_GET['sort'])) {
        switch ($_GET['sort']) {
            case 'prix_desc':
                $orderBy = 'v.PrixLocation DESC'; // Prix décroissant
                break;
            case 'prix_asc':
                $orderBy = 'v.PrixLocation ASC'; // Prix croissant
                break;
            case 'annee_desc':
                $orderBy = 'v.Annee DESC'; // Année plus récente
                break;
            case 'annee_asc':
                $orderBy = 'v.Annee ASC'; // Année plus ancienne
                break;
        }
    }

    // Préparation et exécution de la requête principale
    $query = "
        SELECT 
            v.*,
            m.NomMarque,
            t.NomType
        FROM Voiture v
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN TypeVehicule t ON v.IdType = t.IdType
        WHERE {$whereClause}
        ORDER BY {$orderBy}
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérification de la disponibilité pour chaque voiture
    foreach ($cars as &$car) {
        // Vérifier si la voiture est disponible pour les dates sélectionnées
        if (!empty($_GET['date_debut']) && !empty($_GET['date_fin'])) {
            $availabilityStmt = $pdo->prepare("
                SELECT COUNT(*) as count
                FROM Reservation
                WHERE IdVoiture = :idVoiture
                AND (
                    (DateDebut BETWEEN :dateDebut AND :dateFin)
                    OR (DateFin BETWEEN :dateDebut AND :dateFin)
                    OR (:dateDebut BETWEEN DateDebut AND DateFin)
                )
                AND Statut NOT IN ('Annulée')
            ");
            
            $availabilityStmt->execute([
                ':idVoiture' => $car['IdVoiture'],
                ':dateDebut' => $_GET['date_debut'],
                ':dateFin' => $_GET['date_fin']
            ]);
            
            $result = $availabilityStmt->fetch(PDO::FETCH_ASSOC);
            $car['isAvailable'] = $result['count'] == 0;
        } else {
            $car['isAvailable'] = true;
        }
    }

    // Retourner les résultats en JSON
    echo json_encode($cars);
} catch(PDOException $e) {
    // En cas d'erreur, retourner un code 500 et le message d'erreur
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données: ' . $e->getMessage()]);
}
?> 