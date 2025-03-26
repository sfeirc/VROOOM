<?php
require_once '../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function generateClientId() {
    return 'CLI' . date('Y') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

try {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'login':
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                throw new Exception('Tous les champs sont obligatoires');
            }
            
            if (!validateEmail($email)) {
                throw new Exception('Email invalide');
            }
            
            // vérifier si le client existe
            $stmt = $pdo->prepare("SELECT * FROM Client WHERE MailClient = :email");
            $stmt->execute([':email' => $email]);
            $client = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$client || !password_verify($password, $client['MdpClient'])) {
                throw new Exception('Email ou mot de passe incorrect');
            }
            
            // Créer la session
            $_SESSION['user'] = [
                'id' => $client['IdClient'],
                'email' => $client['MailClient'],
                'nom' => $client['NomClient'],
                'prenom' => $client['PrenomClient'],
                'photo' => $client['PhotoProfil']
            ];
            
            echo json_encode([
                'success' => true,
                'message' => 'Connexion réussie',
                'user' => [
                    'email' => $client['MailClient'],
                    'nom' => $client['NomClient'],
                    'prenom' => $client['PrenomClient'],
                    'photo' => $client['PhotoProfil']
                ]
            ]);
            break;
            
        case 'register':
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $tel = $_POST['tel'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            
            // Valider les champs obligatoires
            if (empty($email) || empty($password) || empty($nom) || empty($prenom)) {
                throw new Exception('Les champs nom, prénom, email et mot de passe sont obligatoires');
            }
            
            if (!validateEmail($email)) {
                throw new Exception('Email invalide');
            }
            
            if ($password !== $confirmPassword) {
                throw new Exception('Les mots de passe ne correspondent pas');
            }
            
            if (strlen($password) < 8) {
                throw new Exception('Le mot de passe doit contenir au moins 8 caractères');
            }
            
            // Définir les valeurs par défaut pour les champs optionnels
            $tel = empty($tel) ? '0000000000' : $tel;
            
            // Vérifier si l'email existe déjà
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Client WHERE MailClient = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Cet email est déjà utilisé');
            }
            
            // Début de la transaction
            $pdo->beginTransaction();
            
            try {
                // Générer l'ID du client
                $clientId = generateClientId();
                
                // Créer le client
                $stmt = $pdo->prepare("
                    INSERT INTO Client (
                        IdClient,
                        NomClient,
                        PrenomClient,
                        MailClient,
                        TelClient,
                        AdresseClient,
                        MdpClient,
                        DateInscription,
                        PhotoProfil
                    ) VALUES (
                        :id,
                        :nom,
                        :prenom,
                        :email,
                        :tel,
                        :adresse,
                        :password,
                        NOW(),
                        :photo
                    )
                ");
                
                $result = $stmt->execute([
                    ':id' => $clientId,
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':email' => $email,
                    ':tel' => $tel,
                    ':adresse' => $adresse,
                    ':password' => hashPassword($password),
                    ':photo' => 'assets/images/default-profile.png'
                ]);
                
                if (!$result) {
                    throw new Exception('Erreur lors de l\'insertion dans la base de données');
                }
                
                $pdo->commit();
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Inscription réussie'
                ]);
            } catch (Exception $e) {
                $pdo->rollBack();
                throw new Exception('Erreur lors de l\'inscription: ' . $e->getMessage());
            }
            break;
            
        case 'check-auth':
            if (!isset($_SESSION['user'])) {
                echo json_encode([
                    'success' => true,
                    'isAuthenticated' => false
                ]);
                break;
            }

            // Récupérer les données complètes de l'utilisateur dans la base de données
            $stmt = $pdo->prepare("SELECT * FROM Client WHERE IdClient = :id");
            $stmt->execute([':id' => $_SESSION['user']['id']]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$userData) {
                echo json_encode([
                    'success' => true,
                    'isAuthenticated' => false
                ]);
                break;
            }

            echo json_encode([
                'success' => true,
                'isAuthenticated' => true,
                'user' => [
                    'id' => $userData['IdClient'],
                    'email' => $userData['MailClient'],
                    'nom' => $userData['NomClient'],
                    'prenom' => $userData['PrenomClient'],
                    'tel' => $userData['TelClient'],
                    'adresse' => $userData['AdresseClient'],
                    'photo' => $userData['PhotoProfil'],
                    'dateInscription' => $userData['DateInscription']
                ]
            ]);
            break;
            
        case 'logout':
            session_destroy();
            echo json_encode([
                'success' => true,
                'message' => 'Déconnexion réussie'
            ]);
            break;
            
        case 'update_profile':
            if (!isset($_SESSION['user'])) {
                throw new Exception('Vous devez être connecté pour modifier votre profil');
            }

            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $tel = $_POST['tel'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($nom) || empty($prenom) || empty($email)) {
                throw new Exception('Les champs nom, prénom et email sont obligatoires');
            }

            if (!validateEmail($email)) {
                throw new Exception('Email invalide');
            }

            // Vérifier si l'email est déjà utilisé par un autre utilisateur
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Client WHERE MailClient = :email AND IdClient != :id");
            $stmt->execute([
                ':email' => $email,
                ':id' => $_SESSION['user']['id']
            ]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Cet email est déjà utilisé');
            }

            // Début de la transaction
            $pdo->beginTransaction();

            try {
                // mettre à jour les informations de base
                $stmt = $pdo->prepare("
                    UPDATE Client 
                    SET NomClient = :nom,
                        PrenomClient = :prenom,
                        MailClient = :email,
                        TelClient = :tel,
                        AdresseClient = :adresse
                    WHERE IdClient = :id
                ");

                $stmt->execute([
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':email' => $email,
                    ':tel' => $tel,
                    ':adresse' => $adresse,
                    ':id' => $_SESSION['user']['id']
                ]);

                // mettre à jour le mot de passe si fourni
                if (!empty($currentPassword) && !empty($newPassword)) {
                    if ($newPassword !== $confirmPassword) {
                        throw new Exception('Les nouveaux mots de passe ne correspondent pas');
                    }

                    // Vérifier le mot de passe actuel
                    $stmt = $pdo->prepare("SELECT MdpClient FROM Client WHERE IdClient = :id");
                    $stmt->execute([':id' => $_SESSION['user']['id']]);
                    $client = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!password_verify($currentPassword, $client['MdpClient'])) {
                        throw new Exception('Mot de passe actuel incorrect');
                    }

                    // mettre à jour le mot de passe
                    $stmt = $pdo->prepare("UPDATE Client SET MdpClient = :password WHERE IdClient = :id");
                    $stmt->execute([
                        ':password' => hashPassword($newPassword),
                        ':id' => $_SESSION['user']['id']
                    ]);
                }

                $pdo->commit();

                // mettre à jour les données de la session
                $_SESSION['user']['nom'] = $nom;
                $_SESSION['user']['prenom'] = $prenom;
                $_SESSION['user']['email'] = $email;

                echo json_encode([
                    'success' => true,
                    'message' => 'Profil mis à jour avec succès'
                ]);
            } catch (Exception $e) {
                $pdo->rollBack();
                throw new Exception('Erreur lors de la mise à jour du profil: ' . $e->getMessage());
            }
            break;
            
        default:
            throw new Exception('Action non valide');
    }
} catch(Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 