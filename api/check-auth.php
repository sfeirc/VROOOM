<?php
// Gestion des sessions
session_start();
// Gestion des en-têtes
header('Content-Type: application/json');
// Retourner une réponse de succès
echo json_encode([
    'isLoggedIn' => isset($_SESSION['user_id']),
    'user' => isset($_SESSION['user_id']) ? [
        'id' => $_SESSION['user_id'],
        'email' => $_SESSION['user_email'] ?? null,
        'name' => $_SESSION['user_name'] ?? null
    ] : null
]); 