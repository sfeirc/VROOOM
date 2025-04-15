<?php
require_once '../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

// Vérifier si l'utilisateur est connecté et est un administrateur
function checkAdminAuth() {
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
        echo json_encode([
            'success' => false,
            'message' => 'Accès non autorisé. Vous devez être connecté en tant qu\'administrateur.'
        ]);
        exit;
    }
}

try {
    $action = $_POST['action'] ?? '';
    
    // Vérifier l'authentification pour toutes les actions
    checkAdminAuth();
    
    switch ($action) {
        case 'get_reservations':
            // Récupérer les filtres
            $status = $_POST['status'] ?? null;
            $dateStart = $_POST['date_start'] ?? null;
            $dateEnd = $_POST['date_end'] ?? null;
            
            // Construire la requête SQL
            $sql = "
                SELECT 
                    r.*, 
                    c.NomClient, 
                    c.PrenomClient, 
                    c.MailClient,
                    v.Modele,
                    m.NomMarque
                FROM Reservation r
                JOIN Client c ON r.IdClient = c.IdClient
                JOIN Voiture v ON r.IdVoiture = v.IdVoiture
                JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
                WHERE 1=1
            ";
            
            $params = [];
            
            // Ajouter les conditions de filtrage
            if ($status) {
                $sql .= " AND r.Statut = :status";
                $params[':status'] = $status;
            }
            
            if ($dateStart) {
                $sql .= " AND r.DateDebut >= :date_start";
                $params[':date_start'] = $dateStart . ' 00:00:00';
            }
            
            if ($dateEnd) {
                $sql .= " AND r.DateFin <= :date_end";
                $params[':date_end'] = $dateEnd . ' 23:59:59';
            }
            
            // Ajouter l'ordre de tri
            $sql .= " ORDER BY r.DateReservation DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'reservations' => $reservations
            ]);
            break;
            
        case 'update_reservation_status':
            $reservationId = $_POST['reservation_id'] ?? '';
            $newStatus = $_POST['status'] ?? '';
            
            if (empty($reservationId) || empty($newStatus)) {
                throw new Exception('ID de réservation et nouveau statut requis');
            }
            
            // Vérifier si la réservation existe
            $stmt = $pdo->prepare("SELECT * FROM Reservation WHERE IdReservation = :id");
            $stmt->execute([':id' => $reservationId]);
            if (!$stmt->fetch()) {
                throw new Exception('Réservation non trouvée');
            }
            
            // Valider le statut
            $validStatuses = ['En attente', 'Confirmée', 'En cours', 'Terminée', 'Annulée'];
            if (!in_array($newStatus, $validStatuses)) {
                throw new Exception('Statut non valide');
            }
            
            // Mettre à jour le statut
            $stmt = $pdo->prepare("UPDATE Reservation SET Statut = :status WHERE IdReservation = :id");
            $result = $stmt->execute([
                ':status' => $newStatus,
                ':id' => $reservationId
            ]);
            
            if (!$result) {
                throw new Exception('Erreur lors de la mise à jour du statut');
            }
            
            // Si la réservation est annulée ou terminée, mettre à jour le statut de la voiture à Disponible
            if ($newStatus === 'Annulée' || $newStatus === 'Terminée') {
                $stmt = $pdo->prepare("
                    UPDATE Voiture v
                    JOIN Reservation r ON v.IdVoiture = r.IdVoiture
                    SET v.IdStatut = 'STAT001'
                    WHERE r.IdReservation = :id
                ");
                $stmt->execute([':id' => $reservationId]);
            }
            
            // Si la réservation est confirmée ou en cours, mettre à jour le statut de la voiture à Louée
            if ($newStatus === 'Confirmée' || $newStatus === 'En cours') {
                $stmt = $pdo->prepare("
                    UPDATE Voiture v
                    JOIN Reservation r ON v.IdVoiture = r.IdVoiture
                    SET v.IdStatut = 'STAT002'
                    WHERE r.IdReservation = :id
                ");
                $stmt->execute([':id' => $reservationId]);
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Statut de la réservation mis à jour'
            ]);
            break;
            
        case 'toggle_car_status':
            $carId = $_POST['car_id'] ?? '';
            
            if (empty($carId)) {
                throw new Exception('ID de voiture requis');
            }
            
            // Récupérer le statut actuel de la voiture
            $stmt = $pdo->prepare("SELECT IdStatut FROM Voiture WHERE IdVoiture = :id");
            $stmt->execute([':id' => $carId]);
            $car = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$car) {
                throw new Exception('Voiture non trouvée');
            }
            
            // Déterminer le nouveau statut
            $newStatus = '';
            switch ($car['IdStatut']) {
                case 'STAT001': // Disponible -> En maintenance
                    $newStatus = 'STAT003';
                    break;
                case 'STAT002': // Louée -> Ne peut pas être modifiée
                    throw new Exception('Impossible de modifier le statut d\'une voiture actuellement louée');
                    break;
                case 'STAT003': // En maintenance -> Disponible
                    $newStatus = 'STAT001';
                    break;
                default:
                    $newStatus = 'STAT001';
            }
            
            // Mettre à jour le statut
            $stmt = $pdo->prepare("UPDATE Voiture SET IdStatut = :status WHERE IdVoiture = :id");
            $result = $stmt->execute([
                ':status' => $newStatus,
                ':id' => $carId
            ]);
            
            if (!$result) {
                throw new Exception('Erreur lors de la mise à jour du statut');
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Statut de la voiture mis à jour'
            ]);
            break;
        
        default:
            throw new Exception('Action non reconnue');
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 