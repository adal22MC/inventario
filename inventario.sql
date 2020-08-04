-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-08-2020 a las 22:29:29
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodegas`
--

CREATE TABLE `bodegas` (
  `id_b` int(11) NOT NULL,
  `f_creacion` date NOT NULL DEFAULT curdate(),
  `correo` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `tel` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT 0,
  `username` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bodegas`
--

INSERT INTO `bodegas` (`id_b`, `f_creacion`, `correo`, `tel`, `nombre`, `tipo`, `username`, `pass`) VALUES
(2, '2020-08-02', 'tapachula@tapachula.com', '9624587845', 'Tapachula', 0, 'tapachula', 'tapachula'),
(3, '2020-08-02', 'my.rg.developer@gmail.com', '564564564', 'Los pinos', 0, 'username', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bod_usu`
--

CREATE TABLE `bod_usu` (
  `id_b_bu` int(11) NOT NULL,
  `username_bu` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bod_usu`
--

INSERT INTO `bod_usu` (`id_b_bu`, `username_bu`) VALUES
(2, 'admin'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_c` int(11) NOT NULL,
  `descr` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_c`, `descr`) VALUES
(2, 'TUBERIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_entrada`
--

CREATE TABLE `detalle_entrada` (
  `cns` int(11) NOT NULL,
  `id_em` int(11) NOT NULL,
  `cant` int(11) NOT NULL,
  `p_compra` float NOT NULL,
  `te_producto` float NOT NULL,
  `id_m_de` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_inventario`
--

CREATE TABLE `detalle_inventario` (
  `cns` int(11) NOT NULL,
  `dispo` int(11) NOT NULL,
  `p_compra` float NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `id_b_di` int(11) NOT NULL,
  `id_m_di` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_inventario`
--

INSERT INTO `detalle_inventario` (`cns`, `dispo`, `p_compra`, `stock`, `fecha`, `id_b_di`, `id_m_di`) VALUES
(1, 0, 200, 0, '2020-08-03', 2, '001'),
(2, 0, 250, 0, '2020-08-04', 2, '003'),
(3, 0, 300, 0, '2020-08-04', 2, '003'),
(4, 1, 300, 50, '2020-08-04', 2, '003'),
(5, 1, 130, 50, '2020-08-04', 2, '001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden`
--

CREATE TABLE `detalle_orden` (
  `cns` int(11) NOT NULL,
  `cant` int(11) NOT NULL,
  `num_orden_do` int(11) NOT NULL,
  `id_m_do` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_orden`
--

INSERT INTO `detalle_orden` (`cns`, `cant`, `num_orden_do`, `id_m_do`) VALUES
(1, 45, 22, '001'),
(2, 150, 22, '003'),
(3, 5, 23, '001'),
(4, 50, 24, '003');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_solicitud`
--

CREATE TABLE `detalle_solicitud` (
  `id_s_ds` int(11) NOT NULL,
  `id_m_ds` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_traslado`
--

CREATE TABLE `detalle_traslado` (
  `cns` int(11) NOT NULL,
  `total` float NOT NULL,
  `p_compra` float NOT NULL,
  `cant` int(11) NOT NULL,
  `id_t_dt` int(11) NOT NULL,
  `id_m_dt` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_material`
--

CREATE TABLE `entrada_material` (
  `id` int(11) NOT NULL,
  `resp` text COLLATE utf8_spanish_ci NOT NULL,
  `t_entrada` int(11) NOT NULL,
  `fecha` date DEFAULT curdate(),
  `hora` time DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `s_total` int(11) NOT NULL,
  `s_min` int(11) NOT NULL,
  `s_max` int(11) NOT NULL,
  `id_b_i` int(11) NOT NULL,
  `id_m_i` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`s_total`, `s_min`, `s_max`, `id_b_i`, `id_m_i`) VALUES
(50, 10, 100, 2, '001'),
(50, 10, 150, 2, '003');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material`
--

CREATE TABLE `material` (
  `id_m` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descr` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `serial` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_c_m` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `material`
--

INSERT INTO `material` (`id_m`, `descr`, `serial`, `id_c_m`) VALUES
('001', 'PVC', '0254512', 2),
('003', 'Tubos', '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_traslado`
--

CREATE TABLE `material_traslado` (
  `cant` int(11) NOT NULL,
  `t_material` float NOT NULL,
  `id_t_mt` int(11) NOT NULL,
  `id_m_mt` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_trabajo`
--

CREATE TABLE `orden_trabajo` (
  `num_orden` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora` time NOT NULL DEFAULT curtime(),
  `n_trabajador` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `cedula` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tel` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `obser` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `orden_trabajo`
--

INSERT INTO `orden_trabajo` (`num_orden`, `fecha`, `hora`, `n_trabajador`, `cedula`, `tel`, `obser`) VALUES
(22, '2020-08-04', '14:44:15', 'Trabajador test', '00003', '9622162349', 'Sin observaciones'),
(23, '2020-08-04', '14:48:36', 'Trabajador test', '23', '9622162349', 'NA'),
(24, '2020-08-04', '14:49:55', 'Trabajador test', '12', '9622162349', 'SIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_p`
--

CREATE TABLE `solicitud_p` (
  `id_s` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora` time NOT NULL DEFAULT curtime(),
  `resp` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `id_b_sp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tu` int(11) NOT NULL,
  `descr` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tu`, `descr`) VALUES
(1, 'Administrador'),
(2, 'Almacenista Principal'),
(3, 'Almacenista Por Unidad Operativa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados`
--

CREATE TABLE `traslados` (
  `id_t` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora` time NOT NULL DEFAULT curtime(),
  `llego_a` int(11) NOT NULL,
  `salio_de` int(11) NOT NULL,
  `t_materiales` int(11) NOT NULL,
  `te_traslado` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `username` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `id_tu_u` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`username`, `pass`, `id_tu_u`) VALUES
('admin', 'admin', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  ADD PRIMARY KEY (`id_b`);

--
-- Indices de la tabla `bod_usu`
--
ALTER TABLE `bod_usu`
  ADD PRIMARY KEY (`id_b_bu`,`username_bu`),
  ADD KEY `username_bu` (`username_bu`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_c`);

--
-- Indices de la tabla `detalle_entrada`
--
ALTER TABLE `detalle_entrada`
  ADD PRIMARY KEY (`cns`,`id_em`,`id_m_de`),
  ADD KEY `id_m_de` (`id_m_de`),
  ADD KEY `id_em` (`id_em`);

--
-- Indices de la tabla `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  ADD PRIMARY KEY (`cns`,`id_b_di`,`id_m_di`),
  ADD KEY `id_b_di` (`id_b_di`,`id_m_di`);

--
-- Indices de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD PRIMARY KEY (`cns`,`num_orden_do`,`id_m_do`),
  ADD KEY `num_orden_do` (`num_orden_do`),
  ADD KEY `id_m_do` (`id_m_do`);

--
-- Indices de la tabla `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
  ADD PRIMARY KEY (`id_s_ds`,`id_m_ds`),
  ADD KEY `id_m_ds` (`id_m_ds`);

--
-- Indices de la tabla `detalle_traslado`
--
ALTER TABLE `detalle_traslado`
  ADD PRIMARY KEY (`cns`,`id_m_dt`,`id_t_dt`),
  ADD KEY `id_m_dt` (`id_m_dt`,`id_t_dt`);

--
-- Indices de la tabla `entrada_material`
--
ALTER TABLE `entrada_material`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_b_i`,`id_m_i`),
  ADD KEY `id_m_i` (`id_m_i`);

--
-- Indices de la tabla `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id_m`),
  ADD KEY `id_c_m` (`id_c_m`);

--
-- Indices de la tabla `material_traslado`
--
ALTER TABLE `material_traslado`
  ADD PRIMARY KEY (`id_m_mt`,`id_t_mt`),
  ADD KEY `id_t_mt` (`id_t_mt`);

--
-- Indices de la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD PRIMARY KEY (`num_orden`);

--
-- Indices de la tabla `solicitud_p`
--
ALTER TABLE `solicitud_p`
  ADD PRIMARY KEY (`id_s`),
  ADD KEY `id_b_sp` (`id_b_sp`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tu`);

--
-- Indices de la tabla `traslados`
--
ALTER TABLE `traslados`
  ADD PRIMARY KEY (`id_t`),
  ADD KEY `llego_a` (`llego_a`),
  ADD KEY `salio_de` (`salio_de`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`username`),
  ADD KEY `id_tu_u` (`id_tu_u`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  MODIFY `id_b` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_c` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_entrada`
--
ALTER TABLE `detalle_entrada`
  MODIFY `cns` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  MODIFY `cns` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  MODIFY `cns` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_traslado`
--
ALTER TABLE `detalle_traslado`
  MODIFY `cns` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entrada_material`
--
ALTER TABLE `entrada_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  MODIFY `num_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `solicitud_p`
--
ALTER TABLE `solicitud_p`
  MODIFY `id_s` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `traslados`
--
ALTER TABLE `traslados`
  MODIFY `id_t` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bod_usu`
--
ALTER TABLE `bod_usu`
  ADD CONSTRAINT `bod_usu_ibfk_1` FOREIGN KEY (`id_b_bu`) REFERENCES `bodegas` (`id_b`),
  ADD CONSTRAINT `bod_usu_ibfk_2` FOREIGN KEY (`username_bu`) REFERENCES `usuarios` (`username`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_entrada`
--
ALTER TABLE `detalle_entrada`
  ADD CONSTRAINT `detalle_entrada_ibfk_1` FOREIGN KEY (`id_m_de`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_entrada_ibfk_2` FOREIGN KEY (`id_em`) REFERENCES `entrada_material` (`id`);

--
-- Filtros para la tabla `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  ADD CONSTRAINT `detalle_inventario_ibfk_1` FOREIGN KEY (`id_b_di`,`id_m_di`) REFERENCES `inventario` (`id_b_i`, `id_m_i`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD CONSTRAINT `detalle_orden_ibfk_1` FOREIGN KEY (`num_orden_do`) REFERENCES `orden_trabajo` (`num_orden`),
  ADD CONSTRAINT `detalle_orden_ibfk_2` FOREIGN KEY (`id_m_do`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
  ADD CONSTRAINT `detalle_solicitud_ibfk_1` FOREIGN KEY (`id_s_ds`) REFERENCES `solicitud_p` (`id_s`),
  ADD CONSTRAINT `detalle_solicitud_ibfk_2` FOREIGN KEY (`id_m_ds`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_traslado`
--
ALTER TABLE `detalle_traslado`
  ADD CONSTRAINT `detalle_traslado_ibfk_1` FOREIGN KEY (`id_m_dt`,`id_t_dt`) REFERENCES `material_traslado` (`id_m_mt`, `id_t_mt`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_b_i`) REFERENCES `bodegas` (`id_b`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`id_m_i`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `material_ibfk_1` FOREIGN KEY (`id_c_m`) REFERENCES `categorias` (`id_c`);

--
-- Filtros para la tabla `material_traslado`
--
ALTER TABLE `material_traslado`
  ADD CONSTRAINT `material_traslado_ibfk_1` FOREIGN KEY (`id_t_mt`) REFERENCES `traslados` (`id_t`),
  ADD CONSTRAINT `material_traslado_ibfk_2` FOREIGN KEY (`id_m_mt`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud_p`
--
ALTER TABLE `solicitud_p`
  ADD CONSTRAINT `solicitud_p_ibfk_1` FOREIGN KEY (`id_b_sp`) REFERENCES `bodegas` (`id_b`);

--
-- Filtros para la tabla `traslados`
--
ALTER TABLE `traslados`
  ADD CONSTRAINT `traslados_ibfk_1` FOREIGN KEY (`llego_a`) REFERENCES `bodegas` (`id_b`),
  ADD CONSTRAINT `traslados_ibfk_2` FOREIGN KEY (`salio_de`) REFERENCES `bodegas` (`id_b`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_tu_u`) REFERENCES `tipo_usuario` (`id_tu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
