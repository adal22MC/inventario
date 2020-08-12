create or replace table categorias(

    id_c int NOT NULL AUTO_INCREMENT,
    descr text COLLATE utf8_spanish_ci NOT NULL, -- Descripcion
    primary key(id_c)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES PARA LA TABLA CATEGORIAS
INSERT INTO categorias VALUES (NULL, 'Ferreteria'), (NULL, 'Tuberia');

create or replace table material(

    id_m varchar(50) COLLATE utf8_spanish_ci NOT NULL,
    descr text COLLATE utf8_spanish_ci, -- Descripcion
    serial text COLLATE utf8_spanish_ci, 
    id_c_m int NOT NULL,
    foreign key (id_c_m) references categorias(id_c),
    primary key(id_m)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES PARA LA TABLA MATERIAL
INSERT INTO material VALUES ('001','Segeta', 'S45568', 1),('002', 'Martillo', 'S13224', 1), ('003', 'Tubo PVC', 'S4564', 2);


create or replace table entrada_material(

    id int NOT NULL AUTO_INCREMENT,
    resp text COLLATE utf8_spanish_ci NOT NULL, -- Responsable
    t_entrada int NOT NULL, -- total entrada efectivo
    fecha date DEFAULT CURRENT_DATE,
    hora time DEFAULT CURRENT_TIME,
    primary key(id)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

create or replace table detalle_entrada(

    cns int NOT NULL AUTO_INCREMENT,
    id_em int NOT NULL,
    cant int NOT NULL, -- cantidad 
    p_compra float NOT NULL, -- precio compra
    te_producto float NOT NULL, -- total efectivo -  cant * p_compra
    id_m_de varchar(50) NOT NULL,
    foreign key (id_m_de) references material(id_m) ON UPDATE CASCADE,
    foreign key (id_em) references entrada_material(id),
    primary key( cns, id_em, id_m_de)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE bodegas(

    id_b INT NOT NULL AUTO_INCREMENT,
    f_creacion date DEFAULT CURRENT_DATE NOT NULL,
    correo VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    tel TEXT COLLATE utf8_spanish_ci NOT NULL,
    nombre TEXT COLLATE utf8_spanish_ci NOT NULL,
    tipo INT NOT NULL DEFAULT 0,
    PRIMARY KEY(id_b)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES EN LA TABLA BODEGA
INSERT INTO bodegas (correo,tel,nombre) VALUES ('tapachula@tapachula.es','9622162349','Sucursal Tapachula'), ('pinos@pinos.com','9627895878', 'Sucursal Los Pinos'), ('san_cristobal@sancris.com','5557894578', 'Sucursal San Cristobal');


CREATE OR REPLACE TABLE tipo_usuario(

    id_tu INT NOT NULL AUTO_INCREMENT,
    descr varchar(60) COLLATE utf8_spanish_ci NOT NULL,
    PRIMARY KEY (id_tu)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES EN  LA TABLA tipo_usuario
INSERT INTO tipo_usuario VALUES (NULL, 'Administrador'),(NULL, 'Almacenista Principal'),
(NULL, 'Almacenista Por Unidad');

CREATE OR REPLACE TABLE usuarios(

    username VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    pass varchar(60) COLLATE utf8_spanish_ci NOT NULL,
    correo VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL UNIQUE,
    num_iden VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL UNIQUE,
    nombres VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL,
    apellidos VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL,
    id_tu_u INT NOT NULL,
    FOREIGN KEY (id_tu_u) REFERENCES tipo_usuario(id_tu),
    PRIMARY KEY (username)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES EN LA TABLA usuarios
INSERT INTO usuarios VALUES 
('user','user','my.rg.developer@gmail.com','45878','Pedro Ignacio','Ruiz Guzmán',3), 
('unidad','unidad','rodriguez@gmail.com', '78545', 'Juan Rodrigo', 'Rodriguez Perez',3);


-- TABLA INTERMEDIA BODEGAS - USUARIOS
CREATE OR REPLACE TABLE bod_usu(

    id_b_bu INT NOT NULL,
    username_bu VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY ( id_b_bu ) REFERENCES bodegas ( id_b ),
    FOREIGN KEY ( username_bu ) REFERENCES usuarios ( username ) ON UPDATE CASCADE,
    PRIMARY KEY ( id_b_bu, username_bu )

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES PARA LA TABLA INTERMEDIA bod_usu
INSERT INTO bod_usu VALUES (1,'user'),(2,'user');

CREATE OR REPLACE TABLE orden_trabajo(

    num_orden VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL,
    fecha DATE DEFAULT CURRENT_DATE NOT NULL,
    hora TIME DEFAULT CURRENT_TIME NOT NULL,
    n_trabajador VARCHAR(255) COLLATE utf8_spanish_ci NOT NULL,
    cedula VARCHAR(100) COLLATE utf8_spanish_ci NOT NULL,
    tel VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    obser TEXT COLLATE utf8_spanish_ci NOT NULL,
    id_b_ot INT NOT NULL,
    resp VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (id_b_ot) REFERENCES bodegas (id_b),
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
    id_b_sp INT NOT NULL,
    FOREIGN KEY (id_b_sp) REFERENCES bodegas(id_b),
    FOREIGN KEY (resp) REFERENCES usuarios(username),
    PRIMARY KEY (id_s)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE detalle_solicitud(

    id_s_ds INT NOT NULL,
    id_m_ds varchar(50) COLLATE utf8_spanish_ci NOT NULL,
    cant INT NOT NULL,
    FOREIGN KEY (id_s_ds) REFERENCES solicitud_p (id_s),
    FOREIGN KEY (id_m_ds) REFERENCES material (id_m) ON UPDATE CASCADE,
    PRIMARY KEY (id_s_ds, id_m_ds)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE OR REPLACE TABLE traslados(

    id_t INT NOT NULL AUTO_INCREMENT,
    fecha DATE DEFAULT CURRENT_DATE NOT NULL,
    hora TIME DEFAULT CURRENT_TIME NOT NULL,
    llego_a INT NOT NULL,
    salio_de INT NOT NULL,
    t_materiales INT NOT NULL, -- cantidad de materiales
    te_traslado FLOAT NOT NULL, -- total efectivo
    resp VARCHAR(60) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY (resp) REFERENCES usuarios (username),
    FOREIGN KEY (llego_a) REFERENCES bodegas(id_b),
    FOREIGN KEY (salio_de) REFERENCES bodegas (id_b),
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
    id_b_i INT NOT NULL,
    id_m_i VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY ( id_b_i ) REFERENCES bodegas (id_b),
    FOREIGN KEY ( id_m_i ) REFERENCES material (id_m) ON UPDATE CASCADE,
    PRIMARY KEY ( id_b_i, id_m_i )

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES PARA LA TABLA inventario
INSERT INTO inventario VALUES (100,10,100,1,'001'),(100,10,100,1,'002'),(100,10,100,1,'003');

CREATE OR REPLACE TABLE detalle_inventario (

    cns INT NOT NULL AUTO_INCREMENT,
    dispo INT NOT NULL, -- disponible
    p_compra FLOAT NOT NULL,
    stock INT NOT NULL,
    fecha DATE DEFAULT CURRENT_DATE NOT NULL,
    id_b_di INT NOT NULL,
    id_m_di VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
    FOREIGN KEY ( id_b_di, id_m_di ) REFERENCES inventario ( id_b_i, id_m_i ) ON UPDATE CASCADE,
    PRIMARY KEY ( cns, id_b_di, id_m_di )

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- INSERCCIONES EN LA TABLA DETALLE INVENTARIO
INSERT INTO detalle_inventario (dispo,p_compra,stock,id_b_di,id_m_di) VALUES (1,80,100,1,'001'),
(1,80,100,1,'002'), (1,80,50,1,'003'), (1,50,50,1,'003');