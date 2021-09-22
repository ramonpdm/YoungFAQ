-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2021 at 07:27 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `youngfaq`
--
CREATE DATABASE IF NOT EXISTS `youngfaq` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `youngfaq`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `slug` text NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT IGNORE INTO `categories` (`id`, `name`, `slug`, `count`) VALUES
(1, 'Anuncios', 'ads', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_topic` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT IGNORE INTO `comments` (`id`, `id_topic`, `id_user`, `content`, `date_created`, `status`) VALUES
(1, 1, 1, 'Este es un mensaje!!!', '2021-09-21 00:33:08', 'published');

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE IF NOT EXISTS `relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_object` int(11) NOT NULL,
  `id_topic` int(11) NOT NULL,
  `type` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `relation`
--

INSERT IGNORE INTO `relation` (`id`, `id_object`, `id_topic`, `type`) VALUES
(1, 1, 1, 'ads');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `comments` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics`
--

INSERT IGNORE INTO `topics` (`id`, `id_user`, `title`, `content`, `date_created`, `comments`, `views`, `status`) VALUES
(1, 1, '¡Bienvenidos nuevos usuarios!', 'Bienvenidos todos a YoungFAQ el foro donde podrán listar todas las dudas que tengan concernientes a los temas que son tratados e impartidos aquí por nuestros preparados y calificados docentes.', '2021-09-20 21:50:31', 1, 0, 'published'),
(2, 1, 'Hoy es un buen día para correr', 'Bienvenidos todos a YoungFAQ el foro donde podrán listar todas las dudas que tengan concernientes a los temas que son tratados e impartidos aquí por nuestros preparados y calificados docentes.', '2021-09-22 01:07:44', 0, 0, 'published'),
(3, 1, 'Ayuda: duda con una silla que tengo que no funciona', 'Es muy molesto', '2021-09-22 01:14:51', 0, 0, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT IGNORE INTO `users` (`id`, `username`, `name`, `email`, `password`, `level`) VALUES
(1, 'ramonpdm', 'Ramón Perdomo', 'inoelperdomo@gmail.com', 'adm12345', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
