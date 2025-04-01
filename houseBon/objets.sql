-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 01 avr. 2025 à 07:24
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `utilisateur`
--

-- --------------------------------------------------------

--
-- Structure de la table `objets`
--

DROP TABLE IF EXISTS `objets`;
CREATE TABLE IF NOT EXISTS `objets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `type` enum('chauffage','machine_laver','four','rideaux','lave_vaisselle','television') NOT NULL,
  `etat` enum('allumé','éteint','en_cours','fermé','ouvert') NOT NULL DEFAULT 'éteint',
  `date_ajout` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_url` varchar(255) NOT NULL,
  `temperature` int DEFAULT NULL,
  `programme` enum('Normal','Intensif','Éco','Rapide') DEFAULT NULL,
  `duree` int DEFAULT NULL,
  `mode` enum('Convection','Grill','Chaleur_tournante') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `position` enum('Ouvert','Ferme') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `chaine` varchar(50) DEFAULT NULL,
  `volume` int DEFAULT NULL,
  `consult` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `objets`
--

INSERT INTO `objets` (`id`, `nom`, `type`, `etat`, `date_ajout`, `image_url`, `temperature`, `programme`, `duree`, `mode`, `position`, `chaine`, `volume`, `consult`) VALUES
(1, 'Chauffage Salon', 'chauffage', 'éteint', '2025-03-19 12:46:12', 'uploads/chauffage.jpg', 22, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(2, 'Machine à Laver Samsung', 'machine_laver', 'allumé', '2025-03-19 12:46:12', 'uploads/lave_linge_samsung.jpg', NULL, 'Rapide', 100, NULL, NULL, NULL, 71, '2025-03-31 17:28:21'),
(3, 'Lave-Vaisselle Bosch', 'lave_vaisselle', 'éteint', '2025-03-19 12:46:12', 'uploads/lave_vaisselle_bosch.jpg', NULL, 'Rapide', 10, NULL, NULL, NULL, NULL, '2025-03-31 17:23:40'),
(4, 'Four Cuisine', 'four', 'allumé', '2025-03-19 12:46:12', 'uploads/four_cuisine.jpg', NULL, NULL, 202, 'Chaleur_tournante', NULL, NULL, NULL, '0000-00-00 00:00:00'),
(5, 'Rideaux Salon', 'rideaux', 'allumé', '2025-03-19 12:46:12', 'uploads/rideaux_salon.jpg', NULL, NULL, NULL, NULL, 'Ferme', NULL, NULL, '2025-03-31 17:49:29'),
(6, 'TV Samsung', 'television', 'éteint', '2025-03-19 12:46:12', 'uploads/tv_samsung.jpg', NULL, NULL, NULL, NULL, NULL, 'GULLI', 20, '2025-03-31 17:50:47'),
(7, 'Chauffage Chambre', 'chauffage', 'allumé', '2025-03-19 12:46:12', 'uploads/chauffage_chambre.jpg', 24, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(8, 'Lave-Vaisselle Siemens', 'lave_vaisselle', 'allumé', '2025-03-19 12:46:12', 'uploads/lave_vaisselle_siemens.jpg', NULL, 'Rapide', 60, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(9, 'Four Bosch', 'four', 'allumé', '2025-03-19 12:46:12', 'uploads/four_bosch.jpg', NULL, NULL, 30, 'Grill', NULL, NULL, NULL, '0000-00-00 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
