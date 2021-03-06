create or replace table categorias(

    id_c int NOT NULL AUTO_INCREMENT,
    descr text COLLATE utf8_spanish_ci NOT NULL, -- Descripcion
    primary key(id_c)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

create or replace table material(

    id_m varchar(50) COLLATE utf8_spanish_ci NOT NULL,
    descr text COLLATE utf8_spanish_ci, -- Descripcion
    serial text COLLATE utf8_spanish_ci, 
    id_c_m int NOT NULL,
    foreign key (id_c_m) references categorias(id_c),
    primary key(id_m)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE bodegas(

    id_b VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    f_creacion date DEFAULT CURRENT_DATE NOT NULL,
    correo VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    tel TEXT COLLATE utf8_spanish_ci NOT NULL,
    nombre TEXT COLLATE utf8_spanish_ci NOT NULL,
    direccion TEXT COLLATE utf8_spanish_ci NOT NULL,
    tipo INT NOT NULL DEFAULT 0,
    PRIMARY KEY(id_b)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES EN LA TABLA BODEGA
INSERT INTO bodegas (id_b,correo,tel,nombre, direccion,tipo) VALUES 
('1','principal@principal.es','4564551315','Sucursal Madre','Mexico DF',1);


CREATE OR REPLACE TABLE tipo_usuario(

    id_tu INT NOT NULL AUTO_INCREMENT,
    descr varchar(60) COLLATE utf8_spanish_ci NOT NULL,
    PRIMARY KEY (id_tu)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES EN  LA TABLA tipo_usuario
INSERT INTO tipo_usuario VALUES 
(NULL, 'Administrador'),
(NULL, 'Almacenista Principal'),
(NULL, 'Almacenista Por Unidad');

CREATE OR REPLACE TABLE usuarios(

    username VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    pass varchar(60) COLLATE utf8_spanish_ci NOT NULL,
    correo VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL UNIQUE,
    num_iden VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL UNIQUE,
    nombres VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL,
    apellidos VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL,
    id_tu_u INT NOT NULL,
    status INT NOT NULL DEFAULT 1,
    FOREIGN KEY (id_tu_u) REFERENCES tipo_usuario(id_tu),
    PRIMARY KEY (username)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES EN LA TABLA usuarios
INSERT INTO usuarios VALUES 
('admin','admin','admin@gmail.com', '7811545', 'Administrador', 'Rodriguez',1,1);


-- TABLA INTERMEDIA BODEGAS - USUARIOS
CREATE OR REPLACE TABLE bod_usu(

    id_b_bu VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    username_bu VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY ( id_b_bu ) REFERENCES bodegas ( id_b ) ON UPDATE CASCADE,
    FOREIGN KEY ( username_bu ) REFERENCES usuarios ( username ) ON UPDATE CASCADE,
    PRIMARY KEY ( id_b_bu, username_bu )

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE OR REPLACE TABLE orden_trabajo(

    num_orden VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL,
    fecha DATE DEFAULT CURRENT_DATE NOT NULL,
    hora TIME DEFAULT CURRENT_TIME NOT NULL,
    n_trabajador VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL,
    cedula VARCHAR(100) COLLATE utf8_spanish_ci NOT NULL,
    tel VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    obser TEXT COLLATE utf8_spanish_ci NOT NULL,
    id_b_ot VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    resp VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (id_b_ot) REFERENCES bodegas (id_b) ON UPDATE CASCADE,
    FOREIGN KEY (resp) REFERENCES usuarios (username),
    PRIMARY KEY (num_orden)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE detalle_orden(

    cns INT NOT NULL AUTO_INCREMENT,
    cant INT NOT NULL,
    num_orden_do VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL,
    id_m_do varchar(50) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (num_orden_do) REFERENCES orden_trabajo(num_orden),
    FOREIGN KEY (id_m_do) REFERENCES material (id_m) ON UPDATE CASCADE,
    PRIMARY KEY (cns, num_orden_do, id_m_do)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE solicitud_p(

    id_s INT NOT NULL AUTO_INCREMENT,
    fecha DATE DEFAULT CURRENT_DATE NOT NULL,
    hora TIME DEFAULT CURRENT_TIME NOT NULL,
    resp varchar(255) COLLATE utf8_spanish_ci NOT NULL,
    status INT NOT NULL,
    id_b_sp VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    observaciones TEXT COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (id_b_sp) REFERENCES bodegas(id_b) ON UPDATE CASCADE,
    FOREIGN KEY (resp) REFERENCES usuarios(username),
    PRIMARY KEY (id_s)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE detalle_solicitud(

    id_s_ds INT NOT NULL,
    id_m_ds varchar(50) COLLATE utf8_spanish_ci NOT NULL,
    cant INT NOT NULL,
    recibi INT NOT NULL,
    FOREIGN KEY (id_s_ds) REFERENCES solicitud_p (id_s),
    FOREIGN KEY (id_m_ds) REFERENCES material (id_m) ON UPDATE CASCADE,
    PRIMARY KEY (id_s_ds, id_m_ds)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE traslados(

    id_t INT NOT NULL AUTO_INCREMENT,
    fecha DATE DEFAULT CURRENT_DATE NOT NULL,
    hora TIME DEFAULT CURRENT_TIME NOT NULL,
    llego_a VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    salio_de VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    t_materiales INT NOT NULL, -- cantidad de materiales
    te_traslado FLOAT NOT NULL, -- total efectivo
    resp VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    observaciones TEXT COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (resp) REFERENCES usuarios (username),
    FOREIGN KEY (llego_a) REFERENCES bodegas(id_b) ON UPDATE CASCADE,
    FOREIGN KEY (salio_de) REFERENCES bodegas (id_b) ON UPDATE CASCADE,
    PRIMARY KEY (id_t)


)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE material_traslado(

    -- cns INT NOT NULL AUTO_INCREMENT,
    cant INT NOT NULL, 
    t_material FLOAT NOT NULL, -- Total efectivo material
    id_t_mt INT NOT NULL,
    id_m_mt VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (id_t_mt) REFERENCES traslados (id_t),
    FOREIGN KEY (id_m_mt) REFERENCES material (id_m) ON UPDATE CASCADE,
    PRIMARY KEY ( id_m_mt, id_t_mt)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE detalle_traslado(

    cns INT NOT NULL AUTO_INCREMENT,
    total FLOAT NOT NULL, -- total efectivo
    p_compra FLOAT NOT NULL,
    cant INT NOT NULL,
    id_t_dt INT NOT NULL,
    id_m_dt VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY ( id_m_dt, id_t_dt) REFERENCES material_traslado (id_m_mt, id_t_mt) ON UPDATE CASCADE,
    PRIMARY KEY ( cns, id_m_dt, id_t_dt )

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE inventario(

    s_total INT NOT NULL,
    s_min INT NOT NULL,
    s_max INT NOT NULL,
    id_b_i VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    id_m_i VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY ( id_b_i ) REFERENCES bodegas (id_b) ON UPDATE CASCADE,
    FOREIGN KEY ( id_m_i ) REFERENCES material (id_m) ON UPDATE CASCADE,
    PRIMARY KEY ( id_b_i, id_m_i )

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE detalle_inventario (

    cns INT NOT NULL AUTO_INCREMENT,
    dispo INT NOT NULL, -- disponible
    p_compra FLOAT NOT NULL,
    stock INT NOT NULL,
    fecha DATE DEFAULT CURRENT_DATE NOT NULL,
    id_b_di VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    id_m_di VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY ( id_b_di, id_m_di ) REFERENCES inventario ( id_b_i, id_m_i ) ON UPDATE CASCADE,
    PRIMARY KEY ( cns, id_b_di, id_m_di )

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE OR REPLACE table orden_compra(

    id_oc INT NOT NULL AUTO_INCREMENT,
    status INT NOT NULL,
    fecha date DEFAULT CURRENT_DATE,
    hora time DEFAULT CURRENT_TIME,
    resp VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (resp) REFERENCES usuarios(username),
    PRIMARY KEY(id_oc)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

create or replace table detalle_orden_compra(

    cns int NOT NULL AUTO_INCREMENT,
    id_oc_do int NOT NULL,
    cant int NOT NULL, -- cantidad que pidio
    recibi int NOT NULL, -- cantidad que recibio
    p_compra float NOT NULL, -- precio compra
    te_producto float NOT NULL, -- total efectivo -  cant * p_compra
    id_m_do varchar(50) COLLATE utf8_spanish_ci NOT NULL ,
    foreign key (id_m_do) references material(id_m) ON UPDATE CASCADE,
    foreign key (id_oc_do) references orden_compra(id_oc),
    primary key( cns, id_oc_do, id_m_do)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

create or replace table entrada_material(

    id_em int NOT NULL AUTO_INCREMENT,
    resp text COLLATE utf8_spanish_ci NOT NULL, -- Responsable
    id_oc_em int NOT NULL, 
    fecha date DEFAULT CURRENT_DATE,
    hora time DEFAULT CURRENT_TIME,
    FOREIGN KEY(id_oc_em) REFERENCES orden_compra(id_oc),
    primary key(id_em)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `empresa` (
  id int NOT NULL ,
  `url` text COLLATE utf8_spanish_ci ,
  `nit` text COLLATE utf8_spanish_ci ,
  `correo` varchar(60) COLLATE utf8_spanish_ci ,
  `tel` text COLLATE utf8_spanish_ci ,
  `nombre` text COLLATE utf8_spanish_ci ,
  `direccion` text COLLATE utf8_spanish_ci ,
  `pagina` text COLLATE utf8_spanish_ci 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO empresa values (1,"example.png","123ee3","nose@gmail.com","9876654","Super Market","fracc.rr","www.SuperMarket.com");

CREATE TABLE traslados_pendientes(

    id int NOT NULL AUTO_INCREMENT,
    resp VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (resp) REFERENCES usuarios(username),
    status int NOT NULL,
    llego_a VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    salio_de VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (llego_a) REFERENCES bodegas(id_b) ON UPDATE CASCADE,
    FOREIGN KEY (salio_de) REFERENCES bodegas (id_b) ON UPDATE CASCADE,
    PRIMARY KEY (id)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE detalle_traslado_pendientes(

    id_tp_dtp int NOT NULL,
    id_m_dtp varchar(50) COLLATE utf8_spanish_ci NOT NULL,
    cant int NOT NULL,
    recibi int NOT NULL,
    FOREIGN KEY (id_m_dtp) REFERENCES material(id_m) ON UPDATE CASCADE,
    FOREIGN KEY (id_tp_dtp) REFERENCES traslados_pendientes(id),
    PRIMARY KEY (id_tp_dtp, id_m_dtp)


)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

