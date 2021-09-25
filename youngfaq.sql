-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2021 a las 18:10:43
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `youngfaq`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `id_topic` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `id_topic`, `id_category`, `name`) VALUES
(1, 1, 1, 'Presentación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `id_topic` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` text NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `reviewed_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `id_topic`, `id_user`, `content`, `date_created`, `status`, `reviewed_by`, `reviewed_date`) VALUES
(1, 1, 2, 'Bienvenido seas Ramón.', '2021-09-25 11:26:29', 'approved', 0, '2021-09-25 11:26:29'),
(2, 1, 3, 'Buenas Ramón! Hiciste un buen trabajo, solo debes mejorar ciertas cosas.', '2021-09-25 11:27:25', 'approved', 2, '2021-09-25 11:27:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `status` text NOT NULL,
  `reason` text NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `reviewed_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `topics`
--

INSERT INTO `topics` (`id`, `id_user`, `title`, `content`, `date_created`, `status`, `reason`, `reviewed_by`, `reviewed_date`) VALUES
(1, 1, 'Mi presentación', 'Muy buenas a todos. Para que no me saquen:\r\n<br>\r\nMi nombre es el que indica mi usario, Ramón Perdomo. Soy Coordinador de Gestión del SGC de un Laboratorio de Calibración de una empresa específica, y también soy Coordinador de Marketing y Publicidad de la misma empresa.\r\n<br>\r\nTengo 18 años de edad. Me ha interesado la programación desde los 13 años aprox. tengo conocimientos básicos pero muy variados en muchas áreas, todos empíricos. Mi fuerte es la programación en el lenguaje PHP. Según tengo entendido este es el curso de WordPress (?) y luego será el de PHP (o algo así); agradecería la aclaratoria. Me emociona el hecho de poder aprender y compartir los conocimientos con más personas. Síganme en Instagram @RamonPDM.\r\n<br>\r\nY exijo que <b>Kelvin Encarnación</b> haga una presentación más adecuada que decir \"Soy kelvin\" (broma). Que falta de respeto. \r\n<br>\r\nSaludos a todos! ', '2021-09-25 11:18:34', 'approved', '', 2, '2021-09-25 11:26:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `level`) VALUES
(1, 'ramonpdm', 'Ramón Perdomo', 'inoelperdomo@gmail.com', '1234', ''),
(2, 'einer', 'Kelvin Encarnación', 'einer@einer.com', '1234', '1'),
(3, 'frica', 'Ismael Frica', 'ismael@ismaelfrica.net', '1234', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
