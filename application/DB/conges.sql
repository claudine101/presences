-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 23, 2024 at 07:09 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `receca_presence`
--

-- --------------------------------------------------------

--
-- Table structure for table `conges`
--

DROP TABLE IF EXISTS `conges`;
CREATE TABLE IF NOT EXISTS `conges` (
  `ID_CONGE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_UTILISATEUR` int(11) NOT NULL,
  `DATE_CONGE` date NOT NULL,
  `ID_MOTIF` int(11) NOT NULL,
  `periode` varchar(10) NOT NULL DEFAULT 'PM',
  PRIMARY KEY (`ID_CONGE`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `conges`
--

INSERT INTO `conges` (`ID_CONGE`, `ID_UTILISATEUR`, `DATE_CONGE`, `ID_MOTIF`, `periode`) VALUES
(1, 2, '2024-08-20', 3, 'AM'),
(2, 2, '2024-08-23', 1, 'PM'),
(3, 2, '2024-08-23', 1, 'AM'),
(4, 43, '2024-08-23', 2, 'AM'),
(5, 42, '2024-08-23', 3, 'PM'),
(6, 42, '2024-08-23', 3, 'AM'),
(7, 43, '2024-08-23', 4, 'AM'),
(8, 42, '2024-08-23', 5, 'PM'),
(9, 42, '2024-08-23', 5, 'AM');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
