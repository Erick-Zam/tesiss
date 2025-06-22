-- MySQL Script para configurar la base de datos completa
-- Incluye todas las tablas necesarias y población de datos

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS `4550502_prueba`;
USE `4550502_prueba`;

-- Configuración de caracteres
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `geolocalizacion`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `geolocalizacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `latitud` decimal(9,6) NOT NULL,
  `longitud` decimal(9,6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcado de datos para la tabla `geolocalizacion`
INSERT INTO `geolocalizacion` (`id`, `usuario`, `telefono`, `fecha`, `latitud`, `longitud`) VALUES
(1, '1', '0969614250', '2024-10-10 23:59:59', -1.965863, -79.808884),
(2, '2', '5551234567', '2023-01-10 00:00:00', -1.965000, -79.809500),
(3, '3', '5559876543', '2023-02-15 00:00:00', -1.964500, -79.808000),
(4, '4', '5556789123', '2023-03-20 00:00:00', -1.967000, -79.810000),
(5, '5', '0969614250', '2025-02-07 00:07:28', -1.860320, -79.976830),
(6, '6', '0969614250', '2025-02-07 23:18:06', -1.833330, -79.800000),
(7, '7', '0969614250', '2025-02-07 23:52:14', -1.873900, -79.860000),
(8, '8', '0969614250', '2025-02-07 23:59:40', -1.950000, -80.000000),
(9, '9', '0969614250', '2025-02-08 00:04:24', -1.916670, -80.016700),
(10, '10', '0969614250', '2025-02-08 00:08:26', -1.962760, -79.724020),
(11, '11', '0969614250', '2025-02-08 00:13:11', -2.214520, -80.951510),
(12, '12', '0969614250', '2025-02-08 00:16:15', -2.233000, -80.910400),
(13, '13', '0969614250', '2025-02-08 00:24:23', -2.116800, -79.699000),
(14, '14', '0969614250', '2025-02-08 00:28:50', -1.850000, -79.983300),
(15, '15', '0969614250', '2025-02-08 19:09:00', -2.047220, -79.916670),
(16, '16', '0969614250', '2025-02-09 20:07:21', -0.679200, -78.437800),
(17, '17', '0965436712', '2025-02-11 15:32:40', -1.950000, -80.000000);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `proveedores`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `cantidad_adquirida_anual` int NOT NULL,
  `telefono` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcado de datos para la tabla `proveedores`
INSERT INTO `proveedores` (`id`, `nombre`, `correo`, `cantidad_adquirida_anual`, `telefono`) VALUES
(1, 'Daniel P', 'daniel.p@gmail.com', 500, '0987654321'),
(2, 'Luis Hernández', 'luis.hernandez@gmail.com', 300, '0987654322'),
(3, 'Ana María', 'ana.maria@gmail.com', 700, '0987654323'),
(4, 'Carlos Rodríguez', 'carlos.rodriguez@gmail.com', 400, '0987654324'),
(5, 'Luis C ', 'luis.chavez@gmail.com', 50, '0969614250'),
(6, 'Jorge Lopez', 'jorge@gmail.com', 100, '0969614250'),
(7, 'Ricardo', 'ricardo@gmail.com', 100, '0969614250'),
(8, 'Oscar Vera', 'oscar.v@gmail.com', 200, '0969614250'),
(9, 'Rosa Navarrete', 'rosa.n@gmail.com', 50, '0969614250'),
(10, 'Enrique Choez', 'choez.enrique258@gmail.com', 70, '0969614250'),
(11, 'Nancy García', 'nangarcia45685@gmail.com', 60, '0969614250'),
(12, 'Pablo Herrera', 'herrera.pablo@gmail.com', 150, '0969614250'),
(13, 'Ernesto Valdez', 'ernes.val.p@gmail.com', 67, '0969614250'),
(14, 'Franklin Burgoz', 'frakpaburgoz@gmail.com', 40, '0969614250'),
(15, 'Onofre Vera', 'o.vera.pena14852@gmail.com', 200, '0969614250'),
(16, 'Pedro Moreira', 'moreira2456.p.n@gmail.com', 10, '0969614250'),
(17, 'Fernando Bazurto', 'fernandbazurto28561@hotmail.com', 500, '0965436712');

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `usuario`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `estado` int DEFAULT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcado de datos para la tabla `usuario`
INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `estado`) VALUES
(4, 'Daniel Chavez', 'danielchavez@gmail.com', 'danielchavez', '123456', 1);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `productos`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `hectares_cosechada` decimal(10,2) NOT NULL,
  `fecha_cosecha` date NOT NULL,
  `fecha_envio` date NOT NULL,
  `lote` varchar(50) NOT NULL,
  `geolocalizacion_id` int DEFAULT NULL,
  `proveedor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `geolocalizacion_id` (`geolocalizacion_id`),
  KEY `proveedor_id` (`proveedor_id`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`geolocalizacion_id`) REFERENCES `geolocalizacion` (`id`),
  CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcado de datos para la tabla `productos`
INSERT INTO `productos` (`id`, `cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`) VALUES
(1, 100, 1500.00, 'Arroz INIAP2', 10.50, '2024-10-10', '2024-10-15', 'Lote001', 1, 1),
(2, 50, 2000.00, 'Arroz INIAP2', 5.00, '2024-11-01', '2024-11-05', 'Lote002', 2, 2),
(3, 200, 1200.00, 'Arroz INIAP2', 20.00, '2024-09-15', '2024-09-20', 'Lote003', 3, 3),
(4, 100, 1500.00, 'Arroz INIAP2', 10.50, '2024-10-10', '2024-10-15', 'Lote001', 1, 1),
(5, 50, 2000.00, 'Arroz INIAP2', 5.00, '2024-11-01', '2024-11-05', 'Lote002', 2, 2),
(6, 200, 1200.00, 'Arroz INIAP2', 20.00, '2024-09-15', '2024-09-20', 'Lote003', 3, 3);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `detalle_envio`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `detalle_envio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `producto_id` int DEFAULT NULL,
  `proveedor_id` int DEFAULT NULL,
  `fecha_cosecha` date NOT NULL,
  `fecha_envio` date NOT NULL,
  `lote` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_id` (`producto_id`),
  KEY `proveedor_id` (`proveedor_id`),
  CONSTRAINT `detalle_envio_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `detalle_envio_ibfk_2` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcado de datos para la tabla `detalle_envio`
INSERT INTO `detalle_envio` (`id`, `producto_id`, `proveedor_id`, `fecha_cosecha`, `fecha_envio`, `lote`) VALUES
(1, 1, 2, '2019-01-05', '2019-01-10', 'Lote001'),
(2, 2, 5, '2019-02-10', '2019-02-15', 'Lote002'),
(3, 3, 7, '2019-03-15', '2019-03-20', 'Lote003'),
(4, 1, 1, '2024-10-10', '2024-10-15', 'Lote001'),
(5, 2, 2, '2024-11-01', '2024-11-05', 'Lote002'),
(6, 3, 3, '2024-09-15', '2024-09-20', 'Lote003'),
(7, 1, 13, '2019-07-05', '2019-07-10', 'Lote007'),
(8, 2, 15, '2019-08-10', '2019-08-15', 'Lote008'),
(9, 3, 17, '2019-09-15', '2019-09-20', 'Lote009'),
(10, 4, 6, '2019-10-20', '2019-10-25', 'Lote010'),
(11, 5, 8, '2019-11-25', '2019-11-30', 'Lote011'),
(12, 6, 10, '2019-12-30', '2020-01-05', 'Lote012'),
(13, 1, 12, '2019-01-15', '2019-01-20', 'Lote013'),
(14, 2, 14, '2019-02-20', '2019-02-25', 'Lote014'),
(15, 3, 16, '2019-03-25', '2019-03-30', 'Lote015'),
(16, 4, 1, '2019-04-30', '2019-05-05', 'Lote016'),
(17, 5, 3, '2019-06-05', '2019-06-10', 'Lote017'),
(18, 6, 5, '2019-07-10', '2019-07-15', 'Lote018'),
(19, 1, 7, '2019-08-15', '2019-08-20', 'Lote019'),
(20, 2, 9, '2019-09-20', '2019-09-25', 'Lote020'),
(21, 3, 11, '2019-10-25', '2019-10-30', 'Lote021'),
(22, 4, 13, '2019-11-30', '2019-12-05', 'Lote022'),
(23, 5, 15, '2019-12-15', '2019-12-20', 'Lote023'),
(24, 6, 17, '2019-01-05', '2019-01-10', 'Lote024'),
(25, 1, 4, '2019-02-10', '2019-02-15', 'Lote025'),
(26, 2, 6, '2019-03-15', '2019-03-20', 'Lote026'),
(27, 3, 8, '2019-04-20', '2019-04-25', 'Lote027'),
(28, 4, 10, '2019-05-25', '2019-05-30', 'Lote028'),
(29, 5, 12, '2019-06-30', '2019-07-05', 'Lote029'),
(30, 6, 14, '2019-07-05', '2019-07-10', 'Lote030'),
(31, 1, 16, '2019-08-10', '2019-08-15', 'Lote031'),
(32, 2, 1, '2019-09-15', '2019-09-20', 'Lote032'),
(33, 3, 3, '2019-10-20', '2019-10-25', 'Lote033'),
(34, 4, 5, '2019-11-25', '2019-11-30', 'Lote034'),
(35, 5, 7, '2019-12-30', '2020-01-05', 'Lote035'),
(36, 6, 9, '2019-01-15', '2019-01-20', 'Lote036'),
(37, 1, 11, '2019-02-20', '2019-02-25', 'Lote037'),
(38, 2, 13, '2019-03-25', '2019-03-30', 'Lote038'),
(39, 3, 15, '2019-04-30', '2019-05-05', 'Lote039'),
(40, 4, 17, '2019-06-05', '2019-06-10', 'Lote040'),
(41, 5, 2, '2019-07-10', '2019-07-15', 'Lote041'),
(42, 6, 4, '2019-08-15', '2019-08-20', 'Lote042'),
(43, 1, 6, '2019-09-20', '2019-09-25', 'Lote043'),
(44, 2, 8, '2019-10-25', '2019-10-30', 'Lote044'),
(45, 3, 10, '2019-11-30', '2019-12-05', 'Lote045'),
(46, 4, 12, '2019-12-15', '2019-12-20', 'Lote046'),
(47, 5, 14, '2019-01-05', '2019-01-10', 'Lote047'),
(48, 6, 16, '2019-02-10', '2019-02-15', 'Lote048'),
(49, 1, 1, '2019-03-15', '2019-03-20', 'Lote049'),
(50, 2, 3, '2019-04-20', '2019-04-25', 'Lote050'),
(51, 1, 2, '2020-01-06', '2020-01-11', 'Lote051'),
(52, 2, 5, '2020-02-12', '2020-02-17', 'Lote052'),
(53, 3, 7, '2020-03-18', '2020-03-23', 'Lote053'),
(54, 4, 3, '2020-04-22', '2020-04-27', 'Lote054'),
(55, 5, 9, '2020-05-27', '2020-06-01', 'Lote055'),
(56, 6, 11, '2020-07-02', '2020-07-07', 'Lote056'),
(57, 1, 13, '2020-07-07', '2020-07-12', 'Lote057'),
(58, 2, 15, '2020-08-12', '2020-08-17', 'Lote058'),
(59, 3, 17, '2020-09-17', '2020-09-22', 'Lote059'),
(60, 4, 6, '2020-10-22', '2020-10-27', 'Lote060'),
(61, 5, 8, '2020-11-27', '2020-12-02', 'Lote061'),
(62, 6, 10, '2020-12-30', '2021-01-04', 'Lote062'),
(63, 1, 12, '2020-01-17', '2020-01-22', 'Lote063'),
(64, 2, 14, '2020-02-22', '2020-02-27', 'Lote064'),
(65, 3, 16, '2020-03-27', '2020-04-01', 'Lote065'),
(66, 4, 1, '2020-04-30', '2020-05-05', 'Lote066'),
(67, 5, 3, '2020-06-07', '2020-06-12', 'Lote067'),
(68, 6, 5, '2020-07-12', '2020-07-17', 'Lote068'),
(69, 1, 7, '2020-08-17', '2020-08-22', 'Lote069'),
(70, 2, 9, '2020-09-22', '2020-09-27', 'Lote070'),
(71, 3, 11, '2020-10-27', '2020-11-01', 'Lote071'),
(72, 4, 13, '2020-11-30', '2020-12-05', 'Lote072'),
(73, 5, 15, '2020-12-17', '2020-12-22', 'Lote073'),
(74, 6, 17, '2020-01-06', '2020-01-11', 'Lote074'),
(75, 1, 4, '2020-02-12', '2020-02-17', 'Lote075'),
(76, 2, 6, '2020-03-18', '2020-03-23', 'Lote076'),
(77, 3, 8, '2020-04-22', '2020-04-27', 'Lote077'),
(78, 4, 10, '2020-05-27', '2020-06-01', 'Lote078'),
(79, 5, 12, '2020-07-02', '2020-07-07', 'Lote079'),
(80, 6, 14, '2020-07-07', '2020-07-12', 'Lote080'),
(81, 1, 16, '2020-08-12', '2020-08-17', 'Lote081'),
(82, 2, 1, '2020-09-17', '2020-09-22', 'Lote082'),
(83, 3, 3, '2020-10-22', '2020-10-27', 'Lote083'),
(84, 4, 5, '2020-11-27', '2020-12-02', 'Lote084'),
(85, 5, 7, '2020-12-30', '2021-01-04', 'Lote085'),
(86, 6, 9, '2020-01-17', '2020-01-22', 'Lote086'),
(87, 1, 11, '2020-02-22', '2020-02-27', 'Lote087'),
(88, 2, 13, '2020-03-27', '2020-04-01', 'Lote088'),
(89, 3, 15, '2020-04-30', '2020-05-05', 'Lote089'),
(90, 4, 17, '2020-06-07', '2020-06-12', 'Lote090'),
(91, 5, 2, '2020-07-12', '2020-07-17', 'Lote091'),
(92, 6, 4, '2020-08-17', '2020-08-22', 'Lote092'),
(93, 1, 6, '2020-09-22', '2020-09-27', 'Lote093'),
(94, 2, 8, '2020-10-27', '2020-11-01', 'Lote094'),
(95, 3, 10, '2020-11-30', '2020-12-05', 'Lote095'),
(96, 4, 12, '2020-12-17', '2020-12-22', 'Lote096'),
(97, 5, 14, '2020-01-06', '2020-01-11', 'Lote097'),
(98, 6, 16, '2020-02-12', '2020-02-17', 'Lote098'),
(99, 1, 1, '2020-03-18', '2020-03-23', 'Lote099'),
(100, 2, 3, '2020-04-22', '2020-04-27', 'Lote100'),
(101, 1, 2, '2021-01-08', '2021-01-13', 'Lote101'),
(102, 2, 5, '2021-02-14', '2021-02-19', 'Lote102'),
(103, 3, 7, '2021-03-20', '2021-03-25', 'Lote103'),
(104, 4, 3, '2021-04-24', '2021-04-29', 'Lote104'),
(105, 5, 9, '2021-05-29', '2021-06-03', 'Lote105'),
(106, 6, 11, '2021-07-04', '2021-07-09', 'Lote106'),
(107, 1, 13, '2021-07-09', '2021-07-14', 'Lote107'),
(108, 2, 15, '2021-08-14', '2021-08-19', 'Lote108'),
(109, 3, 17, '2021-09-19', '2021-09-24', 'Lote109'),
(110, 4, 6, '2021-10-24', '2021-10-29', 'Lote110'),
(111, 5, 8, '2021-11-29', '2021-12-04', 'Lote111'),
(112, 6, 10, '2021-12-31', '2022-01-05', 'Lote112'),
(113, 1, 12, '2021-01-19', '2021-01-24', 'Lote113'),
(114, 2, 14, '2021-02-24', '2021-03-01', 'Lote114'),
(115, 3, 16, '2021-03-29', '2021-04-03', 'Lote115'),
(116, 4, 1, '2021-05-02', '2021-05-07', 'Lote116'),
(117, 5, 3, '2021-06-09', '2021-06-14', 'Lote117'),
(118, 6, 5, '2021-07-14', '2021-07-19', 'Lote118'),
(119, 1, 7, '2021-08-19', '2021-08-24', 'Lote119'),
(120, 2, 9, '2021-09-24', '2021-09-29', 'Lote120'),
(121, 3, 11, '2021-10-29', '2021-11-03', 'Lote121'),
(122, 4, 13, '2021-12-02', '2021-12-07', 'Lote122'),
(123, 5, 15, '2021-12-19', '2021-12-24', 'Lote123'),
(124, 6, 17, '2021-01-08', '2021-01-13', 'Lote124'),
(125, 1, 4, '2021-02-14', '2021-02-19', 'Lote125'),
(126, 2, 6, '2021-03-20', '2021-03-25', 'Lote126'),
(127, 3, 8, '2021-04-24', '2021-04-29', 'Lote127'),
(128, 4, 10, '2021-05-29', '2021-06-03', 'Lote128'),
(129, 5, 12, '2021-07-04', '2021-07-09', 'Lote129'),
(130, 6, 14, '2021-07-09', '2021-07-14', 'Lote130'),
(131, 1, 16, '2021-08-14', '2021-08-19', 'Lote131'),
(132, 2, 1, '2021-09-19', '2021-09-24', 'Lote132'),
(133, 3, 3, '2021-10-24', '2021-10-29', 'Lote133'),
(134, 4, 5, '2021-11-29', '2021-12-04', 'Lote134'),
(135, 5, 7, '2021-12-31', '2022-01-05', 'Lote135'),
(136, 6, 9, '2021-01-19', '2021-01-24', 'Lote136'),
(137, 1, 11, '2021-02-24', '2021-03-01', 'Lote137'),
(138, 2, 13, '2021-03-29', '2021-04-03', 'Lote138'),
(139, 3, 15, '2021-05-02', '2021-05-07', 'Lote139'),
(140, 4, 17, '2021-06-09', '2021-06-14', 'Lote140'),
(141, 5, 2, '2021-07-14', '2021-07-19', 'Lote141'),
(142, 6, 4, '2021-08-19', '2021-08-24', 'Lote142'),
(143, 1, 6, '2021-09-24', '2021-09-29', 'Lote143'),
(144, 2, 8, '2021-10-29', '2021-11-03', 'Lote144'),
(145, 3, 10, '2021-12-02', '2021-12-07', 'Lote145'),
(146, 4, 12, '2021-12-19', '2021-12-24', 'Lote146'),
(147, 5, 14, '2021-01-08', '2021-01-13', 'Lote147'),
(148, 6, 16, '2021-02-14', '2021-02-19', 'Lote148'),
(149, 1, 1, '2021-03-20', '2021-03-25', 'Lote149'),
(150, 2, 3, '2021-04-24', '2021-04-29', 'Lote150'),
(151, 3, 5, '2021-05-29', '2021-06-03', 'Lote151'),
(152, 4, 7, '2021-07-04', '2021-07-09', 'Lote152'),
(153, 5, 9, '2021-08-09', '2021-08-14', 'Lote153'),
(154, 6, 11, '2021-09-14', '2021-09-19', 'Lote154'),
(155, 1, 13, '2021-10-19', '2021-10-24', 'Lote155'),
(156, 2, 15, '2021-11-24', '2021-11-29', 'Lote156'),
(157, 3, 17, '2021-12-29', '2022-01-03', 'Lote157'),
(158, 4, 2, '2021-01-14', '2021-01-19', 'Lote158'),
(159, 5, 4, '2021-02-19', '2021-02-24', 'Lote159'),
(160, 6, 6, '2021-03-24', '2021-03-29', 'Lote160'),
(161, 1, 8, '2021-04-29', '2021-05-04', 'Lote161'),
(162, 2, 10, '2021-06-04', '2021-06-09', 'Lote162'),
(163, 3, 12, '2021-07-09', '2021-07-14', 'Lote163'),
(164, 4, 14, '2021-08-14', '2021-08-19', 'Lote164'),
(165, 5, 16, '2021-09-19', '2021-09-24', 'Lote165'),
(166, 6, 2, '2021-10-24', '2021-10-29', 'Lote166'),
(167, 1, 4, '2021-11-29', '2021-12-04', 'Lote167'),
(168, 2, 6, '2021-12-31', '2022-01-05', 'Lote168'),
(169, 3, 8, '2021-01-19', '2021-01-24', 'Lote169'),
(170, 4, 10, '2021-02-24', '2021-03-01', 'Lote170'),
(171, 5, 12, '2021-03-29', '2021-04-03', 'Lote171'),
(172, 6, 14, '2021-05-02', '2021-05-07', 'Lote172'),
(173, 1, 16, '2021-06-09', '2021-06-14', 'Lote173'),
(174, 2, 1, '2021-07-14', '2021-07-19', 'Lote174'),
(175, 3, 3, '2021-08-19', '2021-08-24', 'Lote175'),
(176, 4, 5, '2021-09-24', '2021-09-29', 'Lote176'),
(177, 5, 7, '2021-10-29', '2021-11-03', 'Lote177'),
(178, 6, 9, '2021-12-02', '2021-12-07', 'Lote178'),
(179, 1, 11, '2021-12-19', '2021-12-24', 'Lote179'),
(180, 1, 2, '2022-01-05', '2022-01-10', 'Lote001'),
(181, 2, 5, '2022-02-10', '2022-02-15', 'Lote002'),
(182, 3, 7, '2022-03-15', '2022-03-20', 'Lote003'),
(183, 4, 3, '2022-04-20', '2022-04-25', 'Lote004'),
(184, 5, 9, '2022-05-25', '2022-05-30', 'Lote005'),
(185, 6, 11, '2022-06-30', '2022-07-05', 'Lote006'),
(186, 1, 13, '2022-07-05', '2022-07-10', 'Lote007'),
(187, 2, 15, '2022-08-10', '2022-08-15', 'Lote008'),
(188, 3, 17, '2022-09-15', '2022-09-20', 'Lote009'),
(189, 4, 6, '2022-10-20', '2022-10-25', 'Lote010'),
(190, 5, 8, '2022-11-25', '2022-11-30', 'Lote011'),
(191, 6, 10, '2022-12-30', '2023-01-05', 'Lote012'),
(192, 1, 12, '2022-01-15', '2022-01-20', 'Lote013'),
(193, 2, 14, '2022-02-20', '2022-02-25', 'Lote014'),
(194, 3, 16, '2022-03-25', '2022-03-30', 'Lote015'),
(195, 4, 1, '2022-04-30', '2022-05-05', 'Lote016'),
(196, 5, 3, '2022-06-05', '2022-06-10', 'Lote017'),
(197, 6, 5, '2022-07-10', '2022-07-15', 'Lote018'),
(198, 1, 7, '2022-08-15', '2022-08-20', 'Lote019'),
(199, 2, 9, '2022-09-20', '2022-09-25', 'Lote020'),
(200, 3, 11, '2022-10-25', '2022-10-30', 'Lote021'),
(201, 4, 13, '2022-11-30', '2022-12-05', 'Lote022'),
(202, 5, 15, '2022-12-15', '2022-12-20', 'Lote023'),
(203, 6, 17, '2022-01-05', '2022-01-10', 'Lote024'),
(204, 1, 4, '2022-02-10', '2022-02-15', 'Lote025'),
(205, 2, 6, '2022-03-15', '2022-03-20', 'Lote026'),
(206, 3, 8, '2022-04-20', '2022-04-25', 'Lote027'),
(207, 4, 10, '2022-05-25', '2022-05-30', 'Lote028'),
(208, 5, 12, '2022-06-30', '2022-07-05', 'Lote029'),
(209, 6, 14, '2022-07-05', '2022-07-10', 'Lote030'),
(210, 1, 16, '2022-08-10', '2022-08-15', 'Lote031'),
(211, 2, 1, '2022-09-15', '2022-09-20', 'Lote032'),
(212, 3, 3, '2022-10-20', '2022-10-25', 'Lote033'),
(213, 4, 5, '2022-11-25', '2022-11-30', 'Lote034'),
(214, 5, 7, '2022-12-30', '2023-01-05', 'Lote035'),
(215, 6, 9, '2022-01-15', '2022-01-20', 'Lote036'),
(216, 1, 11, '2022-02-20', '2022-02-25', 'Lote037'),
(217, 2, 13, '2022-03-25', '2022-03-30', 'Lote038'),
(218, 3, 15, '2022-04-30', '2022-05-05', 'Lote039'),
(219, 4, 17, '2022-06-05', '2022-06-10', 'Lote040'),
(220, 5, 2, '2022-07-10', '2022-07-15', 'Lote041'),
(221, 6, 4, '2022-08-15', '2022-08-20', 'Lote042'),
(222, 1, 6, '2022-09-20', '2022-09-25', 'Lote043'),
(223, 2, 8, '2022-10-25', '2022-10-30', 'Lote044'),
(224, 3, 10, '2022-11-30', '2022-12-05', 'Lote045'),
(225, 4, 12, '2022-12-15', '2022-12-20', 'Lote046'),
(226, 5, 14, '2022-01-05', '2022-01-10', 'Lote047'),
(227, 6, 16, '2022-02-10', '2022-02-15', 'Lote048'),
(228, 1, 1, '2022-03-15', '2022-03-20', 'Lote049'),
(229, 2, 3, '2022-04-20', '2022-04-25', 'Lote050'),
(230, 3, 5, '2022-05-25', '2022-05-30', 'Lote051'),
(231, 4, 7, '2022-06-30', '2022-07-05', 'Lote052'),
(232, 5, 9, '2022-07-05', '2022-07-10', 'Lote053'),
(233, 6, 11, '2022-08-10', '2022-08-15', 'Lote054'),
(234, 1, 13, '2022-09-15', '2022-09-20', 'Lote055'),
(235, 2, 15, '2022-10-20', '2022-10-25', 'Lote056'),
(236, 3, 17, '2022-11-25', '2022-11-30', 'Lote057'),
(237, 4, 6, '2022-12-30', '2023-01-05', 'Lote058'),
(238, 5, 8, '2022-01-15', '2022-01-20', 'Lote059'),
(239, 6, 10, '2022-02-20', '2022-02-25', 'Lote060'),
(240, 1, 12, '2022-03-25', '2022-03-30', 'Lote061'),
(241, 2, 14, '2022-04-30', '2022-05-05', 'Lote062'),
(242, 3, 16, '2022-06-05', '2022-06-10', 'Lote063'),
(243, 4, 13, '2022-07-10', '2022-07-15', 'Lote064'),
(244, 5, 12, '2022-08-15', '2022-08-20', 'Lote065'),
(245, 6, 2, '2022-09-05', '2022-09-10', 'Lote066'),
(246, 1, 4, '2022-10-15', '2022-10-20', 'Lote067'),
(247, 2, 6, '2022-11-05', '2022-11-10', 'Lote247'),
(248, 3, 8, '2022-12-10', '2022-12-15', 'Lote248'),
(249, 4, 10, '2022-01-20', '2022-01-25', 'Lote249'),
(250, 5, 12, '2022-02-25', '2022-03-02', 'Lote250'),
(251, 6, 14, '2022-03-30', '2022-04-04', 'Lote251'),
(252, 1, 16, '2022-04-10', '2022-04-15', 'Lote252'),
(253, 2, 17, '2022-05-05', '2022-05-10', 'Lote253'),
(254, 3, 3, '2022-06-15', '2022-06-20', 'Lote254'),
(255, 4, 5, '2022-07-20', '2022-07-25', 'Lote255'),
(256, 5, 7, '2022-08-10', '2022-08-15', 'Lote256'),
(257, 6, 9, '2022-09-05', '2022-09-10', 'Lote257'),
(258, 1, 11, '2022-10-15', '2022-10-20', 'Lote258'),
(259, 2, 13, '2022-11-25', '2022-11-30', 'Lote259'),
(260, 3, 15, '2022-12-05', '2022-12-10', 'Lote260');

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `detalle_producto` (Nueva tabla)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `detalle_producto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cantidad` INT,
  `precio` DECIMAL(10,2),
  `tipo` VARCHAR(50),
  `hectares_cosechada` DECIMAL(10,2),
  `fecha_cosecha` DATE,
  `fecha_envio` DATE,
  `lote` VARCHAR(50),
  `geolocalizacion_id` INT,
  `proveedor_id` INT,
  PRIMARY KEY (`id`),
  KEY `fk_dp_geolocalizacion` (`geolocalizacion_id`),
  KEY `fk_dp_proveedor` (`proveedor_id`),
  CONSTRAINT `fk_dp_geolocalizacion` FOREIGN KEY (`geolocalizacion_id`) REFERENCES `geolocalizacion`(`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_dp_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Poblar la tabla detalle_producto con datos de la tabla productos
-- --------------------------------------------------------
INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`) 
SELECT 
    `cantidad`, 
    `precio`, 
    `tipo`, 
    `hectares_cosechada`,
    `fecha_cosecha`, 
    `fecha_envio`, 
    `lote`, 
    `geolocalizacion_id`, 
    `proveedor_id`
FROM `productos`
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto`); -- Solo inserta si la tabla está vacía

-- Alternativamente, si prefiere datos de detalle_envio en lugar de productos
-- Descomente estas líneas y comente las anteriores
/*
INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `proveedor_id`)
SELECT 
    100 as `cantidad`,
    1000 as `precio`,
    'Arroz INIAP2' as `tipo`,
    10.00 as `hectares_cosechada`,
    de.`fecha_cosecha`,
    de.`fecha_envio`,
    de.`lote`,
    de.`proveedor_id`
FROM `detalle_envio` de
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto`); -- Solo inserta si la tabla está vacía
*/

-- Añadir datos de ejemplo para 2025 si no existen
INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `proveedor_id`)
SELECT 
    100, 
    1500.00, 
    'Arroz INIAP2', 
    10.50, 
    '2025-01-15', 
    '2025-01-20', 
    'Lote2025-01', 
    1
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE YEAR(`fecha_cosecha`) = 2025 AND MONTH(`fecha_cosecha`) = 1);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `proveedor_id`)
SELECT 
    120, 
    1600.00, 
    'Arroz INIAP2', 
    11.00, 
    '2025-02-15', 
    '2025-02-20', 
    'Lote2025-02', 
    2
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE YEAR(`fecha_cosecha`) = 2025 AND MONTH(`fecha_cosecha`) = 2);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `proveedor_id`)
SELECT 
    140, 
    1700.00, 
    'Arroz INIAP2', 
    12.50, 
    '2025-03-15', 
    '2025-03-20', 
    'Lote2025-03', 
    3
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE YEAR(`fecha_cosecha`) = 2025 AND MONTH(`fecha_cosecha`) = 3);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `proveedor_id`)
SELECT 
    150, 
    1800.00, 
    'Arroz INIAP2', 
    13.50, 
    '2025-04-15', 
    '2025-04-20', 
    'Lote2025-04', 
    4
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE YEAR(`fecha_cosecha`) = 2025 AND MONTH(`fecha_cosecha`) = 4);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `proveedor_id`)
SELECT 
    170, 
    1900.00, 
    'Arroz INIAP2', 
    15.00, 
    '2025-05-15', 
    '2025-05-20', 
    'Lote2025-05', 
    5
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE YEAR(`fecha_cosecha`) = 2025 AND MONTH(`fecha_cosecha`) = 5);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `proveedor_id`)
SELECT 
    180, 
    2000.00, 
    'Arroz INIAP2', 
    16.00, 
    '2025-06-15', 
    '2025-06-20', 
    'Lote2025-06', 
    6
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE YEAR(`fecha_cosecha`) = 2025 AND MONTH(`fecha_cosecha`) = 6);

COMMIT;

-- Insertar registros específicos en detalle_producto si no existen ya
INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 900, 1500.00, 'Arroz INIAP2', 10.50, '2024-10-10', '2024-10-15', 'LOTE3', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2024-10-10' AND `lote` = 'LOTE3' AND `proveedor_id` = 1);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 1010, 2000.00, 'Arroz INIAP2', 5.00, '2024-11-01', '2024-11-05', 'LOTE2', 2, 2
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2024-11-01' AND `lote` = 'LOTE2' AND `proveedor_id` = 2);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 800, 1200.00, 'Arroz INIAP2', 20.00, '2024-09-15', '2024-09-20', 'LOTE3', 3, 3
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2024-09-15' AND `lote` = 'LOTE3' AND `proveedor_id` = 3);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 400, 1500.00, 'Arroz INIAP2', 10.50, '2024-10-10', '2024-10-15', 'LOTE4', 4, 4
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2024-10-10' AND `lote` = 'LOTE4' AND `proveedor_id` = 4);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 742, 2000.00, 'Arroz INIAP2', 5.00, '2024-11-01', '2024-11-05', 'LoteR005', 5, 5
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2024-11-01' AND `lote` = 'LoteR005' AND `proveedor_id` = 5);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 649, 1200.00, 'Arroz INIAP2', 20.00, '2024-09-15', '2024-09-20', 'LoteR006', 6, 6
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2024-09-15' AND `lote` = 'LoteR006' AND `proveedor_id` = 6);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 1200, 1500.00, 'Maiz INIAP2', 10.50, '2019-05-01', '2019-05-05', 'LOTE4', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2019-05-01' AND `lote` = 'LOTE4' AND `proveedor_id` = 1);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 1300, 1600.00, 'Frijol Amarillo', 15.30, '2019-07-15', '2019-07-20', 'LOTE3', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2019-07-15' AND `lote` = 'LOTE3' AND `proveedor_id` = 1);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 1100, 1700.00, 'Tomate Riñón Negro', 12.40, '2019-10-05', '2019-10-10', 'LoteF09', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2019-10-05' AND `lote` = 'LoteF09' AND `proveedor_id` = 1);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 1500, 1450.00, 'Arroz', 8.20, '2020-02-15', '2020-02-20', 'Lote T10', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2020-02-15' AND `lote` = 'Lote T10' AND `proveedor_id` = 1);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 1200, 1550.00, 'Maiz INIAP2', 9.50, '2020-05-01', '2020-05-05', 'LoteR11', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2020-05-01' AND `lote` = 'LoteR11' AND `proveedor_id` = 1);

INSERT INTO `detalle_producto` (`cantidad`, `precio`, `tipo`, `hectares_cosechada`, `fecha_cosecha`, `fecha_envio`, `lote`, `geolocalizacion_id`, `proveedor_id`)
SELECT 1300, 1650.00, 'Friial Amarillo', 14.70, '2020-07-22', '2020-07-27', 'LoteM12', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM `detalle_producto` WHERE `fecha_cosecha` = '2020-07-22' AND `lote` = 'LoteM12' AND `proveedor_id` = 1);

-- Fin del script
