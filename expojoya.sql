-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2025 a las 20:36:55
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
-- Base de datos: `expojoya`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `no_cliente` varchar(50) NOT NULL,
  `nom_completo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `colonia` varchar(50) NOT NULL,
  `no_ext` varchar(10) NOT NULL,
  `no_int` varchar(10) DEFAULT NULL,
  `requiere_factura` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `no_cliente`, `nom_completo`, `telefono`, `calle`, `estado`, `ciudad`, `municipio`, `pais`, `colonia`, `no_ext`, `no_int`, `requiere_factura`) VALUES
(1, '987', 'OOOOOOO', '5651478523', 'Av', 'Jalisco', 'Guadalajara', 'Guadalajara', 'Mexico', 'Centro', '5', '2', 1),
(2, '54', 'QWERTY', '1111111111', 'Av jUAREZ', 'Jalisco', 'Guadalajara', 'Guadalajara', 'Mexico', 'Centro', '5', '2', 1),
(8, '54654d', 'fff', '5651478523', 'Av', 'Jalisco', 'dsada', 'Guadalajara', 'dasas', 'Centro', '5', '1', 1),
(12, '541', 'Nose', '5651478523', 'Av', 'Jalisco', 'Guadalajara', 'Guadalajara', 'Mexico', 'Centro', '5', '2', 1),
(13, '145', 'Nose', '5651478523', 'Av', 'Jalisco', 'Guadalajara', 'Guadalajara', 'Mexico', 'Centro', '5', '2', 0),
(14, '9874', 'Rodrigo', '7894561235', 'av callse', 'Jalisco', 'Guadalajara', 'Guadalajara', 'Mexico', 'san juan', '7', '7', 1),
(17, '55555', 'DAS', 'DAS', 'DAS', 'DSA', 'DSA', 'DSA', 'DSA', 'DSA', 'DSA', 'DAS', 0),
(18, '', '', '', '', '', '', '', '', '', '', NULL, 1),
(20, '0920', 'Diego Lorenzo Mendez', '9191234545', 'Av Juarez', 'Jalisco', 'Guadalajara', 'Guadalajara', 'Mexico', 'Centro', '28', '40', 1),
(23, '54654', 'Diego Lorenzo', '5651478523', 'Av', 'dsa', 'das', 'sdffsd', 'dsa', 'das', '1', '2', 0),
(25, '95', 'quien sabe', '7894567854', 'sdf', 'asa', 'dasa', 'dasas', 'fdsd', 'das', '4', '4', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion`
--

CREATE TABLE `facturacion` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `regimen_fiscal` varchar(50) NOT NULL,
  `uso_cfdi` varchar(50) NOT NULL,
  `codigo_postal` varchar(5) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `es_cliente_nuevo` tinyint(1) DEFAULT 0,
  `como_nos_conocio` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturacion`
--

INSERT INTO `facturacion` (`id`, `cliente_id`, `razon_social`, `rfc`, `regimen_fiscal`, `uso_cfdi`, `codigo_postal`, `correo`, `es_cliente_nuevo`, `como_nos_conocio`) VALUES
(1, 2, 'hjgjhg', 'loqweasdfs123', 'Régimen General', 'Adquisición de mercancías', '44444', 'AAA@gmailcom', 0, ''),
(2, 8, 'hjgjhg', 'loqweasdfs123', 'Régimen Simplificado', 'Gastos en general', '44100', 'nose@gmailcom', 0, ''),
(3, 12, 'hjgjhg', 'loqweasdfs123', 'Régimen Simplificado', 'Adquisición de mercancías', '44100', 'nose@gmailcom', 0, ''),
(4, 1, 'hjgjhg', 'loqweasdfs123', 'Régimen General', 'Adquisición de mercancías', '11111', 'nose@gmailcom', 0, ''),
(5, 14, 'Social', 'loqweasdfs123', 'Régimen General', 'Gastos en general', '44100', 'RRRRRR@gmailcom', 1, 'Publicidad'),
(6, 20, 'Persona', 'red144458124', 'Régimen General', 'Gastos en general', '44100', 'diego@gmailcom', 1, 'Redes Sociales'),
(7, 18, 'razon', 'loqweasdfs123', 'Régimen Simplificado', 'Servicios profesionales', '11111', 'nose@gmailcom', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `usuario`, `email`, `password`, `id_cargo`) VALUES
(2, 'test', 'test@expojoya.com', '$2y$10$6toczh6DgRgCBuWVfRCwjOgAsgJPD2Egkch0/Toauu3a6ZLKYEDhe', 1),
(4, 'ventas', 'vendedor@expojoya.com', '$2y$10$ZnMHODr8la7qUYslcHO7Z.rs1Pz0E3xf7flbt4WRrtK3MtG7duASq', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `privilegio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `privilegio`) VALUES
(1, 'Admin'),
(2, 'Asesora');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_cliente` (`no_cliente`);

--
-- Indices de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_rol` (`id_cargo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD CONSTRAINT `facturacion_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`id_cargo`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
