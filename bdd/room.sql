-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2023 at 11:29 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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

CREATE TABLE `avis` (
  `id_avis` int(3) NOT NULL,
  `id_membre` int(3) NOT NULL,
  `id_salle` int(3) NOT NULL,
  `commentaire` text NOT NULL,
  `note` int(2) NOT NULL,
  `date_enregistrement` datetime NOT NULL
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

CREATE TABLE `commande` (
  `id_commande` int(3) NOT NULL,
  `id_membre` int(3) NOT NULL,
  `id_produit` int(3) NOT NULL,
  `prix` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL
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

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `produit` (
  `id_produit` int(3) NOT NULL,
  `id_salle` int(3) NOT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `prix` int(3) NOT NULL,
  `etat` enum('libre','reservation','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_salle`, `date_arrivee`, `date_depart`, `prix`, `etat`) VALUES
(1, 1, '2016-11-22 09:00:00', '2016-11-29 09:00:00', 1200, 'libre'),
(2, 1, '2016-11-29 09:00:00', '2016-12-03 19:00:00', 990, 'libre'),
(3, 2, '2016-11-29 09:00:00', '2016-12-03 19:00:00', 880, 'libre');

-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

CREATE TABLE `salle` (
  `id_salle` int(3) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(20) NOT NULL,
  `cp` int(5) NOT NULL,
  `capacite` int(3) NOT NULL,
  `categorie` enum('reunion','bureau','formation','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(1, 'Cézanne', 'Cette salle sera parfaite pour vos réunions d\'entreprise', '', 'France', 'Paris', '30 rue mademoiselle', 75015, 30, 'reunion'),
(2, 'Mozart', 'Cette salle vous permettra de recevoir vos collaborateurs en petite comité', '', 'France', 'Paris', '17 rue de Turbigo', 75002, 5, 'reunion'),
(3, 'Picasso', 'Cette salle vous permettra de travailler au calme', '', 'France', 'Paris', '28 quai Claude Berna', 69007, 2, 'bureau');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`);

--
-- Indexes for table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Indexes for table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
