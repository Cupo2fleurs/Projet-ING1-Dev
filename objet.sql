-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 19 mars 2025 à 13:50
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
-- Base de données : `objet`
--

-- --------------------------------------------------------

--
-- Structure de la table `chauffage`
--

DROP TABLE IF EXISTS `chauffage`;
CREATE TABLE IF NOT EXISTS `chauffage` (
  `id` int NOT NULL,
  `temperature` int NOT NULL DEFAULT '20',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `chauffage`
--

INSERT INTO `chauffage` (`id`, `temperature`) VALUES
(1, 22),
(2, 24);

-- --------------------------------------------------------

--
-- Structure de la table `four`
--

DROP TABLE IF EXISTS `four`;
CREATE TABLE IF NOT EXISTS `four` (
  `id` int NOT NULL,
  `temperature` int NOT NULL DEFAULT '180',
  `duree` int NOT NULL DEFAULT '30',
  `mode` enum('Convection','Grill','Chaleur tournante') NOT NULL DEFAULT 'Convection',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `four`
--

INSERT INTO `four` (`id`, `temperature`, `duree`, `mode`) VALUES
(5, 200, 40, 'Grill'),
(6, 180, 35, 'Convection');

-- --------------------------------------------------------

--
-- Structure de la table `lave_vaisselle`
--

DROP TABLE IF EXISTS `lave_vaisselle`;
CREATE TABLE IF NOT EXISTS `lave_vaisselle` (
  `id` int NOT NULL,
  `programme` enum('Normal','Intensif','Éco','Rapide') NOT NULL DEFAULT 'Normal',
  `duree` int NOT NULL DEFAULT '90',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `lave_vaisselle`
--

INSERT INTO `lave_vaisselle` (`id`, `programme`, `duree`) VALUES
(4, 'Éco', 120);

-- --------------------------------------------------------

--
-- Structure de la table `machine_laver`
--

DROP TABLE IF EXISTS `machine_laver`;
CREATE TABLE IF NOT EXISTS `machine_laver` (
  `id` int NOT NULL,
  `programme` enum('Normal','Éco','Rapide') NOT NULL DEFAULT 'Normal',
  `essorage` int NOT NULL DEFAULT '1000',
  `duree` int NOT NULL DEFAULT '60',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `machine_laver`
--

INSERT INTO `machine_laver` (`id`, `programme`, `essorage`, `duree`) VALUES
(3, 'Normal', 1200, 45);

-- --------------------------------------------------------

--
-- Structure de la table `objets`
--

DROP TABLE IF EXISTS `objets`;
CREATE TABLE IF NOT EXISTS `objets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `type` enum('chauffage','machine_laver','four','rideaux','lave_vaisselle','television') NOT NULL,
  `etat` enum('allumé','éteint','ouvert','fermé') NOT NULL DEFAULT 'éteint',
  `date_ajout` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `objets`
--

INSERT INTO `objets` (`id`, `nom`, `type`, `etat`, `date_ajout`) VALUES
(1, 'Chauffage Salon', 'chauffage', 'éteint', '2025-03-19 13:46:12'),
(2, 'Chauffage Salle de Bain', 'chauffage', 'éteint', '2025-03-19 13:46:12'),
(3, 'Lave-linge Samsung', 'machine_laver', 'éteint', '2025-03-19 13:46:12'),
(4, 'Lave-vaisselle Siemens', 'lave_vaisselle', 'éteint', '2025-03-19 13:46:12'),
(5, 'Four Bosch', 'four', 'éteint', '2025-03-19 13:46:12'),
(6, 'Four Cuisine', 'four', 'éteint', '2025-03-19 13:46:12'),
(7, 'Rideaux Salon', 'rideaux', 'fermé', '2025-03-19 13:46:12'),
(8, 'Rideaux Chambre', 'rideaux', 'fermé', '2025-03-19 13:46:12'),
(9, 'TV Samsung', 'television', 'éteint', '2025-03-19 13:46:12'),
(10, 'TV Chambre', 'television', 'éteint', '2025-03-19 13:46:12');

-- --------------------------------------------------------

--
-- Structure de la table `rideaux`
--

DROP TABLE IF EXISTS `rideaux`;
CREATE TABLE IF NOT EXISTS `rideaux` (
  `id` int NOT NULL,
  `position` enum('ouvert','fermé') NOT NULL DEFAULT 'fermé',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rideaux`
--

INSERT INTO `rideaux` (`id`, `position`) VALUES
(7, 'fermé'),
(8, 'ouvert');

-- --------------------------------------------------------

--
-- Structure de la table `television`
--

DROP TABLE IF EXISTS `television`;
CREATE TABLE IF NOT EXISTS `television` (
  `id` int NOT NULL,
  `chaine` varchar(50) NOT NULL DEFAULT 'TF1',
  `volume` int NOT NULL DEFAULT '20',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `television`
--

INSERT INTO `television` (`id`, `chaine`, `volume`) VALUES
(9, 'Netflix', 30),
(10, 'TF1', 25);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chauffage`
--
ALTER TABLE `chauffage`
  ADD CONSTRAINT `chauffage_ibfk_1` FOREIGN KEY (`id`) REFERENCES `objets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `four`
--
ALTER TABLE `four`
  ADD CONSTRAINT `four_ibfk_1` FOREIGN KEY (`id`) REFERENCES `objets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `lave_vaisselle`
--
ALTER TABLE `lave_vaisselle`
  ADD CONSTRAINT `lave_vaisselle_ibfk_1` FOREIGN KEY (`id`) REFERENCES `objets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `machine_laver`
--
ALTER TABLE `machine_laver`
  ADD CONSTRAINT `machine_laver_ibfk_1` FOREIGN KEY (`id`) REFERENCES `objets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `rideaux`
--
ALTER TABLE `rideaux`
  ADD CONSTRAINT `rideaux_ibfk_1` FOREIGN KEY (`id`) REFERENCES `objets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `television`
--
ALTER TABLE `television`
  ADD CONSTRAINT `television_ibfk_1` FOREIGN KEY (`id`) REFERENCES `objets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
