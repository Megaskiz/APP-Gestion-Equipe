-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 22 jan. 2023 à 13:20
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bddprojetsport`
--

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id_joueur` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `num_licence` char(8) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `taille` float DEFAULT NULL,
  `poids` double DEFAULT NULL,
  `poste_pref` varchar(50) DEFAULT NULL,
  `lien_photo` varchar(50) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `commentaire` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id_joueur`, `nom`, `prenom`, `num_licence`, `date_naissance`, `taille`, `poids`, `poste_pref`, `lien_photo`, `statut`, `commentaire`) VALUES
(1, 'LeBron ', 'James', '11111111', '1997-12-17', 2.2, 110.5, 'Ailier', 'projet_photos/63cc3d33b54417.66180220.webp', 'actif', 'Aucun commentaire pour ce joueur'),
(2, 'Kareem', 'Abdul-Jabbar', '11111112', '1997-12-17', 2.05, 100.5, 'Pivot', 'projet_photos/515125316.webp', 'actif', NULL),
(3, 'Kobe', 'Bryant', '11111113', '1997-12-17', 1.98, 99.5, 'Arrière', 'projet_photos/kb.jpg', 'actif', NULL),
(4, 'Michael', 'Jordan', '11111114', '1997-12-17', 1.98, 99.5, 'Arrière', 'projet_photos/mj.png', 'actif', NULL),
(5, 'Dirk', 'Nowitzki', '11111115', '1997-12-17', 2.15, 120, 'Ailier fort', 'projet_photos/63cc3d7aef6751.28074294.webp', 'actif', NULL),
(12, 'Booker', 'Devin', '123454', '1995-01-11', 1.96, 90, 'Meneur', NULL, 'Actif', 'il est sympa');

-- --------------------------------------------------------

--
-- Structure de la table `le_match`
--

CREATE TABLE `le_match` (
  `id_le_match` int(11) NOT NULL,
  `date_match` date DEFAULT NULL,
  `heure_match` time DEFAULT NULL,
  `equipe_adverse` varchar(50) DEFAULT NULL,
  `lieux` varchar(50) DEFAULT NULL,
  `domicile` tinyint(1) DEFAULT NULL,
  `resultat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `le_match`
--

INSERT INTO `le_match` (`id_le_match`, `date_match`, `heure_match`, `equipe_adverse`, `lieux`, `domicile`, `resultat`) VALUES
(1, '2022-12-01', '18:23:32', 'LAKERS', 'LOS ANGELES', 0, '115-110'),
(2, '2022-11-01', '14:24:30', 'BOSTON', 'CELTICS', 0, '95-100'),
(3, '2022-12-01', '13:53:32', 'WARRIORS', 'GOLDEN STATE', 0, '85-90'),
(4, '2023-01-11', '13:45:00', 'Suns de Phoenix', 'Phoenix', 0, '112-117'),
(5, '2023-01-11', '13:45:00', 'Suns de Phoenix', 'Phoenix', 0, '112-117');

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

CREATE TABLE `participe` (
  `id_joueur` int(11) NOT NULL,
  `id_le_match` int(11) NOT NULL,
  `poste` varchar(50) DEFAULT NULL,
  `note` char(5) DEFAULT NULL,
  `titulaire` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `participe`
--

INSERT INTO `participe` (`id_joueur`, `id_le_match`, `poste`, `note`, `titulaire`) VALUES
(12, 2, 'Meneur', '7', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `identifiant` char(5) DEFAULT NULL,
  `mdp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `identifiant`, `mdp`) VALUES
(1, '12345', '12345');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id_joueur`);

--
-- Index pour la table `le_match`
--
ALTER TABLE `le_match`
  ADD PRIMARY KEY (`id_le_match`);

--
-- Index pour la table `participe`
--
ALTER TABLE `participe`
  ADD PRIMARY KEY (`id_joueur`,`id_le_match`),
  ADD KEY `id_le_match` (`id_le_match`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id_joueur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `le_match`
--
ALTER TABLE `le_match`
  MODIFY `id_le_match` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `participe_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id_joueur`),
  ADD CONSTRAINT `participe_ibfk_2` FOREIGN KEY (`id_le_match`) REFERENCES `le_match` (`id_le_match`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
