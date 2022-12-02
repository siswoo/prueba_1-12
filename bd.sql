DROP DATABASE IF EXISTS prueba1_12;
CREATE DATABASE prueba1_12;
USE prueba1_12;

DROP TABLE IF EXISTS categorias;
CREATE TABLE categorias (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE categorias CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO categorias (nombre) VALUES 
('categoria1'),
('categoria2'),
('categoria3');

DROP TABLE IF EXISTS libros;
CREATE TABLE libros (
	id INT AUTO_INCREMENT,
	titulo VARCHAR(250) NOT NULL,
	descripcion VARCHAR(250) NOT NULL,
	categoria_id INT NOT NULL,
	fecha_creacion DATE NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (categoria_id) REFERENCES categorias (id)
); ALTER TABLE libros CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO libros (titulo,descripcion,categoria_id,fecha_creacion) VALUES 
('Libro1','Descripcion1',1,'2022-12-01'),
('Libro2','Descripcion2',2,'2022-12-01'),
('Libro3','Descripcion3',3,'2022-12-01');

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
	id INT AUTO_INCREMENT,
	usuario VARCHAR(250) NOT NULL,
	clave VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO usuarios (usuario,clave) VALUES 
('juan','d964173dc44da83eeafa3aebbee9a1a0');

DROP TABLE IF EXISTS logs;
CREATE TABLE logs (
	id INT AUTO_INCREMENT,
	usuario_id INT NOT NULL,
	accion VARCHAR(250) NOT NULL,
	fecha_creacion DATE NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
); ALTER TABLE logs CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;