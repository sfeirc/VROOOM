<?php
require_once '../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

try {
    // Debug du tableau $_GET
    error_log("Received parameters: " . print_r($_GET, true));

    // Conditions de base
    $conditions = ['v.IdStatut = :status'];
    $params = [':status' => 'STAT001'];

    // Construction de la requête de recherche avec les bonnes jointures
    $searchQuery = "
        SELECT 
            v.*,
            m.NomMarque,
            m.LogoMarque,
            t.NomType
        FROM Voiture v
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN TypeVehicule t ON v.IdType = t.IdType
    ";

    // ajouter les conditions de filtre
    if (!empty($_GET['marque'])) {
        $conditions[] = 'v.IdMarque = :marque';
        $params[':marque'] = $_GET['marque'];
        error_log("Filtering by brand ID: " . $_GET['marque']);
    }

    if (!empty($_GET['type'])) {
        $conditions[] = 'v.IdType = :type';
        $params[':type'] = $_GET['type'];
    }

    if (!empty($_GET['energie'])) {
        $conditions[] = 'v.Energie = :energie';
        $params[':energie'] = $_GET['energie'];
    }

    if (!empty($_GET['boite'])) {
        $conditions[] = 'v.BoiteVitesse = :boite';
        $params[':boite'] = $_GET['boite'];
    }

    if (!empty($_GET['prix_min'])) {
        $conditions[] = 'v.PrixLocation >= :prix_min';
        $params[':prix_min'] = $_GET['prix_min'];
    }

    if (!empty($_GET['prix_max'])) {
        $conditions[] = 'v.PrixLocation <= :prix_max';
        $params[':prix_max'] = $_GET['prix_max'];
    }

    if (!empty($_GET['annee_min'])) {
        $conditions[] = 'v.Annee >= :annee_min';
        $params[':annee_min'] = $_GET['annee_min'];
    }

    if (!empty($_GET['annee_max'])) {
        $conditions[] = 'v.Annee <= :annee_max';
        $params[':annee_max'] = $_GET['annee_max'];
    }

    // ajouter la clause WHERE si il y a des conditions
    if (!empty($conditions)) {
        $searchQuery .= " WHERE " . implode(' AND ', $conditions);
    }

    // ajouter le tri par défaut
    $orderBy = 'v.PrixLocation ASC'; // tri par défaut
    if (!empty($_GET['sort'])) {
        switch ($_GET['sort']) {
            case 'prix_desc':
                $orderBy = 'v.PrixLocation DESC';
                break;
            case 'prix_asc':
                $orderBy = 'v.PrixLocation ASC';
                break;
            case 'annee_desc':
                $orderBy = 'v.Annee DESC';
                break;
            case 'annee_asc':
                $orderBy = 'v.Annee ASC';
                break;
        }
    }
    $searchQuery .= " ORDER BY " . $orderBy;

    // debug de la requête finale
    error_log("Final query: " . $searchQuery);
    error_log("Parameters: " . print_r($params, true));

    // exécuter la requête de recherche
    $stmt = $pdo->prepare($searchQuery);
    $stmt->execute($params);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug des résultats
    error_log("Found " . count($cars) . " cars");
    if (count($cars) > 0) {
        error_log("First car: " . print_r($cars[0], true));
    }

    echo json_encode([
        'success' => true,
        'count' => count($cars),
        'cars' => $cars,
        'debug' => [
            'query' => $searchQuery,
            'params' => $params,
            'conditions' => $conditions,
            'received_brand' => $_GET['marque'] ?? null,
            'received_params' => $_GET
        ]
    ]);

} catch(Exception $e) {
    error_log("Error in advanced search: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 