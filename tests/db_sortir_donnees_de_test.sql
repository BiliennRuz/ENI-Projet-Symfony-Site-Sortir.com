-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 24 juin 2022 à 08:09
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
('2022-06-20 09:20:03', 1, 1),
('2022-06-20 09:18:52', 1, 2),
('2017-01-01 00:00:00', 1, 4),
('2022-06-21 14:36:26', 2, 1),
('2022-06-20 09:18:55', 2, 2),
('2022-06-21 14:40:26', 2, 6),
('2022-06-23 10:22:13', 15, 1),
('2022-06-23 11:46:51', 15, 2),
('2017-01-01 00:00:00', 15, 4),
('2022-06-23 17:50:16', 15, 6),
('2022-06-21 14:42:57', 15, 7),
('2022-06-21 14:43:11', 15, 8),
('2022-06-21 14:43:25', 15, 9),
('2022-06-22 14:51:26', 26, 1),
('2022-06-22 14:29:23', 26, 5),
('2022-06-21 14:40:30', 26, 6),
('2022-06-21 14:41:27', 27, 2),
('2022-06-21 14:40:32', 27, 6),
('2022-06-21 14:36:23', 28, 1),
('2022-06-23 14:28:47', 31, 1),
('2022-06-23 17:54:11', 32, 5),
('2022-06-23 17:52:54', 32, 6);

--
-- Déchargement des données de la table `lieux`
--

INSERT INTO `lieux` (`no_lieu`, `nom_lieu`, `rue`, `latitude`, `longitude`, `villes_no_ville`) VALUES
(1, 'V And B', '52 Av. de Kéradennec', 47.976, -4.07758, 2),
(2, 'Run Ar Puns', 'Run Ar Puns', 48.2057, -4.06208, 1);

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`no_participant`, `pseudo`, `nom`, `prenom`, `telephone`, `mail`, `mot_de_passe`, `roles`, `actif`, `photo_filename`, `sites_no_site`) VALUES
(1, 'participantActif', 'NomParticipantActif', 'PrenomParticipantActif', '118218', 'participant.actif@campus-eni.fr', '$2y$13$eCNQMgEsGYDzKJrDgd/geehyrJdQYplycXBVR6FPx9m5v.2BniRfG', '[]', 1, '', 1),
(2, 'participantInactif', 'NomParticipantInactif', 'PrenomParticipantInactif', '0612345678', 'participant.inactif@campus-eni.fr', '$2y$13$xekH3/RjpTnHYhBhGY8cBOVUh9HZGG/TGKAKITg3Y2ECCuioLccqG', '[]', 0, '', 2),
(4, 'organisateur', 'NomOrganisateur', 'PrenomOrganisateur', '0612345678', 'organisateur@campus-eni.fr', '$2y$13$YGH9934R4GUWRMFO04ptIuhMCA/9pf9XwUcgOUx/9yWSOxWUmOdEu', '[]', 1, '', 4),
(5, 'admin', 'nomAdmin', 'prenomAdmin', '118218', 'admin@campus-eni.fr', '$2y$13$9fztkODRBAUigJqQF0TEK.TGA5YeoOOnHE4qTbX0PFjxPjSC8RXzu', '[\"ROLE_ADMIN\"]', 1, '', 3),
(6, 'tof', 'RENIER', 'Christophe', '0504646465465', 'cr@gmail.com', '$2y$13$nD8YCAhDb9rva5aO2ym/bO6xIhy47dHA98HwRVvHnhVxswYqznuvq', '[]', NULL, '', 1),
(7, 'tom', 'tom', 'tom', '06', 'tom@tom.tom', '$2y$13$nD8YCAhDb9rva5aO2ym/bO6xIhy47dHA98HwRVvHnhVxswYqznuvq', '[]', NULL, '', 1),
(8, 'test', 'test', 'test', '1023', 'test@test.test', '$2y$13$nD8YCAhDb9rva5aO2ym/bO6xIhy47dHA98HwRVvHnhVxswYqznuvq', '[]', NULL, '', 1),
(9, 'test2', 'test2', 'test2', '123456', 'test2@test.test', '$2y$13$nD8YCAhDb9rva5aO2ym/bO6xIhy47dHA98HwRVvHnhVxswYqznuvq', '[]', NULL, '', 1),
(10, 'azefaze', 'aezfazefa', 'zaefaz', '13254658', 'test@test.testo', '$2y$13$Be9Dw2fpQoFPqCJP.broYunFFMJFK2wp2ZXQQb5juc3IIm1BVuPnG', '[]', NULL, '', 2),
(11, 'azejzhbgeazfeertzny', 'arnhbgvff', 'bazrbtnrtbe', '841615', 'azefzafazf@zefazefgazga', '$2y$13$Be9Dw2fpQoFPqCJP.broYunFFMJFK2wp2ZXQQb5juc3IIm1BVuPnG', '[]', NULL, '', 3),
(12, 'zaegfh', 'gag', 'agzga', '4984651', 'azfazfza@afzfafz', '$2y$13$vBkFy3KLr8mWVpM8oK8OH.7IsyyEQtHYK3HgzhtWXONPscRL4Pm.C', '[]', NULL, '', 3),
(13, 'Gege', 'Depardieu', 'Gerard', '0245036910', 'gerard@depardieu.fr', 'gerard', '[]', NULL, NULL, 1),
(14, 'didier', 'didier', 'didier', 'didier', 'didier', 'didier', '[]', NULL, NULL, 2),
(15, 'lol', 'lol', 'lol', '0223232232', 'lol', 'lol', '[]', NULL, 'gitan-62b47584ca602.jpg', 1),
(16, 'azefaz', 'fazfaz', 'fazfaze', 'fazefaz', 'afzafa@afzefzeaf', '$2y$13$6vjn/uR9tbjTi7FuuMFaduwtnpYCF/jikjz2a4H/iwGS8J.xrt.Cq', '[]', NULL, NULL, 1),
(17, 'azgazaga', 'zagfazg', 'gzgazg', 'azgazg', 'azgag', '$2y$13$1xKT5q/TH7qF2GESG.mOl.kmCXzcPqykZQarniUVgU29kI2IKEw/q', '[]', NULL, NULL, 1),
(18, 'looser', 'looser', 'looser', '23223223', 'looser', 'looser', '[]', NULL, 'didier-62b47dc123492.jpg', 1),
(19, 'Toto', 'toto', 'toto', 'sdfsdf', 'toto@toto', '$2y$13$/2wzwYOtPqhGORdPrkOBb.jn4xOWqD1ER/8wHPMI.RiKqF9uk99yO', '[]', NULL, 'telechargement-62b4834164e63.jpg', 2),
(20, 'Bob', 'Bob', 'Bob', '1223232322', 'bob@bob.fr', '$2y$13$1Xvafco7H6yLROu8ZjIcAeMcXWLpBUuveG8wyzPfkLRwUhdAKryYS', '[]', NULL, 'bob-62b56b2bafad5.jpg', 3);

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
(1, 'After V&B', '2022-06-18 02:00:00', 90, '2022-06-17 04:04:00', 100, 'chiasse2', 'https://www.femmeactuelle.fr/sante/news-sante/vue-mer-ameliore-moral-29734', 1, 1, 7),
(2, 'After au Run', '2022-06-24 17:00:00', 90, '2022-06-20 16:17:50', 50, 'vous connaissez pas le Run ?', NULL, 1, 2, 3),
(15, 'Teuf avec Adeline', '2023-05-09 00:00:00', 90, '2023-05-06 00:00:00', 50, '', NULL, 5, 2, 7),
(17, 'Visite d\'un ephad', '2017-01-01 00:00:00', 5656, '2017-01-01 00:00:00', 52, 'Rencontre avec des personnes agées', NULL, 1, 1, 6),
(18, 'bowling', '2017-01-01 00:00:00', 535353, '2017-01-01 00:00:00', 23, 'aaeeaeeae', NULL, 4, 1, 6),
(24, 'Fête de la musique', '2022-06-03 11:05:00', 1, '2022-06-22 11:08:00', 1, 'RTHT', NULL, 1, 1, 3),
(25, 'terg', '2022-06-12 11:06:00', 1, '2022-06-21 11:07:00', 1, 'teger', NULL, 1, 1, 3),
(26, 'afaz', '2022-06-30 15:37:00', 30, '2022-06-28 15:37:00', 25, 'azezfazegazrgff', NULL, 1, 1, 1),
(27, 'new', '2022-06-21 16:14:00', 55, '2022-06-24 16:11:00', 5, 'flemme', NULL, 1, 1, 7),
(28, 'Fête de la musique', '2022-06-21 16:36:00', 1, '2022-06-21 16:38:00', 1, 'rfzrefze', NULL, 1, 1, 3),
(29, 'azefgazevfasdfa', '2022-06-30 15:05:00', 8, '2022-06-28 15:05:00', 7, '', NULL, 5, 2, 7),
(30, 'Ballade à Gouesnach', '2022-06-25 12:23:00', 15, '2022-06-26 12:23:00', 24, 'Suivie d\'un repas gastronomique chez Phileas', NULL, 1, 1, 1),
(31, 'Fête de la musique', '2022-06-16 15:21:00', 2, '2022-06-23 15:23:00', 2, 'è_ooè_o', NULL, 1, 1, 1),
(32, 'Pique nique', '2022-06-25 19:51:00', 180, '2022-06-24 19:51:00', 10, 'A la plage de kerambigorn', NULL, 1, 1, 1),
(33, 'azfzaefaz', '2022-06-28 09:00:00', 52, '2022-06-30 09:00:00', 8, 'azvgubhi', NULL, 1, 2, 1),
(34, 'zzefzefzefzef', '2022-06-26 09:59:00', 100, '2022-06-25 09:59:00', 10, 'ergerate', NULL, 1, 1, 1);

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`no_ville`, `nom_ville`, `code_postal`) VALUES
(1, 'Chateaulin', '29150'),
(2, 'Quimper', '29000'),
(3, 'Brest', '29100'),
(5, 'Morlaix', '29600'),
(6, 'Pleyben', '29190');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
