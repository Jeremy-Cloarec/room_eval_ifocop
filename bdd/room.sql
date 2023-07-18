-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 18, 2023 at 09:27 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `room`
--

-- --------------------------------------------------------

--
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id_avis` int NOT NULL,
  `id_membre` int NOT NULL,
  `id_salle` int NOT NULL,
  `commentaire` text COLLATE utf8mb4_general_ci NOT NULL,
  `note` int NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_avis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `commentaire`, `note`, `date_enregistrement`) VALUES
(1, 1, 1, 'la salle était vraiment spacieuse. TOP !', 5, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int NOT NULL,
  `id_membre` int NOT NULL,
  `id_produit` int NOT NULL,
  `prix` int NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `id_produit`, `prix`, `date_enregistrement`) VALUES
(1, 1, 0, 0, '2016-06-15 14:10:00'),
(2, 2, 0, 0, '2016-09-20 12:00:00'),
(3, 3, 0, 0, '2016-10-03 09:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `civilite` enum('m','f') COLLATE utf8mb4_general_ci NOT NULL,
  `statut` int NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(2, 'Jerem', '$2y$10$bgVW3hhFh8O5UmbLQh/0Xen32s7wA0A5KCLkFpx6lu.K7pTaZZC2.', 'Cloarec', 'Jérémy', 'jeremycloarec@msn.com', 'm', 1, '2023-06-27 15:03:33'),
(3, 'Ele', '$2y$10$NTbbl/LU2ztH1jOYEfMxOu.fs8Gzva5VKf1lUlv.hDwBlFdzZQlSO', 'Eleo', 'Eleonore', 'eleonore@gmail.com', 'f', 0, '2023-06-27 15:05:25'),
(4, 'Max', '$2y$10$H5YFcx0lb0erGuPOkhw9k.C.j4oJOkUrctuq6JokWnxRIW.qTDmpK', 'Maxa', 'Maxime', 'maxime@gmail.com', 'm', 0, '2023-06-27 15:09:39'),
(5, 'Mar', '$2y$10$qyZ5Cj4zu5L69fbPRlza/OCv7FrSqJxblzeH9G6CX.s4K68NIKY8u', 'Maro', 'Marion', 'marion@gmail.com', 'f', 0, '2023-06-27 15:15:09'),
(6, 'Tom', '$2y$10$yy9r1Ht3rK6oks8mfeSS7eHaVccOcdmjCY1dTTNQpmjd/8CoRFH4i', 'Tomi', 'Thomas', 'thomas@gmail.com', 'm', 0, '2023-06-27 15:31:42'),
(7, 'Titi', '$2y$10$YTVTrg3x.eRLPP0s7Qz9/uxCi2JCmX8Tq1LF7de6nmi1SoXOEO3gO', 'Tata', 'Tani', 'tania@gmail.com', 'f', 0, '2023-06-29 11:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `id_salle` int NOT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `prix` int NOT NULL,
  `etat` enum('Libre','Réservé') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_salle`, `date_arrivee`, `date_depart`, `prix`, `etat`) VALUES
(1, 1, '2016-11-22 09:00:00', '2016-11-29 09:00:00', 1200, 'Libre'),
(2, 1, '2016-11-29 09:00:00', '2016-12-03 19:00:00', 990, 'Libre'),
(3, 2, '2016-11-29 09:00:00', '2016-12-03 19:00:00', 880, 'Réservé');

-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `pays` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `cp` int NOT NULL,
  `capacite` int NOT NULL,
  `categorie` enum('reunion','bureau','formation','') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(1, 'Cézanne', 'Cette salle sera parfaite pour vos réunions d\'entreprise', 'salle_1.png', 'France', 'Paris', '30 rue mademoiselle', 75015, 30, 'reunion'),
(2, 'Mozart', 'Cette salle vous permettra de recevoir vos collaborateurs en petite comité', 'salle_2.png', 'France', 'Paris', '17 rue de Turbigo', 75002, 5, 'reunion'),
(3, 'Picasso', 'Cette salle vous permettra de travailler au calme', 'salle_3.png', 'France', 'Paris', '28 quai Claude Berna', 69007, 2, 'bureau'),
(4, 'Klimt', 'Fresque', '13000_essai.png', 'France', 'Marseille', '2 rue Klimt', 13000, 20, 'reunion');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
