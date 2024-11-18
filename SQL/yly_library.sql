-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2024 a las 23:13:05
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
-- Base de datos: ylylibrary
--
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla categoria
--
CREATE TABLE categoria (
  id INT(10) NOT NULL AUTO_INCREMENT, 
  nombre_categoria VARCHAR(50) NOT NULL, 
  descripcion TEXT, 
  PRIMARY KEY (id) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla libros
--
CREATE TABLE libros (
  codigo INT(10) NOT NULL,
  Editorial VARCHAR(30) NOT NULL,
  titulo VARCHAR(30) NOT NULL, 
  Genero VARCHAR(30) NOT NULL, 
  Autor VARCHAR(30) NOT NULL, 
  categoria_id INT(10), 
  PRIMARY KEY (codigo), 
  CONSTRAINT fk_categoria_libros FOREIGN KEY (categoria_id) REFERENCES categoria(id) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estructura de tabla para la tabla usuarios
CREATE TABLE usuarios (
  nombre VARCHAR(50) NOT NULL, 
  N_Cedula INT(10) NOT NULL, 
  contraseña VARCHAR(100) NOT NULL, 
  tipo_usuario VARCHAR(20) NOT NULL, 
  PRIMARY KEY (N_Cedula) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- tabla prestamos 
-- 
CREATE TABLE prestamos (
  id INT(10) NOT NULL AUTO_INCREMENT, -- ID único para cada préstamo
  id_libro INT(10) NOT NULL, -- Relación con la tabla libros
  id_usuario INT(10) NOT NULL, -- Relación con la tabla usuarios
  titulo_libro VARCHAR(255) NOT NULL, -- Título del libro
  fecha_prestamo DATETIME NOT NULL, -- Fecha en que se realizó el préstamo
  fecha_regreso DATETIME DEFAULT NULL, -- Fecha en que se devuelve el libro (puede ser NULL mientras esté activo)
  PRIMARY KEY (id), -- Declarar el campo 'id' como clave primaria
  FOREIGN KEY (id_libro) REFERENCES libros(codigo), -- Relación con 'libros'
  FOREIGN KEY (id_usuario) REFERENCES usuarios(N_Cedula)-- Relación con 'usuarios'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Volcado de datos para la tabla usuarios
--

INSERT INTO usuarios (nombre, N_Cedula, contraseña, tipo_usuario) VALUES
('Laura', 1, '098765', 'Administrador');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;