-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 24 juil. 2023 à 21:44
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `room`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
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
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `commentaire`, `note`, `date_enregistrement`) VALUES
(1, 1, 1, 'la salle était vraiment spacieuse. TOP !', 5, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_membre` int NOT NULL,
  `pseudo` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `id_salle` int NOT NULL,
  `prix` int NOT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `id_membre` (`id_membre`),
  KEY `commande_ibfk_1` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `pseudo`, `email`, `id_salle`, `prix`, `date_arrivee`, `date_depart`) VALUES
(12, 4, 'Max', 'maxime@gmail.com', 3, 375, '2023-07-28 14:41:00', '2023-07-30 14:41:00'),
(14, 3, 'Ele', 'eleonore@gmail.com', 4, 415, '2023-07-24 15:09:00', '2023-07-25 15:09:00'),
(15, 8, 'Rook', 'roukun@gmail.com', 7, 320, '2023-09-10 22:51:00', '2023-09-25 22:51:00'),
(16, 8, 'Rook', 'roukun@gmail.com', 2, 350, '2023-07-26 22:52:00', '2023-07-29 22:52:00'),
(17, 9, 'Guess', 'guess@gmail.com', 6, 156, '2023-07-23 22:53:00', '2023-07-29 22:53:00'),
(18, 2, 'Jerem', 'jeremycloarec@msn.com', 6, 156, '2023-07-24 23:17:00', '2023-07-29 23:17:00');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(2, 'Jerem', '$2y$10$bgVW3hhFh8O5UmbLQh/0Xen32s7wA0A5KCLkFpx6lu.K7pTaZZC2.', 'Cloarec', 'Jérémy', 'jeremycloarec@msn.com', 'm', 1, '2023-06-27 15:03:33'),
(3, 'Ele', '$2y$10$NTbbl/LU2ztH1jOYEfMxOu.fs8Gzva5VKf1lUlv.hDwBlFdzZQlSO', 'Eleo', 'Eleonore', 'eleonore@gmail.com', 'f', 0, '2023-06-27 15:05:25'),
(4, 'Max', '$2y$10$H5YFcx0lb0erGuPOkhw9k.C.j4oJOkUrctuq6JokWnxRIW.qTDmpK', 'Maxa', 'Maxime', 'maxime@gmail.com', 'm', 0, '2023-06-27 15:09:39'),
(5, 'Mar', '$2y$10$qyZ5Cj4zu5L69fbPRlza/OCv7FrSqJxblzeH9G6CX.s4K68NIKY8u', 'Maro', 'Marion', 'marion@gmail.com', 'f', 0, '2023-06-27 15:15:09'),
(6, 'Tom', '$2y$10$yy9r1Ht3rK6oks8mfeSS7eHaVccOcdmjCY1dTTNQpmjd/8CoRFH4i', 'Tomi', 'Thomas', 'thomas@gmail.com', 'm', 0, '2023-06-27 15:31:42'),
(7, 'Titi', '$2y$10$YTVTrg3x.eRLPP0s7Qz9/uxCi2JCmX8Tq1LF7de6nmi1SoXOEO3gO', 'Tata', 'Tani', 'tania@gmail.com', 'f', 1, '2023-06-29 11:02:06'),
(8, 'Rook', '$2y$10$qeS./4s59jO413ZXxkvkgOfQ./e3FAMeIFpqhgQGENZ6wWAaTZtkm', 'Abdou', 'Roukia', 'roukun@gmail.com', 'f', 1, '2023-07-24 22:01:56'),
(9, 'Guess', '$2y$10$2Up.Nsch01HPV3w6UpAKTuIMKDZzpNgwmnOLZZxYaOaHWP5QefJx6', 'Guess', 'Guess', 'guess@gmail.com', 'f', 1, '2023-07-24 22:53:35');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `id_salle` int NOT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `prix` int NOT NULL,
  `etat` enum('Libre','Réservé') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_salle`, `date_arrivee`, `date_depart`, `prix`, `etat`) VALUES
(1, 1, '2016-11-22 09:00:00', '2016-11-29 09:00:00', 1200, 'Libre'),
(2, 1, '2016-11-29 09:00:00', '2016-12-03 19:00:00', 990, 'Libre'),
(3, 2, '2016-11-29 09:00:00', '2016-12-03 19:00:00', 880, 'Réservé');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `prix` int NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `pays` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `cp` int NOT NULL,
  `capacite` int NOT NULL,
  `categorie` enum('reunion','bureau','formation','') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `prix`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(1, 'Cézanne', 200, 'Cette salle sera parfaite pour vos réunions d\'entreprise', 'salle_1.png', 'France', 'Paris', '30 rue mademoiselle', 75015, 30, 'formation'),
(2, 'Mozart', 350, 'Cette salle vous permettra de recevoir vos collaborateurs en petite comité', 'salle_2.png', 'France', 'Paris', '17 rue de Turbigo', 75002, 5, 'reunion'),
(3, 'Picasso', 375, 'Cette salle vous permettra de travailler au calme', '69007_salle_5.png', 'France', 'Paris', '28 quai Claude Berna', 69007, 2, 'bureau'),
(4, 'Klimt', 415, 'Plongez dans un univers artistique et captivant avec notre salle de réunion Klimt. Inspirée par les œuvres éblouissantes de Gustav Klimt, cette salle offre une atmosphère unique.', '13000_essai.png', 'France', 'Marseille', '2 rue Klimt', 13000, 20, 'reunion'),
(6, 'Salle Monet', 156, 'Plongez dans un paradis de sérénité et d\'harmonie avec notre salle de formation Monet. Inspirée par l\'artiste lui-même, cette salle offre une ambiance paisible au milieu d\'un jardin.', '75002_salle_7.png', 'France', 'Paris', '2 rue Monet', 75002, 223, 'formation'),
(7, 'Da Vinci', 320, 'Laissez libre cours à votre génie créatif dans notre salle de bureau Da Vinci, un espace innovant conçu pour stimuler la réflexion et la résolution de problèmes.', '69003_pexels-photomix-company-94825.jpg', 'France', 'Lyon', '8 avenue de Leonard', 69003, 80, 'bureau'),
(8, 'Hemingway', 450, 'Espace moderne et ergonomique, propice à la productivité et à la confidentialité des réunions professionnelles.', '13005_pexels-pixabay-260928.jpg', 'France', 'Marseille', '5 impasse Hemingway', 13005, 176, 'reunion'),
(9, 'Curie', 120, 'Salle équipée de technologies avancées et d\'un agencement flexible pour des sessions d\'apprentissage interactives et enrichissantes.', '13002_sa.jpg', 'France', 'Marseille', '45 avenue Curie', 13002, 63, 'formation');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
