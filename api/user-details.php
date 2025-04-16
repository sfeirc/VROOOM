<?php
// Gestion des erreurs
require_once '../config/database.php';
// Gestion des sessions
session_start();
// Gestion des en-têtes
header('Content-Type: application/json');
// Gestion des erreurs
try {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        throw new Exception('Utilisateur non connecté');
    }
    // Récupérer l'ID de l'utilisateur
    $userId = $_SESSION['user']['id'];
    // Préparer la requête
    // Récupérer les informations de l'utilisateur
    $stmt = $pdo->prepare("
        SELECT IdUser, Nom, Prenom, Email, 
               Tel as Telephone, Adresse, PhotoProfil, IsAdmin
        FROM Users
        WHERE IdUser = :userId
    ");
    // Exécuter la requête
    $stmt->execute([':userId' => $userId]);
    // Récupérer les informations de l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // Vérifier si l'utilisateur existe
    if (!$user) {
        throw new Exception('Utilisateur non trouvé');
    }
    // Retourner une réponse de succès
    echo json_encode([
        'success' => true,
        'user' => $user
    ]);
// Gestion des erreurs
} catch (Exception $e) {
    // Log l'erreur
    error_log("Erreur API user-details: " . $e->getMessage());
    // Retourner un code 400 et le message d'erreur
    http_response_code(400);
    // Retourner une réponse d'erreur
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 