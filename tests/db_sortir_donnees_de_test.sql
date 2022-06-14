-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 13 juin 2022 à 14:24
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

--
-- Déchargement des données de la table `etats`
--

INSERT INTO `etats` (`no_etat`, `libelle`) VALUES
(1, 'Création en cours'),
(2, 'Inscription ouverte'),
(3, 'Inscription clôturée'),
(4, 'Activité en cours'),
(5, 'Activité terminée'),
(6, 'Activité historisée'),
(7, 'Annulée');

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`date_inscription`, `sorties_no_sortie`, `participants_no_participant`) VALUES
('2022-06-13 14:17:03', 1, 1),
('2022-06-13 14:19:25', 2, 2);

--
-- Déchargement des données de la table `lieux`
--

INSERT INTO `lieux` (`no_lieu`, `nom_lieu`, `rue`, `latitude`, `longitude`, `villes_no_ville`) VALUES
(1, 'V And B', '52 Av. de Kéradennec', 47.976, -4.07758, 2),
(2, 'Run Ar Puns', 'Run Ar Puns', 48.2057, -4.06208, 1);

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`no_participant`, `pseudo`, `nom`, `prenom`, `telephone`, `mail`, `mot_de_passe`, `administrateur`, `actif`, `sites_no_site`) VALUES
(1, 'participantActif', 'NomParticipantActif', 'PrenomParticipantActif', '0612345678', 'participant.actif@campus-eni.fr', 'e10adc3949ba59abbe56e057f20f883e', 0, 1, 1),
(2, 'participantInactif', 'NomParticipantInactif', 'PrenomParticipantInactif', '0612345678', 'participant.inactif@campus-eni.fr', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 2),
(3, 'admin', 'NomAdmin', 'PrenomAdmin', '0612345678', 'admin@campus-eni.fr', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 3),
(4, 'organisateur', 'NomOrganisateur', 'PrenomOrganisateur', '0612345678', 'organisateur@campus-eni.fr', 'e10adc3949ba59abbe56e057f20f883e', 0, 1, 4);

--
-- Déchargement des données de la table `sites`
--

INSERT INTO `sites` (`no_site`, `nom_site`) VALUES
(1, 'Quimper'),
(2, 'Saint-Herblain'),
(3, 'Rennes'),
(4, 'Niort');

--
-- Déchargement des données de la table `sorties`
--

INSERT INTO `sorties` (`no_sortie`, `nom`, `datedebut`, `duree`, `datecloture`, `nbinscriptionsmax`, `descriptioninfos`, `urlPhoto`, `organisateur`, `lieux_no_lieu`, `etats_no_etat`) VALUES
(1, 'After V&B', '2022-06-17 17:00:00', 90, '2022-06-17 16:06:03', 100, 'une p\'tit binouze !', NULL, 4, 1, 1),
(2, 'After au Run', '2022-06-24 17:00:00', 90, '2022-06-22 16:17:50', 50, 'vous connaissez pas le Run ?', NULL, 4, 2, 2);

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`no_ville`, `nom_ville`, `code_postal`) VALUES
(1, 'Chateaulin', '29150'),
(2, 'Quimper', '29000');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
