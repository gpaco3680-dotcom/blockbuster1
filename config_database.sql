DROP DATABASE IF EXISTS blockbuster;
CREATE DATABASE IF NOT EXISTS blockbuster DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE blockbuster;

-- Credenciales exigidas por la rúbrica
CREATE USER IF NOT EXISTS 'blockbuser'@'localhost' IDENTIFIED BY 'blockpass487';
GRANT ALL PRIVILEGES ON blockbuster.* TO 'blockbuser'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE blockbuster_roles (
    id_rol INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_rol VARCHAR(30) NOT NULL
)ENGINE=InnoDB;

INSERT INTO blockbuster_roles (id_rol, nombre_rol) VALUES
    (745, 'Administrador'),
    (125, 'Operador'),
    (58, 'Cliente');

CREATE TABLE blockbuster_planes (
    id_plan INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    estatus_plan TINYINT(1) NULL DEFAULT -1 COMMENT '1-> Habilitado, -1-> Deshabilitado',
    nombre_plan VARCHAR(30) NOT NULL,
    precio_plan decimal(10,2) NOT NULL,
    cantidad_limite_plan TINYINT(1) NOT NULL,
    tipo_plan TINYINT(1) NOT NULL COMMENT '8-> Semanal, 16-> Mensual, 32-> Anual',
    descripcion_plan TEXT NULL, 
    fecha_registro_plan DATE NOT NULL 
)ENGINE=InnoDB;

INSERT INTO blockbuster_planes (id_plan, estatus_plan, nombre_plan, precio_plan, cantidad_limite_plan, tipo_plan, descripcion_plan, fecha_registro_plan) VALUES
    (NULL, 1, "Básico", 99.99, 10, 8, "Plan ideal para comenzar", CURDATE()),
    (NULL, 1, "Estándar", 199.09, 10, 16, "Plan para disfrutar en familia", CURDATE()),
    (NULL, 1, "Co-Prenium", 398.37, 10, 16, "Plan con beneficios extra", CURDATE()),
    (NULL, 1, "Prenium", 1499.99, 10, 32, "Todo el catálogo sin límites", CURDATE());

CREATE TABLE blockbuster_usuarios (
    id_usuario INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    estatus_usuario TINYINT(1) NULL DEFAULT -1 COMMENT '1-> Habilitado, -1-> Deshabilitado',
    fecha_registro_usuario DATE NOT NULL,
    nombre_usuario VARCHAR(50) NOT NULL,
    ap_usuario VARCHAR(50) NOT NULL,
    am_usuario VARCHAR(50) NULL DEFAULT NULL,
    sexo_usuario TINYINT(1) NOT NULL COMMENT '0:Femenino, 1: Masculino',
    email_usuario VARCHAR(70) NOT NULL,
    password_usuario VARCHAR(64) NOT NULL,
    imagen_usuario VARCHAR(100) DEFAULT NULL,
    id_rol INT(3) NOT NULL,
    FOREIGN KEY(id_rol) REFERENCES blockbuster_roles (id_rol) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO blockbuster_usuarios (id_usuario, estatus_usuario, fecha_registro_usuario, nombre_usuario, ap_usuario, am_usuario, sexo_usuario, email_usuario, password_usuario, id_rol) VALUES
    (NULL, 1, CURDATE(), 'Fanni', 'Gutierrez', 'Pacheco', 0, 'fanni@blockbuster.com', SHA2("admon123",256), 745),
    (NULL, 1, CURDATE(), 'Marcos Braulio', 'Calva', 'Cervantes', 1, 'marcosbraulio@blockbuster.com', SHA2("operador123",256), 125),
    (NULL, -1, CURDATE(), 'Jessica Melina', 'Gutierrez', 'Zempoalteca', 0, 'jessmelina@blockbuster.com', SHA2("cliente123",256), 58);

CREATE TABLE blockbuster_generos (
    id_genero INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    estatus_genero TINYINT(1) NULL DEFAULT -1 COMMENT '1-> Habilitado, -1-> Deshabilitado',
    nombre_genero VARCHAR(30) NOT NULL,
    descripcion_genero TEXT NULL COMMENT '' 
)ENGINE=InnoDB;

INSERT INTO blockbuster_generos (id_genero, estatus_genero, nombre_genero, descripcion_genero) VALUES
    (1, 1, 'Acción', 'Escenas de combate, persecuciones y adrenalina.'),
    (2, 1, 'Aventura', 'Historias de exploración y desafíos emocionantes.');

CREATE TABLE blockbuster_streaming (
    id_streaming INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    estatus_streaming TINYINT(1) NULL DEFAULT -1 COMMENT '1-> Habilitado, -1-> Deshabilitado',
    nombre_streaming VARCHAR(50) NOT NULL,
    fecha_lanzamiento_streaming  DATE NOT NULL,
    duracion_streaming TIME NULL COMMENT 'Peliculas',
    temporadas_streaming TINYINT(1) NULL COMMENT 'temporadas',
    caratula_streaming VARCHAR(50) NOT NULL COMMENT 'image_caratula.png',
    trailer_streaming VARCHAR(70) NOT NULL COMMENT 'trailer_streaming.mp3',
    clasificacion_streaming VARCHAR(3) NOT NULL COMMENT 'AA: Infantil, A: Todo Público, B: Mayores de 12, B15: Mayores de 15, C: Solo Mayores 18, D: Exclusiva Adultos',
    sipnosis_streaming TEXT NULL COMMENT '', 
    fecha_estreno_streaming DATE NOT NULL,
    id_genero INT(3) NOT NULL,
    FOREIGN KEY(id_genero) REFERENCES blockbuster_generos (id_genero) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO blockbuster_streaming (id_streaming, estatus_streaming, nombre_streaming, fecha_lanzamiento_streaming, duracion_streaming, caratula_streaming, trailer_streaming, clasificacion_streaming, sipnosis_streaming, fecha_estreno_streaming, id_genero) VALUES
    (NULL, 1, "Mufasa: El Rey León", "2024-12-20", "01:45:00",  "caratula_mufasa.png", "trailer_mufasa.mp4", "AA", "Rafiki cuenta la leyenda...", "2025-03-16", 2);

CREATE TABLE blockbuster_videos (
    id_video INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    estatus_video TINYINT(1) NULL DEFAULT -1 COMMENT '1-> Disponible, -1-> No Disponible',
    video VARCHAR(70) NOT NULL COMMENT 'nombre_video.mp3',
    nombre_temporada VARCHAR(70) NULL COMMENT 'Parte 1, ',
    video_temporada TINYINT(1) NULL COMMENT 'Temporada 1, Temporada 2',
    capitulo_temporada TINYINT(1) NULL COMMENT 'Capitulo 1, Episodeo 1',
    descripcion_capitulo_temporada TEXT NULL COMMENT 'Descripción...',
    id_streaming INT(11) NOT NULL, 
    FOREIGN KEY(id_streaming) REFERENCES blockbuster_streaming (id_streaming) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO blockbuster_videos (id_video, estatus_video, video, id_streaming) VALUES 
    (NULL, 1, "pelicula_mufasa.mp4", 1);

CREATE TABLE blockbuster_usuarios_planes (
    id_usuario_plan INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha_registro_plan DATE NOT NULL COMMENT '',
    fecha_fin_plan DATE NOT NULL COMMENT '',
    id_usuario INT(11) NOT NULL,
    id_plan INT(11) NOT NULL,
    FOREIGN KEY(id_usuario) REFERENCES blockbuster_usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(id_plan) REFERENCES blockbuster_planes (id_plan) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO blockbuster_usuarios_planes (id_usuario_plan, fecha_registro_plan, fecha_fin_plan, id_usuario, id_plan) VALUES
    (NULL, "2025-03-16", "2025-03-23", 3, 1);

CREATE TABLE blockbuster_pagos (
    id_pago INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha_registro_pago DATE NOT NULL COMMENT '',
    estatus_pago TINYINT(1) NULL DEFAULT -1 COMMENT '-1: Rechazado, 0: Pendiente, 1: Aceptado',
    monto_pago DECIMAL(10,2) NOT NULL COMMENT '',
    tarjeta_pago VARCHAR(32) NOT NULL COMMENT '',
    id_usuario INT(11) NOT NULL,
    id_plan INT(11) NOT NULL,
    FOREIGN KEY(id_usuario) REFERENCES blockbuster_usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(id_plan) REFERENCES blockbuster_planes (id_plan) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO blockbuster_pagos (id_pago, fecha_registro_pago, estatus_pago, monto_pago, tarjeta_pago, id_usuario, id_plan) VALUES
    (NULL, "2025-03-16", 1, 99.99, "XXXXXXXXXXXXXXXX", 3, 1);

CREATE TABLE blockbuster_alquileres (
    id_alquiler INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha_inicio_alquiler DATE NOT NULL COMMENT '',
    fecha_fin_alquiler DATE NOT NULL COMMENT '',
    estatus_alquiler TINYINT(1) NULL DEFAULT -1 COMMENT '-1-> En proceso, 0-> Cancelado, 1-> Culminado',
    id_streaming INT(11) NOT NULL,
    id_usuario INT(11) NOT NULL,
    FOREIGN KEY(id_usuario) REFERENCES blockbuster_usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(id_streaming) REFERENCES blockbuster_streaming (id_streaming) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO blockbuster_alquileres (id_alquiler, fecha_inicio_alquiler, fecha_fin_alquiler, id_usuario, id_streaming) VALUES
    (NULL, "2025-03-16", "2025-03-21", 3, 1);