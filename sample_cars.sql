-- données des voitures
INSERT INTO `Voiture` 
(`Modele`, `NbPorte`, `BoiteVitesse`, `Annee`, `Couleur`, `Photo`, `Energie`, `Puissance`, `Kilometrage`, `PrixAchat`, `PrixLocation`, `Description`, `NbPlaces`, `Climatisation`, `GPS`, `IdStatut`, `IdMarque`, `IdType`) 
VALUES
-- Tesla
('Model S', 5, 'Automatique', 2023, 'Blanc', 'cars/tesla-model-s.jpg', 'Électrique', 670, 1000, 89990, 299, 'Tesla Model S Performance - Version longue autonomie', 5, true, true, 'STAT001', 1, 2),
('Model 3', 4, 'Automatique', 2023, 'Rouge', 'cars/tesla-model-3.jpg', 'Électrique', 450, 500, 45990, 199, 'Tesla Model 3 Performance', 5, true, true, 'STAT001', 1, 2),
('Model X', 5, 'Automatique', 2023, 'Noir', 'cars/tesla-model-x.jpg', 'Électrique', 550, 2000, 99990, 349, 'Tesla Model X avec Autopilot', 7, true, true, 'STAT001', 1, 1),

-- BMW
('M4 Competition', 2, 'Automatique', 2023, 'Bleu', 'cars/bmw-m4.jpg', 'Essence', 510, 5000, 89900, 299, 'BMW M4 Competition - Pure performance', 4, true, true, 'STAT001', 2, 3),
('X5 M', 5, 'Automatique', 2023, 'Noir', 'cars/bmw-x5m.jpg', 'Essence', 625, 3000, 129900, 399, 'BMW X5 M Competition', 5, true, true, 'STAT001', 2, 1),
('i8', 2, 'Automatique', 2022, 'Blanc', 'cars/bmw-i8.jpg', 'Hybride', 374, 8000, 145900, 449, 'BMW i8 - Supercar hybride', 2, true, true, 'STAT001', 2, 7),

-- Audi
('RS e-tron GT', 4, 'Automatique', 2023, 'Gris', 'cars/audi-etron-gt.jpg', 'Électrique', 646, 1500, 139900, 399, 'Audi RS e-tron GT - Performance électrique', 4, true, true, 'STAT001', 3, 2),
('RS6 Avant', 5, 'Automatique', 2023, 'Bleu', 'cars/audi-rs6.jpg', 'Essence', 600, 4000, 129900, 379, 'Audi RS6 Avant - Break surpuissant', 5, true, true, 'STAT001', 3, 5),
('R8 V10', 2, 'Automatique', 2023, 'Rouge', 'cars/audi-r8.jpg', 'Essence', 620, 2000, 189900, 599, 'Audi R8 V10 Performance', 2, true, true, 'STAT001', 3, 7),

-- Mercedes
('AMG GT 63 S', 4, 'Automatique', 2023, 'Noir', 'cars/mercedes-amg-gt.jpg', 'Essence', 639, 3000, 159900, 499, 'Mercedes-AMG GT 63 S 4MATIC+', 4, true, true, 'STAT001', 4, 2),
('Classe G 63 AMG', 5, 'Automatique', 2023, 'Noir Mat', 'cars/mercedes-g63.jpg', 'Essence', 585, 5000, 179900, 549, 'Mercedes-AMG G 63 - Icône tout-terrain', 5, true, true, 'STAT001', 4, 8),
('AMG GT Black Series', 2, 'Automatique', 2023, 'Orange', 'cars/mercedes-gt-black.jpg', 'Essence', 730, 1000, 335900, 899, 'Mercedes-AMG GT Black Series', 2, true, true, 'STAT001', 4, 7),

-- Porsche
('911 GT3 RS', 2, 'PDK', 2023, 'Vert', 'cars/porsche-gt3rs.jpg', 'Essence', 525, 1500, 229900, 699, 'Porsche 911 GT3 RS - Performance pure', 2, true, true, 'STAT001', 5, 7),
('Taycan Turbo S', 4, 'Automatique', 2023, 'Blanc', 'cars/porsche-taycan.jpg', 'Électrique', 761, 2000, 189900, 599, 'Porsche Taycan Turbo S - Performance électrique', 4, true, true, 'STAT001', 5, 2),
('Cayenne Turbo GT', 5, 'Automatique', 2023, 'Noir', 'cars/porsche-cayenne.jpg', 'Essence', 640, 3000, 199900, 649, 'Porsche Cayenne Turbo GT', 5, true, true, 'STAT001', 5, 1),

-- Ferrari
('SF90 Stradale', 2, 'Automatique', 2023, 'Rouge', 'cars/ferrari-sf90.jpg', 'Hybride', 1000, 1000, 449900, 1299, 'Ferrari SF90 Stradale - Hybride surpuissante', 2, true, true, 'STAT001', 6, 7),
('F8 Tributo', 2, 'Automatique', 2023, 'Jaune', 'cars/ferrari-f8.jpg', 'Essence', 720, 2000, 369900, 999, 'Ferrari F8 Tributo - V8 biturbo', 2, true, true, 'STAT001', 6, 7),
('812 Superfast', 2, 'Automatique', 2023, 'Bleu', 'cars/ferrari-812.jpg', 'Essence', 800, 1500, 399900, 1099, 'Ferrari 812 Superfast - V12 atmosphérique', 2, true, true, 'STAT001', 6, 7),

-- Lamborghini
('Aventador SVJ', 2, 'Automatique', 2023, 'Vert', 'cars/lambo-aventador.jpg', 'Essence', 770, 1000, 499900, 1499, 'Lamborghini Aventador SVJ', 2, true, true, 'STAT001', 7, 7),
('Huracan STO', 2, 'Automatique', 2023, 'Bleu', 'cars/lambo-huracan.jpg', 'Essence', 640, 2000, 329900, 999, 'Lamborghini Huracan STO - Version piste', 2, true, true, 'STAT001', 7, 7),
('Urus', 5, 'Automatique', 2023, 'Jaune', 'cars/lambo-urus.jpg', 'Essence', 650, 3000, 229900, 799, 'Lamborghini Urus - SUV supersportif', 5, true, true, 'STAT001', 7, 1),

-- Toyota
('Supra', 2, 'Automatique', 2023, 'Rouge', 'cars/toyota-supra.jpg', 'Essence', 340, 5000, 67900, 249, 'Toyota GR Supra - Légende sportive', 2, true, true, 'STAT001', 8, 3),
('Land Cruiser', 5, 'Automatique', 2023, 'Noir', 'cars/toyota-landcruiser.jpg', 'Diesel', 299, 8000, 89900, 299, 'Toyota Land Cruiser - 4x4 légendaire', 7, true, true, 'STAT001', 8, 8),
('GR Yaris', 3, 'Manuelle', 2023, 'Blanc', 'cars/toyota-gryaris.jpg', 'Essence', 261, 3000, 45900, 199, 'Toyota GR Yaris - Compacte sportive', 4, true, true, 'STAT001', 8, 6),

-- Ford
('Mustang GT', 2, 'Manuelle', 2023, 'Rouge', 'cars/ford-mustang.jpg', 'Essence', 450, 4000, 59900, 249, 'Ford Mustang GT - Muscle car américaine', 4, true, true, 'STAT001', 9, 3),
('F-150 Raptor', 4, 'Automatique', 2023, 'Bleu', 'cars/ford-raptor.jpg', 'Essence', 450, 5000, 89900, 299, 'Ford F-150 Raptor - Pick-up haute performance', 5, true, true, 'STAT001', 9, 8),
('GT', 2, 'Automatique', 2023, 'Bleu', 'cars/ford-gt.jpg', 'Essence', 660, 1000, 499900, 1299, 'Ford GT - Supercar américaine', 2, true, true, 'STAT001', 9, 7),

-- Chevrolet
('Corvette C8', 2, 'Automatique', 2023, 'Rouge', 'cars/chevrolet-corvette.jpg', 'Essence', 495, 3000, 89900, 299, 'Chevrolet Corvette C8 - Supercar accessible', 2, true, true, 'STAT001', 10, 7),
('Camaro ZL1', 2, 'Manuelle', 2023, 'Noir', 'cars/chevrolet-camaro.jpg', 'Essence', 650, 4000, 79900, 279, 'Chevrolet Camaro ZL1 - Muscle car extrême', 4, true, true, 'STAT001', 10, 3),
('Tahoe', 5, 'Automatique', 2023, 'Blanc', 'cars/chevrolet-tahoe.jpg', 'Essence', 420, 5000, 89900, 299, 'Chevrolet Tahoe - SUV full-size', 7, true, true, 'STAT001', 10, 1); 