

CREATE TABLE `bod_usu` (
  `id_b_bu` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `username_bu` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_b_bu`,`username_bu`),
  KEY `username_bu` (`username_bu`),
  CONSTRAINT `bod_usu_ibfk_1` FOREIGN KEY (`id_b_bu`) REFERENCES `bodegas` (`id_b`) ON UPDATE CASCADE,
  CONSTRAINT `bod_usu_ibfk_2` FOREIGN KEY (`username_bu`) REFERENCES `usuarios` (`username`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO bod_usu VALUES("BOD001","pinos");





CREATE TABLE `bodegas` (
  `id_b` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `f_creacion` date NOT NULL DEFAULT curdate(),
  `correo` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `tel` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_b`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO bodegas VALUES("1","2020-08-19","principal@principal.es","4564551315","Sucursal Madre","Mexico DF","1");
INSERT INTO bodegas VALUES("BOD001","2020-08-19","sucursal_pinos@gmail.com","97873121345","Sucursal Los Pinos","Tapachula, Chiapas","0");





CREATE TABLE `categorias` (
  `id_c` int(11) NOT NULL AUTO_INCREMENT,
  `descr` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `detalle_inventario` (
  `cns` int(11) NOT NULL AUTO_INCREMENT,
  `dispo` int(11) NOT NULL,
  `p_compra` float NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `id_b_di` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_m_di` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`cns`,`id_b_di`,`id_m_di`),
  KEY `id_b_di` (`id_b_di`,`id_m_di`),
  CONSTRAINT `detalle_inventario_ibfk_1` FOREIGN KEY (`id_b_di`, `id_m_di`) REFERENCES `inventario` (`id_b_i`, `id_m_i`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `detalle_orden` (
  `cns` int(11) NOT NULL AUTO_INCREMENT,
  `cant` int(11) NOT NULL,
  `num_orden_do` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `id_m_do` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`cns`,`num_orden_do`,`id_m_do`),
  KEY `num_orden_do` (`num_orden_do`),
  KEY `id_m_do` (`id_m_do`),
  CONSTRAINT `detalle_orden_ibfk_1` FOREIGN KEY (`num_orden_do`) REFERENCES `orden_trabajo` (`num_orden`),
  CONSTRAINT `detalle_orden_ibfk_2` FOREIGN KEY (`id_m_do`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `detalle_orden_compra` (
  `cns` int(11) NOT NULL AUTO_INCREMENT,
  `id_oc_do` int(11) NOT NULL,
  `cant` int(11) NOT NULL,
  `recibi` int(11) NOT NULL,
  `p_compra` float NOT NULL,
  `te_producto` float NOT NULL,
  `id_m_do` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`cns`,`id_oc_do`,`id_m_do`),
  KEY `id_m_do` (`id_m_do`),
  KEY `id_oc_do` (`id_oc_do`),
  CONSTRAINT `detalle_orden_compra_ibfk_1` FOREIGN KEY (`id_m_do`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE,
  CONSTRAINT `detalle_orden_compra_ibfk_2` FOREIGN KEY (`id_oc_do`) REFERENCES `orden_compra` (`id_oc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `detalle_solicitud` (
  `id_s_ds` int(11) NOT NULL,
  `id_m_ds` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cant` int(11) NOT NULL,
  PRIMARY KEY (`id_s_ds`,`id_m_ds`),
  KEY `id_m_ds` (`id_m_ds`),
  CONSTRAINT `detalle_solicitud_ibfk_1` FOREIGN KEY (`id_s_ds`) REFERENCES `solicitud_p` (`id_s`),
  CONSTRAINT `detalle_solicitud_ibfk_2` FOREIGN KEY (`id_m_ds`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `detalle_traslado` (
  `cns` int(11) NOT NULL AUTO_INCREMENT,
  `total` float NOT NULL,
  `p_compra` float NOT NULL,
  `cant` int(11) NOT NULL,
  `id_t_dt` int(11) NOT NULL,
  `id_m_dt` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`cns`,`id_m_dt`,`id_t_dt`),
  KEY `id_m_dt` (`id_m_dt`,`id_t_dt`),
  CONSTRAINT `detalle_traslado_ibfk_1` FOREIGN KEY (`id_m_dt`, `id_t_dt`) REFERENCES `material_traslado` (`id_m_mt`, `id_t_mt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `entrada_material` (
  `id_em` int(11) NOT NULL AUTO_INCREMENT,
  `resp` text COLLATE utf8_spanish_ci NOT NULL,
  `id_oc_em` int(11) NOT NULL,
  `fecha` date DEFAULT curdate(),
  `hora` time DEFAULT curtime(),
  PRIMARY KEY (`id_em`),
  KEY `id_oc_em` (`id_oc_em`),
  CONSTRAINT `entrada_material_ibfk_1` FOREIGN KEY (`id_oc_em`) REFERENCES `orden_compra` (`id_oc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `inventario` (
  `s_total` int(11) NOT NULL,
  `s_min` int(11) NOT NULL,
  `s_max` int(11) NOT NULL,
  `id_b_i` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_m_i` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_b_i`,`id_m_i`),
  KEY `id_m_i` (`id_m_i`),
  CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_b_i`) REFERENCES `bodegas` (`id_b`) ON UPDATE CASCADE,
  CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`id_m_i`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `material` (
  `id_m` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descr` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `serial` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_c_m` int(11) NOT NULL,
  PRIMARY KEY (`id_m`),
  KEY `id_c_m` (`id_c_m`),
  CONSTRAINT `material_ibfk_1` FOREIGN KEY (`id_c_m`) REFERENCES `categorias` (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `material_traslado` (
  `cant` int(11) NOT NULL,
  `t_material` float NOT NULL,
  `id_t_mt` int(11) NOT NULL,
  `id_m_mt` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_m_mt`,`id_t_mt`),
  KEY `id_t_mt` (`id_t_mt`),
  CONSTRAINT `material_traslado_ibfk_1` FOREIGN KEY (`id_t_mt`) REFERENCES `traslados` (`id_t`),
  CONSTRAINT `material_traslado_ibfk_2` FOREIGN KEY (`id_m_mt`) REFERENCES `material` (`id_m`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `orden_compra` (
  `id_oc` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `fecha` date DEFAULT curdate(),
  `hora` time DEFAULT curtime(),
  `resp` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_oc`),
  KEY `resp` (`resp`),
  CONSTRAINT `orden_compra_ibfk_1` FOREIGN KEY (`resp`) REFERENCES `usuarios` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `orden_trabajo` (
  `num_orden` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora` time NOT NULL DEFAULT curtime(),
  `n_trabajador` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `cedula` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tel` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `obser` text COLLATE utf8_spanish_ci NOT NULL,
  `id_b_ot` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `resp` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`num_orden`),
  KEY `id_b_ot` (`id_b_ot`),
  KEY `resp` (`resp`),
  CONSTRAINT `orden_trabajo_ibfk_1` FOREIGN KEY (`id_b_ot`) REFERENCES `bodegas` (`id_b`) ON UPDATE CASCADE,
  CONSTRAINT `orden_trabajo_ibfk_2` FOREIGN KEY (`resp`) REFERENCES `usuarios` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `solicitud_p` (
  `id_s` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora` time NOT NULL DEFAULT curtime(),
  `resp` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `id_b_sp` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_s`),
  KEY `id_b_sp` (`id_b_sp`),
  KEY `resp` (`resp`),
  CONSTRAINT `solicitud_p_ibfk_1` FOREIGN KEY (`id_b_sp`) REFERENCES `bodegas` (`id_b`) ON UPDATE CASCADE,
  CONSTRAINT `solicitud_p_ibfk_2` FOREIGN KEY (`resp`) REFERENCES `usuarios` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `tipo_usuario` (
  `id_tu` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tu`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO tipo_usuario VALUES("1","Administrador");
INSERT INTO tipo_usuario VALUES("2","Almacenista Principal");
INSERT INTO tipo_usuario VALUES("3","Almacenista Por Unidad");
INSERT INTO tipo_usuario VALUES("4","Almacenista Multisucursal");





CREATE TABLE `traslados` (
  `id_t` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora` time NOT NULL DEFAULT curtime(),
  `llego_a` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `salio_de` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `t_materiales` int(11) NOT NULL,
  `te_traslado` float NOT NULL,
  `resp` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_t`),
  KEY `resp` (`resp`),
  KEY `llego_a` (`llego_a`),
  KEY `salio_de` (`salio_de`),
  CONSTRAINT `traslados_ibfk_1` FOREIGN KEY (`resp`) REFERENCES `usuarios` (`username`),
  CONSTRAINT `traslados_ibfk_2` FOREIGN KEY (`llego_a`) REFERENCES `bodegas` (`id_b`) ON UPDATE CASCADE,
  CONSTRAINT `traslados_ibfk_3` FOREIGN KEY (`salio_de`) REFERENCES `bodegas` (`id_b`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `usuarios` (
  `username` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `num_iden` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `id_tu_u` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`username`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `num_iden` (`num_iden`),
  KEY `id_tu_u` (`id_tu_u`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_tu_u`) REFERENCES `tipo_usuario` (`id_tu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO usuarios VALUES("admin","admin","admin@gmail.com","7811545","Administrador","Rodriguez","1","1");
INSERT INTO usuarios VALUES("pinos","pinos","pinos@pinos.com","021548787","Luis Angel","Perez Garcia","3","1");



