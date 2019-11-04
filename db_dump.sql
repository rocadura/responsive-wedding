-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.6.13 - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para wedding
DROP DATABASE IF EXISTS `wedding`;
CREATE DATABASE IF NOT EXISTS `wedding` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `wedding`;

-- Volcando estructura para tabla wedding.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` char(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla wedding.foods
DROP TABLE IF EXISTS `foods`;
CREATE TABLE IF NOT EXISTS `foods` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` char(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla wedding.invitations
DROP TABLE IF EXISTS `invitations`;
CREATE TABLE IF NOT EXISTS `invitations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(255) NOT NULL,
  `Email` char(255) NOT NULL,
  `UniqueKey` char(8) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Send` timestamp NULL DEFAULT NULL,
  `Open` timestamp NULL DEFAULT NULL,
  `OpenedTimes` int(5) DEFAULT NULL,
  `OptionalText` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `UniqueKey` (`UniqueKey`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla wedding.guests
DROP TABLE IF EXISTS `guests`;
CREATE TABLE IF NOT EXISTS `guests` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Invitation` int(11) unsigned NOT NULL,
  `Name` char(255) NOT NULL,
  `Id_Food` int(11) DEFAULT NULL,
  `Id_Category` int(11) DEFAULT NULL,
  `Accept` int(1) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Food` (`Id_Food`),
  KEY `Category` (`Id_Category`),
  KEY `Invitation` (`Id_Invitation`),
  CONSTRAINT `Category` FOREIGN KEY (`Id_Category`) REFERENCES `categories` (`Id`),
  CONSTRAINT `Food` FOREIGN KEY (`Id_Food`) REFERENCES `foods` (`Id`),
  CONSTRAINT `Invitation` FOREIGN KEY (`Id_Invitation`) REFERENCES `invitations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para vista wedding.overview
DROP VIEW IF EXISTS `overview`;
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `overview` (
	`Id` INT(11) NOT NULL,
	`Id_Invitation` INT(11) UNSIGNED NOT NULL,
	`Name` CHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`SendTo` CHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`UniqueKey` CHAR(8) NULL COLLATE 'latin1_swedish_ci',
	`Created` TIMESTAMP NULL,
	`Send` TIMESTAMP NULL,
	`Open` TIMESTAMP NULL,
	`Accept` INT(1) NULL,
	`Id_Food` INT(11) NULL,
	`Food` CHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`Category` CHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`OpenedTimes` INT(5) NULL
) ENGINE=MyISAM;

-- Volcando estructura para vista wedding.overview
DROP VIEW IF EXISTS `overview`;
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `overview`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `overview` AS SELECT
	Guest.Id,
	Guest.Id_Invitation,
	Guest.Name,
	Invitation.Email as `SendTo`,
	Invitation.UniqueKey,
	Invitation.Created,
	Invitation.Send,
	Invitation.Open,
	Guest.Accept,
	Food.Id as `Id_Food`,
	Food.Name as `Food`,
	Category.Name as `Category`,
	Invitation.OpenedTimes

FROM `guests` as `Guest`
	LEFT JOIN `invitations` as `Invitation`
		ON Invitation.Id = Guest.Id_Invitation
	LEFT JOIN `foods` as `Food`
		ON Food.Id = Guest.Id_Food
	LEFT JOIN `categories` as `Category`
		ON Category.Id = Guest.Id_Category ;

-- Volcando datos para la tabla wedding.categories: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`Id`, `Name`) VALUES
	(1, 'Cat_1'),
	(2, 'Cat_2'),
	(3, 'Cat_3'),
	(4, 'Cat_4'),
	(5, 'Cat_5');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Volcando datos para la tabla wedding.foods: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `foods` DISABLE KEYS */;
INSERT INTO `foods` (`Id`, `Name`) VALUES
	(1, 'Food_1'),
	(2, 'Food_2'),
	(3, 'Food_3'),
	(4, 'Food_4');
/*!40000 ALTER TABLE `foods` ENABLE KEYS */;
