-- Script SQL para configurar Blockbuster (Actualizado con utf8mb4_general_ci y Catálogo Extendido)
-- Ejecutar como root/administrador de MySQL

-- 1. Crear base de datos y usuario exactamente como pide el PDF
CREATE DATABASE IF NOT EXISTS blockbuster CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE blockbuster;

CREATE USER IF NOT EXISTS 'blockbuser'@'localhost' IDENTIFIED BY 'blockpass487';
GRANT ALL PRIVILEGES ON blockbuster.* TO 'blockbuser'@'localhost';
FLUSH PRIVILEGES;

-- 2. Crear tabla roles
CREATE TABLE IF NOT EXISTS blockbuster_roles (
    id_rol INT(3) PRIMARY KEY AUTO_INCREMENT,
    nombre_rol VARCHAR(30) NOT NULL
);

-- Insertar roles
INSERT INTO blockbuster_roles (nombre_rol) VALUES
('Administrador'),
('Operador'),
('Cliente');

-- 3. Crear tabla generos
CREATE TABLE IF NOT EXISTS blockbuster_generos (
    id_genero INT(3) PRIMARY KEY AUTO_INCREMENT,
    estatus_genero TINYINT(1) DEFAULT 1,
    nombre_genero VARCHAR(30) NOT NULL,
    descripcion_genero TEXT
);

-- Insertar géneros
INSERT INTO blockbuster_generos (nombre_genero, descripcion_genero, estatus_genero) VALUES
('Acción', 'Películas de acción y aventura', 1),
('Comedia', 'Películas y series cómicas', 1),
('Drama', 'Películas dramáticas', 1),
('Terror', 'Películas de terror y suspenso', 1),
('Romance', 'Películas románticas', 1),
('Ciencia Ficción', 'Películas de ciencia ficción', 1);

-- 4. Crear tabla usuarios
CREATE TABLE IF NOT EXISTS blockbuster_usuarios (
    id_usuario INT(11) PRIMARY KEY AUTO_INCREMENT,
    estatus_usuario TINYINT(1) DEFAULT 1,
    nombre_usuario VARCHAR(50) NOT NULL,
    ap_usuario VARCHAR(50) NOT NULL,
    am_usuario VARCHAR(50),
    sexo_usuario TINYINT(1),
    email_usuario VARCHAR(70) UNIQUE NOT NULL,
    password_usuario VARCHAR(255) NOT NULL, -- Aumentado para compatibilidad de hash
    imagen_usuario VARCHAR(100),
    id_rol INT(3) NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES blockbuster_roles(id_rol)
);

-- Insertar usuarios de prueba
INSERT INTO blockbuster_usuarios (nombre_usuario, ap_usuario, am_usuario, email_usuario, password_usuario, id_rol, estatus_usuario) VALUES
('Admin', 'Sistema', 'Principal', 'admin@blockbuster.com', '$2y$10$hHAdoPnlb/Gj1Yrowlq1FuPMf5HrlRDlVgrklknKyU.aIQUsBRDVW', 1, 1),
('Operador', 'Sistema', 'Principal', 'operador@blockbuster.com', '$2y$10$T3JRYKtcb2jDLpLEsbsbIeDa5I6wdzIbkRv1XIwSLwMTVxVb0PiSG', 2, 1),
('Cliente', 'Sistema', 'Principal', 'cliente@blockbuster.com', '$2y$10$T1VHSIUP7KuZvlvbX2nqwuaAKru.LI1mSCUtwTi3g6LRjVC2Gjxym', 3, 1);

-- 5. Crear tabla planes
CREATE TABLE IF NOT EXISTS blockbuster_planes (
    id_plan INT(3) PRIMARY KEY AUTO_INCREMENT,
    estatus_plan TINYINT(1) DEFAULT 1,
    nombre_plan VARCHAR(30) NOT NULL,
    precio_plan DECIMAL(10,2) NOT NULL,
    cantidad_limite_plan TINYINT(1) NOT NULL,
    tipo_plan TINYINT(1)
);

-- Insertar planes
INSERT INTO blockbuster_planes (nombre_plan, precio_plan, cantidad_limite_plan, estatus_plan) VALUES
('Plan Básico', 9.99, 1, 1),
('Plan Premium', 15.99, 4, 1),
('Plan Familiar', 19.99, 6, 1);

-- 6. Crear tabla streaming (El corazón del catálogo)
CREATE TABLE IF NOT EXISTS blockbuster_streaming (
    id_streaming INT(11) PRIMARY KEY AUTO_INCREMENT,
    estatus_streaming TINYINT(1) DEFAULT 1,
    nombre_streaming VARCHAR(50) NOT NULL,
    fecha_lanzamiento_streaming DATE,
    duracion_streaming TIME,
    temporadas_streaming TINYINT(1),
    caratula_streaming VARCHAR(50),
    trailer_streaming VARCHAR(70),
    clasificacion_streaming VARCHAR(3),
    sipnosis_streaming TEXT,
    fecha_estreno_streaming DATE,
    id_genero INT(3),
    FOREIGN KEY (id_genero) REFERENCES blockbuster_generos(id_genero)
);

-- Insertar contenido (Original + Imágenes solicitadas)
INSERT INTO blockbuster_streaming (nombre_streaming, id_genero, duracion_streaming, temporadas_streaming, clasificacion_streaming, caratula_streaming, trailer_streaming, estatus_streaming, sipnosis_streaming, fecha_estreno_streaming) VALUES
('Avengers: Endgame', 1, '03:01:00', NULL, 'B15', 'endgame.jpg', 'https://youtu.be/TcMBFSGVi1c', 1, 'Un final épico para la saga de los superhéroes.', '2019-04-26'),
('The Mandalorian', 6, NULL, 3, 'B', 'mandalorian.jpg', 'https://youtu.be/BbNvKCuEF4E', 1, 'Aventura espacial con el Niño y los mandalorianos.', '2019-11-12'),
('Inception', 6, '02:28:00', NULL, 'B15', 'inception.jpg', 'https://youtu.be/YoHD9XEInc0', 1, 'La frontera entre sueño y realidad se desdibuja.', '2010-07-16'),
('The Batman', 1, '02:56:00', NULL, 'B15', 'batman.jpg', NULL, 1, 'Batman desenmascara la corrupción en Gotham City.', '2022-03-04'),
('Breaking Bad', 3, NULL, 5, 'C', 'breaking.jpg', NULL, 1, 'Un profesor de química se convierte en productor de metanfetamina.', '2008-01-20'),
('Coco', 6, '01:45:00', NULL, 'AA', 'coco.jpg', NULL, 1, 'Miguel viaja a la Tierra de los Muertos.', '2017-10-27'),
('Interestelar', 6, '02:49:00', NULL, 'B', 'interstellar.jpg', NULL, 1, 'Un equipo de exploradores viaja a través de un agujero de gusano.', '2014-11-07'),
('Spider-Man: No Way Home', 1, '02:28:00', NULL, 'B', 'spiderman.jpg', NULL, 1, 'Peter Parker busca la ayuda del Doctor Strange.', '2021-12-17'),
('Stranger Things', 6, NULL, 4, 'B15', 'stranger.jpg', NULL, 1, 'Un niño desaparece en un pequeño pueblo.', '2016-07-15'),
('The Last of Us', 3, NULL, 1, 'C', 'tlou.jpg', NULL, 1, 'Supervivencia en un mundo post-apocalíptico.', '2023-01-15');

-- 7. Crear tabla de videos
CREATE TABLE IF NOT EXISTS blockbuster_videos (
    id_video INT(11) PRIMARY KEY AUTO_INCREMENT,
    estatus_video TINYINT(1) DEFAULT 1,
    video VARCHAR(70),
    nombre_temporada VARCHAR(70),
    video_temporada TINYINT(1),
    capitulo_temporada TINYINT(1),
    descripcion_capitulo_temporada TEXT,
    id_streaming INT(11),
    FOREIGN KEY (id_streaming) REFERENCES blockbuster_streaming(id_streaming)
);

-- 8. Crear tablas transaccionales
CREATE TABLE IF NOT EXISTS blockbuster_usuarios_planes (
    id_usuario_plan INT(11) PRIMARY KEY AUTO_INCREMENT,
    fecha_registro_plan DATE,
    fecha_fin_plan DATE,
    id_usuario INT(11) NOT NULL,
    id_plan INT(3) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES blockbuster_usuarios(id_usuario),
    FOREIGN KEY (id_plan) REFERENCES blockbuster_planes(id_plan)
);

CREATE TABLE IF NOT EXISTS blockbuster_alquileres (
    id_alquiler INT(11) PRIMARY KEY AUTO_INCREMENT,
    fecha_inicio_alquiler DATE,
    fecha_fin_alquiler DATE,
    estatus_alquiler TINYINT(1) DEFAULT 1,
    id_streaming INT(11) NOT NULL,
    id_usuario INT(11) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES blockbuster_usuarios(id_usuario),
    FOREIGN KEY (id_streaming) REFERENCES blockbuster_streaming(id_streaming)
);

CREATE TABLE IF NOT EXISTS blockbuster_pagos (
    id_pago INT(11) PRIMARY KEY AUTO_INCREMENT,
    fecha_registro_pago DATE,
    estatus_pago TINYINT(1) DEFAULT 1,
    monto_pago DECIMAL(10,2),
    tarjeta_pago VARCHAR(32),
    id_usuario INT(11) NOT NULL,
    id_plan INT(3) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES blockbuster_usuarios(id_usuario),
    FOREIGN KEY (id_plan) REFERENCES blockbuster_planes(id_plan)
);

SELECT 'Base de datos Blockbuster actualizada con éxito!' as mensaje;