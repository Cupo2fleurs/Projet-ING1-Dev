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
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `age` int NOT NULL,
  `sexe` varchar(30) NOT NULL,
  `grade` varchar(30) NOT NULL,
  `born` date NOT NULL,
  `photo` text NOT NULL,
  `points` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `mdp`, `pseudo`, `age`, `sexe`, `grade`, `born`, `photo`, `points`) VALUES
(1, 'Bon', 'Jean', '1234', 'Super PAPA', 45, 'Homme', 'Père', '1111-11-11', 'uploads/1626614117160.jpg', 47),
(2, 'Bon', 'Bella', 'bonbon', 'Bibou', 46, 'Femme', 'Mère', '1978-06-14', 'uploads/cheval.jpg', 2),
(3, 'Bon', 'Otis', 'coucou', 'TurboMan', 15, 'Homme', 'Enfant', '2010-06-11', 'uploads/20240321_173018.jpg', 2),
(10, 'Bon', 'Jeanne', '1234', 'Mamitrailette', 79, 'Femme', 'Visiteur', '0001-01-01', 'uploads/default.jpg', 1),
(9, 'Bon', 'Michelle', '1234', 'Papi Moustache', 78, 'Homme', 'Visiteur', '1945-03-11', 'uploads/Team-Sonic-Racing_Eggman_profil.webp', 1),
(11, 'Bap', 'Carl', '1234', 'Ned Flanders', 30, 'Homme', 'Visiteur', '1995-09-09', 'uploads/412rysZZ3GL._AC_UY350_.jpg', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
