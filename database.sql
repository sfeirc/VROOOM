CREATE DATABASE IF NOT EXISTS `vroom_prestige` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `vroom_prestige`;

-- Supprimer les tables inutiles
DROP TABLE IF EXISTS `Administre`;
DROP TABLE IF EXISTS `Gere`;
DROP TABLE IF EXISTS `Reservation`;
DROP TABLE IF EXISTS `Voiture`;
DROP TABLE IF EXISTS `Administrateur`;
DROP TABLE IF EXISTS `Client`;
DROP TABLE IF EXISTS `MarqueVoiture`;
DROP TABLE IF EXISTS `Statut`;
DROP TABLE IF EXISTS `TypeVehicule`;

CREATE TABLE `Administrateur` (
  `IdAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `PrenomAdmin` varchar(50) NOT NULL,
  `MailAdmin` varchar(50) NOT NULL,
  `MdpAdmin` varchar(255) NOT NULL,
  `NomAdmin` varchar(50) NOT NULL,
  PRIMARY KEY (`IdAdmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Client` (
  `IdClient` varchar(50) NOT NULL,
  `NomClient` varchar(50) NOT NULL,
  `PrenomClient` varchar(50) NOT NULL,
  `MailClient` varchar(50) NOT NULL UNIQUE,
  `TelClient` varchar(20) NOT NULL,
  `AdresseClient` varchar(255) DEFAULT NULL,
  `MdpClient` varchar(255) NOT NULL,
  `DateInscription` datetime DEFAULT CURRENT_TIMESTAMP,
  `PhotoProfil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdClient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `MarqueVoiture` (
  `IdMarque` int(11) NOT NULL AUTO_INCREMENT,
  `NomMarque` varchar(50) NOT NULL,
  `LogoMarque` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`IdMarque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Statut` (
  `IdStatut` varchar(50) NOT NULL,
  `TypeStatut` varchar(50) NOT NULL,
  PRIMARY KEY (`IdStatut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `TypeVehicule` (
  `IdType` int(11) NOT NULL AUTO_INCREMENT,
  `NomType` varchar(50) NOT NULL,
  PRIMARY KEY (`IdType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Voiture` (
  `IdVoiture` int(11) NOT NULL AUTO_INCREMENT,
  `Modele` varchar(100) NOT NULL,
  `NbPorte` tinyint(4) DEFAULT NULL,
  `BoiteVitesse` varchar(50) NOT NULL,
  `Annee` int(4) NOT NULL,
  `Couleur` varchar(50) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `PhotosSupplementaires` JSON DEFAULT NULL,
  `Energie` varchar(50) DEFAULT NULL,
  `Puissance` int(11) DEFAULT NULL,
  `PrixLocation` decimal(15,2) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `NbPlaces` int(11) DEFAULT NULL,
  `IdStatut` varchar(50) NOT NULL,
  `IdMarque` int(11) NOT NULL,
  `IdType` int(11) NOT NULL,
  PRIMARY KEY (`IdVoiture`),
  FOREIGN KEY (`IdStatut`) REFERENCES `Statut` (`IdStatut`),
  FOREIGN KEY (`IdMarque`) REFERENCES `MarqueVoiture` (`IdMarque`),
  FOREIGN KEY (`IdType`) REFERENCES `TypeVehicule` (`IdType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Reservation` (
  `IdReservation` varchar(50) NOT NULL,
  `DateDebut` datetime NOT NULL,
  `DateFin` datetime NOT NULL,
  `MontantReservation` decimal(15,2) NOT NULL,
  `Statut` ENUM('En attente', 'Confirmée', 'En cours', 'Terminée', 'Annulée') DEFAULT 'En attente',
  `DateReservation` datetime DEFAULT CURRENT_TIMESTAMP,
  `IdClient` varchar(50) NOT NULL,
  `IdVoiture` int(11) NOT NULL,
  PRIMARY KEY (`IdReservation`),
  FOREIGN KEY (`IdClient`) REFERENCES `Client` (`IdClient`),
  FOREIGN KEY (`IdVoiture`) REFERENCES `Voiture` (`IdVoiture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ajouter les types de voitures
INSERT INTO `TypeVehicule` (`NomType`) VALUES 
('SUV'), ('Berline'), ('Coupé'), ('Cabriolet'), ('Break'), 
('Citadine'), ('Supercar'), ('4x4'), ('Crossover'), ('Luxe');

INSERT INTO `Statut` VALUES
('STAT001', 'Disponible'),
('STAT002', 'Louée'),
('STAT003', 'En maintenance');

INSERT INTO `MarqueVoiture` (`NomMarque`, `LogoMarque`, `Description`) VALUES
('Tesla', 'logos/tesla.png', 'Constructeur américain de véhicules électriques haut de gamme'),
('BMW', 'logos/bmw.png', 'Constructeur allemand réputé pour ses véhicules sportifs et luxueux'),
('Audi', 'logos/audi.png', 'Marque premium allemande connue pour sa technologie de pointe'),
('Mercedes', 'logos/mercedes.png', 'Constructeur allemand synonyme de luxe et d''innovation'),
('Porsche', 'logos/porsche.png', 'Constructeur de voitures de sport de prestige'),
('Ferrari', 'logos/ferrari.png', 'Constructeur italien légendaire de supercars'),
('Lamborghini', 'logos/lamborghini.png', 'Constructeur italien de voitures de sport extrêmes'),
('Toyota', 'logos/toyota.png', 'Plus grand constructeur automobile mondial'),
('Ford', 'logos/ford.png', 'Constructeur américain historique'),
('Chevrolet', 'logos/chevrolet.png', 'Marque américaine emblématique');

-- ajouter les index pour les nouvelles critères de recherche
ALTER TABLE `Voiture`
ADD INDEX `idx_puissance` (`Puissance`),
ADD INDEX `idx_nb_places` (`NbPlaces`),
ADD INDEX `idx_prix` (`PrixLocation`),
ADD INDEX `idx_annee` (`Annee`);

ALTER TABLE `Reservation`
ADD INDEX `idx_dates` (`DateDebut`, `DateFin`);

ALTER TABLE `Client`
ADD INDEX `idx_email` (`MailClient`);

-- créer la vue pour les voitures disponibles
CREATE VIEW `VoituresDisponibles` AS
SELECT v.*, m.NomMarque, t.NomType
FROM Voiture v
JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
JOIN TypeVehicule t ON v.IdType = t.IdType
WHERE v.IdStatut = 'STAT001';

-- créer la vue pour l'historique des locations
CREATE VIEW `HistoriqueLocations` AS
SELECT 
    r.IdReservation,
    r.DateDebut,
    r.DateFin,
    r.MontantReservation,
    r.Statut,
    c.NomClient,
    c.PrenomClient,
    v.Modele,
    m.NomMarque
FROM Reservation r
JOIN Client c ON r.IdClient = c.IdClient
JOIN Voiture v ON r.IdVoiture = v.IdVoiture
JOIN MarqueVoiture m ON v.IdMarque = m.IdMarque
ORDER BY r.DateReservation DESC;

-- ajouter la table Utilisateur
CREATE TABLE IF NOT EXISTS Utilisateur (
    IdUtilisateur INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    MotDePasse VARCHAR(255) NOT NULL,
    Nom VARCHAR(100) NOT NULL,
    Prenom VARCHAR(100) NOT NULL,
    Role ENUM('ADMIN', 'CLIENT') NOT NULL DEFAULT 'CLIENT',
    DateInscription DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    DernierConnexion DATETIME,
    INDEX idx_email (Email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
