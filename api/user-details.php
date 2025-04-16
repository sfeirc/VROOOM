<?php
require_once '../config/database.php';
session_start();

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        throw new Exception('Utilisateur non connecté');
    }

    $userId = $_SESSION['user']['id'];

    // Récupérer les informations de l'utilisateur
    $stmt = $pdo->prepare("
        SELECT IdUser, Nom, Prenom, Email, 
               Tel as Telephone, Adresse, PhotoProfil, IsAdmin
        FROM Users
        WHERE IdUser = :userId
    ");
    
    $stmt->execute([':userId' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception('Utilisateur non trouvé');
    }

    echo json_encode([
        'success' => true,
        'user' => $user
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 