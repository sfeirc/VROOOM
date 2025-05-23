<?php
require_once '../config/database.php';
// Gestion des en-têtes
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
// Gestion des sessions
session_start();
// Fonction pour valider l'email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
// Fonction pour hacher le mot de passe
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}
// Fonction pour générer un ID d'utilisateur
function generateUserId() {
    return 'USR' . date('Y') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}
// Gestion des actions
try {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        // Gestion de la connexion
        case 'login':
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                throw new Exception('Tous les champs sont obligatoires');
            }
            // Vérifier si l'email est valide
            if (!validateEmail($email)) {
                throw new Exception('Email invalide');
            }
            // Vérifier si l'utilisateur existe
            $stmt = $pdo->prepare("SELECT * FROM Users WHERE Email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Vérifier si l'utilisateur existe et si le mot de passe est correct
            if (!$user || !password_verify($password, $user['MotDePasse'])) {
                throw new Exception('Email ou mot de passe incorrect');
            }

            // Créer la session
            $_SESSION['user'] = [
                'id' => $user['IdUser'],
                'email' => $user['Email'],
                'nom' => $user['Nom'],
                'prenom' => $user['Prenom'],
                'photo' => $user['PhotoProfil'],
                'role' => $user['Role']
            ];
            // Retourner une réponse de succès
            echo json_encode([
                'success' => true,
                'message' => $user['Role'] === 'CLIENT' ? 'Connexion réussie' : 'Connexion administrateur réussie',
                'user' => [
                    'email' => $user['Email'],
                    'nom' => $user['Nom'],
                    'prenom' => $user['Prenom'],
                    'photo' => $user['PhotoProfil'],
                    'role' => $user['Role']
                ]
            ]);
            break;
        // Gestion de l'inscription
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
            // Vérifier si l'email est valide
            if (!validateEmail($email)) {
                throw new Exception('Email invalide');
            }
            // Vérifier si les mots de passe correspondent
            if ($password !== $confirmPassword) {
                throw new Exception('Les mots de passe ne correspondent pas');
            }
            // Vérifier si le mot de passe est suffisamment long
            if (strlen($password) < 8) {
                throw new Exception('Le mot de passe doit contenir au moins 8 caractères');
            }

            // Définir les valeurs par défaut pour les champs optionnels
            $tel = empty($tel) ? NULL : $tel;
            
            // Vérifier si l'email existe déjà
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE Email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Cet email est déjà utilisé');
            }
            // Début de la transaction
            $pdo->beginTransaction();
            // Générer l'ID de l'utilisateur
            try {
                // Générer l'ID de l'utilisateur
                $userId = generateUserId();

                // Créer l'utilisateur
                $stmt = $pdo->prepare("
                    INSERT INTO Users (
                        IdUser,
                        Nom,
                        Prenom,
                        Email,
                        Tel,
                        Adresse,
                        MotDePasse,
                        DateInscription,
                        PhotoProfil,
                        Role
                    ) VALUES (
                        :id,
                        :nom,
                        :prenom,
                        :email,
                        :tel,
                        :adresse,
                        :password,
                        NOW(),
                        :photo,
                        'CLIENT'
                    )
                ");
                // Exécuter la requête
                $result = $stmt->execute([
                    ':id' => $userId,
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':email' => $email,
                    ':tel' => $tel,
                    ':adresse' => $adresse,
                    ':password' => hashPassword($password),
                    ':photo' => 'assets/images/default-profile.png'
                ]);
                // Vérifier si la requête a échoué
                if (!$result) {
                    throw new Exception('Erreur lors de l\'insertion dans la base de données');
                }
                // Valider la transaction
                $pdo->commit();
                // Retourner une réponse de succès
                echo json_encode([
                    'success' => true,
                    'message' => 'Inscription réussie'
                ]);
            } catch (Exception $e) {
                $pdo->rollBack();
                throw new Exception('Erreur lors de l\'inscription: ' . $e->getMessage());
            }
            break;
        //   Gestion de la vérification de l'authentification
        case 'check-auth':
            if (!isset($_SESSION['user'])) {
                echo json_encode([
                    'success' => true,
                    'isAuthenticated' => false
                ]);
                break;
            }

            // Récupérer les données complètes de l'utilisateur dans la base de données
            $stmt = $pdo->prepare("SELECT * FROM Users WHERE IdUser = :id");
            $stmt->execute([':id' => $_SESSION['user']['id']]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            // Vérifier si l'utilisateur existe
            if (!$userData) {
                echo json_encode([
                    'success' => true,
                    'isAuthenticated' => false
                ]);
                break;
            }
            // Vérifier si l'utilisateur est un administrateur
            $isAdmin = $userData['Role'] !== 'CLIENT';
            // Compter le nombre de réservations pour cet utilisateur   
            $reservationCount = 0;
            try {
                // Préparer la requête
                $reservationStmt = $pdo->prepare("SELECT COUNT(*) FROM Reservation WHERE IdUser = :userId");
                // Exécuter la requête
                $reservationStmt->execute([':userId' => $_SESSION['user']['id']]);
                // Récupérer le nombre de réservations
                $reservationCount = (int)$reservationStmt->fetchColumn();
            } catch (PDOException $e) {
                // Gérer l'erreur
                error_log("Erreur lors du comptage des réservations: " . $e->getMessage());
                // Ne pas faire échouer toute la requête pour cette erreur
            }
            // Retourner une réponse de succès
            echo json_encode([
                'success' => true,
                'isAuthenticated' => true,
                'isAdmin' => $isAdmin,
                'user' => [
                    'id' => $userData['IdUser'],
                    'email' => $userData['Email'],
                    'nom' => $userData['Nom'],
                    'prenom' => $userData['Prenom'],
                    'tel' => $userData['Tel'],
                    'adresse' => $userData['Adresse'],
                    'photo' => $userData['PhotoProfil'],
                    'dateInscription' => $userData['DateInscription'],
                    'role' => $userData['Role'],
                    'reservations' => $reservationCount
                ]
            ]);
            break;
        // Gestion de la déconnexion
        case 'logout':
            session_destroy();
            echo json_encode([
                'success' => true,
                'message' => 'Déconnexion réussie'
            ]);
            break;
        // Gestion de la mise à jour du profil
        case 'update_profile':
            if (!isset($_SESSION['user'])) {
                throw new Exception('Vous devez être connecté pour modifier votre profil');
            }
            // Récupérer les données du profil
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $tel = $_POST['tel'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            // Vérifier si les champs obligatoires sont remplis
            if (empty($nom) || empty($prenom) || empty($email)) {
                throw new Exception('Les champs nom, prénom et email sont obligatoires');
            }
            // Vérifier si l'email est valide
            if (!validateEmail($email)) {
                throw new Exception('Email invalide');
            }

            // Vérifier si l'email est déjà utilisé par un autre utilisateur
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE Email = :email AND IdUser != :id");
            $stmt->execute([
                ':email' => $email,
                ':id' => $_SESSION['user']['id']
            ]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Cet email est déjà utilisé');
            }

            // Début de la transaction
            $pdo->beginTransaction();
            // Essayer de mettre à jour les informations de base
            try {
                // mettre à jour les informations de base
                $stmt = $pdo->prepare("
                    UPDATE Users 
                    SET Nom = :nom,
                        Prenom = :prenom,
                        Email = :email,
                        Tel = :tel,
                        Adresse = :adresse
                    WHERE IdUser = :id
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
                    $stmt = $pdo->prepare("SELECT MotDePasse FROM Users WHERE IdUser = :id");
                    $stmt->execute([':id' => $_SESSION['user']['id']]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!password_verify($currentPassword, $user['MotDePasse'])) {
                        throw new Exception('Mot de passe actuel incorrect');
                    }

                    // mettre à jour le mot de passe
                    $stmt = $pdo->prepare("UPDATE Users SET MotDePasse = :password WHERE IdUser = :id");
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