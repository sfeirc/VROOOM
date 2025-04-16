-- Modification de la structure de la table Users
-- Remplacer la colonne booléenne IsAdmin par un champ ENUM Role

-- Ajouter la nouvelle colonne Role
ALTER TABLE Users 
ADD Role ENUM('CLIENT', 'ADMIN', 'SUPERADMIN') NOT NULL DEFAULT 'CLIENT';

-- Mettre à jour les valeurs existantes (tous les utilisateurs avec IsAdmin=1 deviennent ADMIN)
UPDATE Users SET Role = 'ADMIN' WHERE IsAdmin = 1;

-- Supprimer l'ancienne colonne IsAdmin (seulement après avoir confirmé que la migration s'est bien déroulée)
ALTER TABLE Users 
DROP COLUMN IsAdmin; 