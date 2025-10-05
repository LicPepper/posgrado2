-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-10-2025 a las 08:47:32
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `residencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

DROP TABLE IF EXISTS `alumno`;
CREATE TABLE IF NOT EXISTS `alumno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `programa_id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `titulo_tesis` varchar(255) DEFAULT NULL,
  `articulo_ingles` varchar(255) DEFAULT NULL,
  `fecha_egreso` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`, `matricula`, `programa_id`, `email`, `telefono`, `titulo_tesis`, `articulo_ingles`, `fecha_egreso`, `activo`, `fecha_creacion`) VALUES
(1, 'Ana', 'García', 'López', '2024MPE001', 1, 'ana.garcia@itvh.edu.mx', '9931000001', 'Análisis del impacto económico regional de las PYMES en Tabasco', 'Economic impact of SMEs in Southeast Mexico', NULL, 1, '2025-09-18 09:04:38'),
(2, 'Carlos', 'Martínez', 'Sánchez', '2024MPE002', 1, 'carlos.martinez@itvh.edu.mx', '9931000002', 'Estrategias de desarrollo sostenible para comunidades rurales', 'Sustainable development strategies for rural communities', NULL, 1, '2025-09-18 09:04:38'),
(3, 'Laura', 'Hernández', 'Gómez', '2024MPE003', 1, 'laura.hernandez@itvh.edu.mx', '9931000003', 'Planificación estratégica para MIPYMES del sector servicios', 'Strategic planning for service sector MSMEs', NULL, 1, '2025-09-18 09:04:38'),
(4, 'Miguel', 'Díaz', 'Ramírez', '2024MPE004', 1, 'miguel.diaz@itvh.edu.mx', '9931000004', 'Modelos de negocio para economías circulares emergentes', 'Business models for emerging circular economies', NULL, 1, '2025-09-18 09:04:38'),
(5, 'Sofía', 'Pérez', 'Castillo', '2024MPE005', 1, 'sofia.perez@itvh.edu.mx', '9931000005', 'Inversión extranjera directa y su impacto en el desarrollo regional', 'Foreign direct investment and regional development impact', NULL, 1, '2025-09-18 09:04:38'),
(6, 'Javier', 'López', 'Morales', '2024MPE006', 1, 'javier.lopez@itvh.edu.mx', '9931000006', 'Políticas públicas para el fomento empresarial en zonas marginadas', 'Public policies for business development in marginalized areas', NULL, 1, '2025-09-18 09:04:38'),
(7, 'Elena', 'Gómez', 'Vargas', '2024MPE007', 1, 'elena.gomez@itvh.edu.mx', '9931000007', 'Análisis de clusters industriales en el sureste mexicano', 'Industrial cluster analysis in Southeast Mexico', NULL, 1, '2025-09-18 09:04:38'),
(8, 'Ricardo', 'Rodríguez', 'Silva', '2024MPE008', 1, 'ricardo.rodriguez@itvh.edu.mx', '9931000008', 'Emprendimiento social como motor de desarrollo comunitario', 'Social entrepreneurship as community development driver', NULL, 1, '2025-09-18 09:04:38'),
(9, 'Carmen', 'Torres', 'Mendoza', '2024MPE009', 1, 'carmen.torres@itvh.edu.mx', '9931000009', 'Planificación urbana y su relación con el desarrollo económico', 'Urban planning and its relationship with economic development', NULL, 1, '2025-09-18 09:04:38'),
(10, 'Fernando', 'Ortiz', 'Cruz', '2024MPE010', 1, 'fernando.ortiz@itvh.edu.mx', '9931000010', 'Economía naranja: oportunidades para el desarrollo regional', 'Orange economy: opportunities for regional development', NULL, 1, '2025-09-18 09:04:38'),
(11, 'Luis', 'Moreno', 'Gutiérrez', '2024MTI001', 2, 'luis.moreno@itvh.edu.mx', '9932000001', 'Framework para el desarrollo de aplicaciones móviles multiplataforma', 'Cross-platform mobile application development framework', NULL, 1, '2025-09-18 09:04:39'),
(12, 'Andrea', 'Rojas', 'Padilla', '2024MTI002', 2, 'andrea.rojas@itvh.edu.mx', '9932000002', 'Sistema de recomendación basado en machine learning para e-commerce', 'Machine learning based recommendation system for e-commerce', NULL, 1, '2025-09-18 09:04:39'),
(13, 'Jorge', 'Campos', 'Espinoza', '2024MTI003', 2, 'jorge.campos@itvh.edu.mx', '9932000003', 'Arquitectura de microservicios para aplicaciones empresariales escalables', 'Microservices architecture for scalable enterprise applications', NULL, 1, '2025-09-18 09:04:39'),
(14, 'Carolina', 'Méndez', 'Duarte', '2024MTI004', 2, 'carolina.mendez@itvh.edu.mx', '9932000004', 'Análisis de big data para la predicción de tendencias de mercado', 'Big data analysis for market trend prediction', NULL, 1, '2025-09-18 09:04:39'),
(15, 'Oscar', 'Herrera', 'Zamora', '2024MTI005', 2, 'oscar.herrera@itvh.edu.mx', '9932000005', 'Blockchain aplicado a la trazabilidad en cadenas de suministro', 'Blockchain applied to traceability in supply chains', NULL, 1, '2025-09-18 09:04:39'),
(16, 'Adriana', 'Luna', 'Cervantes', '2024MTI006', 2, 'adriana.luna@itvh.edu.mx', '9932000006', 'Desarrollo de chatbots inteligentes para servicio al cliente', 'Development of intelligent chatbots for customer service', NULL, 1, '2025-09-18 09:04:39'),
(17, 'Pedro', 'Sosa', 'Bautista', '2024MTI007', 2, 'pedro.sosa@itvh.edu.mx', '9932000007', 'Sistema de detección de intrusos basado en inteligencia artificial', 'Artificial intelligence based intrusion detection system', NULL, 1, '2025-09-18 09:04:39'),
(18, 'Mónica', 'Valdez', 'Gallardo', '2024MTI008', 2, 'monica.valdez@itvh.edu.mx', '9932000008', 'Plataforma IoT para monitoreo de variables ambientales en smart cities', 'IoT platform for environmental monitoring in smart cities', NULL, 1, '2025-09-18 09:04:39'),
(19, 'Héctor', 'Cruz', 'Ochoa', '2024MTI009', 2, 'hector.cruz@itvh.edu.mx', '9932000009', 'Framework para desarrollo ágil de aplicaciones web progresivas', 'Framework for agile development of progressive web applications', NULL, 1, '2025-09-18 09:04:39'),
(20, 'Silvia', 'Paredes', 'Rosales', '2024MTI010', 2, 'silvia.paredes@itvh.edu.mx', '9932000010', 'Algoritmos de computer vision para diagnóstico médico asistido', 'Computer vision algorithms for assisted medical diagnosis', NULL, 1, '2025-09-18 09:04:39'),
(21, 'Alejandra', 'Santiago', 'Mora', '2024MIG001', 3, 'alejandra.santiago@itvh.edu.mx', '9933000001', 'Diseño y optimización de procesos industriales mediante simulación', 'Design and optimization of industrial processes through simulation', NULL, 1, '2025-09-18 09:04:39'),
(22, 'Roberto', 'Maldonado', 'Zúñiga', '2024MIG002', 3, 'roberto.maldonado@itvh.edu.mx', '9933000002', 'Desarrollo de materiales compuestos para aplicaciones aeronáuticas', 'Development of composite materials for aeronautical applications', NULL, 1, '2025-09-18 09:04:39'),
(23, 'Beatriz', 'Zamora', 'Carrasco', '2024MIG003', 3, 'beatriz.zamora@itvh.edu.mx', '9933000003', 'Análisis de fatiga en estructuras sometidas a cargas cíclicas', 'Fatigue analysis in structures subjected to cyclic loads', NULL, 1, '2025-09-18 09:04:39'),
(24, 'José', 'Reyes', 'Pimentel', '2024MIG004', 3, 'jose.reyes@itvh.edu.mx', '9933000004', 'Optimización de sistemas de energía renovable híbridos', 'Optimization of hybrid renewable energy systems', NULL, 1, '2025-09-18 09:04:39'),
(25, 'Carmen', 'Vázquez', 'Delgado', '2024MIG005', 3, 'carmen.vazquez@itvh.edu.mx', '9933000005', 'Diseño de plantas de tratamiento de aguas residuales', 'Design of wastewater treatment plants', NULL, 1, '2025-09-18 09:04:39'),
(26, 'Ángel', 'Cortés', 'Rivas', '2024MIG006', 3, 'angel.cortes@itvh.edu.mx', '9933000006', 'Desarrollo de aleaciones metálicas para alta temperatura', 'Development of metallic alloys for high temperature', NULL, 1, '2025-09-18 09:04:39'),
(27, 'Lourdes', 'Ponce', 'Salas', '2024MIG007', 3, 'lourdes.ponce@itvh.edu.mx', '9933000007', 'Modelado y simulación de procesos de manufactura aditiva', 'Modeling and simulation of additive manufacturing processes', NULL, 1, '2025-09-18 09:04:39'),
(28, 'Francisco', 'Santillán', 'Ochoa', '2024MIG008', 3, 'francisco.santillan@itvh.edu.mx', '9933000008', 'Diseño de sistemas de automatización industrial con PLC', 'Design of industrial automation systems with PLC', NULL, 1, '2025-09-18 09:04:39'),
(29, 'Rocío', 'Barrios', 'Valencia', '2024MIG009', 3, 'rocio.barrios@itvh.edu.mx', '9933000009', 'Análisis estructural de puentes bajo cargas dinámicas', 'Structural analysis of bridges under dynamic loads', NULL, 1, '2025-09-18 09:04:39'),
(30, 'Eduardo', 'Navarro', 'Romo', '2024MIG010', 3, 'eduardo.navaro@itvh.edu.mx', '9933000010', 'Desarrollo de catalizadores para procesos de refinación', 'Development of catalysts for refining processes', NULL, 1, '2025-09-18 09:04:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avancealumno`
--

DROP TABLE IF EXISTS `avancealumno`;
CREATE TABLE IF NOT EXISTS `avancealumno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alumno_id` int NOT NULL,
  `requisito_id` int NOT NULL,
  `completado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_completado` datetime DEFAULT NULL,
  `evidencia` varchar(255) DEFAULT NULL,
  `comentarios` text,
  `validado_por` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alumnoRequisito` (`alumno_id`,`requisito_id`),
  KEY `avancealumno_ibfk_2` (`requisito_id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `avancealumno`
--

INSERT INTO `avancealumno` (`id`, `alumno_id`, `requisito_id`, `completado`, `fecha_completado`, `evidencia`, `comentarios`, `validado_por`) VALUES
(1, 1, 1, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(2, 1, 2, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(3, 1, 5, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(4, 1, 7, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(5, 1, 9, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(6, 1, 3, 0, NULL, NULL, NULL, 16),
(7, 1, 4, 0, NULL, NULL, NULL, 16),
(8, 1, 6, 0, NULL, NULL, NULL, 16),
(9, 1, 8, 0, NULL, NULL, NULL, 16),
(10, 1, 10, 0, NULL, NULL, NULL, 16),
(11, 21, 14, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(12, 21, 15, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(13, 21, 16, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(14, 21, 20, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(15, 21, 21, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(16, 21, 22, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(17, 21, 11, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(18, 21, 12, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(19, 21, 13, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(20, 21, 17, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(21, 21, 18, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(22, 21, 19, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(23, 21, 1, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(24, 21, 2, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(25, 21, 5, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(26, 21, 7, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(27, 21, 9, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(28, 21, 3, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(29, 21, 4, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(30, 21, 6, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(31, 21, 8, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(32, 21, 10, 1, '2025-09-19 06:34:43', NULL, NULL, 16),
(33, 21, 23, 0, NULL, NULL, NULL, 16),
(34, 21, 24, 0, NULL, NULL, NULL, 16),
(35, 21, 25, 0, NULL, NULL, NULL, 16),
(36, 1, 14, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(37, 1, 15, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(38, 1, 16, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(39, 1, 20, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(40, 1, 21, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(41, 1, 22, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(42, 1, 11, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(43, 1, 12, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(44, 1, 13, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(45, 1, 17, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(46, 1, 18, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(47, 1, 19, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(48, 1, 23, 0, NULL, NULL, NULL, 16),
(49, 1, 24, 0, NULL, NULL, NULL, 16),
(50, 1, 25, 0, NULL, NULL, NULL, 16),
(51, 17, 14, 0, NULL, NULL, NULL, 16),
(52, 17, 15, 0, NULL, NULL, NULL, 16),
(53, 17, 16, 0, NULL, NULL, NULL, 16),
(54, 17, 20, 0, NULL, NULL, NULL, 16),
(55, 17, 21, 0, NULL, NULL, NULL, 16),
(56, 17, 22, 0, NULL, NULL, NULL, 16),
(57, 17, 11, 0, NULL, NULL, NULL, 16),
(58, 17, 12, 0, NULL, NULL, NULL, 16),
(59, 17, 13, 0, NULL, NULL, NULL, 16),
(60, 17, 17, 0, NULL, NULL, NULL, 16),
(61, 17, 18, 0, NULL, NULL, NULL, 16),
(62, 17, 19, 0, NULL, NULL, NULL, 16),
(63, 17, 1, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(64, 17, 2, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(65, 17, 5, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(66, 17, 7, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(67, 17, 9, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(68, 17, 3, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(69, 17, 4, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(70, 17, 6, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(71, 17, 8, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(72, 17, 10, 1, '2025-09-21 08:40:04', NULL, NULL, 16),
(73, 17, 23, 0, NULL, NULL, NULL, 16),
(74, 17, 24, 0, NULL, NULL, NULL, 16),
(75, 17, 25, 0, NULL, NULL, NULL, 16),
(76, 7, 14, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(77, 7, 15, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(78, 7, 16, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(79, 7, 20, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(80, 7, 21, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(81, 7, 22, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(82, 7, 11, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(83, 7, 12, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(84, 7, 13, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(85, 7, 17, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(86, 7, 18, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(87, 7, 19, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(88, 7, 1, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(89, 7, 2, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(90, 7, 5, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(91, 7, 7, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(92, 7, 9, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(93, 7, 3, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(94, 7, 4, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(95, 7, 6, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(96, 7, 8, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(97, 7, 10, 1, '2025-09-22 10:28:00', NULL, NULL, 16),
(98, 7, 23, 0, NULL, NULL, NULL, 16),
(99, 7, 24, 0, NULL, NULL, NULL, 16),
(100, 7, 25, 0, NULL, NULL, NULL, 16),
(101, 20, 14, 0, NULL, NULL, NULL, 16),
(102, 20, 15, 0, NULL, NULL, NULL, 16),
(103, 20, 16, 0, NULL, NULL, NULL, 16),
(104, 20, 20, 0, NULL, NULL, NULL, 16),
(105, 20, 21, 0, NULL, NULL, NULL, 16),
(106, 20, 22, 0, NULL, NULL, NULL, 16),
(107, 20, 11, 0, NULL, NULL, NULL, 16),
(108, 20, 12, 0, NULL, NULL, NULL, 16),
(109, 20, 13, 0, NULL, NULL, NULL, 16),
(110, 20, 17, 0, NULL, NULL, NULL, 16),
(111, 20, 18, 0, NULL, NULL, NULL, 16),
(112, 20, 19, 0, NULL, NULL, NULL, 16),
(113, 20, 1, 1, '2025-09-22 10:57:02', NULL, NULL, 16),
(114, 20, 2, 1, '2025-09-22 10:57:02', NULL, NULL, 16),
(115, 20, 5, 1, '2025-09-22 10:57:02', NULL, NULL, 16),
(116, 20, 7, 1, '2025-09-22 10:57:02', NULL, NULL, 16),
(117, 20, 9, 1, '2025-09-22 10:57:02', NULL, NULL, 16),
(118, 20, 3, 0, NULL, NULL, NULL, 16),
(119, 20, 4, 0, NULL, NULL, NULL, 16),
(120, 20, 6, 0, NULL, NULL, NULL, 16),
(121, 20, 8, 0, NULL, NULL, NULL, 16),
(122, 20, 10, 0, NULL, NULL, NULL, 16),
(123, 20, 23, 0, NULL, NULL, NULL, 16),
(124, 20, 24, 0, NULL, NULL, NULL, 16),
(125, 20, 25, 0, NULL, NULL, NULL, 16),
(126, 1, 26, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(127, 1, 27, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(128, 1, 28, 1, '2025-09-30 10:52:56', NULL, NULL, 16),
(129, 15, 14, 0, NULL, NULL, NULL, 16),
(130, 15, 15, 0, NULL, NULL, NULL, 16),
(131, 15, 16, 0, NULL, NULL, NULL, 16),
(132, 15, 20, 0, NULL, NULL, NULL, 16),
(133, 15, 21, 0, NULL, NULL, NULL, 16),
(134, 15, 22, 0, NULL, NULL, NULL, 16),
(135, 15, 11, 0, NULL, NULL, NULL, 16),
(136, 15, 12, 0, NULL, NULL, NULL, 16),
(137, 15, 13, 0, NULL, NULL, NULL, 16),
(138, 15, 17, 0, NULL, NULL, NULL, 16),
(139, 15, 18, 0, NULL, NULL, NULL, 16),
(140, 15, 19, 0, NULL, NULL, NULL, 16),
(141, 15, 1, 1, '2025-09-23 17:36:32', NULL, NULL, 16),
(142, 15, 2, 1, '2025-09-23 17:36:32', NULL, NULL, 16),
(143, 15, 5, 1, '2025-09-23 17:36:32', NULL, NULL, 16),
(144, 15, 7, 1, '2025-09-23 17:36:32', NULL, NULL, 16),
(145, 15, 9, 1, '2025-09-23 17:36:32', NULL, NULL, 16),
(146, 15, 3, 0, NULL, NULL, NULL, 16),
(147, 15, 4, 0, NULL, NULL, NULL, 16),
(148, 15, 6, 0, NULL, NULL, NULL, 16),
(149, 15, 8, 0, NULL, NULL, NULL, 16),
(150, 15, 10, 0, NULL, NULL, NULL, 16),
(151, 15, 26, 0, NULL, NULL, NULL, 16),
(152, 15, 27, 0, NULL, NULL, NULL, 16),
(153, 15, 28, 0, NULL, NULL, NULL, 16),
(154, 15, 23, 0, NULL, NULL, NULL, 16),
(155, 15, 24, 0, NULL, NULL, NULL, 16),
(156, 15, 25, 0, NULL, NULL, NULL, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentogenerado`
--

DROP TABLE IF EXISTS `documentogenerado`;
CREATE TABLE IF NOT EXISTS `documentogenerado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alumno_id` int NOT NULL,
  `plantilla_id` int NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL,
  `hash_verificacion` varchar(64) NOT NULL,
  `fecha_generacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `generado_por` int DEFAULT NULL,
  `version` int NOT NULL DEFAULT '1',
  `estado` enum('Generado','Validado','Rechazado') NOT NULL DEFAULT 'Generado',
  `comentarios` text,
  PRIMARY KEY (`id`),
  KEY `alumno_id` (`alumno_id`),
  KEY `documentoGenerado_ibfk_2` (`plantilla_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `documentogenerado`
--

INSERT INTO `documentogenerado` (`id`, `alumno_id`, `plantilla_id`, `ruta_archivo`, `hash_verificacion`, `fecha_generacion`, `generado_por`, `version`, `estado`, `comentarios`) VALUES
(1, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758209518.pdf', '415927d07a64d27b631f33673d637adf', '2025-09-18 09:31:59', 16, 1, 'Generado', NULL),
(2, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758209519.pdf', '06f470b9ec6d5c0f496d4224698fabc2', '2025-09-18 09:31:59', 16, 1, 'Generado', NULL),
(3, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758274760.pdf', '8d6c7685b2be59a4c03091df15be94d8', '2025-09-19 03:39:20', 16, 1, 'Generado', NULL),
(4, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758274760.pdf', '51ee20dc21afadc1ad3eeb1f84ca904b', '2025-09-19 03:39:20', 16, 1, 'Generado', NULL),
(5, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758404004.pdf', '62faee291ff310d42a12e0cb98dc9b32', '2025-09-20 15:33:24', 16, 1, 'Generado', NULL),
(6, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758404005.pdf', 'baae1938d715d3f6d04b2a7685665c34', '2025-09-20 15:33:25', 16, 1, 'Generado', NULL),
(7, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758404640.pdf', '8efcead2dac3e5703369d9728b905128', '2025-09-20 15:44:00', 16, 1, 'Generado', NULL),
(8, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758404810.pdf', 'b9d242fafbb76bb78fb9c7d7ef5c9c63', '2025-09-20 15:46:51', 16, 1, 'Generado', NULL),
(9, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758408023.pdf', '71966149b9b2260080bcd607d8f09f43', '2025-09-20 16:40:23', 16, 1, 'Generado', NULL),
(10, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758408023.pdf', 'c4f44dca16338113ae6586db904ec9b2', '2025-09-20 16:40:23', 16, 1, 'Generado', NULL),
(11, 17, 1001, '/documentos/001_CARTA_REVISOR_prueba_1_2024MTI007_1758465330_0.pdf', 'a97a8a6304476ec64dcfd347fe787dbe', '2025-09-21 08:35:31', 16, 1, 'Generado', NULL),
(12, 17, 1001, '/documentos/001_CARTA_REVISOR_Prueba_2_2024MTI007_1758465331_1.pdf', 'b9ecf5563e2fd7b94405ed9c1ce4c499', '2025-09-21 08:35:31', 16, 1, 'Generado', NULL),
(13, 17, 1001, '/documentos/001_CARTA_REVISOR_Prueba_2_2024MTI007_1758465331_2.pdf', '6a8cbed5ee30d42f5d42449a702092f5', '2025-09-21 08:35:31', 16, 1, 'Generado', NULL),
(14, 17, 1001, '/documentos/001_CARTA_REVISOR_Pedro_Pascal_2024MTI007_1758465331_3.pdf', '99b7b9c4dde7d90ed406a15098abca4d', '2025-09-21 08:35:31', 16, 1, 'Generado', NULL),
(15, 17, 1000, '/documentos/002_NOTIFICACION_ALUMNO_2024MTI007_1758465331.pdf', '36e9e5d2079def1467c3e8764481378f', '2025-09-21 08:35:31', 16, 1, 'Generado', NULL),
(16, 7, 1, '/documentos/doc_LiberacionIngles_2024MPE007_1758469651.pdf', 'f34ec977ed29df753f3872e94cf903d5', '2025-09-21 09:47:31', 16, 1, 'Generado', NULL),
(17, 7, 1, '/documentos/doc_LiberacionIngles_2024MPE007_1758469651.pdf', 'fe78380fb859ddae89dea47a83fb111b', '2025-09-21 09:47:31', 16, 1, 'Generado', NULL),
(18, 7, 2, '/documentos/doc_LiberacionTesis_2024MPE007_1758469673.pdf', '8de6c0cb4fef6fb0b175a1716735dc81', '2025-09-21 09:47:53', 16, 1, 'Generado', NULL),
(19, 7, 2, '/documentos/doc_LiberacionTesis_2024MPE007_1758469673.pdf', 'a2936d7541868199768223159523e8d3', '2025-09-21 09:47:53', 16, 1, 'Generado', NULL),
(20, 7, 2, '/documentos/doc_LiberacionTesis_2024MPE007_1758479374.pdf', '6de4301fe193c60facfeafbfbfed81bc', '2025-09-21 12:29:34', 16, 1, 'Generado', NULL),
(21, 7, 2, '/documentos/doc_LiberacionTesis_2024MPE007_1758558621.pdf', 'f55d3e49a857c2ec41d8ec2a768bf1f5', '2025-09-22 10:30:21', 16, 1, 'Generado', NULL),
(22, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758560368.pdf', 'd1d4c908418eaef853ba796d7694a4f1', '2025-09-22 10:59:28', 16, 1, 'Generado', NULL),
(23, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758560368.pdf', 'bc996bb97b39e4ea2fa5bfd92d647666', '2025-09-22 10:59:28', 16, 1, 'Generado', NULL),
(24, 1, 1005, '/documentos/doc_AutorizacionExamen_2024MPE001_1758561359.pdf', '30de783b3e9e4342416bd4af00e1d891', '2025-09-22 11:15:59', 16, 1, 'Generado', NULL),
(25, 1, 1005, '/documentos/doc_AutorizacionExamen_2024MPE001_1758561359.pdf', '30b860bb90c67f308b0a946bdab23a9f', '2025-09-22 11:15:59', 16, 1, 'Generado', NULL),
(26, 1, 1004, '/documentos/doc_ConstanciaDictamen_2024MPE001_1758564943.pdf', '0b77fa4f0411a74cdc774d2d330fbf78', '2025-09-22 12:15:44', 16, 1, 'Generado', NULL),
(27, 1, 1003, '/documentos/doc_AutorizacionActoRecepcion_2024MPE001_1758564956.pdf', '18f2381694fe1f09a6d560e7e5a3d833', '2025-09-22 12:15:56', 16, 1, 'Generado', NULL),
(28, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758638717.pdf', '3cd95264ee02863b1473c203beacab1a', '2025-09-23 08:45:17', 16, 1, 'Generado', NULL),
(29, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758638717.pdf', '31de31c1d9545fdce8a96893d07d0c48', '2025-09-23 08:45:17', 16, 1, 'Generado', NULL),
(30, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758655741.pdf', '8cdbb1c257be09108a33cd68edee8cb0', '2025-09-23 13:29:01', 16, 1, 'Generado', NULL),
(31, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758655741.pdf', '8cdbb1c257be09108a33cd68edee8cb0', '2025-09-23 13:29:01', 16, 1, 'Generado', NULL),
(32, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758655992.pdf', '8ea8a9736cfc74ec5a8efd9c24de76bb', '2025-09-23 13:33:12', 16, 1, 'Generado', NULL),
(33, 1, 1005, '/documentos/doc_AutorizacionExamen_2024MPE001_1758656537.pdf', 'fb69a3e030110f98fe4ced3feb713840', '2025-09-23 13:42:17', 16, 1, 'Generado', NULL),
(34, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758657438.pdf', '35d64c094280e53eebcdf3fee0757390', '2025-09-23 13:57:18', 16, 1, 'Generado', NULL),
(35, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758657464.pdf', '86bfe46a69a6c07699edf9366aaf17d9', '2025-09-23 13:57:44', 16, 1, 'Generado', NULL),
(36, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758658284.pdf', '7762b83e8133ca74cd965258da97296a', '2025-09-23 14:11:24', 16, 1, 'Generado', NULL),
(37, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758658284.pdf', '7762b83e8133ca74cd965258da97296a', '2025-09-23 14:11:24', 16, 1, 'Generado', NULL),
(38, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758658762.pdf', '280e8d9dcf7199e2fadd3062db32cce1', '2025-09-23 14:19:22', 16, 1, 'Generado', NULL),
(39, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758658762.pdf', 'e9441de1173a3dcfcc256e7751599019', '2025-09-23 14:19:23', 16, 1, 'Generado', NULL),
(40, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758658892.pdf', '02aace8e2adba2004dbff954ab9f06b4', '2025-09-23 14:21:32', 16, 1, 'Generado', NULL),
(41, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758658892.pdf', '02aace8e2adba2004dbff954ab9f06b4', '2025-09-23 14:21:32', 16, 1, 'Generado', NULL),
(42, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758659763.pdf', '2deccb8ed34f91a4b1af35b2a73b3bca', '2025-09-23 14:36:03', 16, 1, 'Generado', NULL),
(43, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758659763.pdf', 'eaa36cca37e1fbce6fb1acc238a7e845', '2025-09-23 14:36:04', 16, 1, 'Generado', NULL),
(44, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758659814.pdf', '141c8a2b7b9d9d69a207a961dfeea9da', '2025-09-23 14:36:55', 16, 1, 'Generado', NULL),
(45, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758659815.pdf', '141c8a2b7b9d9d69a207a961dfeea9da', '2025-09-23 14:36:55', 16, 1, 'Generado', NULL),
(46, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758661228.pdf', 'a486e0170f39f83cee7df42a4604382e', '2025-09-23 15:00:28', 16, 1, 'Generado', NULL),
(47, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758661229.pdf', '305e9de3ae994300a18cb1a3d7d56027', '2025-09-23 15:00:29', 16, 1, 'Generado', NULL),
(48, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758661434.pdf', '2db8234f13e2cac9818bc7cfa6bcafe3', '2025-09-23 15:03:54', 16, 1, 'Generado', NULL),
(49, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758661447.pdf', '190ce9b0def52b9c3325a16c24e2a627', '2025-09-23 15:04:08', 16, 1, 'Generado', NULL),
(50, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758661448.pdf', 'f90e8ec36a6b38c5e48927e02373797b', '2025-09-23 15:04:08', 16, 1, 'Generado', NULL),
(51, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758661463.pdf', '036cccf4be3b7e0bafe0c766782e8e28', '2025-09-23 15:04:23', 16, 1, 'Generado', NULL),
(52, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758661481.pdf', 'e7d283de21f8f86f02f2c0f7846fd35a', '2025-09-23 15:04:41', 16, 1, 'Generado', NULL),
(53, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758661481.pdf', '6a67d58ce7d546159fcf00c240dcc7a1', '2025-09-23 15:04:41', 16, 1, 'Generado', NULL),
(54, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758661505.pdf', '5889b6032c812b97964695a1ed6ba1da', '2025-09-23 15:05:05', 16, 1, 'Generado', NULL),
(55, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758661506.pdf', '201522430a24e56325328b081ae37371', '2025-09-23 15:05:06', 16, 1, 'Generado', NULL),
(56, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758661522.pdf', '5fa56a647dcbb475f5edce97a969d91b', '2025-09-23 15:05:22', 16, 1, 'Generado', NULL),
(57, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758661522.pdf', 'bf189eb5cb3f65e16d8a5c45739db42a', '2025-09-23 15:05:23', 16, 1, 'Generado', NULL),
(58, 15, 1001, '/documentos/001_CARTA_REVISOR_prueba_1_2024MTI005_1758670528_0.pdf', '991eb7b1bb589e12e4f0ee35284c9fe1', '2025-09-23 17:35:28', 16, 1, 'Generado', NULL),
(59, 15, 1001, '/documentos/001_CARTA_REVISOR_Prueba_2_2024MTI005_1758670528_1.pdf', 'a2170de290adcdd0b1ec867fff6b3c25', '2025-09-23 17:35:28', 16, 1, 'Generado', NULL),
(60, 15, 1001, '/documentos/001_CARTA_REVISOR_Pedro_Pascal_2024MTI005_1758670528_2.pdf', '73014130e8978134e5009373987cb50a', '2025-09-23 17:35:29', 16, 1, 'Generado', NULL),
(61, 15, 1001, '/documentos/001_CARTA_REVISOR_Alexis_Mazapan_123_2024MTI005_1758670529_3.pdf', 'fd6202c1811b0843b9f1f37d55dccd02', '2025-09-23 17:35:29', 16, 1, 'Generado', NULL),
(62, 15, 1000, '/documentos/002_NOTIFICACION_ALUMNO_2024MTI005_1758670529.pdf', '3227f006d75838924a6d5779378ab748', '2025-09-23 17:35:29', 16, 1, 'Generado', NULL),
(63, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758670651.pdf', '3313aa2e0ee9c7a92d1a7fbdc632d801', '2025-09-23 17:37:31', 16, 1, 'Generado', NULL),
(64, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758670652.pdf', '57d30533f51a40eafdc1b42ecda463d0', '2025-09-23 17:37:32', 16, 1, 'Generado', NULL),
(65, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758670749.pdf', '250e8a99d08c378b6b57d970c7cea9a9', '2025-09-23 17:39:09', 16, 1, 'Generado', NULL),
(66, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758670750.pdf', 'bf5caec57424053f4bdc045c906a62b8', '2025-09-23 17:39:10', 16, 1, 'Generado', NULL),
(67, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758887878.pdf', 'fc0e3b268a7e5c903a4c2f03ec812cd5', '2025-09-26 05:57:58', 16, 1, 'Generado', NULL),
(68, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1758887879.pdf', '201b4e9f48c47ad5404c6c756356e892', '2025-09-26 05:57:59', 16, 1, 'Generado', NULL),
(69, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758888531.pdf', '4efc38e7eefd15aecd07967ef755e56e', '2025-09-26 06:08:51', 16, 1, 'Generado', NULL),
(70, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758888790.pdf', '740b3b8978558226f8e710a5505f952f', '2025-09-26 06:13:10', 16, 1, 'Generado', NULL),
(71, 1, 2, '/documentos/doc_LiberacionTesis_2024MPE001_1758888791.pdf', 'edb93767e4dd1d1aa28098889ef2ba7b', '2025-09-26 06:13:11', 16, 1, 'Generado', NULL),
(72, 1, 1002, '/documentos/doc_AutorizacionImpresion_2024MPE001_1758888945.pdf', '47616e8931e3ab1b5ec337a3bfe5c94f', '2025-09-26 06:15:46', 16, 1, 'Generado', NULL),
(73, 1, 1002, '/documentos/doc_AutorizacionImpresion_2024MPE001_1758888946.pdf', '4dfcb856c0b4a1176b4c1d2f92942d77', '2025-09-26 06:15:46', 16, 1, 'Generado', NULL),
(74, 1, 1002, '/documentos/doc_AutorizacionImpresion_2024MPE001_1758889100.pdf', '7c490505263a3ec864ebcec90a82bae3', '2025-09-26 06:18:20', 16, 1, 'Generado', NULL),
(75, 1, 1003, '/documentos/doc_AutorizacionActoRecepcion_2024MPE001_1758889190.pdf', '9c30e2773f8e68025e2a96638922f304', '2025-09-26 06:19:51', 16, 1, 'Generado', NULL),
(76, 1, 1003, '/documentos/doc_AutorizacionActoRecepcion_2024MPE001_1758889191.pdf', 'c64707abdd34229e9f1eea9295c992b4', '2025-09-26 06:19:51', 16, 1, 'Generado', NULL),
(77, 1, 1003, '/documentos/doc_AutorizacionActoRecepcion_2024MPE001_1758889650.pdf', 'add613a558cad39b1beff5bf5a24d159', '2025-09-26 06:27:31', 16, 1, 'Generado', NULL),
(78, 1, 1004, '/documentos/doc_ConstanciaDictamen_2024MPE001_1758890330.pdf', '043cd447d530acd97a4013934fd1f7ae', '2025-09-26 06:38:50', 16, 1, 'Generado', NULL),
(79, 1, 1004, '/documentos/doc_ConstanciaDictamen_2024MPE001_1758890331.pdf', 'f4c1dc3f9231f9bf2b6ff51cf4b61409', '2025-09-26 06:38:51', 16, 1, 'Generado', NULL),
(80, 1, 1005, '/documentos/doc_AutorizacionExamen_2024MPE001_1758892072.pdf', 'baa4495037ea677c72fe5312ab2e01c0', '2025-09-26 07:07:52', 16, 1, 'Generado', NULL),
(81, 1, 1005, '/documentos/doc_AutorizacionExamen_2024MPE001_1758892072.pdf', '72886e19078ef358b1007becde96b0bd', '2025-09-26 07:07:52', 16, 1, 'Generado', NULL),
(82, 1, 1005, '/documentos/doc_AutorizacionExamen_2024MPE001_1758892302.pdf', 'bbc6f75a83109ae2e1005d02d1ff6360', '2025-09-26 07:11:42', 16, 1, 'Generado', NULL),
(83, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758892428.pdf', '36f6ee73966bd395ea8043806dbc016f', '2025-09-26 07:13:48', 16, 1, 'Generado', NULL),
(84, 1, 1010, '/documentos/doc_ProtocoloExamen_2024MPE001_1758892429.pdf', '7eeefb405df8e6d7342c4ac044a2f813', '2025-09-26 07:13:49', 16, 1, 'Generado', NULL),
(85, 1, 1001, '/documentos/001_CARTA_REVISOR_Dr__VICTOR_PEREGRINO_2024MPE001_1759250997_0.pdf', 'f36337e2610b71c7a17b10365713201d', '2025-09-30 10:49:58', 16, 1, 'Generado', NULL),
(86, 1, 1001, '/documentos/001_CARTA_REVISOR_Pedro_Pascal_2024MPE001_1759250998_1.pdf', 'aa2746a01a1a14fff34f45dac2cbf02a', '2025-09-30 10:49:58', 16, 1, 'Generado', NULL),
(87, 1, 1001, '/documentos/001_CARTA_REVISOR_Prueba_2_2024MPE001_1759250998_2.pdf', '4620816c2bccdd3eccada5dfcb94d6df', '2025-09-30 10:49:59', 16, 1, 'Generado', NULL),
(88, 1, 1001, '/documentos/001_CARTA_REVISOR_Prueba_2_2024MPE001_1759250999_3.pdf', '71e79a5eab8b68d24846b6b11f288e1d', '2025-09-30 10:49:59', 16, 1, 'Generado', NULL),
(89, 1, 1000, '/documentos/002_NOTIFICACION_ALUMNO_2024MPE001_1759250999.pdf', '204a06d43fa73123687b304fb7adc28e', '2025-09-30 10:49:59', 16, 1, 'Generado', NULL),
(90, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1759251827.pdf', '9ee42298524e9cee2203228f70ec9085', '2025-09-30 11:03:47', 16, 1, 'Generado', NULL),
(91, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1759251827.pdf', '9167f9032c976d1c4ecca02a59f8732a', '2025-09-30 11:03:48', 16, 1, 'Generado', NULL),
(92, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1759251861.pdf', 'fe938af08b62bb5763f37f6bd8a0fc29', '2025-09-30 11:04:21', 16, 1, 'Generado', NULL),
(93, 1, 1, '/documentos/doc_LiberacionIngles_2024MPE001_1759251861.pdf', '3eae7657d87ea82c3a0c023906a5e3c1', '2025-09-30 11:04:21', 16, 1, 'Generado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1747399419),
('m250609_193219_add_posgrado_fields', 1756812113);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilladocumento`
--

DROP TABLE IF EXISTS `plantilladocumento`;
CREATE TABLE IF NOT EXISTS `plantilladocumento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `programa_id` int DEFAULT NULL,
  `tipo` enum('Constancia','LiberacionIngles','LiberacionTesis','Estancia','Kardex','AutorizacionImpresion','AutorizacionActoRecepcion','ConstanciaDictamen','AutorizacionExamen','ProtocoloExamen') DEFAULT NULL,
  `contenido` text NOT NULL,
  `campos_dinamicos` json DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `programa_id` (`programa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1011 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `plantilladocumento`
--

INSERT INTO `plantilladocumento` (`id`, `nombre`, `programa_id`, `tipo`, `contenido`, `campos_dinamicos`, `activo`) VALUES
(1, 'Liberación de Inglés - Maestría', 1, 'LiberacionIngles', 'Plantilla oficial para liberación de inglés', NULL, 1),
(2, 'Liberación de Tesis - Maestría', 1, 'LiberacionTesis', 'Plantilla oficial para liberación de tesis', NULL, 1),
(1000, 'Asignación Revisores - Notificación Alumno', NULL, 'Constancia', 'Plantilla para notificación de asignación de revisores al alumno', NULL, 1),
(1001, 'Carta Revisor Individual', NULL, 'Constancia', 'Plantilla para carta individual de revisor', NULL, 1),
(1002, 'Autorización Impresión de Tesis', NULL, 'AutorizacionImpresion', 'Plantilla oficial para autorización de impresión de tesis', NULL, 1),
(1003, 'Autorización Acto Recepción', NULL, 'AutorizacionActoRecepcion', 'Plantilla oficial para autorización de acto de recepción', NULL, 1),
(1004, 'Constancia Dictamen de Tesis', NULL, 'ConstanciaDictamen', 'Plantilla oficial para constancia de dictamen de tesis', NULL, 1),
(1005, 'Autorización Examen', NULL, 'AutorizacionExamen', 'Plantilla oficial para autorización de examen', NULL, 1),
(1010, 'Protocolo de Examen Profesional', NULL, 'ProtocoloExamen', 'Plantilla oficial para protocolo de examen profesional', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

DROP TABLE IF EXISTS `programa`;
CREATE TABLE IF NOT EXISTS `programa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `nivel` enum('Maestría','Doctorado') NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id`, `nombre`, `nivel`, `descripcion`) VALUES
(1, 'Maestría en Planificación de Empresas y Desarrollo Regional', 'Maestría', 'Programa de posgrado enfocado en planificación empresarial y desarrollo regional'),
(2, 'Maestría en Tecnologías de la Información', 'Maestría', 'Programa de posgrado especializado en tecnologías de la información'),
(3, 'Maestría en Ingeniería', 'Maestría', 'Programa de posgrado en ingeniería avanzada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisito`
--

DROP TABLE IF EXISTS `requisito`;
CREATE TABLE IF NOT EXISTS `requisito` (
  `id` int NOT NULL AUTO_INCREMENT,
  `programa_id` int DEFAULT NULL,
  `tipo_documento` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `obligatorio` tinyint(1) NOT NULL DEFAULT '1',
  `orden` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `programa_id` (`programa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `requisito`
--

INSERT INTO `requisito` (`id`, `programa_id`, `tipo_documento`, `nombre`, `descripcion`, `obligatorio`, `orden`) VALUES
(1, NULL, 'LiberacionIngles', 'Examen de admisión', 'Aprobar examen de conocimientos básicos', 1, 1),
(2, NULL, 'LiberacionIngles', 'Pago de derechos', 'Pago completo de cuotas de inscripción', 1, 2),
(3, NULL, 'LiberacionTesis', 'Propuesta de investigación', 'Aprobar propuesta de investigación', 1, 1),
(4, NULL, 'LiberacionTesis', 'Examen de grado', 'Evaluación oral y escrita del trabajo de tesis', 1, 2),
(5, 1, 'LiberacionIngles', 'Artículo indexado', 'Publicar artículo en revista indexada', 1, 3),
(6, 1, 'LiberacionTesis', 'Estudio de caso', 'Presentar estudio de caso aplicado', 1, 3),
(7, 2, 'LiberacionIngles', 'TOEFL o equivalente', 'Acreditar examen de inglés con puntaje mínimo', 1, 3),
(8, 2, 'LiberacionTesis', 'Prototipo funcional', 'Desarrollar y presentar prototipo funcional', 1, 3),
(9, 3, 'LiberacionIngles', 'Publicación congreso', 'Participar en congreso internacional', 1, 3),
(10, 3, 'LiberacionTesis', 'Modelo matemático', 'Desarrollar modelo matemático validado', 1, 3),
(11, NULL, 'AutorizacionImpresion', 'Revisores asignados', '4 revisores asignados oficialmente', 1, 1),
(12, NULL, 'AutorizacionImpresion', 'Dictamen de revisores', 'Dictamen favorable de al menos 3 revisores', 1, 2),
(13, NULL, 'AutorizacionImpresion', 'Liberación de tesis', 'Tesis liberada oficialmente', 1, 3),
(14, NULL, 'AutorizacionActoRecepcion', 'Tesis impresa', 'Tesis impresa y encuadernada', 1, 1),
(15, NULL, 'AutorizacionActoRecepcion', 'Aprobación de sinodales', 'Confirmación de asistencia de los sinodales', 1, 2),
(16, NULL, 'AutorizacionActoRecepcion', 'Sala reservada', 'Reserva confirmada de sala para el acto', 1, 3),
(17, NULL, 'ConstanciaDictamen', 'Revisión completa', 'Revisión completa de todos los capítulos', 1, 1),
(18, NULL, 'ConstanciaDictamen', 'Correcciones aplicadas', 'Todas las correcciones aplicadas', 1, 2),
(19, NULL, 'ConstanciaDictamen', 'Visto bueno director', 'Visto bueno del director de tesis', 1, 3),
(20, NULL, 'AutorizacionExamen', 'Todos los créditos', 'Todos los créditos del programa cursados', 1, 1),
(21, NULL, 'AutorizacionExamen', 'Promedio mínimo', 'Promedio mínimo de 8.0', 1, 2),
(22, NULL, 'AutorizacionExamen', 'Solicitud formal', 'Solicitud formal de examen de grado', 1, 3),
(23, NULL, 'revisores', 'Tesis avanzada', 'Tesis con al menos 80% de avance', 1, 1),
(24, NULL, 'revisores', 'Propuesta aprobada', 'Propuesta de tesis aprobada', 1, 2),
(25, NULL, 'revisores', 'Director asignado', 'Director de tesis asignado oficialmente', 1, 3),
(26, NULL, 'ProtocoloExamen', 'Examen programado', 'Examen de grado programado oficialmente', 1, 1),
(27, NULL, 'ProtocoloExamen', 'Jurado designado', 'Jurado examinador designado', 1, 2),
(28, NULL, 'ProtocoloExamen', 'Pago de derechos', 'Pago de derechos de examen realizado', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revisor`
--

DROP TABLE IF EXISTS `revisor`;
CREATE TABLE IF NOT EXISTS `revisor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cargo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'CATEDRÁTICO DEL INSTITUTO TECNOLÓGICO DE VILLAHERMOSA',
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `revisor`
--

INSERT INTO `revisor` (`id`, `nombre`, `cargo`, `activo`) VALUES
(1, 'prueba 1', 'CATEDRÁTICO DEL INSTITUTO TECNOLÓGICO DE VILLAHERMOSA', 1),
(2, 'Prueba 2', 'maestro', 1),
(3, 'Prueba 2', 'maestro', 1),
(6, 'Pedro Pascal', 'DOCTOR EN ECONOMIA', 1),
(5, 'Alexis Mazapan 123', 'Doctor en tecnologías de la información', 1),
(7, 'Dr. VICTOR PEREGRINO', 'DOCENTE ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revisor_tesis`
--

DROP TABLE IF EXISTS `revisor_tesis`;
CREATE TABLE IF NOT EXISTS `revisor_tesis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alumno_id` int NOT NULL,
  `revisor_id` int NOT NULL,
  `fecha_asignacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `alumno_id` (`alumno_id`),
  KEY `revisor_id` (`revisor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `revisor_tesis`
--

INSERT INTO `revisor_tesis` (`id`, `alumno_id`, `revisor_id`, `fecha_asignacion`) VALUES
(20, 1, 7, '2025-09-30 10:49:50'),
(19, 1, 6, '2025-09-30 10:49:50'),
(18, 1, 3, '2025-09-30 10:49:50'),
(17, 1, 2, '2025-09-30 10:49:50'),
(5, 17, 1, '2025-09-21 08:35:28'),
(6, 17, 2, '2025-09-21 08:35:28'),
(7, 17, 3, '2025-09-21 08:35:28'),
(8, 17, 6, '2025-09-21 08:35:28'),
(9, 7, 1, '2025-09-21 09:47:13'),
(10, 7, 2, '2025-09-21 09:47:13'),
(11, 7, 3, '2025-09-21 09:47:13'),
(12, 7, 6, '2025-09-21 09:47:13'),
(13, 15, 1, '2025-09-23 17:34:58'),
(14, 15, 3, '2025-09-23 17:34:58'),
(15, 15, 6, '2025-09-23 17:34:58'),
(16, 15, 5, '2025-09-23 17:34:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rol` enum('Administrador','Moderador','Asistente') NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `password_hash`, `nombre`, `email`, `rol`, `activo`) VALUES
(13, 'superadmin', 'admin123', 'Super Admin', 'superadmin@itvh.edu.mx', 'Administrador', 1),
(14, 'admin', 'admin123', 'Administrador', 'admin@itvh.edu.mx', 'Administrador', 1),
(16, 'gonzalo', '$2y$13$9PTgqavAYc2518nWpVi3de3TnexZJv/pcx6eJEcDt004r5NEmYd9O', 'Administrador del Sistema', 'admin@itvh.edu.mx', 'Administrador', 1),
(17, 'administrador', '$2y$13$ueLYNJL9eZs1.Rbvn8V4Ce9oG4YFcPNdW/4CeIhe/fcWjFlPLa8Qm', 'Alexis Alexis', 'nada.com', 'Administrador', 1),
(18, 'sebastian', '$2y$13$Lmwf8uE0mXDJ1Mhcg/LYcuEPqQ8lQqbAUzzStoZ6z.R1mpazNbaVu', 'sebastian', 'sebas.com', 'Moderador', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `avancealumno`
--
ALTER TABLE `avancealumno`
  ADD CONSTRAINT `avancealumno_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `avancealumno_ibfk_2` FOREIGN KEY (`requisito_id`) REFERENCES `requisito` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documentogenerado`
--
ALTER TABLE `documentogenerado`
  ADD CONSTRAINT `documentogenerado_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `documentoGenerado_ibfk_2` FOREIGN KEY (`plantilla_id`) REFERENCES `plantilladocumento` (`id`);

--
-- Filtros para la tabla `plantilladocumento`
--
ALTER TABLE `plantilladocumento`
  ADD CONSTRAINT `plantilladocumento_ibfk_1` FOREIGN KEY (`programa_id`) REFERENCES `programa` (`id`);

--
-- Filtros para la tabla `requisito`
--
ALTER TABLE `requisito`
  ADD CONSTRAINT `requisito_ibfk_1` FOREIGN KEY (`programa_id`) REFERENCES `programa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
