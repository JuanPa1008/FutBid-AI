-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.4.3 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para futbid_ai
CREATE DATABASE IF NOT EXISTS `futbid_ai` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `futbid_ai`;

-- Volcando estructura para tabla futbid_ai.ofertas
CREATE TABLE IF NOT EXISTS `ofertas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `playera_id` int DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `playera_id` (`playera_id`),
  CONSTRAINT `ofertas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `ofertas_ibfk_2` FOREIGN KEY (`playera_id`) REFERENCES `playeras` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla futbid_ai.ofertas: ~4 rows (aproximadamente)
INSERT INTO `ofertas` (`id`, `usuario_id`, `playera_id`, `monto`, `creado_en`) VALUES
	(2, 2, 1, 1700.00, '2026-05-26 04:27:20'),
	(3, 2, 2, 1400.00, '2026-05-26 16:32:23'),
	(4, 1, 2, 1800.00, '2026-05-26 16:47:59'),
	(5, 2, 2, 1900.00, '2026-05-26 18:02:19');

-- Volcando estructura para tabla futbid_ai.playeras
CREATE TABLE IF NOT EXISTS `playeras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `equipo` varchar(100) NOT NULL,
  `jugador` varchar(100) DEFAULT NULL,
  `temporada` varchar(50) DEFAULT NULL,
  `talla` varchar(20) DEFAULT NULL,
  `precio_inicial` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `autenticidad` int DEFAULT '94',
  `rareza` varchar(50) DEFAULT 'Alta',
  `precio_sugerido` varchar(100) DEFAULT '$1,700-$2,000',
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_cierre` datetime DEFAULT NULL,
  `ganador_id` int DEFAULT NULL,
  `finalizada` tinyint DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `playeras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla futbid_ai.playeras: ~2 rows (aproximadamente)
INSERT INTO `playeras` (`id`, `usuario_id`, `equipo`, `jugador`, `temporada`, `talla`, `precio_inicial`, `imagen`, `autenticidad`, `rareza`, `precio_sugerido`, `creado_en`, `fecha_cierre`, `ganador_id`, `finalizada`) VALUES
	(1, 2, 'Atletico La Paz', 'Horacio Torres', '2026', 'M', 1249.00, 'uploads/1779769332_playera.png', 94, 'Alta', '$1,700-$2,000', '2026-05-26 04:22:12', '2026-05-26 11:39:13', 2, 1),
	(2, 2, 'Atlante', 'Diego Cruz', '2026', 'M', 1350.00, 'uploads/1779813105_jerseyatlante.png', 94, 'Alta', '$1,700-$2,000', '2026-05-26 16:31:45', '2026-05-26 13:12:30', 2, 1);

-- Volcando estructura para tabla futbid_ai.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('usuario','admin') DEFAULT 'usuario',
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla futbid_ai.usuarios: ~3 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `creado_en`) VALUES
	(1, 'Galilea Lopez', 'ochoadara1@gmail.com', '$2y$10$CHqJPAIGX8bvKHkkw2a97OPKB.GmFJ.hT/9OUn/lMLdW', 'usuario', '2026-05-25 23:00:33'),
	(2, 'Juan Pablo', 'jpcarrillo59@gmail.com', '$2y$10$NLgME2M.aBrZgQEeDCQSmeOeNi/tby7isOSQHpgpOr4Al', 'usuario', '2026-05-25 23:18:40'),
	(3, 'Administrador FutBid', 'admin@futbid.com', '$2y$10$dRdd3MJxlNW18o3GMn4O4.Rbj154g0gsqomHw7OQG', 'admin', '2026-05-26 18:14:29');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
