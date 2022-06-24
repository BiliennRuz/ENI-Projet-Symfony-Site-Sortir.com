-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 24 juin 2022 à 08:11
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_sortir`
--

-- --------------------------------------------------------

--
-- Structure de la table `etats`
--

DROP TABLE IF EXISTS `etats`;
CREATE TABLE IF NOT EXISTS `etats` (
  `no_etat` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(30) NOT NULL,
  PRIMARY KEY (`no_etat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `date_inscription` datetime NOT NULL,
  `sorties_no_sortie` int(11) NOT NULL,
  `participants_no_participant` int(11) NOT NULL,
  PRIMARY KEY (`sorties_no_sortie`,`participants_no_participant`),
  KEY `inscriptions_participants_fk` (`participants_no_participant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `lieux`
--

DROP TABLE IF EXISTS `lieux`;
CREATE TABLE IF NOT EXISTS `lieux` (
  `no_lieu` int(11) NOT NULL AUTO_INCREMENT,
  `nom_lieu` varchar(30) NOT NULL,
  `rue` varchar(30) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `villes_no_ville` int(11) NOT NULL,
  PRIMARY KEY (`no_lieu`),
  KEY `lieux_villes_fk` (`villes_no_ville`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `participants`
--

DROP TABLE IF EXISTS `participants`;
CREATE TABLE IF NOT EXISTS `participants` (
  `no_participant` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(30) DEFAULT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(250) NOT NULL,
  `roles` json NOT NULL,
  `actif` tinyint(1) DEFAULT NULL,
  `photo_filename` varchar(255) DEFAULT NULL,
  `sites_no_site` int(11) DEFAULT NULL,
  PRIMARY KEY (`no_participant`),
  UNIQUE KEY `participants_pseudo_uk` (`pseudo`),
  KEY `participants_sites_fk` (`sites_no_site`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sites`
--

DROP TABLE IF EXISTS `sites`;
CREATE TABLE IF NOT EXISTS `sites` (
  `no_site` int(11) NOT NULL AUTO_INCREMENT,
  `nom_site` varchar(30) NOT NULL,
  PRIMARY KEY (`no_site`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sorties`
--

DROP TABLE IF EXISTS `sorties`;
CREATE TABLE IF NOT EXISTS `sorties` (
  `no_sortie` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `datedebut` datetime NOT NULL,
  `duree` int(11) DEFAULT NULL,
  `datecloture` datetime NOT NULL,
  `nbinscriptionsmax` int(11) NOT NULL,
  `descriptioninfos` varchar(500) DEFAULT NULL,
  `urlPhoto` varchar(250) DEFAULT NULL,
  `organisateur` int(11) NOT NULL,
  `lieux_no_lieu` int(11) NOT NULL,
  `etats_no_etat` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`no_sortie`),
  KEY `sorties_etats_fk` (`etats_no_etat`),
  KEY `sorties_lieux_fk` (`lieux_no_lieu`),
  KEY `sorties_participants_fk` (`organisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `no_ville` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ville` varchar(30) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  PRIMARY KEY (`no_ville`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_participants_fk` FOREIGN KEY (`participants_no_participant`) REFERENCES `participants` (`no_participant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `inscriptions_sorties_fk` FOREIGN KEY (`sorties_no_sortie`) REFERENCES `sorties` (`no_sortie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `lieux`
--
ALTER TABLE `lieux`
  ADD CONSTRAINT `lieux_villes_fk` FOREIGN KEY (`villes_no_ville`) REFERENCES `villes` (`no_ville`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_sites_fk` FOREIGN KEY (`sites_no_site`) REFERENCES `sites` (`no_site`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `sorties`
--
ALTER TABLE `sorties`
  ADD CONSTRAINT `sorties_etats_fk` FOREIGN KEY (`etats_no_etat`) REFERENCES `etats` (`no_etat`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sorties_lieux_fk` FOREIGN KEY (`lieux_no_lieu`) REFERENCES `lieux` (`no_lieu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sorties_participants_fk` FOREIGN KEY (`organisateur`) REFERENCES `participants` (`no_participant`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
