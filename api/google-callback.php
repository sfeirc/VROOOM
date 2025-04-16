<?php
// Gestion des erreurs
require_once '../config/database.php';
require_once '../config/env.php';
// Gestion des sessions
session_start();
// Gestion des erreurs
// Charger les variables d'environnement
loadEnv();

// Configuration OAuth Google
$clientID = getenv('GOOGLE_CLIENT_ID');
$clientSecret = getenv('GOOGLE_CLIENT_SECRET');
$redirectUri = getenv('GOOGLE_REDIRECT_URI');

// Journalisation de débogage (à supprimer en production)
error_log("Client ID: " . substr($clientID, 0, 10) . "...");
error_log("Redirect URI: " . $redirectUri);

// Vérifier la configuration
if (!$clientID || !$clientSecret || !$redirectUri) {
    error_log("Configuration OAuth manquante");
    die('La configuration OAuth Google est manquante. Veuillez vérifier votre fichier .env.');
}

// Gérer le flux OAuth
if (isset($_GET['code'])) {
    try {
        // Échanger le code contre un jeton d'accès
        $token = getAccessToken($_GET['code']);
        
        if (!$token || isset($token['error'])) {
            error_log("Erreur de jeton: " . json_encode($token));
            throw new Exception($token['error_description'] ?? 'Impossible d\'obtenir le jeton d\'accès');
        }
        
        // Obtenir les informations de l'utilisateur avec le jeton d'accès
        $userInfo = getUserInfo($token);
        
        if (!$userInfo || isset($userInfo['error'])) {
            error_log("Erreur d'informations utilisateur: " . json_encode($userInfo));
            throw new Exception('Impossible d\'obtenir les informations de l\'utilisateur');
        }
        
        // Vérifier si l'utilisateur existe dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE Email = :email");
        $stmt->execute([':email' => $userInfo['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // User exists, set up session
            $_SESSION['user'] = [
                'id' => $user['IdUser'],
                'nom' => $user['Nom'],
                'prenom' => $user['Prenom'],
                'email' => $user['Email'],
                'photo' => $user['PhotoProfil'],
                'role' => $user['IsAdmin'] ? 'admin' : 'client'
            ];
            
            // Redirect to homepage
            header('Location: ../index.html');
            exit;
        } else {
            // L'utilisateur n'existe pas, créer un nouvel utilisateur  
            // Générer un identifiant utilisateur unique
            $userId = 'USR' . date('Y') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            
            // Créer un mot de passe aléatoire
            $randomPassword = bin2hex(random_bytes(16));
            // Hacher le mot de passe
            $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
            
            try {
                // Préparer la requête
                $stmt = $pdo->prepare("INSERT INTO Users (
                    IdUser, 
                    Nom, 
                    Prenom, 
                    Email, 
                    Tel, 
                    Adresse, 
                    MotDePasse, 
                    DateInscription, 
                    PhotoProfil,
                    IsAdmin
                ) VALUES (
                    :id,
                    :nom,
                    :prenom,
                    :email,
                    NULL, 
                    NULL,
                    :mdp,
                    NOW(),
                    :photo,
                    0
                )");
                // Exécuter la requête
                $stmt->execute([
                    ':id' => $userId,
                    ':nom' => $userInfo['family_name'] ?? 'Inconnu',
                    ':prenom' => $userInfo['given_name'] ?? 'Inconnu',
                    ':email' => $userInfo['email'],
                    ':mdp' => $hashedPassword,
                    ':photo' => $userInfo['picture'] ?? 'assets/images/default-profile.png'
                ]);
                // Récupérer les informations de l'utilisateur
                $_SESSION['user'] = [
                    'id' => $userId,
                    'nom' => $userInfo['family_name'] ?? 'Inconnu',
                    'prenom' => $userInfo['given_name'] ?? 'Inconnu',
                    'email' => $userInfo['email'],
                    'photo' => $userInfo['picture'] ?? 'assets/images/default-profile.png',
                    'role' => 'client'
                ];
                // Rediriger vers la page d'accueil
                header('Location: ../index.html');
                exit;
            } catch (Exception $e) {
                // Gérer les erreurs
                error_log("Erreur lors de la création de l'utilisateur: " . $e->getMessage());
                $error = "Une erreur est survenue lors de la création de votre compte.";
                // Rediriger vers la page de connexion avec l'erreur
                header("Location: ../login.html?error=" . urlencode($error));
                exit;
            }
        }
    } catch (Exception $e) {
        // Gérer les erreurs
        error_log("Erreur d'authentification Google: " . $e->getMessage());
        // Rediriger vers la page de connexion avec l'erreur
        header('Location: ../login_register.html?error=' . urlencode($e->getMessage()));
        exit;
    }
}

// Fonction pour obtenir le jeton d'accès
function getAccessToken($code) {
    global $clientID, $clientSecret, $redirectUri;
    // Préparer la requête
    $url = 'https://oauth2.googleapis.com/token';
    $data = [
        'code' => $code,
        'client_id' => $clientID,
        'client_secret' => $clientSecret,
        'redirect_uri' => $redirectUri,
        'grant_type' => 'authorization_code'
    ];
    // Initialiser cURL
    $ch = curl_init($url);
    // Configurer cURL pour envoyer une requête POST
    curl_setopt($ch, CURLOPT_POST, 1);
    // Configurer cURL pour envoyer les données POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    // Configurer cURL pour retourner la réponse
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Configurer cURL pour ne pas vérifier le certificat SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    // Exécuter la requête
    $response = curl_exec($ch);
    // Récupérer l'erreur
    $error = curl_error($ch);
    // Fermer cURL
    curl_close($ch);
    // Vérifier si une erreur est survenue
    if ($error) {
        error_log("Erreur CURL: " . $error);
        return ['error' => 'curl_error', 'error_description' => $error];
    }
    
    return json_decode($response, true);
}

// Fonction pour obtenir les informations de l'utilisateur
function getUserInfo($token) {
    $url = 'https://www.googleapis.com/oauth2/v2/userinfo';
    $headers = ['Authorization: Bearer ' . $token['access_token']];
    // Initialiser cURL
    $ch = curl_init($url);
    // Configurer cURL pour envoyer les en-têtes HTTP
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // Configurer cURL pour retourner la réponse
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Configurer cURL pour ne pas vérifier le certificat SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    // Exécuter la requête
    $response = curl_exec($ch);
    // Fermer cURL
    curl_close($ch);
    // Retourner les informations de l'utilisateur
    return json_decode($response, true);
} 