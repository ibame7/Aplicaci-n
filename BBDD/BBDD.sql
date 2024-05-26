-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-05-2024 a las 15:56:15
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
-- Base de datos: `reservayjuega`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `admin`) VALUES
(4, 'admin1'),
(5, 'admin2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumidor`
--

CREATE TABLE `consumidor` (
  `id` int(11) NOT NULL,
  `reservas_realizadas` int(11) DEFAULT NULL,
  `consumidor` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumidor`
--

INSERT INTO `consumidor` (`id`, `reservas_realizadas`, `consumidor`) VALUES
(10, 3, 'ibame'),
(11, 1, 'joseant'),
(12, 2, 'locas99');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `correo` varchar(140) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `mensaje` varchar(240) NOT NULL,
  `estado` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `nombre`, `correo`, `telefono`, `mensaje`, `estado`) VALUES
(1234, 'Juan', 'juan@gmail.com', '675981230', 'Hola buenas, me gustaría tener información para unirme a vosotros ', 'sin responder'),
(12345, 'Pepe', 'pepe@gmail.com', '644654784', 'Hola buenas, me gustaría tener información acerca de la reserva de pistas deportiva', 'sin responder'),
(20558, 'ismael', 'ismael@gmail.com', '654384932', 'Quiero trabajar con ustedes', 'Finalizado'),
(21645, 'samuel', 'samuel@gmail.com', '634987235', 'Hola buenas tardes, me gustaria saber informacion acerca de cancelar reservas', 'Finalizado'),
(76466, 'manuel', 'manuel@gmail.com', '654654654', 'Me gustaria que me llamaseis', 'sin responder');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pista`
--

CREATE TABLE `pista` (
  `id` varchar(6) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `deporte` varchar(50) NOT NULL,
  `precio` double NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `propietario` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pista`
--

INSERT INTO `pista` (`id`, `nombre`, `deporte`, `precio`, `activo`, `propietario`) VALUES
('ara1', 'Polideportivo Municipal de Arahal', 'Futbol', 8.5, 1, 'arahal123'),
('ara2', 'Polideportivo Municipal de Arahal', 'Baloncesto', 6, 0, 'arahal123'),
('ara3', 'Club Tenis Nadal Arahal', 'Tenis', 12, 1, 'arahal123'),
('ara4', 'Cyan Padel', 'Padel', 4, 0, 'arahal123'),
('mar1', 'Polideportivo Miguelete', 'Futbol', 10, 1, 'marchena123'),
('mar2', 'Polideportivo Municipal Marchena', 'Tenis', 7, 1, 'marchena123'),
('mar3', 'Club Camino Hondo', 'Baloncesto', 10, 0, 'marchena123'),
('mar4', 'Club San Ginés', 'Futbol Sala', 10, 1, 'marchena123'),
('mor1', 'Polideportivo Municipal Morón de la Frontera', 'Padel', 5, 1, 'moron123'),
('mor2', 'Polideportivo Municipal Morón de la Frontera', 'Tenis', 8, 1, 'moron123'),
('mor3', 'Polideportivo Municipal Morón de la Frontera', 'Futbol', 9, 1, 'moron123'),
('mor4', 'Polideportivo Municipal Morón de la Frontera', 'Futbol', 9, 1, 'moron123'),
('mor5', 'Polideportivo Municipal Morón de la Frontera', 'Futbol', 15, 1, 'moron123'),
('par1', 'Pabellón Municipal José Martínez', 'Balonmano', 6, 0, 'paradas123'),
('par2', 'Complejo Deportivo ParadasCity', 'Baloncesto', 5, 1, 'paradas123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietario`
--

CREATE TABLE `propietario` (
  `id` int(11) NOT NULL,
  `propietario` varchar(15) DEFAULT NULL,
  `pueblo` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propietario`
--

INSERT INTO `propietario` (`id`, `propietario`, `pueblo`) VALUES
(4, 'arahal123', 'Arahal'),
(5, 'marchena123', 'Marchena'),
(6, 'paradas123', 'Paradas'),
(7, 'moron123', 'Morón de la Frontera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL,
  `fecha_start` datetime NOT NULL,
  `fecha_finish` datetime NOT NULL,
  `importe` double NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `comentario` varchar(120) NOT NULL,
  `consumidor` int(11) NOT NULL,
  `pista` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `fecha_start`, `fecha_finish`, `importe`, `puntuacion`, `comentario`, `consumidor`, `pista`) VALUES
(1234, '2024-05-21 20:00:00', '2024-05-21 21:00:00', 8.5, 3, 'La pista no está en muy buen estado que digamos', 11, 'ara1'),
(1245, '2024-05-20 16:00:00', '2024-05-20 17:00:00', 10, 5, 'Todo perfecto', 10, 'mar3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `username` varchar(15) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido1` varchar(20) NOT NULL,
  `apellido2` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasenia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`username`, `nombre`, `apellido1`, `apellido2`, `correo`, `contrasenia`) VALUES
('admin1', 'antonio david', 'ibañez', 'medina', 'antonio@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
('admin2', 'ismael', 'ontanilla', 'gonzalez', 'ismael@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
('arahal123', 'maria', 'hidalgo', 'castro', 'maria@gmail.com', '050ae231c1026f05b3f9c0c4a8b0b57815d24c6d692957bd4a04410ab709b6a6'),
('ibame', 'antonio', 'perez', 'nuñez', 'ibame@gmail.com', 'dedaed504e5a3ac42e3b822ea71d446bcddcde09eca7e4c2ee798c90dc731c79'),
('joseant', 'jose antonio', 'rosales', 'giron', 'jose@gmail.com', '4fd12708b364bbf86cfbd003813bbc07d9bd2becef67cdf79d7a72fad89cd5f8'),
('locas99', 'luis', 'lopez', 'castillo', 'luis@gmail.com', '14a1667f2c7080d808354a9a0aeb90b01af4bbc1cc99aa159740e752fcb6dee3'),
('marchena123', 'juan', 'lopez', 'martinez', 'juan@gmail.com', 'e6973f2059ab617e6e2ea0dba1184e062d9ba56b74d2b7ba2d0e4a3463a00f09'),
('moron123', 'alberto', 'rodriguez', 'españa', 'alberto@gmail.com', '110c6c5a86fa0de59f9170494cb9841e767243e1f611bb6c513b86e4641284c8'),
('paradas123', 'ernesto', 'arispon', 'gutierrez', 'ernesto@gmail.com', '3824d2853cc5f643dcb4d5149c7de1ee37d168642ddd53b87365aee36da2348f');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin` (`admin`);

--
-- Indices de la tabla `consumidor`
--
ALTER TABLE `consumidor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consumidor` (`consumidor`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pista`
--
ALTER TABLE `pista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `propietario` (`propietario`);

--
-- Indices de la tabla `propietario`
--
ALTER TABLE `propietario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `propietario` (`propietario`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `consumidor` (`consumidor`),
  ADD KEY `pista` (`pista`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `consumidor`
--
ALTER TABLE `consumidor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `propietario`
--
ALTER TABLE `propietario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=324313;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`admin`) REFERENCES `user` (`username`);

--
-- Filtros para la tabla `consumidor`
--
ALTER TABLE `consumidor`
  ADD CONSTRAINT `consumidor_ibfk_1` FOREIGN KEY (`consumidor`) REFERENCES `user` (`username`);

--
-- Filtros para la tabla `pista`
--
ALTER TABLE `pista`
  ADD CONSTRAINT `pista_ibfk_1` FOREIGN KEY (`propietario`) REFERENCES `propietario` (`propietario`);

--
-- Filtros para la tabla `propietario`
--
ALTER TABLE `propietario`
  ADD CONSTRAINT `propietario_ibfk_1` FOREIGN KEY (`propietario`) REFERENCES `user` (`username`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`consumidor`) REFERENCES `consumidor` (`id`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`pista`) REFERENCES `pista` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
