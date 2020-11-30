-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2020 a las 00:59:11
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tpcomandautn`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `usuario`, `clave`) VALUES
(23, 'Paloma', 'Lagandara', 'PLagandara', '$2y$10$uEpVaOjIWZ41Cb0LiWr7TOyV/RpXYcarts/uYEWOHkxy0Y9k5o1Re'),
(24, 'Paloma', 'Lagandara', 'PLagandara', '$2y$10$2vHrFw957MrWjpdW4T9TiuMUN2o1xfMT2doDTkO/49NVqbAhXZAO.'),
(25, 'Eric', 'Gimenez', 'EGimenez', '$2y$10$UrlHFXYnugUBrV2NOgdcL.iU8SuGvDCKn.KIBlLWQstPJALPOaWRy');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  `id_sector` int(11) NOT NULL,
  `operaciones` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `tipo`, `nombre`, `apellido`, `disponible`, `id_sector`, `operaciones`, `id_estado`) VALUES
(40, 'cocinero', 'Enrique', 'Lux', 1, 3, 1, 1),
(41, 'mozo', 'Cesar', 'Martinez', 0, 4, 1, 1),
(42, 'cervecero', 'Nix', 'Martinez', 1, 2, 3, 1),
(43, 'mozo', 'Carlos', 'Hex', 0, 4, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_empleados`
--

CREATE TABLE `estado_empleados` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_empleados`
--

INSERT INTO `estado_empleados` (`id`, `descripcion`) VALUES
(1, 'ACTIVO'),
(2, 'SUSPENDIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_mesa`
--

CREATE TABLE `estado_mesa` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_mesa`
--

INSERT INTO `estado_mesa` (`id`, `descripcion`) VALUES
(1, 'con cliente esperando pedido'),
(2, 'con clientes comiendo'),
(3, 'con clientes pagando'),
(4, 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedido`
--

CREATE TABLE `estado_pedido` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_pedido`
--

INSERT INTO `estado_pedido` (`id`, `descripcion`) VALUES
(1, 'PENDIENTE'),
(2, 'EN PREPARACION'),
(3, 'LISTO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tiempoEstimado` time NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id`, `descripcion`, `created_at`, `updated_at`, `tiempoEstimado`, `id_pedido`, `id_empleado`) VALUES
(82, 'cerveza', '2020-11-30 02:12:57', '2020-11-30 03:11:46', '00:00:00', 77, 42),
(83, 'cerveza', '2020-11-30 03:33:27', '2020-11-30 03:39:23', '00:00:00', 78, 42),
(84, 'mani', '2020-11-30 03:33:27', '2020-11-30 03:33:27', '00:00:00', 78, 43),
(85, 'cerveza', '2020-11-30 03:41:39', '2020-11-30 03:43:43', '00:00:00', 79, 42),
(86, 'empanadas', '2020-11-30 03:41:39', '2020-11-30 03:43:43', '00:00:00', 79, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `codigo` varchar(5) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `descripcion`, `codigo`, `id_estado`) VALUES
(21, 'Mesa', '93021', 3),
(31, 'Mesa familiar', '98339', 4),
(32, 'Mesa VIP', '23689', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `tiempo` time NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `codigo` varchar(5) NOT NULL,
  `detalle` varchar(100) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_sector` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `tiempo`, `precio`, `codigo`, `detalle`, `id_cliente`, `id_estado`, `id_empleado`, `id_mesa`, `id_sector`) VALUES
(77, '00:10:00', '250', 'd9b23', '', 24, 3, 41, 21, 2),
(78, '00:10:00', '400', 'e64a7', '', 25, 3, 43, 21, 2),
(79, '00:00:00', '400', '65b12', '', 25, 3, 40, 31, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`id`, `descripcion`) VALUES
(1, 'BARRA VINOS Y TRAGOS'),
(2, 'BARRA CHOPERA'),
(3, 'COCINA'),
(4, 'CANDY BAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE `socios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `socios`
--

INSERT INTO `socios` (`id`, `nombre`, `apellido`, `usuario`, `clave`) VALUES
(23, 'Enrique', 'Silva', 'ESilva', '$2y$10$MmEeCVVxu4kN0dlSiMiwNOHdUjeqhifjVpvWgihB4FpxMVuPywDsy'),
(24, 'Paula', 'Silva', 'PSilva', '$2y$10$BS2OchzyFjJTubqzaJboEu9OCRFxTsOYCNgCYphnzZ.GoTU0q.LQi'),
(25, 'Jessica', 'Silva', 'JSilva', '$2y$10$UNV2WXMvh/qJ6pldFHszHe.s3M28TbWKTWIziP2QnuF7N0fOAFjvW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sector` (`id_sector`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `estado_empleados`
--
ALTER TABLE `estado_empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_mesa`
--
ALTER TABLE `estado_mesa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_mesa` (`id_mesa`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socios`
--
ALTER TABLE `socios`
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
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `estado_empleados`
--
ALTER TABLE `estado_empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`id_sector`) REFERENCES `sectores` (`id`),
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado_empleados` (`id`);

--
-- Filtros para la tabla `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `mesas_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado_mesa` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado_pedido` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_4` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
