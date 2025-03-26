-- Supprimer les colonnes inutiles
ALTER TABLE `Voiture`
DROP COLUMN `Kilometrage`,
DROP COLUMN `PrixAchat`,
DROP COLUMN `Options`,
DROP COLUMN `Climatisation`,
DROP COLUMN `GPS`;

-- Ajouter des index pour les nouvelles critères de recherche
ALTER TABLE `Voiture`
ADD INDEX `idx_puissance` (`Puissance`),
ADD INDEX `idx_nb_places` (`NbPlaces`); 