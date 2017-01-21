-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2017 at 06:19 PM
-- Server version: 5.6.31-0ubuntu0.15.10.1
-- PHP Version: 5.6.11-1ubuntu3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gesticole`
--

-- --------------------------------------------------------

--
-- Table structure for table `acceso`
--

CREATE TABLE IF NOT EXISTS `acceso` (
  `usuario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acceso`
--

INSERT INTO `acceso` (`usuario`, `clave`, `tipo`) VALUES
('admin', '123456', 'administra'),
('root', 'toor', 'profesor'),
('tux', 'linux', 'profesor'),
('usuario', 'usuario', 'alumno');

-- --------------------------------------------------------

--
-- Table structure for table `actividad`
--

CREATE TABLE IF NOT EXISTS `actividad` (
  `idActividad` int(11) NOT NULL,
  `nomActiv` varchar(15) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `actividad`
--

INSERT INTO `actividad` (`idActividad`, `nomActiv`) VALUES
(1, 'Zumba'),
(2, 'Judo'),
(3, 'Baile'),
(4, 'Futbol'),
(5, 'Hockey');

-- --------------------------------------------------------

--
-- Table structure for table `alumno`
--

CREATE TABLE IF NOT EXISTS `alumno` (
  `dni` varchar(9) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `colegio` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `edad` date NOT NULL,
  `curso` int(2) NOT NULL,
  `idActividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `alumno`
--

INSERT INTO `alumno` (`dni`, `nombre`, `colegio`, `edad`, `curso`, `idActividad`) VALUES
('12345678B', 'Pedro', 'Colegio Las Flores', '2008-06-09', 3, 5),
('12345678P', 'Rosa', 'Colegio Las Flores', '2008-06-09', 3, 3),
('12345678Z', 'Olga', 'Colegio de Primaria', '2006-06-06', 4, 1),
('12345679P', 'Blanco', 'Colegio Las Flores', '2008-06-10', 3, 5),
('12356892K', 'Alexia', 'Colegio de Primaria', '2006-09-09', 2, 3),
('12745632K', 'Alejandro', 'Colegio de Primaria', '2006-09-09', 2, 1),
('2368995P', 'Ricardo', 'Colegio de Secundaria', '2017-01-19', 2, 4),
('252582525', 'Angel', 'Colegio Los Jarales', '2010-02-25', 1, 4),
('252582527', 'Lucas', 'Colegio Los Jarales', '2010-02-26', 1, 4),
('35869756K', 'Amapola', 'Colegio Las Flores', '2007-01-14', 4, 5),
('35869757K', 'Lucia', 'Colegio Las Flores', '2006-12-07', 4, 5),
('784591263', 'Gabriel', 'El leon trece', '2007-07-08', 4, 1),
('8459126', 'Raquel', 'Los Jarales', '2010-02-25', 1, 2),
('88888888S', 'Sofía', 'Colegio Los Jarales', '2008-03-18', 3, 2),
('98745612K', 'Rocio Caballero Galante', 'Colegio de Primaria', '2006-07-09', 2, 1),
('98745632K', 'Mario', 'Colegio de Primaria', '2006-09-09', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `castillo`
--

CREATE TABLE IF NOT EXISTS `castillo` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) COLLATE utf8_bin NOT NULL,
  `imagen` varchar(100) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(500) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `castillo`
--

INSERT INTO `castillo` (`id`, `titulo`, `imagen`, `descripcion`) VALUES
(3, 'Castillo Mediano Rosa', 'castillo3.jpg', 'Castillo de tamaño medio con dos pasarelas de entrada y salida.'),
(27, 'hla', '', '                '),
(29, 'Castillo azul', 'logo2.jpg', '                Probando');

-- --------------------------------------------------------

--
-- Table structure for table `profesor`
--

CREATE TABLE IF NOT EXISTS `profesor` (
  `dni` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `actividad` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `profesor`
--

INSERT INTO `profesor` (`dni`, `nombre`, `direccion`, `telefono`, `actividad`) VALUES
('12345678A', 'Jose Antonio Flores Camp', 'C/Rosas Rojas, s/n, 29000, Malaga', '600123476', 'futbol'),
('123546', 'Adoc', 'Polo Norte', '123', 'baile'),
('23456789B', 'Almudena Vera Fernandez', 'C/Rio Seco, s/n, 29000, Malaga', '600234567', 'baile'),
('34567890C', 'Alejandro Risas Misas', 'Avda. del Manantial, s/n, 29000, Malaga', '600345678', 'hockey');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indexes for table `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`idActividad`),
  ADD UNIQUE KEY `actividad` (`idActividad`);

--
-- Indexes for table `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD KEY `idActividad` (`idActividad`);

--
-- Indexes for table `castillo`
--
ALTER TABLE `castillo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`dni`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actividad`
--
ALTER TABLE `actividad`
  MODIFY `idActividad` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `castillo`
--
ALTER TABLE `castillo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
