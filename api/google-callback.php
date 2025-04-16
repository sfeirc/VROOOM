<?php
require_once '../config/database.php';
require_once '../config/env.php';

session_start();

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
            // User doesn't exist, create a new user
            // Générer un identifiant utilisateur unique
            $userId = 'USR' . date('Y') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            
            // Créer un mot de passe aléatoire
            $randomPassword = bin2hex(random_bytes(16));
            $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
            
            try {
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
                
                $stmt->execute([
                    ':id' => $userId,
                    ':nom' => $userInfo['family_name'] ?? 'Inconnu',
                    ':prenom' => $userInfo['given_name'] ?? 'Inconnu',
                    ':email' => $userInfo['email'],
                    ':mdp' => $hashedPassword,
                    ':photo' => $userInfo['picture'] ?? 'assets/images/default-profile.png'
                ]);
                
                // Set up session
                $_SESSION['user'] = [
                    'id' => $userId,
                    'nom' => $userInfo['family_name'] ?? 'Inconnu',
                    'prenom' => $userInfo['given_name'] ?? 'Inconnu',
                    'email' => $userInfo['email'],
                    'photo' => $userInfo['picture'] ?? 'assets/images/default-profile.png',
                    'role' => 'client'
                ];
                
                // Redirect to homepage
                header('Location: ../index.html');
                exit;
            } catch (Exception $e) {
                error_log("Error creating new user: " . $e->getMessage());
                $error = "Une erreur est survenue lors de la création de votre compte.";
                header("Location: ../login.html?error=" . urlencode($error));
                exit;
            }
        }
    } catch (Exception $e) {
        error_log("Erreur d'authentification Google: " . $e->getMessage());
        header('Location: ../login_register.html?error=' . urlencode($e->getMessage()));
        exit;
    }
}

// Fonction pour obtenir le jeton d'accès
function getAccessToken($code) {
    global $clientID, $clientSecret, $redirectUri;
    
    $url = 'https://oauth2.googleapis.com/token';
    $data = [
        'code' => $code,
        'client_id' => $clientID,
        'client_secret' => $clientSecret,
        'redirect_uri' => $redirectUri,
        'grant_type' => 'authorization_code'
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Uniquement pour le développement
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
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
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Uniquement pour le développement
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
} 