-- Base de données : `objet`

-- --------------------------------------------------------

-- Structure de la table `objets`

DROP TABLE IF EXISTS `objets`;
CREATE TABLE IF NOT EXISTS `objets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `type` enum('chauffage', 'machine_laver', 'four', 'rideaux', 'lave_vaisselle', 'television') NOT NULL,
  `etat` enum('allumé', 'éteint', 'en_cours', 'fermé', 'ouvert') NOT NULL DEFAULT 'éteint',
  `date_ajout` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_url` varchar(255) NOT NULL,
  -- Attributs spécifiques par type
  `temperature` int DEFAULT NULL,  -- Spécifique pour chauffage
  `programme` enum('Normal', 'Intensif', 'Éco', 'Rapide') DEFAULT NULL,  -- Spécifique pour machine à laver et lave-vaisselle
  `duree` int DEFAULT NULL,  -- Spécifique pour machine à laver, lave-vaisselle, et four
  `mode` enum('Convection', 'Grill', 'Chaleur tournante') DEFAULT NULL,  -- Spécifique pour four
  `position` enum('ouvert', 'fermé') DEFAULT NULL,  -- Spécifique pour rideaux
  `chaine` varchar(50) DEFAULT NULL,  -- Spécifique pour télévision
  `volume` int DEFAULT NULL,  -- Spécifique pour télévision
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Insertion des objets dans la table `objets`

INSERT INTO `objets` (`id`, `nom`, `type`, `etat`, `date_ajout`, `image_url`, `temperature`, `programme`, `duree`, `mode`, `position`, `chaine`, `volume`) VALUES
(1, 'Chauffage Salon', 'chauffage', 'éteint', '2025-03-19 13:46:12', 'uploads/chauffage.jpg', 22, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Machine à Laver Samsung', 'machine_laver', 'éteint', '2025-03-19 13:46:12', 'uploads/lave_linge_samsung.jpg', NULL, 'Normal', 45, NULL, NULL, NULL, NULL),
(3, 'Lave-Vaisselle Bosch', 'lave_vaisselle', 'éteint', '2025-03-19 13:46:12', 'uploads/lave_vaisselle_bosch.jpg', NULL, 'Intensif', 90, NULL, NULL, NULL, NULL),
(4, 'Four Cuisine', 'four', 'éteint', '2025-03-19 13:46:12', 'uploads/four_cuisine.jpg', NULL, NULL, 60, 'Convection', NULL, NULL, NULL),
(5, 'Rideaux Salon', 'rideaux', 'fermé', '2025-03-19 13:46:12', 'uploads/rideaux_salon.jpg', NULL, NULL, NULL, NULL, 'fermé', NULL, NULL),
(6, 'TV Samsung', 'television', 'éteint', '2025-03-19 13:46:12', 'uploads/tv_samsung.jpg', NULL, NULL, NULL, NULL, NULL, 'TF1', 20),
(7, 'Chauffage Chambre', 'chauffage', 'allumé', '2025-03-19 13:46:12', 'uploads/chauffage_chambre.jpg', 24, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Lave-Vaisselle Siemens', 'lave_vaisselle', 'allumé', '2025-03-19 13:46:12', 'uploads/lave_vaisselle_siemens.jpg', NULL, 'Rapide', 60, NULL, NULL, NULL, NULL),
(9, 'Four Bosch', 'four', 'allumé', '2025-03-19 13:46:12', 'uploads/four_bosch.jpg', NULL, NULL, 30, 'Grill', NULL, NULL, NULL);

-- --------------------------------------------------------
