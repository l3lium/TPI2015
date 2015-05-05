-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 01 Mai 2015 à 18:23
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `visiolocbdd`
--
CREATE DATABASE IF NOT EXISTS `visiolocbdd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `visiolocbdd`;

-- --------------------------------------------------------

--
-- Structure de la table `actors`
--

DROP TABLE IF EXISTS `actors`;
CREATE TABLE IF NOT EXISTS `actors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(64) NOT NULL,
  `lastName` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `creators`
--

DROP TABLE IF EXISTS `creators`;
CREATE TABLE IF NOT EXISTS `creators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(64) NOT NULL,
  `lastName` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` varchar(2) NOT NULL,
  `label` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `date` date NOT NULL,
  `imgSrc` varchar(255) NOT NULL,
  `videoSrc` varchar(255) NOT NULL,
  `synopsis` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `movies_has_actors`
--

DROP TABLE IF EXISTS `movies_has_actors`;
CREATE TABLE IF NOT EXISTS `movies_has_actors` (
  `idMovie` int(11) NOT NULL,
  `idPerson` int(11) NOT NULL,
  PRIMARY KEY (`idMovie`,`idPerson`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `movies_has_creators`
--

DROP TABLE IF EXISTS `movies_has_creators`;
CREATE TABLE IF NOT EXISTS `movies_has_creators` (
  `idMovie` int(11) NOT NULL,
  `idPerson` int(11) NOT NULL,
  PRIMARY KEY (`idMovie`,`idPerson`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `movies_has_keywords`
--

DROP TABLE IF EXISTS `movies_has_keywords`;
CREATE TABLE IF NOT EXISTS `movies_has_keywords` (
  `idMovie` int(11) NOT NULL,
  `idKeyword` int(11) NOT NULL,
  PRIMARY KEY (`idMovie`,`idKeyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `movies_has_subtitles`
--

DROP TABLE IF EXISTS `movies_has_subtitles`;
CREATE TABLE IF NOT EXISTS `movies_has_subtitles` (
  `idMovie` int(11) NOT NULL,
  `idSubtitle` int(11) NOT NULL,
  `idLanguage` int(11) NOT NULL,
  PRIMARY KEY (`idMovie`,`idSubtitle`,`idLanguage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `subtitles`
--

DROP TABLE IF EXISTS `subtitles`;
CREATE TABLE IF NOT EXISTS `subtitles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subSrc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `temporary` tinyint(1) NOT NULL DEFAULT '0',
  `userType` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Structure de la table `users_has_movies`
--

DROP TABLE IF EXISTS `users_has_movies`;
CREATE TABLE IF NOT EXISTS `users_has_movies` (
  `idUser` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `location` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUser`,`idMovie`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
