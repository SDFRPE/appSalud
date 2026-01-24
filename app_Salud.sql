-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-12-2024 a las 23:34:21
-- Versión del servidor: 8.0.39-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `app_Salud`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`adminSalud`@`%` PROCEDURE `EnlazarDispositivo` (IN `p_dispositivo_id` VARCHAR(50), IN `p_alias` VARCHAR(50), IN `p_adulto_mayor_id` INT, IN `p_responsable_id` INT)  BEGIN
    INSERT INTO dispositivo(
        dispositivo_id, alias, adulto_mayor_id, responsable_id
    )
    VALUES(
        p_dispositivo_id, p_alias, p_adulto_mayor_id, p_responsable_id
    );
END$$

CREATE DEFINER=`adminSalud`@`%` PROCEDURE `InsertarAdultoMayor` (IN `p_dni` VARCHAR(8), IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(50), IN `p_email` VARCHAR(100), IN `p_telefono` VARCHAR(15), IN `p_departamento` VARCHAR(50), IN `p_provincia` VARCHAR(50), IN `p_ciudad` VARCHAR(50), IN `p_direccion` VARCHAR(100), IN `p_sexo` VARCHAR(50), IN `p_estatura` VARCHAR(10), IN `p_fecha_nacimiento` DATE, IN `p_tipo_de_sangre` VARCHAR(5), IN `p_padecimientos` TEXT, IN `p_responsable_id` INT)  BEGIN
    INSERT INTO adultoMayor(
        dni, nombres, apellidos, email, telefono, departamento, provincia, ciudad, direccion, sexo, estatura, fecha_nacimiento, tipo_de_sangre, padecimientos, responsable_id
    )
    VALUES(
        p_dni, p_nombres, p_apellidos, p_email, p_telefono, p_departamento, p_provincia, p_ciudad, p_direccion, p_sexo, p_estatura, p_fecha_nacimiento, p_tipo_de_sangre, p_padecimientos, p_responsable_id
    );
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adultoMayor`
--

CREATE TABLE `adultoMayor` (
  `id` int NOT NULL,
  `dni` varchar(8) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `sexo` varchar(50) DEFAULT NULL,
  `estatura` varchar(10) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `tipo_de_sangre` varchar(5) DEFAULT NULL,
  `padecimientos` text,
  `responsable_id` int DEFAULT NULL,
  `distrito` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `adultoMayor`
--

INSERT INTO `adultoMayor` (`id`, `dni`, `nombres`, `apellidos`, `email`, `telefono`, `departamento`, `provincia`, `ciudad`, `direccion`, `sexo`, `estatura`, `fecha_nacimiento`, `tipo_de_sangre`, `padecimientos`, `responsable_id`, `distrito`) VALUES
(8, '00000005', 'Mariana', 'Portocarrero Castillo', 'juanportocarreroriva@gmail.com', '935094057', 'Lima', 'Lima', 'Lima', 'Av. Proceres de La Independencia Mzc1 Lte1', 'F', '178', '1944-02-11', 'A+', 'n/a', 1, NULL),
(10, '70528425', 'Juan', 'Portocarrero Riva', 'juanportocarreroriva@gmail.com', '935094057', 'Lima', 'Lima', 'Lima', 'Av. Proceres de La Independencia Mzc1 Lte1', 'M', '170', '2005-06-24', 'A+', 'na/a', 1, NULL),
(13, '20582540', 'Alicia Maria', 'Rojas Perez', 'aliciamariarojasperez1@gmail.com', '913640558', 'Lima', 'Lima', 'Lima', '12 de Las Flores', 'F', '165', '1979-02-28', 'A', 'Ninguno', 20, NULL),
(14, '43303550', 'Sharelly', 'Fernandez Rojas', 'sharelly.fernandez@gmail.com', '930971823', 'Lima', 'Lima', 'Lima', '12 de Las Flores', 'F', '165', '2002-05-27', 'A+', 'NULL', 20, NULL),
(15, '61120662', 'Fiorella', 'Sanchez', 'fiorella@gmail.com', '986644049', 'Lima', 'Lima', 'Lima', 'Lima', 'F', '165', '2024-12-05', 'A+', 'NUL', 23, NULL),
(16, '70458241', 'Shande', 'Rojas', 'ale.gave2004@gmail.com', '999666444', 'Lima', 'Lima', 'Lima', 'av.123', 'M', '1.70', '2024-12-10', 'o', 'NA', 25, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivo`
--

CREATE TABLE `dispositivo` (
  `id` int NOT NULL,
  `dispositivo_id` varchar(50) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `adulto_mayor_id` int NOT NULL,
  `responsable_id` int DEFAULT NULL,
  `ultima_fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `dispositivo`
--

INSERT INTO `dispositivo` (`id`, `dispositivo_id`, `alias`, `adulto_mayor_id`, `responsable_id`, `ultima_fecha_actualizacion`) VALUES
(1, 'F7KB8XY6WRPQ9MDT2LCNV4ZA1', 'prueba', 8, 1, '2024-11-28 10:10:19'),
(6, 'SUSAL-X4K9Y-HM2PQ-8TGBV-NPRC7', 'Mamá', 13, 20, '2024-12-10 12:34:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `dni` varchar(8) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `verification_code` varchar(128) DEFAULT NULL,
  `contraseña` varchar(128) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `sexo` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ultimo_inicio_sesion` datetime DEFAULT NULL,
  `distrito` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `dni`, `nombres`, `apellidos`, `email`, `verification_code`, `contraseña`, `telefono`, `departamento`, `provincia`, `ciudad`, `direccion`, `sexo`, `fecha_nacimiento`, `created_at`, `updated_at`, `ultimo_inicio_sesion`, `distrito`) VALUES
(1, '73186544', 'Juan Manuel', 'Portocarrero', 'juanportocarreroriva@gmail.com', NULL, '673d4b1d7deabe33d0037d3a39927ec3d56397a45f5eb9ac0512c75808c293f0d022e04adc5555cd3644d18cf79e9e9ebaea7e3a8e96744b0c49312a7f8af398', '935094057', 'Lima', 'Lima', 'Lima', 'Av. Proceres de La Independencia Mzc1 Lte1', 'M', '2005-06-24', '2024-11-03 22:52:04', '2024-12-10 05:54:51', NULL, 'San Juan de Lurigancho'),
(2, '00000001', 'Alexandra', 'Leon', 'alexandraleon@gmail.com', NULL, '6e6e98082318a56e1b5cc55f648e5d36f37726f6f5225b4aa6c4557ea6b9c5af4c6e27e8bd9455c98498cbbd51a5da502a57c2ac994b8e2f33dd3a8f5d7112ca', '999999991', NULL, NULL, NULL, NULL, 'F', '2004-01-01', '2024-11-03 23:07:14', '2024-11-04 04:17:37', NULL, NULL),
(5, '73793427', 'Aaron', 'Cornejo', 'aaroncornejo@gmail.com', NULL, '2f9159e3b1f8fd2ca1ea3c98d877c56e6387027296c3dc8f1564120e9f7019857a318d753161c76f6d9c72e8f4712c7184e7a98ff3a4b8de7d470499321e5018', '966666666', 'Lima', NULL, 'Lima', 'Cerro Camote', 'M', '1902-01-01', '2024-11-04 01:36:44', '2024-11-04 01:37:25', NULL, NULL),
(10, '73186540', 'Juan', 'Portocarrero', 'juanportocarreroriva01@gmail.com', NULL, '673d6be5b6fd87678e0fd651ef54764e137d4a47286e14636d1421bd8482c71a58d1740123b946c221b859336d0d4eefe13d11c74b3b06c8b1afd970a52d1dc0', '935094057', NULL, NULL, NULL, NULL, 'M', '2005-06-24', '2024-11-04 06:15:04', '2024-11-04 06:15:04', NULL, NULL),
(19, '78804454', 'Katty', 'Hilasaca Mestanza', 'hilasacmestanzak@gmail.com', NULL, 'bad62920c493a7602a5d29f81a3a52b2f98e93ca11f24d9e3c60a51d3e31afdec3e89e42aa2da27ae889d080027361bfb4fa4028049c06eb0fc291583042e8a9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-10 05:54:08', '2024-12-10 05:54:08', NULL, NULL),
(20, '62490664', 'Shande Daysuke', 'Fernandez Rojas', 'rs.daysuu@gmail.com', NULL, '5f62312467bd57b74be46873d038e95c95626b9c335b9a10e57d738fc1d04eac10917de854059c38314946c6883ce0a5648bb72fe988ddd25cdaf2da7670bd21', '930971823', 'Lima', 'Lima', 'Lima', '12 de Las Mil Flores', 'M', '2004-10-12', '2024-12-10 12:02:47', '2024-12-10 16:42:17', NULL, 'San Juan de Lurigancho'),
(21, '12345678', 'shande', 'shande', 'shande@gmail.com', NULL, 'b4ca3dca8734f0c501707ea5bc4e69c982a8de57746e9f5beb9073d456cfe9772d8a9587b8b31a193e02ea8ce5cadd2143622e8f7c370c0b62efdfdccf47f40e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-10 15:05:55', '2024-12-10 15:05:55', NULL, NULL),
(22, '47059112', 'a', 'b', 'correo@gmail.com', NULL, 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-10 15:10:19', '2024-12-10 15:10:19', NULL, NULL),
(23, '95148524', 'Florencia', 'Hurtado', 'florencia@gmail.com', NULL, '238e5411ff2e5fa02ddf1dbe79ad2bf57f5a1fa3184e5146b37ca576f1b373a33eacce356990f92adba662d78e5450d63de78c975b6232f67c1fd88f816d8ac5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-10 15:12:04', '2024-12-10 15:12:04', NULL, NULL),
(24, '74521235', 'p*ne', 'aaron', 'Bibi_aiala@hotmail.com', NULL, 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-10 15:16:15', '2024-12-10 15:16:15', NULL, NULL),
(25, '71959451', 'Marielena', 'Gavedia', 'ale.gave2004@gmail.com', NULL, '3313b015d7f64a125dd57d59fd0a9f4dbfe8d3d803520a786930f0ad25acacdce0c18bab826b6ea05d17186e253c31dff7c2abf6405483184b2924c5ee29e734', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-10 18:43:24', '2024-12-10 18:43:24', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adultoMayor`
--
ALTER TABLE `adultoMayor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD KEY `fk_responsable` (`responsable_id`);

--
-- Indices de la tabla `dispositivo`
--
ALTER TABLE `dispositivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adulto_mayor_id` (`adulto_mayor_id`),
  ADD KEY `responsable_id` (`responsable_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `dni_2` (`dni`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adultoMayor`
--
ALTER TABLE `adultoMayor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `dispositivo`
--
ALTER TABLE `dispositivo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adultoMayor`
--
ALTER TABLE `adultoMayor`
  ADD CONSTRAINT `adultoMayor_ibfk_1` FOREIGN KEY (`responsable_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_responsable` FOREIGN KEY (`responsable_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `dispositivo`
--
ALTER TABLE `dispositivo`
  ADD CONSTRAINT `dispositivo_ibfk_1` FOREIGN KEY (`adulto_mayor_id`) REFERENCES `adultoMayor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dispositivo_ibfk_2` FOREIGN KEY (`responsable_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
