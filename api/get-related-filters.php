<?php
require_once '../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

try {
    $brandId = isset($_GET['brand']) ? $_GET['brand'] : null;
    $typeId = isset($_GET['type']) ? $_GET['type'] : null;
    
    if ($brandId) {
        // Si une marque est sélectionnée, récupérer les types associés
        $stmt = $pdo->prepare("
            SELECT DISTINCT t.IdType, t.NomType
            FROM TypeVehicule t
            JOIN Voiture v ON v.IdType = t.IdType
            WHERE v.IdMarque = ?
            ORDER BY t.NomType
        ");
        $stmt->execute([$brandId]);
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'types' => $types
        ]);
    } 
    else if ($typeId) {
        // Si un type est sélectionné, récupérer les marques associées
        $stmt = $pdo->prepare("
            SELECT DISTINCT m.IdMarque, m.NomMarque
            FROM MarqueVoiture m
            JOIN Voiture v ON v.IdMarque = m.IdMarque
            WHERE v.IdType = ?
            ORDER BY m.NomMarque
        ");
        $stmt->execute([$typeId]);
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'brands' => $brands
        ]);
    }
    else {
        // Si ni une marque ni un type n'est sélectionné, récupérer toutes les marques et types
        $stmtBrands = $pdo->query("SELECT * FROM MarqueVoiture ORDER BY NomMarque");
        $stmtTypes = $pdo->query("SELECT * FROM TypeVehicule ORDER BY NomType");
        
        echo json_encode([
            'success' => true,
            'brands' => $stmtBrands->fetchAll(PDO::FETCH_ASSOC),
            'types' => $stmtTypes->fetchAll(PDO::FETCH_ASSOC)
        ]);
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 