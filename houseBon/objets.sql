-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 01 avr. 2025 à 13:19
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
  `type` enum('chauffage','machine_laver','four','rideaux','lave_vaisselle','television','lumiere') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `etat` enum('allumé','éteint','en_cours') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'éteint',
  `date_ajout` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_url` varchar(255) NOT NULL,
  `temperature` int DEFAULT NULL,
  `programme` enum('Normal','Intensif','Éco','Rapide') DEFAULT NULL,
  `duree` int DEFAULT NULL,
  `mode` enum('Convection','Grill','Chaleur_tournante') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `position` enum('Ouvert','Ferme') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `chaine` varchar(50) DEFAULT NULL,
  `volume` int DEFAULT NULL,
  `consomation` int NOT NULL,
  `connectivite` enum('Wifi','Ethernet','Bluetooth','NON') NOT NULL,
  `consult` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `objets`
--

INSERT INTO `objets` (`id`, `nom`, `type`, `etat`, `date_ajout`, `image_url`, `temperature`, `programme`, `duree`, `mode`, `position`, `chaine`, `volume`, `consomation`, `connectivite`, `consult`) VALUES
(1, 'Chauffage Salon', 'chauffage', 'allumé', '2025-03-19 12:46:12', 'uploads/chauffage.jpg', 20, NULL, NULL, NULL, NULL, NULL, NULL, 8, 'Wifi', '2025-04-01 13:25:12'),
(2, 'Machine à Laver Samsung', 'machine_laver', 'allumé', '2025-03-19 12:46:12', 'uploads/lave_linge_samsung.jpg', NULL, '', 100, NULL, NULL, NULL, 71, 100, 'Ethernet', '2025-04-01 14:43:26'),
(3, 'Lave-Vaisselle Bosch', 'lave_vaisselle', 'éteint', '2025-03-19 12:46:12', 'uploads/lave_vaisselle_bosch.jpg', NULL, 'Rapide', 10, NULL, NULL, NULL, NULL, 114, 'Ethernet', '2025-03-31 17:23:40'),
(4, 'Four Cuisine', 'four', 'allumé', '2025-03-19 12:46:12', 'uploads/four_cuisine.jpg', NULL, NULL, 202, 'Chaleur_tournante', NULL, NULL, NULL, 200, 'Ethernet', '0000-00-00 00:00:00'),
(5, 'Rideaux Salon', 'rideaux', 'allumé', '2025-03-19 12:46:12', 'uploads/rideaux_salon.jpg', NULL, NULL, NULL, NULL, 'Ferme', NULL, NULL, 4, 'Wifi', '2025-04-01 09:31:25'),
(6, 'TV Samsung', 'television', 'éteint', '2025-03-19 12:46:12', 'uploads/tv_samsung.jpg', NULL, NULL, NULL, NULL, NULL, 'GULLI', 20, 20, 'Wifi', '2025-03-31 17:50:47'),
(7, 'Chauffage Chambre', 'chauffage', 'allumé', '2025-03-19 12:46:12', 'uploads/chauffage_chambre.jpg', 24, NULL, NULL, NULL, NULL, NULL, NULL, 8, 'Wifi', '0000-00-00 00:00:00'),
(8, 'Lave-Vaisselle Siemens', 'lave_vaisselle', 'allumé', '2025-03-19 12:46:12', 'uploads/lave_vaisselle_siemens.jpg', NULL, 'Rapide', 60, NULL, NULL, NULL, NULL, 150, 'Ethernet', '0000-00-00 00:00:00'),
(9, 'Four Bosch', 'four', 'allumé', '2025-03-19 12:46:12', 'uploads/four_bosch.jpg', NULL, NULL, 30, 'Grill', NULL, NULL, NULL, 150, 'Ethernet', '0000-00-00 00:00:00'),
(17, 'Lumière Salon', 'lumiere', 'éteint', '2025-04-01 13:11:54', 'uploads/img_67ebe61a98825.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Bluetooth', '0000-00-00 00:00:00'),
(18, 'Lumière Bureau', 'lumiere', 'allumé', '2025-04-01 13:12:55', 'uploads/img_67ebe65721136.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, 'Bluetooth', '0000-00-00 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
