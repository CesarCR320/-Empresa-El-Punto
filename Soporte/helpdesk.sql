-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-03-2025 a las 05:27:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `helpdesk`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `e_id` int(11) NOT NULL,
  `e_name` varchar(200) DEFAULT NULL,
  `e_last` varchar(200) DEFAULT NULL,
  `e_mail` varchar(200) NOT NULL,
  `e_pass` varchar(64) NOT NULL,
  `e_creat` datetime DEFAULT NULL,
  `e_mod` datetime DEFAULT NULL,
  `e_del` datetime DEFAULT NULL,
  `stat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de empleados';

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`e_id`, `e_name`, `e_last`, `e_mail`, `e_pass`, `e_creat`, `e_mod`, `e_del`, `stat`) VALUES
(1, 'Administrador', NULL, 'admin@laughingmantech.com', '123456', '2025-03-26 20:00:00', NULL, NULL, 1),
(2, 'Alejandro', 'Villaseñor', 'a.villasenor@laughingmantech.com', '123456', '2025-03-26 20:00:00', NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`e_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
