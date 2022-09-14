-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 08 sep. 2022 à 17:04
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Structure de la table `blogpost`
--

DROP TABLE IF EXISTS `blogpost`;
CREATE TABLE IF NOT EXISTS `blogpost` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idAuthor` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `publishedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastUpdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isPublished` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idAuthor` (`idAuthor`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `commentary`
--

DROP TABLE IF EXISTS `commentary`;
CREATE TABLE IF NOT EXISTS `commentary` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idBlogpost` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `commentary` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValidated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idBlogPost` (`idBlogpost`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO `users`(`email`, `password`, `firstname`, `lastname`, `isAdmin`) VALUES ('admin@admin.com','$2y$10$JOPQLFAvGbPcU19Z.JvFZee7OliOtJRgUc4YDHgtpkcUiA5rsM.ey','admin','admin','1')