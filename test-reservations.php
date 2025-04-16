<?php
require_once 'config/database.php';

try {
    echo "<h1>Test de l'accès aux réservations</h1>";
    
    // 1. Vérifier le nombre de réservations dans la base de données
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM Reservation");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    echo "<p>Nombre total de réservations dans la base de données: <strong>{$count}</strong></p>";
    
    if ($count == 0) {
        echo "<p style='color: red;'>Aucune réservation trouvée. Vérifiez votre base de données.</p>";
    } else {
        // 2. Afficher quelques réservations pour aider au débogage
        $stmt = $pdo->query("SELECT IdReservation, IdUser, IdVoiture, DateDebut, DateFin, Statut FROM Reservation LIMIT 10");
        echo "<h2>10 premières réservations:</h2>";
        echo "<table border='1' cellpadding='5'>
                <tr>
                    <th>ID Réservation</th>
                    <th>ID Utilisateur</th>
                    <th>ID Voiture</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>";
        
        while ($reservation = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$reservation['IdReservation']}</td>
                    <td>{$reservation['IdUser']}</td>
                    <td>{$reservation['IdVoiture']}</td>
                    <td>{$reservation['DateDebut']}</td>
                    <td>{$reservation['DateFin']}</td>
                    <td>{$reservation['Statut']}</td>
                    <td>
                        <a href='debug-reservation.php?id={$reservation['IdReservation']}' target='_blank'>Déboguer</a> | 
                        <a href='reservation-details.php?id={$reservation['IdReservation']}' target='_blank'>Voir détails</a>
                    </td>
                </tr>";
        }
        echo "</table>";
        
        // 3. Tester les jointures de base
        echo "<h2>Test des jointures de tables</h2>";
        
        // Test jointure Users
        $testUsers = $pdo->query("SELECT r.IdReservation, u.Nom, u.Prenom 
                                FROM Reservation r 
                                JOIN Users u ON r.IdUser = u.IdUser 
                                LIMIT 3");
        $usersJoinOk = $testUsers && $testUsers->rowCount() > 0;
        echo "<p>Jointure Reservation → Users: " . ($usersJoinOk ? "✅ OK" : "❌ Erreur") . "</p>";
        
        // Test jointure Voiture
        $testVoitures = $pdo->query("SELECT r.IdReservation, v.Modele 
                                   FROM Reservation r 
                                   JOIN Voiture v ON r.IdVoiture = v.IdVoiture 
                                   LIMIT 3");
        $voituresJoinOk = $testVoitures && $testVoitures->rowCount() > 0;
        echo "<p>Jointure Reservation → Voiture: " . ($voituresJoinOk ? "✅ OK" : "❌ Erreur") . "</p>";
        
        // Test jointure MarqueVoiture
        $testMarques = $pdo->query("SELECT r.IdReservation, v.Modele, m.NomMarque
                                  FROM Reservation r 
                                  JOIN Voiture v ON r.IdVoiture = v.IdVoiture
                                  JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
                                  LIMIT 3");
        $marquesJoinOk = $testMarques && $testMarques->rowCount() > 0;
        echo "<p>Jointure Reservation → Voiture → MarqueVoiture: " . ($marquesJoinOk ? "✅ OK" : "❌ Erreur") . "</p>";
        
        // Test jointure TypeVoiture
        $testTypes = $pdo->query("SELECT r.IdReservation, v.Modele, t.NomType
                                FROM Reservation r 
                                JOIN Voiture v ON r.IdVoiture = v.IdVoiture
                                JOIN TypeVoiture t ON v.IdType = t.IdType
                                LIMIT 3");
        $typesJoinOk = $testTypes && $testTypes->rowCount() > 0;
        echo "<p>Jointure Reservation → Voiture → TypeVoiture: " . ($typesJoinOk ? "✅ OK" : "❌ Erreur") . "</p>";
        
        // 4. Tester la requête complète
        echo "<h2>Test de la requête complète</h2>";
        
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
            LIMIT 1
        ";
        
        try {
            $stmt = $pdo->query($sql);
            $completeFetch = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($completeFetch) {
                echo "<p style='color: green;'>✅ La requête complète fonctionne correctement!</p>";
            } else {
                echo "<p style='color: red;'>❌ La requête complète ne renvoie aucun résultat.</p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color: red;'>❌ Erreur dans la requête complète: " . $e->getMessage() . "</p>";
        }
    }
    
} catch (PDOException $e) {
    echo "<h1 style='color: red;'>Erreur de connexion à la base de données</h1>";
    echo "<p>Message: " . $e->getMessage() . "</p>";
} 