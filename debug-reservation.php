<?php
require_once 'config/database.php';

// ID de la réservation à tester
$reservationId = $_GET['id'] ?? '';

if (empty($reservationId)) {
    die('Veuillez fournir un ID de réservation dans le paramètre "id"');
}

try {
    echo "<h1>Débogage de la réservation #{$reservationId}</h1>";
    
    // Tester une requête simplifiée d'abord
    echo "<h2>Vérification de l'existence de la réservation</h2>";
    $stmt = $pdo->prepare("SELECT * FROM Reservation WHERE IdReservation = :id");
    $stmt->execute([':id' => $reservationId]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$reservation) {
        die("La réservation avec l'ID {$reservationId} n'existe pas.");
    }
    
    echo "✅ La réservation existe.<br><br>";
    
    // Vérifier les tables et colonnes utilisées dans la requête
    echo "<h2>Vérification des tables et relations</h2>";
    
    // Vérifier Users
    $stmt = $pdo->prepare("
        SELECT u.* 
        FROM Reservation r
        JOIN Users u ON r.IdUser = u.IdUser
        WHERE r.IdReservation = :id
    ");
    $stmt->execute([':id' => $reservationId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo "❌ Erreur de jointure avec la table Users<br>";
    } else {
        echo "✅ Jointure avec Users OK<br>";
    }
    
    // Vérifier Voiture
    $stmt = $pdo->prepare("
        SELECT v.* 
        FROM Reservation r
        JOIN Voiture v ON r.IdVoiture = v.IdVoiture
        WHERE r.IdReservation = :id
    ");
    $stmt->execute([':id' => $reservationId]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$car) {
        echo "❌ Erreur de jointure avec la table Voiture<br>";
    } else {
        echo "✅ Jointure avec Voiture OK<br>";
    }
    
    // Vérifier MarqueVoiture
    $stmt = $pdo->prepare("
        SELECT m.* 
        FROM Reservation r
        JOIN Voiture v ON r.IdVoiture = v.IdVoiture
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        WHERE r.IdReservation = :id
    ");
    $stmt->execute([':id' => $reservationId]);
    $brand = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$brand) {
        echo "❌ Erreur de jointure avec la table MarqueVoiture<br>";
    } else {
        echo "✅ Jointure avec MarqueVoiture OK<br>";
    }
    
    // Vérifier TypeVoiture
    $stmt = $pdo->prepare("
        SELECT t.* 
        FROM Reservation r
        JOIN Voiture v ON r.IdVoiture = v.IdVoiture
        JOIN TypeVoiture t ON v.IdType = t.IdType
        WHERE r.IdReservation = :id
    ");
    $stmt->execute([':id' => $reservationId]);
    $type = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$type) {
        echo "❌ Erreur de jointure avec la table TypeVoiture<br>";
    } else {
        echo "✅ Jointure avec TypeVoiture OK<br>";
    }
    
    echo "<br><h2>Structure de la table Voiture</h2>";
    $stmt = $pdo->query("DESCRIBE Voiture");
    echo "<pre>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
    echo "</pre>";
    
    // Maintenant, essayons la requête complète
    echo "<h2>Tentative de requête complète</h2>";
    
    $sql = "
        SELECT 
            r.*,
            u.IdUser, u.Nom, u.Prenom, u.Email, u.Tel, u.Adresse,
            v.IdVoiture, v.Modele, v.Annee, v.Couleur, v.Energie, v.Puissance, v.NbPlaces, v.Prix, v.Description, v.Photo,
            v.IdStatut,
            m.IdMarque, m.NomMarque,
            t.IdType, t.NomType
        FROM Reservation r
        JOIN Users u ON r.IdUser = u.IdUser
        JOIN Voiture v ON r.IdVoiture = v.IdVoiture
        JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
        JOIN TypeVoiture t ON v.IdType = t.IdType
        WHERE r.IdReservation = :id
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $reservationId]);
    $fullReservation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$fullReservation) {
        echo "❌ La requête complète a échoué.<br>";
    } else {
        echo "✅ La requête complète a réussi.<br>";
        echo "<h3>Données obtenues :</h3>";
        echo "<pre>";
        print_r($fullReservation);
        echo "</pre>";
    }
    
} catch (PDOException $e) {
    echo "<h2>Erreur PDO</h2>";
    echo "<pre>";
    echo "Message : " . $e->getMessage() . "\n";
    echo "Code : " . $e->getCode() . "\n";
    echo "Trace : " . $e->getTraceAsString();
    echo "</pre>";
} 