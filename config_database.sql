-- Script SQL Unificado con Catálogo Extendido (Mínimo 2 títulos por género)
-- Configuración: utf8mb4_general_ci

CREATE DATABASE IF NOT EXISTS blockbuster CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE blockbuster;

-- 1. Usuarios y Roles
CREATE USER IF NOT EXISTS 'blockbuser'@'localhost' IDENTIFIED BY 'blockpass487';
GRANT ALL PRIVILEGES ON blockbuster.* TO 'blockbuser'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS blockbuster_roles (
    id_rol INT(3) PRIMARY KEY AUTO_INCREMENT,
    nombre_rol VARCHAR(30) NOT NULL
);

INSERT INTO blockbuster_roles (nombre_rol) VALUES ('Administrador'), ('Operador'), ('Cliente');

-- 2. Tabla de Géneros (26 categorías)
CREATE TABLE IF NOT EXISTS blockbuster_generos (
    id_genero INT(3) PRIMARY KEY AUTO_INCREMENT,
    estatus_genero TINYINT(1) DEFAULT 1,
    nombre_genero VARCHAR(30) NOT NULL,
    descripcion_genero TEXT
);

INSERT INTO blockbuster_generos (id_genero, estatus_genero, nombre_genero, descripcion_genero) VALUES
(1, 1, 'Acción', 'Escenas de combate, persecuciones y adrenalina.'),
(2, 1, 'Aventura', 'Historias de exploración y desafíos emocionantes.'),
(3, 1, 'Ciencia Ficción', 'Futuros distópicos, tecnología avanzada y viajes espaciales.'),
(4, 1, 'Comedia', 'Situaciones humorísticas y personajes divertidos.'),
(5, 1, 'Drama', 'Historias emocionales con conflictos personales profundos.'),
(6, 1, 'Fantasía', 'Mundos mágicos, criaturas míticas y poderes sobrenaturales.'),
(7, 1, 'Suspenso', 'Intriga, tensión y giros inesperados.'),
(8, 1, 'Terror', 'Historias de miedo con atmósferas inquietantes.'),
(9, 1, 'Animación', 'Películas y series animadas en diferentes estilos.'),
(10, 1, 'Anime', 'Animación japonesa con múltiples subgéneros.'),
(11, 1, 'Biográfico', 'Historias basadas en la vida de personajes reales.'),
(12, 1, 'Crimen / Policíaco', 'Investigaciones criminales, mafia y detectives.'),
(13, 1, 'Deportes', 'Historias centradas en disciplinas deportivas y atletas.'),
(14, 1, 'Documental', 'Basado en hechos reales con análisis y entrevistas.'),
(15, 1, 'Guerra / Bélico', 'Historias ambientadas en conflictos militares.'),
(16, 1, 'Histórico', 'Dramas basados en eventos históricos reales.'),
(17, 1, 'Musical', 'Películas y series con canciones y coreografías.'),
(18, 1, 'Romance', 'Historias de amor y relaciones sentimentales.'),
(19, 1, 'Superhéroes', 'Personajes con habilidades extraordinarias.'),
(20, 1, 'Western', 'Historias del viejo oeste, vaqueros y forajidos.'),
(21, 1, 'Comedia Romántica', 'Romance con elementos de humor ligero.'),
(22, 1, 'Ciberpunk', 'Futuro distópico con tecnología avanzada.'),
(23, 1, 'Gore / Slasher', 'Terror con violencia extrema y sangre explícita.'),
(24, 1, 'Noir / Neo-Noir', 'Historias criminales con un tono oscuro y detectives.'),
(25, 1, 'Survival', 'Personajes enfrentando condiciones extremas para sobrevivir.'),
(26, 1, 'Utopía / Distopía', 'Mundos futuros ideales o en crisis política y social.');

-- 3. Tabla Streaming (Contenido con 2 títulos por género)
CREATE TABLE IF NOT EXISTS blockbuster_streaming (
    id_streaming INT(11) PRIMARY KEY AUTO_INCREMENT,
    estatus_streaming TINYINT(1) DEFAULT 1,
    nombre_streaming VARCHAR(100) NOT NULL,
    duracion_streaming TIME,
    temporadas_streaming TINYINT(1),
    clasificacion_streaming VARCHAR(3),
    caratula_streaming VARCHAR(50),
    sipnosis_streaming TEXT,
    id_genero INT(3),
    FOREIGN KEY (id_genero) REFERENCES blockbuster_generos(id_genero)
);

INSERT INTO blockbuster_streaming (nombre_streaming, id_genero, clasificacion_streaming, caratula_streaming, sipnosis_streaming) VALUES
-- Acción (1)
('John Wick', 1, 'C', 'johnwick.jpg', 'Un exasesino busca venganza por su perro.'),
('Mad Max: Fury Road', 1, 'B15', 'madmax.jpg', 'Persecución postapocalíptica en el desierto.'),
-- Aventura (2)
('Indiana Jones: Raiders', 2, 'B', 'indiana.jpg', 'Un arqueólogo busca el Arca Perdida.'),
('Uncharted', 2, 'B', 'uncharted.jpg', 'Nathan Drake busca un tesoro perdido.'),
-- Ciencia Ficción (3)
('Interstellar', 3, 'B', 'interstellar.jpg', 'Viaje a través de un agujero de gusano.'),
('Blade Runner 2049', 3, 'B15', 'bladerunner.jpg', 'Un replicante busca a una leyenda perdida.'),
-- Comedia (4)
('The Hangover', 4, 'C', 'hangover.jpg', 'Tres amigos despiertan tras una despedida de soltero.'),
('Superbad', 4, 'C', 'superbad.jpg', 'Dos amigos intentan comprar alcohol para una fiesta.'),
-- Drama (5)
('The Godfather', 5, 'C', 'godfather.jpg', 'La historia de una familia de la mafia.'),
('Parasite', 5, 'C', 'parasite.jpg', 'Una familia pobre se infiltra en una rica.'),
-- Fantasía (6)
('Harry Potter y la Piedra Filosofal', 6, 'A', 'hp1.jpg', 'Un niño descubre que es mago.'),
('The Lord of the Rings: Fellowship', 6, 'B', 'lotr1.jpg', 'Un hobbit debe destruir un anillo único.'),
-- Suspenso (7)
('Se7en', 7, 'C', 'seven.jpg', 'Dos detectives cazan a un asesino serial.'),
('Shutter Island', 7, 'B15', 'shutter.jpg', 'Un agente investiga un hospital psiquiátrico.'),
-- Terror (8)
('The Conjuring', 8, 'B15', 'conjuring.jpg', 'Investigadores paranormales ayudan a una familia.'),
('Hereditary', 8, 'C', 'hereditary.jpg', 'Una familia enfrenta una herencia siniestra.'),
-- Animación (9)
('Toy Story', 9, 'AA', 'toystory.jpg', 'Juguetes que cobran vida.'),
('Spider-Man: Into the Spider-Verse', 9, 'A', 'spiderv.jpg', 'Múltiples versiones de Spider-Man se unen.'),
-- Anime (10)
('Demon Slayer: Mugen Train', 10, 'B15', 'demonslayer.jpg', 'Tanjiro lucha contra demonios en un tren.'),
('El Viaje de Chihiro', 10, 'A', 'chihiro.jpg', 'Una niña entra en un mundo espiritual.'),
-- Biográfico (11)
('Bohemian Rhapsody', 11, 'B', 'freddie.jpg', 'La vida de Freddie Mercury y Queen.'),
('Oppenheimer', 11, 'B15', 'oppenheimer.jpg', 'El creador de la bomba atómica.'),
-- Crimen (12)
('Breaking Bad', 12, 'C', 'breaking.jpg', 'Un profesor vende metanfetamina.'),
('The Irishman', 12, 'C', 'irishman.jpg', 'Un sicario recuerda su vida en la mafia.'),
-- Deportes (13)
('Rocky', 13, 'B', 'rocky.jpg', 'Un boxeador amateur tiene una oportunidad única.'),
('The Last Dance', 13, 'B', 'lastdance.jpg', 'Documental sobre Michael Jordan y los Bulls.'),
-- Documental (14)
('Our Planet', 14, 'A', 'ourplanet.jpg', 'Exploración de la belleza de la Tierra.'),
('The Social Dilemma', 14, 'B', 'social.jpg', 'El impacto de las redes sociales.'),
-- Guerra (15)
('Saving Private Ryan', 15, 'C', 'ryan.jpg', 'Misión para rescatar a un soldado en el Día D.'),
('1917', 15, 'B15', '1917.jpg', 'Dos soldados deben entregar un mensaje vital.'),
-- Histórico (16)
('Gladiator', 16, 'B15', 'gladiator.jpg', 'Un general romano busca venganza en la arena.'),
('Schindler\'s List', 16, 'C', 'schindler.jpg', 'Un hombre salva judíos durante el Holocausto.'),
-- Musical (17)
('La La Land', 17, 'B', 'lalaland.jpg', 'Un músico y una actriz se enamoran en LA.'),
('Hamilton', 17, 'B', 'hamilton.jpg', 'La vida de Alexander Hamilton cantada.'),
-- Romance (18)
('The Notebook', 18, 'B', 'notebook.jpg', 'Una historia de amor eterno.'),
('Pride and Prejudice', 18, 'A', 'pride.jpg', 'El romance entre Elizabeth y Mr. Darcy.'),
-- Superhéroes (19)
('Avengers: Endgame', 19, 'B', 'endgame.jpg', 'Los héroes intentan revertir el chasquido de Thanos.'),
('The Dark Knight', 19, 'B15', 'darkknight.jpg', 'Batman enfrenta al Joker en Gotham.'),
-- Western (20)
('Django Unchained', 20, 'C', 'django.jpg', 'Un esclavo liberado busca rescatar a su esposa.'),
('The Good, the Bad and the Ugly', 20, 'B', 'western.jpg', 'Tres hombres buscan un tesoro enterrado.'),
-- Comedia Romántica (21)
('About Time', 21, 'B', 'abouttime.jpg', 'Un joven viaja en el tiempo por amor.'),
('10 Things I Hate About You', 21, 'B', '10things.jpg', 'Una versión moderna de Shakespeare.'),
-- Ciberpunk (22)
('The Matrix', 22, 'B15', 'matrix.jpg', 'La realidad es una simulación.'),
('Cyberpunk: Edgerunners', 22, 'C', 'edgerunners.jpg', 'Un joven sobrevive en Night City.'),
-- Gore (23)
('Saw', 23, 'C', 'saw.jpg', 'Un asesino pone a prueba el instinto de vivir.'),
('Evil Dead Rise', 23, 'C', 'evildead.jpg', 'Un libro libera demonios en un edificio.'),
-- Noir (24)
('Chinatown', 24, 'C', 'chinatown.jpg', 'Un detective investiga un caso de corrupción.'),
('Seven Psychopaths', 24, 'C', 'noir.jpg', 'Escritores y criminales se mezclan en LA.'),
-- Survival (25)
('The Last of Us', 25, 'C', 'tlou.jpg', 'Sobreviviendo a una infección fúngica.'),
('The Revenant', 25, 'C', 'revenant.jpg', 'Un trampero lucha por sobrevivir en el frío.'),
-- Utopía/Distopía (26)
('The Hunger Games', 26, 'B15', 'hungergames.jpg', 'Jóvenes obligados a pelear a muerte.'),
('Black Mirror', 26, 'C', 'blackmirror.jpg', 'Relatos distópicos sobre la tecnología.');

-- 4. Tablas adicionales (Estructura final)
CREATE TABLE IF NOT EXISTS blockbuster_usuarios (
    id_usuario INT(11) PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(50) NOT NULL,
    email_usuario VARCHAR(70) UNIQUE NOT NULL,
    password_usuario VARCHAR(255) NOT NULL,
    id_rol INT(3) NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES blockbuster_roles(id_rol)
);

CREATE TABLE IF NOT EXISTS blockbuster_videos (
    id_video INT(11) PRIMARY KEY AUTO_INCREMENT,
    nombre_capitulo VARCHAR(70),
    id_streaming INT(11),
    FOREIGN KEY (id_streaming) REFERENCES blockbuster_streaming(id_streaming)
);

-- Inserción de usuarios básica
INSERT INTO blockbuster_usuarios (nombre_usuario, email_usuario, password_usuario, id_rol) VALUES
('Admin', 'admin@blockbuster.com', 'hash_pass_123', 1),
('User1', 'cliente@gmail.com', 'hash_pass_456', 3);

SELECT 'Base de datos Blockbuster con catálogo completo creada!' as mensaje;