<?php
// This script helps with debugging and fixing reservation detail page issues
$id = $_REQUEST['id'] ?? '';

if (empty($id)) {
    echo "<h1>Fixer la page de détails</h1>";
    echo "<p>Veuillez fournir l'ID de la réservation dans l'URL, par exemple: <code>fix-details-page.php?id=RES12345678</code></p>";
    exit;
}

echo "<!DOCTYPE html>
<html>
<head>
    <title>Redirection vers les détails</title>
    <meta http-equiv='refresh' content='5;url=reservation-details.php?id=$id'>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
        .progress { height: 5px; background-color: #f3f3f3; border-radius: 2px; margin: 20px 0; }
        .progress-bar { height: 100%; width: 0; background-color: #4CAF50; border-radius: 2px; transition: width 5s linear; }
    </style>
</head>
<body>
    <h1>Redirection vers la page de détails...</h1>
    <p>Réservation ID: <strong>$id</strong></p>
    <p>Vous allez être redirigé vers la page de détails dans 5 secondes.</p>
    
    <div class='progress'>
        <div class='progress-bar' id='progress'></div>
    </div>
    
    <p>Si vous n'êtes pas redirigé automatiquement, <a href='reservation-details.php?id=$id'>cliquez ici</a>.</p>
    
    <div style='margin-top: 30px; padding: 15px; background: #f9f9f9; border-left: 4px solid #4CAF50;'>
        <h3>Informations de débogage:</h3>
        <p>Si vous rencontrez toujours des problèmes, essayez les liens suivants:</p>
        <ul>
            <li><a href='api/reservation-details-simple.php?id=$id' target='_blank'>Tester l'API simplifiée</a></li>
            <li><a href='debug-reservation.php?id=$id' target='_blank'>Débogage détaillé</a></li>
            <li><a href='test-reservations.php' target='_blank'>Voir toutes les réservations</a></li>
        </ul>
    </div>
    
    <script>
        // Animation de la barre de progression
        window.onload = function() {
            document.getElementById('progress').style.width = '100%';
        };
    </script>
</body>
</html>";
?> 