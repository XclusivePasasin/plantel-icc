-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-08-2025 a las 02:57:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `plantel_unilever`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `analisis_agua`
--

CREATE TABLE `analisis_agua` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phagua` varchar(50) DEFAULT NULL,
  `conductividad` varchar(50) DEFAULT NULL,
  `clibre` varchar(50) DEFAULT NULL,
  `phproducto` varchar(50) DEFAULT NULL,
  `viscosidad` varchar(50) DEFAULT NULL,
  `densidad` varchar(50) DEFAULT NULL,
  `apariencia` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `olor` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `turno` int(11) NOT NULL,
  `observaciones` varchar(300) DEFAULT NULL,
  `especificacion` varchar(500) NOT NULL,
  `user_crea` varchar(50) DEFAULT NULL,
  `rol_crea` varchar(50) DEFAULT NULL,
  `crea_date` timestamp NULL DEFAULT NULL,
  `user_verifica` varchar(50) DEFAULT NULL,
  `rol_verifica` varchar(50) DEFAULT NULL,
  `verifica_date` timestamp NULL DEFAULT NULL,
  `user_autoriza` varchar(50) DEFAULT NULL,
  `rol_autoriza` varchar(50) DEFAULT NULL,
  `autoriza_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controles`
--

CREATE TABLE `controles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `oproduccion` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentacion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vmaximo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voptimo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vminimo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pmaximo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poptimo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pminimo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecharealizada` timestamp NULL DEFAULT current_timestamp(),
  `fecharealizada2` timestamp NULL DEFAULT current_timestamp(),
  `llenado` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisado` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autorizado` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seccion` int(11) NOT NULL,
  `turno` int(11) DEFAULT NULL,
  `horas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `realizo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `verifico` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `realizo2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `verifico2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `m1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `m2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `m3` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `m4` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `m5` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `m6` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `m7` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `pesos_por_hora` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pesos_por_hora`)),
  `t1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `t2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `t3` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `t4` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `t5` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `t6` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `t7` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `e1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `e2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `packing_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `controles`
--

INSERT INTO `controles` (`id`, `oproduccion`, `presentacion`, `vmaximo`, `voptimo`, `vminimo`, `pmaximo`, `poptimo`, `pminimo`, `fecharealizada`, `fecharealizada2`, `llenado`, `supervisado`, `autorizado`, `observaciones`, `seccion`, `turno`, `horas`, `realizo`, `verifico`, `realizo2`, `verifico2`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `pesos_por_hora`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `e1`, `e2`, `packing_id`, `created_at`, `updated_at`) VALUES
(1, '14096-10', '9 ML', NULL, NULL, NULL, '10.2g', '10.0g', '9.8g', '2025-07-29 06:00:00', '2025-07-29 06:00:00', 'Gabriela Vásquez', 'Jayro Arias', 'Ana Hernández', '01:00 - 01:30 Pesos no tomados por Receso', 25, 1, '[\"22:30\",\"23:00\",\"23:30\",\"00:00\",\"00:30\",\"02:00\",\"02:30\",\"03:00\",\"03:30\",\"04:00\",\"04:30\",\"06:00\",\"06:30\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",null,null,null,null,null,null,null,null,null,null,null,null]', '[\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\",null,null,null,null,null,null,null,null,null,null,\"Ana Hern\\u00e1ndez\",\"Ana Hern\\u00e1ndez\"]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[\"10.2\",\"10.00\",\"9.9\",\"9.9\",\"10\",\"10.1\",\"9.9\",\"9.9\",\"10.00\",\"10.2\",\"10\",\"10.2\",\"10.1\",null,null,null,null,null,null,null,null,null,null,null,null]', '\"\\\"[{\\\\\\\"index\\\\\\\":0,\\\\\\\"hora\\\\\\\":\\\\\\\"22:30\\\\\\\",\\\\\\\"peso\\\\\\\":10.2},{\\\\\\\"index\\\\\\\":1,\\\\\\\"hora\\\\\\\":\\\\\\\"23:00\\\\\\\",\\\\\\\"peso\\\\\\\":10},{\\\\\\\"index\\\\\\\":2,\\\\\\\"hora\\\\\\\":\\\\\\\"23:30\\\\\\\",\\\\\\\"peso\\\\\\\":9.9},{\\\\\\\"index\\\\\\\":3,\\\\\\\"hora\\\\\\\":\\\\\\\"00:00\\\\\\\",\\\\\\\"peso\\\\\\\":9.9},{\\\\\\\"index\\\\\\\":4,\\\\\\\"hora\\\\\\\":\\\\\\\"00:30\\\\\\\",\\\\\\\"peso\\\\\\\":10},{\\\\\\\"index\\\\\\\":5,\\\\\\\"hora\\\\\\\":\\\\\\\"02:00\\\\\\\",\\\\\\\"peso\\\\\\\":10.1},{\\\\\\\"index\\\\\\\":6,\\\\\\\"hora\\\\\\\":\\\\\\\"02:30\\\\\\\",\\\\\\\"peso\\\\\\\":9.9},{\\\\\\\"index\\\\\\\":7,\\\\\\\"hora\\\\\\\":\\\\\\\"03:00\\\\\\\",\\\\\\\"peso\\\\\\\":9.9},{\\\\\\\"index\\\\\\\":8,\\\\\\\"hora\\\\\\\":\\\\\\\"03:30\\\\\\\",\\\\\\\"peso\\\\\\\":10},{\\\\\\\"index\\\\\\\":9,\\\\\\\"hora\\\\\\\":\\\\\\\"04:00\\\\\\\",\\\\\\\"peso\\\\\\\":10.2},{\\\\\\\"index\\\\\\\":10,\\\\\\\"hora\\\\\\\":\\\\\\\"04:30\\\\\\\",\\\\\\\"peso\\\\\\\":10},{\\\\\\\"index\\\\\\\":11,\\\\\\\"hora\\\\\\\":\\\\\\\"06:00\\\\\\\",\\\\\\\"peso\\\\\\\":10.2},{\\\\\\\"index\\\\\\\":12,\\\\\\\"hora\\\\\\\":\\\\\\\"06:30\\\\\\\",\\\\\\\"peso\\\\\\\":10.1}]\\\"\"', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[\"Seg\\u00fan patr\\u00f3n\",\"Caracter\\u00edstico\",\"Semi-s\\u00f3lido\"]', '[\"Seg\\u00fan patr\\u00f3n\",\"Caracter\\u00edstico\",null]', 1, '2025-07-30 04:32:08', '2025-07-30 04:47:19'),
(2, '14097-10', '9 ML', NULL, NULL, NULL, '10.2', '10', '9.7', '2025-07-30 06:00:00', '2025-07-30 06:00:00', 'Gabriela Vásquez', 'Cecilia Juarez', 'Douglas Campos', NULL, 25, 1, '[\"20:30\",\"21:00\",\"21:30\",\"22:00\",\"22:30\",\"23:00\",\"23:30\",\"00:00\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",\"Gabriela V\\u00e1squez\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[\"Douglas Campos\",\"Douglas Campos\",\"Douglas Campos\",\"Douglas Campos\",\"Douglas Campos\",\"Douglas Campos\",\"Douglas Campos\",\"Douglas Campos\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"Douglas Campos\",\"Douglas Campos\"]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[\"10.2\",\"10.1\",\"10\",\"10\",\"9.8\",\"10\",\"10\",\"10\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '\"\\\"[{\\\\\\\"index\\\\\\\":0,\\\\\\\"hora\\\\\\\":\\\\\\\"20:30\\\\\\\",\\\\\\\"peso\\\\\\\":10.2},{\\\\\\\"index\\\\\\\":1,\\\\\\\"hora\\\\\\\":\\\\\\\"21:00\\\\\\\",\\\\\\\"peso\\\\\\\":10.1},{\\\\\\\"index\\\\\\\":2,\\\\\\\"hora\\\\\\\":\\\\\\\"21:30\\\\\\\",\\\\\\\"peso\\\\\\\":10},{\\\\\\\"index\\\\\\\":3,\\\\\\\"hora\\\\\\\":\\\\\\\"22:00\\\\\\\",\\\\\\\"peso\\\\\\\":10},{\\\\\\\"index\\\\\\\":4,\\\\\\\"hora\\\\\\\":\\\\\\\"22:30\\\\\\\",\\\\\\\"peso\\\\\\\":9.8},{\\\\\\\"index\\\\\\\":5,\\\\\\\"hora\\\\\\\":\\\\\\\"23:00\\\\\\\",\\\\\\\"peso\\\\\\\":10},{\\\\\\\"index\\\\\\\":6,\\\\\\\"hora\\\\\\\":\\\\\\\"23:30\\\\\\\",\\\\\\\"peso\\\\\\\":10},{\\\\\\\"index\\\\\\\":7,\\\\\\\"hora\\\\\\\":\\\\\\\"00:00\\\\\\\",\\\\\\\"peso\\\\\\\":10}]\\\"\"', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '[\"Seg\\u00fan patr\\u00f3n\",\"Caracter\\u00edstico\",\"Semi-s\\u00f3lido\"]', '[\"Seg\\u00fan patr\\u00f3n\",\"Caracter\\u00edstico\",null]', 2, '2025-07-31 02:23:49', '2025-07-31 02:48:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_producto`
--

CREATE TABLE `control_producto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero_orden` varchar(100) NOT NULL,
  `codigo_producto` varchar(100) DEFAULT NULL,
  `nombre_producto` varchar(255) DEFAULT NULL,
  `ph_agua` varchar(50) DEFAULT NULL,
  `conductividad_agua` varchar(50) DEFAULT NULL,
  `cloro_libre_agua` varchar(50) DEFAULT NULL,
  `ph_producto` varchar(50) DEFAULT NULL,
  `especificacion_ph_producto` varchar(50) DEFAULT NULL,
  `viscosidad_producto` varchar(50) DEFAULT NULL,
  `especificacion_viscosidad_producto` varchar(50) DEFAULT NULL,
  `densidad_producto` varchar(50) DEFAULT NULL,
  `especificacion_densidad_producto` varchar(50) DEFAULT NULL,
  `apariencia_producto` tinyint(1) DEFAULT 0,
  `color_producto` tinyint(1) DEFAULT 0,
  `olor_producto` tinyint(1) DEFAULT 0,
  `observaciones_producto` text DEFAULT NULL,
  `usuario_crea` varchar(100) DEFAULT NULL,
  `rol_crea` varchar(100) DEFAULT NULL,
  `usuario_verifica` varchar(100) DEFAULT NULL,
  `rol_verifica` varchar(100) DEFAULT NULL,
  `usuario_autoriza` varchar(100) DEFAULT NULL,
  `rol_autoriza` varchar(100) DEFAULT NULL,
  `estado` tinyint(3) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `control_producto`
--

INSERT INTO `control_producto` (`id`, `numero_orden`, `codigo_producto`, `nombre_producto`, `ph_agua`, `conductividad_agua`, `cloro_libre_agua`, `ph_producto`, `especificacion_ph_producto`, `viscosidad_producto`, `especificacion_viscosidad_producto`, `densidad_producto`, `especificacion_densidad_producto`, `apariencia_producto`, `color_producto`, `olor_producto`, `observaciones_producto`, `usuario_crea`, `rol_crea`, `usuario_verifica`, `rol_verifica`, `usuario_autoriza`, `rol_autoriza`, `estado`, `created_at`, `updated_at`) VALUES
(1, '10203-20', '805800100002', 'MZ SEDAL SH 2EN1 KER C/ANTI 1000LT', '5.9', '15', '2.2', '09', '0 - 0', '12', '0 - 0', '14', '0 - 0', 1, 1, 1, 'ninguna', 'Ana Hernández', 'Calidad', 'Verónica Alas', 'SupCalidad', 'Mirella Herrera', 'JefeControlCalidad', 3, '2025-07-23 03:55:43', '2025-07-23 04:00:05'),
(2, '14096-20', '805800300005', 'MZ SEDAL CR PEINAR RIZOS DEFINIDO', '6.31', '19.30 ms/cm', '1.85 ppm', '4.95', '0 - 0', '109600 mPas', '0 - 0', '0.993 g/ml', '0 - 0', 1, 1, 1, NULL, 'Ana Hernández', 'Calidad', 'Verónica Alas', 'SupCalidad', 'Mirella Herrera', 'JefeControlCalidad', 3, '2025-07-30 03:14:31', '2025-07-30 03:16:36'),
(3, '14097-20', '805800300005', 'MZ SEDAL CR PEINAR RIZOS DEFINIDO', '6.05', '17.74 us/cm', '1.70 ppm', '4.91', '0 - 0', '115200 mPas', '0 - 0', '0.992 g/ml', '0 - 0', 1, 1, 1, NULL, 'Ana Hernández', 'Calidad', 'Carolina Guillén', 'AuxControlCalidad', 'Mirella Herrera', 'JefeControlCalidad', 3, '2025-07-30 22:22:15', '2025-07-30 22:26:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empaque_materials`
--

CREATE TABLE `empaque_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `description` varchar(700) NOT NULL,
  `process` varchar(700) NOT NULL,
  `required_amount` int(11) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `stock` varchar(30) NOT NULL,
  `lot1` varchar(30) DEFAULT NULL,
  `entrega1` int(11) DEFAULT NULL,
  `entrega2` int(11) DEFAULT NULL,
  `return` int(11) DEFAULT NULL,
  `packing_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `almacen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empaque_materials`
--

INSERT INTO `empaque_materials` (`id`, `code`, `description`, `process`, `required_amount`, `unit`, `stock`, `lot1`, `entrega1`, `entrega2`, `return`, `packing_id`, `created_at`, `updated_at`, `almacen`) VALUES
(1, '205700000004', 'CC SEDAL SH/CC GEN 24X28X9ML SRSE', 'EMPAQUE', 478, 'UN', '0.000000', 'ME01470625', 475, 3, NULL, 1, '2025-07-30 04:09:03', '2025-07-30 04:09:03', 101),
(2, '205700000005', 'GAN SEDAL GEN 28X9ML SRSE', 'EMPAQUE', 5736, 'UN', '0.000000', '25185', 3000, NULL, NULL, 1, '2025-07-30 04:09:03', '2025-07-30 04:09:03', 101),
(3, '605800300020', 'LAM SSK CC RIZOS DEFINIDOS 9ML RNBK2', 'EMPAQUE', 272, 'KG', '0.000000', 'ME01480625', 6048, NULL, 312, 1, '2025-07-30 04:09:03', '2025-07-30 04:09:03', 101),
(4, '805800300005', 'MZ SEDAL CR PEINAR RIZOS DEFINIDO', 'COSTEO', 3000, 'KG', '4481.831200', 'ME01410625', 507, NULL, 242, 1, '2025-07-30 04:09:03', '2025-07-30 04:09:03', 101),
(5, '205700000004', 'CC SEDAL SH/CC GEN 24X28X9ML SRSE', 'EMPAQUE', 475, 'UN', '0.000000', 'ME01470625', 475, 34, 34, 2, '2025-07-30 23:14:05', '2025-07-30 23:14:05', 101),
(6, '205700000005', 'GAN SEDAL GEN 28X9ML SRSE', 'EMPAQUE', 5700, 'UN', '0.000000', '25185A', 3000, NULL, NULL, 2, '2025-07-30 23:14:05', '2025-07-30 23:14:05', 101),
(7, '605800300020', 'LAM SSK CC RIZOS DEFINIDOS 9ML RNBK2', 'EMPAQUE', 271, 'KG', '0.000000', 'ME01480625', 6098, NULL, 348, 2, '2025-07-30 23:14:05', '2025-07-30 23:14:05', 101),
(8, '805800300005', 'MZ SEDAL CR PEINAR RIZOS DEFINIDO', 'COSTEO', 3000, 'KG', '4481.831200', 'ME01410625', 570, NULL, 307, 2, '2025-07-30 23:14:05', '2025-07-30 23:14:05', 101);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estandares`
--

CREATE TABLE `estandares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `opresponsable` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisado` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autorizado` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecharealizada` timestamp NULL DEFAULT current_timestamp(),
  `seccion` int(11) NOT NULL,
  `turno` int(11) NOT NULL,
  `presentacion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `realizo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `verifico` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a3` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a4` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a5` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a6` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a7` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a8` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a9` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a10` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a11` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a12` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a13` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a14` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a15` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a16` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a17` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a18` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `a19` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `packing_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `granel`
--

CREATE TABLE `granel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto` varchar(700) NOT NULL,
  `lote` varchar(50) DEFAULT NULL,
  `batch` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `tanque` varchar(50) DEFAULT NULL,
  `orden` varchar(50) NOT NULL,
  `fecha_fabricacion` timestamp NULL DEFAULT NULL,
  `fecha_expiracion` timestamp NULL DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `proceso` varchar(200) DEFAULT NULL,
  `cv1` varchar(50) DEFAULT NULL,
  `cv2` varchar(50) DEFAULT NULL,
  `responsables` varchar(300) NOT NULL,
  `equipo` varchar(150) DEFAULT NULL,
  `mix_order_id` bigint(20) UNSIGNED NOT NULL,
  `user_crea` varchar(50) DEFAULT NULL,
  `user_upd` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parametros` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `granel`
--

INSERT INTO `granel` (`id`, `producto`, `lote`, `batch`, `status`, `tanque`, `orden`, `fecha_fabricacion`, `fecha_expiracion`, `cantidad`, `proceso`, `cv1`, `cv2`, `responsables`, `equipo`, `mix_order_id`, `user_crea`, `user_upd`, `created_at`, `updated_at`, `parametros`) VALUES
(1, 'MZ SEDAL CR PEINAR RIZOS DEFINIDO', '25185', '7', 3, '6', '14096-20', '2025-07-29 06:00:00', '2027-01-04 06:00:00', 3000, 'Fabricación', '1', '1', 'Carlos Avilés', 'Mixer 2', 1, '', '', '2025-07-30 03:53:14', '2025-07-30 04:02:32', '[{\"id\":\"VISCOCIDAD\",\"order\":1,\"values\":{\"temp\":\"215\",\"especification\":\"200-400 mPas\",\"results\":\"109600 mPas\",\"create_by\":\"Ana Hern\\u00e1ndez\"}},{\"id\":\"PH\",\"order\":2,\"values\":{\"temp\":\"35\",\"especification\":\"5.5 - 7.6\",\"results\":\"4.95\",\"create_by\":\"Ana Hern\\u00e1ndez\"}},{\"id\":\"DENSIDAD\",\"order\":3,\"values\":{\"temp\":\"55\",\"especification\":\"0.95 - 1.05 g\\/mL\",\"results\":\"0.993 g\\/ml\",\"create_by\":\"Ana Hern\\u00e1ndez\"}}]'),
(2, 'MZ SEDAL CR PEINAR RIZOS DEFINIDO', '25185A', '8', 3, '7', '14097-20', '2025-07-30 06:00:00', '2027-01-04 06:00:00', 3000, 'Fabricación', NULL, NULL, 'Carlos Avilés', 'Mixer 2', 3, '', '', '2025-07-30 22:27:53', '2025-07-30 22:35:09', '[{\"id\":\"VISCOCIDAD\",\"order\":1,\"values\":{\"temp\":\"215\",\"especification\":\"200-400 mPas\",\"results\":\"115200 mPas\",\"create_by\":\"Ana Hern\\u00e1ndez\"}},{\"id\":\"PH\",\"order\":2,\"values\":{\"temp\":\"35\",\"especification\":\"5.5 - 7.6\",\"results\":\"4.91\",\"create_by\":\"Ana Hern\\u00e1ndez\"}},{\"id\":\"DENSIDAD\",\"order\":3,\"values\":{\"temp\":\"55\",\"especification\":\"0.95 - 1.05 g\\/mL\",\"results\":\"0.992 g\\/ml\",\"create_by\":\"Ana Hern\\u00e1ndez\"}}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspecciones`
--

CREATE TABLE `inspecciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estado` int(11) NOT NULL,
  `lote` varchar(15) NOT NULL,
  `tanque` varchar(50) DEFAULT NULL,
  `fechahoraconxtanque1` timestamp NULL DEFAULT NULL,
  `fechahoraconxtanque2` timestamp NULL DEFAULT NULL,
  `supervisorconxtanque1` varchar(255) DEFAULT NULL,
  `supervisorconxtanque2` varchar(255) DEFAULT NULL,
  `ctrlcalidadconxtanque1` varchar(255) DEFAULT NULL,
  `ctrlcalidadconxtanque2` varchar(255) DEFAULT NULL,
  `opmaquinaconxtanque1` varchar(255) DEFAULT NULL,
  `opmaquinaconxtanque2` varchar(255) DEFAULT NULL,
  `rechazadosfecha1` date DEFAULT NULL,
  `rechazadosfecha2` date DEFAULT NULL,
  `rechazadosfecha3` date DEFAULT NULL,
  `rechazadosfecha4` date DEFAULT NULL,
  `rechazadoscantidadund1` int(11) DEFAULT NULL,
  `rechazadoscantidadund2` int(11) DEFAULT NULL,
  `rechazadoscantidadund3` int(11) DEFAULT NULL,
  `rechazadoscantidadund4` int(11) DEFAULT NULL,
  `totalunidadesrechazadas` int(11) DEFAULT NULL,
  `vaciosfecha1` date DEFAULT NULL,
  `vaciosfecha2` date DEFAULT NULL,
  `vaciosfecha3` date DEFAULT NULL,
  `vaciosfecha4` date DEFAULT NULL,
  `vacioscantidadkgs1` double(8,2) DEFAULT NULL,
  `vacioscantidadkgs2` double(8,2) DEFAULT NULL,
  `vacioscantidadkgs3` double(8,2) DEFAULT NULL,
  `vacioscantidadkgs4` double(8,2) DEFAULT NULL,
  `totalkilogramosvacios` double(8,2) DEFAULT NULL,
  `productoterminado1` varchar(255) DEFAULT NULL,
  `productoterminado2` varchar(255) DEFAULT NULL,
  `pt` int(11) DEFAULT NULL,
  `ptotal` int(11) DEFAULT NULL,
  `rendimientomezcla` double(8,2) DEFAULT NULL,
  `consumobobina` varchar(15) DEFAULT NULL,
  `packing_id` bigint(20) UNSIGNED DEFAULT NULL,
  `num_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inspecciones`
--

INSERT INTO `inspecciones` (`id`, `estado`, `lote`, `tanque`, `fechahoraconxtanque1`, `fechahoraconxtanque2`, `supervisorconxtanque1`, `supervisorconxtanque2`, `ctrlcalidadconxtanque1`, `ctrlcalidadconxtanque2`, `opmaquinaconxtanque1`, `opmaquinaconxtanque2`, `rechazadosfecha1`, `rechazadosfecha2`, `rechazadosfecha3`, `rechazadosfecha4`, `rechazadoscantidadund1`, `rechazadoscantidadund2`, `rechazadoscantidadund3`, `rechazadoscantidadund4`, `totalunidadesrechazadas`, `vaciosfecha1`, `vaciosfecha2`, `vaciosfecha3`, `vaciosfecha4`, `vacioscantidadkgs1`, `vacioscantidadkgs2`, `vacioscantidadkgs3`, `vacioscantidadkgs4`, `totalkilogramosvacios`, `productoterminado1`, `productoterminado2`, `pt`, `ptotal`, `rendimientomezcla`, `consumobobina`, `packing_id`, `num_id`, `created_at`, `updated_at`) VALUES
(1, 5, '25185', '6', '2025-07-29 16:04:00', NULL, 'Jayro Arias', NULL, 'Carolina Guillén', NULL, 'Gabriela Vásquez', NULL, '2025-07-08', '2025-07-08', NULL, NULL, 31, 170, NULL, NULL, 201, '2025-07-08', '2025-07-08', NULL, NULL, 1.47, 2.28, NULL, NULL, 3.75, '478', '64', 321280, 201, 0.07, '264.88', 1, NULL, '2025-07-30 04:54:15', '2025-07-30 04:56:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `description` varchar(700) NOT NULL,
  `required_amount` decimal(10,6) DEFAULT NULL,
  `unit` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `entrega1` tinyint(1) NOT NULL,
  `lot1` varchar(100) DEFAULT NULL,
  `old_lot1` varchar(100) DEFAULT NULL,
  `entrega2` tinyint(1) NOT NULL,
  `lot2` varchar(30) DEFAULT NULL,
  `old_lot2` varchar(30) DEFAULT NULL,
  `mix_order_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `modified_by` varchar(150) DEFAULT NULL,
  `modification_date` timestamp NULL DEFAULT NULL,
  `modification_count` int(11) DEFAULT 0,
  `amount1` decimal(10,6) DEFAULT NULL,
  `amount2` decimal(10,6) DEFAULT NULL,
  `entrega3` tinyint(1) NOT NULL DEFAULT 0,
  `lot_changes_history` longtext DEFAULT NULL COMMENT 'Historial de cambios de lote en formato JSON'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materials`
--

INSERT INTO `materials` (`id`, `code`, `description`, `required_amount`, `unit`, `stock`, `entrega1`, `lot1`, `old_lot1`, `entrega2`, `lot2`, `old_lot2`, `mix_order_id`, `created_at`, `updated_at`, `modified_by`, `modification_date`, `modification_count`, `amount1`, `amount2`, `entrega3`, `lot_changes_history`) VALUES
(1, '809909900100', 'AGUA', 2611.660000, 'LT', 0, 1, 'N/A', NULL, 1, 'N/A', NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(2, '003007000003', 'CETERYL ALCOHOL', 180.000000, 'KG', 0, 1, 'MP01490625', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(3, '003007000010', 'STEARAMIDOPROPYL DIMETHYLAMINE MB', 48.000000, 'KG', 0, 1, 'MP00880325', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(4, '003007000009', 'DIMETHICONOL 1MM 500NM + BA ISOT', 65.000000, 'KG', 0, 1, 'MP01360525', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(5, '003007000005', 'GLYCERIN PHARMACOPEIA GRADE VEGETABLE', 30.000000, 'KG', 0, 1, 'MP01410525', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(6, '003007000016', 'LACTIC ACID 88%', 15.810000, 'KG', 0, 1, 'MP00620325', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(7, '003007000031', 'PERF BALI BEACH LLF2', 10.500000, 'KG', 0, 1, 'MP00280125 / MP01420525', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, 7.000000, 3.500000, 1, NULL),
(8, '003007000021', 'METHYLPARABEN', 6.000000, 'KG', 0, 1, 'MP01070425', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(9, '003007000030', 'DISODIUM EDTA', 1.500000, 'KG', 0, 1, 'MP02781224', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(10, '003007000011', 'MINERAL OIL 70', 9.000000, 'KG', 0, 1, 'MP00850325', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(11, '003007000027', 'PETROLATO (VASELINA)', 6.000000, 'KG', 0, 1, 'MP01660625', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(12, '003007000038', 'PERFECTA CAPS LLF', 4.500000, 'KG', 0, 1, 'MP00700325', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(13, '003007000054', 'ETHYLHEXYL METHOXYCINNAMATE', 0.030000, 'KG', 0, 1, 'MP02391123', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(14, '003007000032', 'PHENOXYETHANOL AC MX', 12.000000, 'KG', 0, 1, 'MP00740325', NULL, 0, NULL, NULL, 1, '2025-07-30 02:49:42', '2025-07-30 02:59:40', NULL, NULL, 0, NULL, NULL, 1, NULL),
(15, '809909900100', 'AGUA', 2781.900000, 'LT', 0, 1, 'N/A', NULL, 1, 'N/A', NULL, 2, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, 0, NULL, NULL, 0, NULL),
(16, '003007000014', 'CARBOMER 980', 30.000000, 'KG', 0, 0, '1', NULL, 0, NULL, NULL, 2, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, 0, NULL, NULL, 0, NULL),
(17, '003007000030', 'DISODIUM EDTA', 1.500000, 'KG', 0, 0, '1', NULL, 0, NULL, NULL, 2, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, 0, NULL, NULL, 0, NULL),
(18, '003007000090', 'ACRYLATES COPOLYMER 31%', 90.600000, 'KG', 0, 0, '1', NULL, 0, NULL, NULL, 2, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, 0, NULL, NULL, 0, NULL),
(19, '003007000092', 'CHRLT FRAGANCIA COLISEUM 16762801', 4.200000, 'KG', 0, 0, '1', NULL, 0, NULL, NULL, 2, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, 0, NULL, NULL, 0, NULL),
(20, '003007000093', 'GLYDANT PLUS', 5.400000, 'KG', 0, 0, '1', NULL, 0, NULL, NULL, 2, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, 0, NULL, NULL, 0, NULL),
(21, '003007000094', 'PROPILENGLICOL USP/EP', 12.000000, 'KG', 0, 0, '1', NULL, 0, NULL, NULL, 2, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, 0, NULL, NULL, 0, NULL),
(22, '003007000095', 'CI 60730 80% COSMETIC GRADE', 0.000780, 'KG', 0, 0, '1', NULL, 0, NULL, NULL, 2, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, 0, NULL, NULL, 0, NULL),
(23, '003007000100', 'TRIETHANOLAMINE 99%', 72.000000, 'KG', 73, 0, '1', NULL, 0, NULL, NULL, 2, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, 0, NULL, NULL, 0, NULL),
(24, '809909900100', 'AGUA', 2611.660000, 'LT', 101, 1, 'N/A', NULL, 1, 'N/A', NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(25, '003007000003', 'CETERYL ALCOHOL', 180.000000, 'KG', 101, 1, 'MP01490625', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(26, '003007000010', 'STEARAMIDOPROPYL DIMETHYLAMINE MB', 48.000000, 'KG', 101, 1, 'MP00880325', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(27, '003007000009', 'DIMETHICONOL 1MM 500NM + BA ISOT', 65.000000, 'KG', 101, 1, 'MP01360525', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(28, '003007000005', 'GLYCERIN PHARMACOPEIA GRADE VEGETABLE', 30.000000, 'KG', 101, 1, 'MP01410525', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(29, '003007000016', 'LACTIC ACID 88%', 15.810000, 'KG', 101, 1, 'MP00620325', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(30, '003007000031', 'PERF BALI BEACH LLF2', 10.500000, 'KG', 101, 1, 'MP01420525', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(31, '003007000021', 'METHYLPARABEN', 6.000000, 'KG', 101, 1, 'MP01070425', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(32, '003007000030', 'DISODIUM EDTA', 1.500000, 'KG', 101, 1, 'MP02781224', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(33, '003007000011', 'MINERAL OIL 70', 9.000000, 'KG', 101, 1, 'MP00850325', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(34, '003007000027', 'PETROLATO (VASELINA)', 6.000000, 'KG', 101, 1, 'MP01660625', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(35, '003007000038', 'PERFECTA CAPS LLF', 4.500000, 'KG', 101, 1, 'MP00700325', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(36, '003007000054', 'ETHYLHEXYL METHOXYCINNAMATE', 0.030000, 'KG', 101, 1, 'MP02391123', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(37, '003007000032', 'PHENOXYETHANOL AC MX', 12.000000, 'KG', 101, 1, 'MP00740325', NULL, 0, NULL, NULL, 3, '2025-07-30 22:05:57', '2025-07-30 22:16:25', NULL, NULL, 0, NULL, NULL, 1, NULL),
(38, '003007000089', 'SODIUM LAURETH SULFATE (70%) ICOF', 377.700000, 'KG', 101, 1, 'MP01550625 / MP01560625', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, 377.700000, 0.000000, 0, NULL),
(39, '003007000002', 'PARA PC COCAMIDOPROPYL BETAINE + NABENZ', 107.790000, 'KG', 101, 1, 'MP01500625', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(40, '003007000004', 'CLORURO DE SODIO', 48.900000, 'KG', 101, 1, 'MP0170625', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(41, '003007000005', 'GLYCERIN PHARMACOPEIA GRADE VEGETABLE', 30.000000, 'KG', 101, 1, 'MP01410525', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(42, '003007000006', 'PEG 45M', 0.750000, 'KG', 101, 1, 'MP01310525', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(43, '003007000007', 'EGDS (VEGETABLE DERIVED) + NABENZ DRUM', 48.840000, 'KG', 101, 1, 'MP01520625', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(44, '003007000008', 'DIMETHICONOL 1 MM 90 NM + POE +IPBC', 50.010000, 'KG', 101, 1, 'MP01030425', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(45, '003007000012', 'SODIUM BENZOATO', 14.220000, 'KG', 101, 1, 'MP01400525', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(46, '003007000014', 'CARBOMER 980', 9.000000, 'KG', 101, 1, 'MP00870325', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(47, '003007000018', 'ACIDO CITRICO', 6.000000, 'KG', 101, 1, 'MP01380525', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(48, '003007000026', 'GUAR HYDROXYPROPYLTRIMONIUM CHLORIDE', 3.000000, 'KG', 101, 1, 'MP00690325', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(49, '003007000029', 'SODA CAUSTICA LIQ 50%', 0.030000, 'KG', 101, 1, 'MP1120425', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(50, '003007000030', 'DISODIUM EDTA', 1.500000, 'KG', 101, 1, 'MP02781224', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(51, '003007000035', 'MYSTIQUE AD', 15.000000, 'KG', 101, 1, 'MP00020125', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(52, '003007000036', 'MICA DIOXIDO DE TITANIO', 1.500000, 'KG', 101, 1, 'MP02191023', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(53, '003007000055', 'CI 19140 85% COSMETIC GRADE', 0.090000, 'KG', 101, 1, 'MP01870522', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(54, '003007000056', 'CI 16035 85% COSMETIC GRADE', 0.330000, 'KG', 101, 1, 'MP01110424', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(55, '003007000057', 'CI 28440 80% COSMETIC GRADE', 0.255000, 'KG', 101, 1, 'MP00200125', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(56, '003007000065', 'MELANIN 98%', 0.030000, 'KG', 101, 1, 'MP02361024', NULL, 0, NULL, NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(57, '809909900100', 'AGUA', 2285.070000, 'LT', 101, 1, 'N/A', NULL, 1, 'N/A', NULL, 4, '2025-07-31 02:48:38', '2025-07-31 20:15:45', NULL, NULL, 0, NULL, NULL, 0, NULL),
(58, '809909900100', 'AGUA', 2783.300000, 'LT', 101, 1, 'N/A', NULL, 1, 'N/A', NULL, 5, '2025-07-31 22:29:51', '2025-07-31 22:43:15', NULL, NULL, 0, NULL, NULL, 0, NULL),
(59, '003007000014', 'CARBOMER 980', 30.000000, 'KG', 101, 1, 'MP00870325', NULL, 0, NULL, NULL, 5, '2025-07-31 22:29:51', '2025-07-31 22:43:15', NULL, NULL, 0, NULL, NULL, 0, NULL),
(60, '003007000030', 'DISODIUM EDTA', 1.500000, 'KG', 101, 1, 'MP02781224', NULL, 0, NULL, NULL, 5, '2025-07-31 22:29:51', '2025-07-31 22:43:15', NULL, NULL, 0, NULL, NULL, 0, NULL),
(61, '003007000090', 'ACRYLATES COPOLYMER 31%', 90.600000, 'KG', 101, 1, 'MP00590325', NULL, 0, NULL, NULL, 5, '2025-07-31 22:29:51', '2025-07-31 22:43:15', NULL, NULL, 0, NULL, NULL, 0, NULL),
(62, '003007000092', 'CHRLT FRAGANCIA COLISEUM 16762801', 4.200000, 'KG', 101, 1, 'MP02611124', NULL, 0, NULL, NULL, 5, '2025-07-31 22:29:51', '2025-07-31 22:43:15', NULL, NULL, 0, NULL, NULL, 0, NULL),
(63, '003007000093', 'GLYDANT PLUS', 5.400000, 'KG', 101, 1, 'MP01860824', NULL, 0, NULL, NULL, 5, '2025-07-31 22:29:51', '2025-07-31 22:43:15', NULL, NULL, 0, NULL, NULL, 0, NULL),
(64, '003007000094', 'PROPILENGLICOL USP/EP', 12.000000, 'KG', 101, 1, 'MP02381024', NULL, 0, NULL, NULL, 5, '2025-07-31 22:29:51', '2025-07-31 22:43:15', NULL, NULL, 0, NULL, NULL, 0, NULL),
(65, '003007000095', 'CI 60730 80% COSMETIC GRADE', 0.000780, 'KG', 101, 1, 'MP01970824', NULL, 0, NULL, NULL, 5, '2025-07-31 22:29:51', '2025-07-31 22:43:15', NULL, NULL, 0, NULL, NULL, 0, NULL),
(66, '003007000100', 'TRIETHANOLAMINE 99%', 73.000000, 'KG', 101, 1, 'MP00830325', NULL, 0, NULL, NULL, 5, '2025-07-31 22:29:51', '2025-07-31 22:43:15', NULL, NULL, 0, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `menu` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `path` varchar(200) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `menu`, `role_id`, `path`, `icon`, `parent`) VALUES
(100, 'Pesaje', 2, 'mix.load', 'bi bi-box', NULL),
(101, 'Control de Agua', 3, 'admin.anagua', 'bi bi-droplet-half', NULL),
(102, 'Iniciar proceso', 3, 'peso.approve', 'bi bi-box', NULL),
(103, 'Granel', 3, 'admin.addgranel', 'bi bi-box', NULL),
(104, 'Aprobar Pesaje', 6, 'peso.approve', 'bi bi-calendar2-check', NULL),
(105, 'Control de Agua', 6, 'admin.anagua', 'bi bi-calendar2-check', NULL),
(106, 'Verificar Análisis de Agua', 5, 'admin.anagua', 'bi bi-calendar2-check', NULL),
(107, 'Autorizar orden mezcla', 6, 'peso.approve', 'bi bi-calendar2-check', NULL),
(108, 'Seguimiento mezcla', 3, 'peso.approve', 'bi bi-box', NULL),
(109, 'Estandares de Calidad', 4, 'admin.addestandares', 'bi bi-box', NULL),
(110, 'Estandares de Calidad', 5, 'admin.addestandares', 'bi bi-box', NULL),
(111, 'Estandares de Calidad', 6, 'admin.addestandares', 'bi bi-box', NULL),
(112, 'Hoja de Control en Proceso', 4, 'admin.addcontroles', 'bi bi-box', NULL),
(113, 'Hoja de Control en Proceso', 5, 'admin.addcontroles', 'bi bi-box', NULL),
(114, 'Hoja de Control en Proceso', 6, 'admin.addcontroles', 'bi bi-box', NULL),
(115, 'Usuarios', 8, 'usuarios.list', 'bi bi-box', NULL),
(116, 'Empaque', 7, 'packing.load', 'bi bi-box', NULL),
(117, 'Seguimiento Empaque', 6, 'packing.seg', 'bi bi-box', NULL),
(118, 'Seguimiento Empaque', 4, 'packing.seg', 'bi bi-box', NULL),
(119, 'Hoja de Inspección', 4, 'admin.addinspecciones', 'bi bi-box', NULL),
(120, 'Hoja de Inspección', 5, 'admin.addinspecciones', 'bi bi-box', NULL),
(121, 'Hoja de Inspección', 9, 'admin.addinspecciones', 'bi bi-box', NULL),
(122, 'Estandares de Calidad', 9, 'admin.addestandares', 'bi bi-box', NULL),
(123, 'Hoja de Control en Proceso', 9, 'admin.addcontroles', 'bi bi-box', NULL),
(124, 'Control de Agua', 10, 'admin.anagua', 'bi bi-calendar2-check', NULL),
(125, 'Granel', 5, 'admin.addgranel', 'bi bi-box', NULL),
(126, 'Revisar orden de Mezcla', 5, 'peso.approve', 'bi bi-calendar2-check', NULL),
(127, 'Empaque', 4, 'packing.load', 'bi bi-box', NULL),
(128, 'Granel', 6, 'admin.addgranel', 'bi bi-box', NULL),
(129, 'Seguimiento de Empaque', 11, 'packing.seg', 'bi bi-box', NULL),
(130, 'Estandares de Calidad', 11, 'admin.addestandares', 'bi bi-box', NULL),
(131, 'Revisar orden Mezcla', 6, 'peso.approve', 'bi bi-box', NULL),
(132, 'Hoja de Inspección', 11, 'admin.addinspecciones', 'bi bi-box', NULL),
(133, 'Autorizar finalización de mezcla', 12, 'peso.approve', 'bi bi-box', NULL),
(134, 'Hoja de Control en Proceso', 12, 'admin.addcontroles', 'bi bi-box', NULL),
(135, 'Control de producto', 5, 'admin.controlproducto', 'bi bi-box', NULL),
(136, 'Control de producto', 6, 'admin.controlproducto', 'bi bi-box', NULL),
(137, 'Control de producto', 11, 'admin.controlproducto', 'bi bi-box', NULL),
(138, 'Control de producto', 10, 'admin.controlproducto', 'bi bi-box', NULL),
(139, 'Tanque', 4, 'tanque.tanque', 'bi bi-box', NULL),
(140, 'Tanque', 11, 'tanque.tanque', 'bi bi-box', NULL),
(141, 'Tanque', 9, 'tanque.tanque', 'bi bi-box', NULL),
(142, 'Tanque', 10, 'tanque.tanque', 'bi bi-box', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_11_25_070420_create_permission_tables', 1),
(5, '2021_11_25_070425_create_menus_table', 1),
(6, '2021_11_28_210628_create_mix_orders_table', 1),
(7, '2021_11_28_210823_create_materials_table', 1),
(8, '2021_11_28_210830_create_analisis_agua_table', 1),
(9, '2021_12_06_210830_create_granel_table', 1),
(10, '2021_12_19_205519_create_packings_table', 1),
(11, '2021_12_20_210830_create_controles_table', 1),
(12, '2021_12_20_210830_create_estandares_table', 1),
(13, '2021_12_27_230930_create_empaque_materials_table', 1),
(14, '2021_12_27_231042_create_inspecciones_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mix_orders`
--

CREATE TABLE `mix_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `num_id` varchar(100) DEFAULT NULL,
  `product_code` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lot_size` int(11) NOT NULL,
  `datetime_init` timestamp NULL DEFAULT NULL,
  `datetime_end` timestamp NULL DEFAULT NULL,
  `cod_formula_master` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_by` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `real_performance` int(11) DEFAULT NULL,
  `materials` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `status_receive_materials` tinyint(1) NOT NULL DEFAULT 0,
  `materials_received_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `water_check` tinyint(1) NOT NULL DEFAULT 0,
  `water_firma` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `water_date` timestamp NULL DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lot1_changes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `strict_modification` tinyint(1) NOT NULL DEFAULT 0,
  `revisiones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `user_entrega` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_autoriza` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_recibe` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lot_num` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autorize_finish_order` timestamp NULL DEFAULT NULL,
  `user_autoriza_finish` varchar(160) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `mix_orders`
--

INSERT INTO `mix_orders` (`id`, `order_date`, `num_id`, `product_code`, `product_name`, `lot_size`, `datetime_init`, `datetime_end`, `cod_formula_master`, `verified_by`, `real_performance`, `materials`, `status`, `status_receive_materials`, `materials_received_by`, `water_check`, `water_firma`, `water_date`, `observaciones`, `lot1_changes`, `strict_modification`, `revisiones`, `user_entrega`, `user_autoriza`, `user_recibe`, `created_at`, `updated_at`, `lot_num`, `autorize_finish_order`, `user_autoriza_finish`) VALUES
(1, '2025-07-29 21:06:37', '14096-20', '805800300005', 'MZ SEDAL CR PEINAR RIZOS DEFINIDO', 3000, '2025-07-29 21:02:00', '2025-07-29 21:05:00', 'SE004-06-21', 'Verónica Alas', 3000, 14, 7, 1, 'Carlos Avilés', 0, NULL, NULL, NULL, 0, 0, '[{\"username\":\"Ver\\u00f3nica Alas\",\"date\":\"2025-07-29\",\"firma\":\"Ver\\u00f3nica Alas\"}]', 'Miguel Cortéz', 'Verónica Alas', 'Carlos Avilés', '2025-07-30 02:49:42', '2025-07-30 03:06:37', '25185', '2025-07-30 03:06:37', 'Rafael Mendez'),
(2, '2025-03-05 06:00:00', '12334-20', '804300500001', 'MZ EGO GEL ATTRACTION EXP SLNM TAL', 3000, NULL, NULL, 'EGOB001-07-24', NULL, NULL, 9, 2, 0, NULL, 0, NULL, NULL, NULL, 0, 0, '[{\"username\":null,\"firma\":null,\"date\":null}]', 'Miguel Cortéz', NULL, NULL, '2025-07-30 10:49:52', '2025-07-30 10:49:52', NULL, NULL, NULL),
(3, '2025-07-30 16:19:17', '14097-20', '805800300005', 'MZ SEDAL CR PEINAR RIZOS DEFINIDO', 3000, '2025-07-30 16:17:00', '2025-07-30 16:18:00', 'SE004-06-21', 'Verónica Alas', 3000, 14, 7, 1, 'Carlos Avilés', 0, NULL, NULL, NULL, 0, 0, '[{\"username\":\"Ver\\u00f3nica Alas\",\"date\":\"2025-07-30\",\"firma\":\"Ver\\u00f3nica Alas\"}]', 'Miguel Cortéz', 'Verónica Alas', 'Carlos Avilés', '2025-07-30 22:05:57', '2025-07-30 22:19:17', '25185A', '2025-07-30 22:19:17', 'Rafael Mendez'),
(4, '2025-07-31 14:15:54', '13884-20', '805800100004', 'MZ SEDAL SH 2EN1 NEGROS LUMINOSOS', 3000, NULL, NULL, 'SE006-06-21', 'Wendy Toloza', NULL, 20, 3, 0, NULL, 0, NULL, NULL, NULL, 0, 0, '[{\"username\":null,\"firma\":null,\"date\":null}]', 'Miguel Castillo', NULL, NULL, '2025-07-31 02:48:38', '2025-07-31 20:15:54', NULL, NULL, NULL),
(5, '2025-07-31 16:52:11', '14077-20', '804300500001', 'MZ EGO GEL ATTRACTION EXP SLNM TAL', 3000, NULL, NULL, 'EGOB001-07-24', 'Wendy Toloza', NULL, 9, 3, 1, 'Carlos Avilés', 0, NULL, NULL, NULL, 0, 0, '[{\"username\":null,\"firma\":null,\"date\":null}]', 'Miguel Cortéz', NULL, NULL, '2025-07-31 22:29:51', '2025-07-31 22:52:11', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(3, 'App\\User', 3),
(4, 'App\\User', 4),
(5, 'App\\User', 5),
(6, 'App\\User', 6),
(7, 'App\\User', 7),
(9, 'App\\User', 8),
(8, 'App\\User', 9),
(2, 'App\\User', 10),
(5, 'App\\User', 11),
(6, 'App\\User', 12),
(3, 'App\\User', 13),
(9, 'App\\User', 14),
(4, 'App\\User', 15),
(7, 'App\\User', 16),
(10, 'App\\User', 18),
(1, 'App\\User', 19),
(1, 'App\\User', 20),
(1, 'App\\User', 21),
(2, 'App\\User', 22),
(2, 'App\\User', 23),
(2, 'App\\User', 24),
(2, 'App\\User', 25),
(7, 'App\\User', 26),
(7, 'App\\User', 27),
(7, 'App\\User', 28),
(5, 'App\\User', 29),
(5, 'App\\User', 30),
(5, 'App\\User', 31),
(6, 'App\\User', 32),
(6, 'App\\User', 33),
(6, 'App\\User', 34),
(6, 'App\\User', 35),
(11, 'App\\User', 36),
(11, 'App\\User', 37),
(11, 'App\\User', 38),
(11, 'App\\User', 39),
(11, 'App\\User', 40),
(11, 'App\\User', 41),
(3, 'App\\User', 42),
(3, 'App\\User', 43),
(3, 'App\\User', 44),
(3, 'App\\User', 45),
(3, 'App\\User', 46),
(3, 'App\\User', 47),
(9, 'App\\User', 48),
(9, 'App\\User', 49),
(4, 'App\\User', 50),
(4, 'App\\User', 51),
(12, 'App\\User', 52),
(10, 'App\\User', 53),
(8, 'App\\User', 54);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `packings`
--

CREATE TABLE `packings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `num_id` varchar(100) DEFAULT NULL,
  `product_code` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lot_num` varchar(30) DEFAULT NULL,
  `lot_size` int(11) NOT NULL,
  `total_units` int(11) NOT NULL,
  `performance_teorico` varchar(30) DEFAULT NULL,
  `performance` decimal(10,2) DEFAULT NULL,
  `times` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `operarios` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `entregas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `materials` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `observations` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_entrega` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_autoriza` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_recibe` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `packings`
--

INSERT INTO `packings` (`id`, `order_date`, `num_id`, `product_code`, `product_name`, `lot_num`, `lot_size`, `total_units`, `performance_teorico`, `performance`, `times`, `operarios`, `entregas`, `materials`, `status`, `observations`, `user_entrega`, `user_autoriza`, `user_recibe`, `created_at`, `updated_at`) VALUES
(1, '2025-06-24', '14096-10', '905800300007', 'SEDAL CR PEINAR RIZOS DEF SCH 24X28X9ML', '25185', 478, 321216, '321216', NULL, '[{\"time_id\":0,\"date_init\":\"2025-07-07\",\"time_init\":\"22:30\",\"format_init\":null,\"date_end\":\"2025-07-08\",\"time_end\":\"04:59\",\"format_end\":null},{\"time_id\":0,\"date_init\":\"2025-07-08\",\"time_init\":\"06:00\",\"format_init\":null,\"date_end\":\"2025-07-08\",\"time_end\":\"06:57\",\"format_end\":null},{\"time_id\":0,\"date_init\":null,\"time_init\":null,\"format_init\":null,\"date_end\":null,\"time_end\":null,\"format_end\":null}]', '[{\"ope_id\":0,\"fullname\":\"Gabriela Vásquez\",\"date\":\"29/07/2025\"},{\"ope_id\":0,\"fullname\":\"Gabriela Vásquez\",\"date\":\"29/07/2025\"},{\"ope_id\":0,\"fullname\":null,\"date\":null}]', '[{\"date\":\"29\\/07\\/2025\",\"cantidad\":\"400 C + 64 m\",\"entrega\":\"Gabriela V\\u00e1squez\",\"recibe\":\"Gabriela V\\u00e1squez\"},{\"date\":\"29\\/07\\/2025\",\"cantidad\":\"78 C\",\"entrega\":\"Gabriela V\\u00e1squez\",\"recibe\":\"Gabriela V\\u00e1squez\"},{\"date\":null,\"cantidad\":null,\"entrega\":null,\"recibe\":null}]', 4, 4, NULL, 'Elmer Celada', 'Carolina Guillén', 'Gabriela Vásquez', '2025-07-30 04:09:03', '2025-07-30 04:49:22'),
(2, '2025-06-24', '14097-10', '905800300007', 'SEDAL CR PEINAR RIZOS DEF SCH 24X28X9ML', '25185A', 475, 319200, NULL, NULL, '[{\"time_id\":0,\"date_init\":\"2025-07-08\",\"time_init\":\"08:11\",\"format_init\":null,\"date_end\":\"2025-07-08\",\"time_end\":\"14:59\",\"format_end\":null},{\"time_id\":0,\"date_init\":\"2025-07-08\",\"time_init\":\"20:10\",\"format_init\":null,\"date_end\":\"2025-07-08\",\"time_end\":\"20:53\",\"format_end\":null},{\"time_id\":0,\"date_init\":null,\"time_init\":null,\"format_init\":null,\"date_end\":null,\"time_end\":null,\"format_end\":null}]', '[{\"ope_id\":0,\"fullname\":\"Jessica Córdova\",\"date\":\"30/07/2025\"},{\"ope_id\":0,\"fullname\":\"Jessica Córdova\",\"date\":\"30/07/2025\"},{\"ope_id\":0,\"fullname\":null,\"date\":null}]', '[{\"date\":\"30\\/07\\/2025\",\"cantidad\":\"420 C\",\"entrega\":\"Jessica C\\u00f3rdova\",\"recibe\":\"Gabriela V\\u00e1squez\"},{\"date\":\"30\\/07\\/2025\",\"cantidad\":\"55\",\"entrega\":\"Jessica C\\u00f3rdova\",\"recibe\":\"Jessica C\\u00f3rdova\"},{\"date\":null,\"cantidad\":null,\"entrega\":null,\"recibe\":null}]', 4, 3, NULL, 'Elmer Celada', 'Carolina Guillén', 'Gabriela Vásquez', '2025-07-30 23:14:05', '2025-07-30 23:33:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'cap-cip', 'web', 'Capacidad especificamente para rol CIP', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(2, 'cap-materiaprima', 'web', 'Capacidad destinada solo para rol materia prima', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(3, 'cap-supcalidad', 'web', 'Capacidad destinada especificamente para rol supervisor de calidad', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(4, 'cap-mezcla', 'web', 'Capacidad destinada especificamente para rol mezcla', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(5, 'cap-produccion', 'web', 'Capacidad destinada especificamente para rol produccion', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(6, 'cap-calidad', 'web', 'Capacidad destinada especificamente para rol analisis de calidad', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(7, 'cap-bodega', 'web', 'Capacidad destinada especificamente para rol analisis de calidad', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(8, 'cap-administrador', 'web', 'Capacidad destinada especificamente para rol analisis de calidad', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(9, 'cap-supprod', 'web', 'Capacidad destinada especificamente para rol Supervisor de produccion', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(10, 'cargar-ordermix', 'web', 'Apartado para cargar un orden desde API o local', '2023-09-27 07:42:08', '2023-09-27 07:42:08'),
(11, 'approved-ordermix', 'web', 'Capacidad de aprovar una orden de produccion, mezcla', '2023-09-27 07:42:08', '2023-09-27 07:42:08'),
(12, 'times-ordermix', 'web', 'Capacidad de marcar tiempos de inicio y fin para orden de produccion, mezcla', '2023-09-27 07:42:08', '2023-09-27 07:42:08'),
(13, 'registro-analisis-agua', 'web', 'Capacidad de registrar, modificar hoja de granel', '2023-09-27 07:42:08', '2023-09-27 07:42:08'),
(14, 'registro-granel', 'web', 'Capacidad de registrar, modificar hoja de granel', '2023-09-27 07:42:08', '2023-09-27 07:42:08'),
(15, 'cap-jefecontrol-calidad', 'web', 'Capacidad especificamente para rol Jefe Control Calidad', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(16, 'cap-auxcontrol-calidad', 'web', 'Capacidad destinada específicamente para el rol Auxiliar de Control de Calidad', '2025-02-06 16:45:17', '2025-02-06 16:45:17'),
(17, 'cap-jefeproduccion', 'web', 'Capacidad destinada específicamente para el rol Jefe de Produccion', '2025-02-06 16:45:17', '2025-02-06 16:45:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado_analisis_agua`
--

CREATE TABLE `resultado_analisis_agua` (
  `id` int(11) NOT NULL,
  `resultado_ph` varchar(100) DEFAULT NULL,
  `resultado_conductividad` varchar(100) DEFAULT NULL,
  `resultado_cloro_libre` varchar(100) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `usuario_crea` varchar(100) DEFAULT NULL,
  `rol_crea` varchar(100) DEFAULT NULL,
  `estado` tinyint(3) UNSIGNED DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `resultado_analisis_agua`
--

INSERT INTO `resultado_analisis_agua` (`id`, `resultado_ph`, `resultado_conductividad`, `resultado_cloro_libre`, `observaciones`, `fecha_registro`, `usuario_crea`, `rol_crea`, `estado`) VALUES
(1, '6.31', '19.30 ms/cm', '1.85 ppm', NULL, '2025-07-29 14:39:59', 'Ana Hernández', 'Calidad', 0),
(2, '6.05', '17.74 us/cm', '1.70 ppm', NULL, '2025-07-30 10:02:59', 'Ana Hernández', 'Calidad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'CleanInPlace', 'web', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(2, 'MateriaPrima', 'web', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(3, 'Mezcla', 'web', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(4, 'Produccion', 'web', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(5, 'Calidad', 'web', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(6, 'SupCalidad', 'web', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(7, 'Bodega', 'web', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(8, 'Admin', 'web', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(9, 'SupProduccion', 'web', '2023-09-27 07:42:07', '2023-09-27 07:42:07'),
(10, 'JefeControlCalidad', 'web', '2024-05-01 07:42:07', '2024-05-01 07:42:07'),
(11, 'AuxControlCalidad', 'web', '2025-02-06 16:45:12', '2025-02-06 16:45:12'),
(12, 'JefeProduccion', 'web', '2025-02-06 16:45:12', '2025-02-06 16:45:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(10, 2),
(4, 3),
(12, 3),
(13, 3),
(5, 4),
(14, 4),
(6, 5),
(3, 6),
(11, 6),
(7, 7),
(8, 8),
(9, 9),
(15, 10),
(11, 11),
(16, 11),
(17, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Javier Bonilla', 'cip@unilever.es', NULL, '$2y$10$zqdko6R4LiyooF0pIHZiZexT..8.i/xWuR4rYi1gNGmvrtVMaobRm', NULL, 'Activo', '2023-09-27 19:42:08', '2025-04-08 00:36:49'),
(2, 'Marvin Cabrera', 'materiaprima@unilever.es', NULL, '$2y$10$esx4mV/PJA6dTIKR2OzGbu9zqy4BOVVmIriDxlTROPaT/dKhkFj36', NULL, 'Activo', '2023-09-27 19:42:08', '2023-09-27 19:42:08'),
(3, 'Carlos Agustin', 'mezcla@unilever.es', NULL, '$2y$10$RK0xYiONUh2fayZ8JvkQ3ud6zVFnEyH3fxZwyPtzZtC49lr6HatOa', NULL, 'Activo', '2023-09-27 19:42:08', '2023-09-27 19:42:08'),
(4, 'Jessica Murcia', 'produccion@unilever.es', NULL, '$2y$10$jgWwQxWrl.AYIrUPU4jqHOZBnQHqxCSwYuYycNKaIwxCtCbSTxl.e', NULL, 'Activo', '2023-09-27 19:42:08', '2023-09-27 19:42:08'),
(5, 'Angelica Rosalva', 'analisis.calidad@unilever.es', NULL, '$2y$10$EvBSpQnQfJ8OXAQvbhbd9u5cvDXnDjRt/GCZPZp1O.RYIu6NbPbyO', NULL, 'Activo', '2023-09-27 19:42:08', '2023-09-27 19:42:08'),
(6, 'Jorge Aguilar', 'sup.calidad@unilever.es', NULL, '$2y$10$3erFHtWZPfpDfkSqNutmGOx9smh7PYiOiu2K.vEecB/B8Pofhli/W', NULL, 'Activo', '2023-09-27 19:42:08', '2023-09-27 19:42:08'),
(7, 'Boris Argueta', 'bodega.empaque@unilever.es', NULL, '$2y$10$.ATPHZ5LyJr8ZMQALY5PkeyXowVjX4NEP4ELrEyaNfuryOTSP54zi', NULL, 'Activo', '2023-09-27 19:42:08', '2023-09-27 19:42:08'),
(8, 'Saul Mendoza', 'supervisor.produccion@unilever.es', NULL, '$2y$10$PbtCjaGBDQjsVYbGfAWHB.GUaVTYp/xYXTER/0r3Qf.R6wFLDnWuW', NULL, 'Activo', '2023-09-27 19:42:08', '2023-09-27 19:42:08'),
(9, 'Mario Nerio', 'admin@unilever.es', NULL, '$2y$10$lrV4oayTysrTvhO6vtxm8uD8GVPnFdN4etA/lR5w06wJOeEMYM8Ja', NULL, 'Activo', '2023-09-27 19:42:08', '2023-09-27 19:42:08'),
(10, 'Miguel Cortéz', 'miguel.cortez@iccuscatlan.com', NULL, '$2y$10$OzzE61QbiDRoOFksNhNg/eWXNXhfGx4ecF.gE0GWnK/oDDuSouN..', NULL, 'Activo', '2023-10-01 15:46:23', '2025-03-19 07:04:54'),
(11, 'Gabriela Mejía', 'gabriela.mejia@iccuscatlan.com', NULL, '$2y$10$3EfMYM.TcSWWxI.oBG5s4ewuhNqadQ/rW3bNTRYoOdW.lMrfT7UbS', NULL, 'Activo', '2023-10-01 15:47:51', '2023-10-01 15:47:51'),
(12, 'Verónica Alas', 'veronica.alas@iccuscatlan.com', NULL, '$2y$10$8PdkuAAlIQSIB/vS.OIK2OQiZ99pBWrd1X/JDzLHja9hgYWVkGju6', NULL, 'Activo', '2023-10-01 15:48:29', '2025-03-19 07:10:53'),
(13, 'Fredys Martínez', 'fredys.martinez@iccuscatlan.com', NULL, '$2y$10$EoGzVEsRkRq3SGcqIJvIWeDUEGzSgK3ZrYOHZzHXGrPAMXpLnSmo.', NULL, 'Activo', '2023-10-01 15:49:35', '2023-10-01 15:49:35'),
(14, 'Jayro Arias', 'jayro.arias@iccuscatlan.com', NULL, '$2y$10$SN4A4u0k3VRjzSZ559qQruDoM9St46/HF5treocI8/Ehydat1ivRe', NULL, 'Activo', '2023-10-01 15:50:32', '2025-03-19 07:15:23'),
(15, 'Gabriela Vásquez', 'gabriela.vasquez@iccuscatlan.com', NULL, '$2y$10$Y9dqtNsey.qoFf5tdx.WkO2nYC9yS3ulfVZoG89sZMoZzTy62AqNy', NULL, 'Activo', '2023-10-01 15:51:25', '2025-05-15 22:37:59'),
(16, 'Hector Navarro', 'hector.navarro@iccuscatlan.com', NULL, '$2y$10$N/paSC/0fvFIVHfMNL0/l.2FUK2XhtLFIGdkRifBXv1w/JyOiGeiW', NULL, 'Activo', '2023-10-01 15:53:31', '2025-05-16 00:12:45'),
(18, 'Marco Linares', 'jefecontrol.calidad@unilever.es', NULL, '$2y$10$pHoQcgV03gLnIN7O8Sjdxe9gEMzFG3iv4St.XyEXrFJNqz8DxkxJy', NULL, 'Activo', '2024-05-01 13:42:08', '2024-05-01 13:42:08'),
(19, 'José Amaya', 'jose.amaya@iccuscatlan.com', NULL, '$2y$10$bSYd1IaWKmys1m..2gzsw.fTzgD1rb.bXAKX5HymXKFOCa25iZ7wK', NULL, 'Activo', '2025-01-20 19:38:05', '2025-03-19 07:03:22'),
(20, 'Luis Miguel', 'luis.miguel@iccuscatlan.com', NULL, '$2y$10$Ly0CwwI82vMCkT5I0cFM8OEy37tERdSuGkvA0Wl2kr6xI9XzRqbxW', NULL, 'Activo', '2025-01-20 19:51:20', '2025-01-20 19:51:20'),
(21, 'David Calderón', 'david.calderon@iccuscatlan.com', NULL, '$2y$10$aXDfocvnop.rJxLA7Kvdj.H.9bBCa9YGiUmTZjDaxIzqnqpQzpwf.', NULL, 'Activo', '2025-01-20 19:51:54', '2025-01-20 19:51:54'),
(22, 'Iván Díaz', 'ivan.diaz@iccuscatlan.com', NULL, '$2y$10$Lv./.x9V9tRgJusl0IL/MumXoGEmIO0hceJdHlMoP7T0HCnszWg/.', NULL, 'Activo', '2025-01-20 19:52:43', '2025-05-12 22:27:15'),
(23, 'Gerson Molina', 'gerson.molina@iccuscatlan.com', NULL, '$2y$10$1P8m3UnCNlzB86wAViEaWu9ddPrKveY7eJvM2lWWUh2vNbZpTvAPi', NULL, 'Activo', '2025-01-20 19:53:18', '2025-01-20 19:53:18'),
(24, 'Josué Morataya', 'josue.morataya@iccuscatlan.com', NULL, '$2y$10$D1MrD5t.xO0vw2AfpPUE5uyiqEJiVznhwBB7ExDfzbtiUUlcDeZ86', NULL, 'Activo', '2025-01-20 19:53:50', '2025-01-20 19:53:50'),
(25, 'Miguel Castillo', 'miguel.castillo@iccuscatlan.com', NULL, '$2y$10$Cd480Vgwjfv/PFTWiXtdQ.vF7cFYqoGyzVmlypfOBavbZ61DCxxg.', NULL, 'Activo', '2025-01-20 19:54:22', '2025-01-20 19:54:22'),
(26, 'Elmer Celada', 'elmer.celada@iccuscatlan.com', NULL, '$2y$10$9W/L77U66jCnTYFHCljMXeBw9igQdcHXNMwb4FLZ.l43E4Iepojcu', NULL, 'Activo', '2025-01-20 19:55:49', '2025-01-20 19:55:49'),
(27, 'Josué Joya', 'josue.joya@iccuscatlan.com', NULL, '$2y$10$7meILKVCaQXKIL7IuW2W7uQLpKrPVX3yaTwEsj570hdI5h2eGRFXe', NULL, 'Activo', '2025-01-20 19:56:21', '2025-01-20 19:56:21'),
(28, 'Cesar López', 'cesar.lopez@iccuscatlan.com', NULL, '$2y$10$58jwUtaXnDi2NkZLFx0OdefyUXm90CYhbMHAEWSMBD7fpYR0wHMEq', NULL, 'Activo', '2025-01-20 19:56:58', '2025-01-20 19:56:58'),
(29, 'Ana Hernández', 'ana.hernandez@iccuscatlan.com', NULL, '$2y$10$aTectmqCORBihV2WuI4xq.MZ0Ufg1ZFvpi/REkCS.r.7ZK7wvMObi', NULL, 'Activo', '2025-01-20 19:57:40', '2025-03-19 07:08:31'),
(30, 'Douglas Campos', 'douglas.campos@iccuscatlan.com', NULL, '$2y$10$ffFsVjitpRpyQwIQ.ImGVeQUHPpUXnbXVjFuKSMXfdeTVs7GB4qbi', NULL, 'Activo', '2025-01-20 19:58:13', '2025-01-20 23:35:47'),
(31, 'Elena Bonilla', 'elena.bonilla@iccuscatlan.com', NULL, '$2y$10$T.ad9ROSm6FL7pTcVmc0tOrce7ZH/HrTkjD5A0Soupv8zKW2yXVtC', NULL, 'Activo', '2025-01-20 19:58:47', '2025-01-20 19:58:47'),
(32, 'Wendy Toloza', 'wendy.toloza@iccuscatlan.com', NULL, '$2y$10$24LvFz/Q2g2wSNT3P.AVu.W.zRGg4RwRxT/mO2xosAmOQyBrzC4.S', NULL, 'Activo', '2025-01-20 20:00:03', '2025-01-20 20:00:03'),
(33, 'Priscila Perez', 'priscila.perez@iccuscatlan.com', NULL, '$2y$10$V7lcuS64hywqY.UdZknhvur6slm/kao4Ev1VsRG0/QRQcbI9E15bi', NULL, 'Activo', '2025-01-20 20:00:31', '2025-01-20 20:00:31'),
(34, 'Jhonatan Asdrubal', 'jhonatan.asdrubal@iccuscatlan.com', NULL, '$2y$10$MglM7Yg.WgoxMB5qE/apzOO5SQjmTisc/5rU.hK85/O4jXJvZhN4O', NULL, 'Activo', '2025-01-20 20:01:05', '2025-01-20 23:36:34'),
(35, 'Oscar Palacios', 'oscar.palacios@iccuscatlan.com', NULL, '$2y$10$q/Ufwt3qjdUUW9l834kUieBQHrimNlA45Gk4nlbnMh9YWF2IyJpRi', NULL, 'Activo', '2025-01-20 20:01:33', '2025-01-20 20:01:33'),
(36, 'Carolina Guillén', 'carolina.guillen@iccuscatlan.com', NULL, '$2y$10$ZhVk7ar9GVJ8vF0qKlU4OeO7wg6WTN9oUSoUwJQgszkhRzlUPQQqy', NULL, 'Activo', '2025-01-20 20:02:06', '2025-03-19 07:12:14'),
(37, 'Claudia Alvarez', 'claudia.alvarez@iccuscatlan.com', NULL, '$2y$10$DVBlfaBvjzuVW7Xgi5O30O7vYtvBh7N9Kg9SDWlhggODeb8E7EwBS', NULL, 'Activo', '2025-01-20 20:02:37', '2025-01-20 20:02:37'),
(38, 'Juana Chevez', 'juana.chevez@iccuscatlan.com', NULL, '$2y$10$YppFOQyrEW8vRPDLz7gxjuRr058Fs9Wq6lTBjVbH1Oiz1bqJBucNO', NULL, 'Activo', '2025-01-20 20:03:03', '2025-01-20 20:03:03'),
(39, 'Abigail Navas', 'abigail.navas@iccuscatlan.com', NULL, '$2y$10$0oIjKTF/2OTMzMGOxZmzdumtrOQsng2HVpfazWteKx6IyOdEAhZtm', NULL, 'Activo', '2025-01-20 20:03:36', '2025-01-20 20:03:36'),
(40, 'Fabiola Chicas', 'fabiola.chicas@iccuscatlan.com', NULL, '$2y$10$2BljKmCeEQ/YfoK2eCB2/uEQcx4xygt2lh5TIUdYVln8WKIdnDFx.', NULL, 'Activo', '2025-01-20 20:04:10', '2025-01-20 20:04:10'),
(41, 'Fernando Melendez', 'fernando.melendez@iccuscatlan.com', NULL, '$2y$10$CKpbg/y3bFvNPZDJu9ECpeSZMflOy5NyVC/6spwEMPLMi/quThfeG', NULL, 'Activo', '2025-01-20 20:05:19', '2025-01-20 20:05:19'),
(42, 'Carlos Avilés', 'carlos.aviles@iccuscatlan.com', NULL, '$2y$10$jXzeiwIcztDntab9rSIxWeEAelnGwl7FFQn1at/Zky3k2iZnwb5ZK', NULL, 'Activo', '2025-01-20 20:06:09', '2025-03-19 07:13:22'),
(43, 'Lester Pacheco', 'lester.pacheco@iccuscatlan.com', NULL, '$2y$10$c6x1yw5JE4nJkj0i.etuL.0tIP7hvKuOzWZ8/RF7nVdA3zNn76rL.', NULL, 'Activo', '2025-01-20 20:06:45', '2025-01-20 20:06:45'),
(44, 'Samuel Montoya', 'samuel.montoya@iccuscatlan.com', NULL, '$2y$10$hKWilSgQkNH3VFaL6BK4HeHz9wAFkgXYcY.WmGlSPEK4rJCj/91Pq', NULL, 'Activo', '2025-01-20 20:07:12', '2025-01-20 20:07:12'),
(45, 'Ronald Perdomo', 'ronald.perdomo@iccuscatlan.com', NULL, '$2y$10$uuioaEYIbTpN64oGviZemOu.HNQRVxtQjt3s97uUWZaHxG1dP1Ht.', NULL, 'Activo', '2025-01-20 20:07:42', '2025-01-20 20:07:42'),
(46, 'Nelson Azahar', 'nelson.azahar@iccuscatlan.com', NULL, '$2y$10$/QL66mT7hlShURP70mTyd.W/wEPZyL.oK.7/OIFFJq.VxlTqZxf7y', NULL, 'Activo', '2025-01-20 20:08:11', '2025-01-20 23:41:59'),
(47, 'Jonathan Alvarez', 'jonathan.alvarez@iccuscatlan.com', NULL, '$2y$10$TrBfzdE.i18KLT/GJ8xmBuBLdqAVeIH7vBBFBekKJ6GxEF.0KHcqm', NULL, 'Activo', '2025-01-20 20:08:45', '2025-01-20 20:08:45'),
(48, 'Cecilia Juarez', 'Cecilia.Juarez@iccuscatlan.com', NULL, '$2y$10$uPnLijzj2nvBnfxPUa16G.d5igsv1ng9bBwjwSRkatz8CwYyCy/dW', NULL, 'Activo', '2025-01-20 20:10:33', '2025-01-20 20:10:33'),
(49, 'Gabriela Melara', 'gabriela.melara@iccuscatlan.com', NULL, '$2y$10$OpOchp2h/sGBKPL0X.MQ3eP8LulUpeFZ/eKWZ96X.uht9ixCUIpvm', NULL, 'Activo', '2025-01-20 20:11:04', '2025-01-20 20:11:04'),
(50, 'Jessica Córdova', 'jessica.cordova@iccuscatlan.com', NULL, '$2y$10$Zb38683dJyvaEutGgdS1DOQb3UegTIwsobyTG6Akpb6SfJX8/w7xi', NULL, 'Activo', '2025-01-20 20:12:39', '2025-05-20 01:19:16'),
(51, 'Lidia Mestizo', 'lidia.mestizo@iccuscatlan.com', NULL, '$2y$10$MBR88qjq6ApONPYcJbmOS.yGxV6SdqtUejfEx5adeTEEKh/4tjDu2', NULL, 'Activo', '2025-01-20 20:13:08', '2025-01-20 20:13:08'),
(52, 'Rafael Mendez', 'rafael.mendez@iccuscatlan.com', NULL, '$2y$10$3X3pCwk29QvE2nqUQ3kCtuhiykcoTKG3L8WEWWgfjC5pfTyaI8gVK', NULL, 'Activo', '2025-01-20 20:14:04', '2025-03-19 07:16:28'),
(53, 'Mirella Herrera', 'mirella.herrera@iccuscatlan.com', NULL, '$2y$10$esifO3gsvzE08dBHzZiMQ.KcQPl6IyIkf8WmMsYxzcL83bqq.aUKq', NULL, 'Activo', '2025-01-20 20:14:46', '2025-03-19 07:17:00'),
(54, 'Administrador', 'administrador@iccuscatlan.com', NULL, '$2y$10$fMEZW5/nFT/rxKuSfICXKui0eFcgppSSmlX44UJFnCdTnKjClu9Qi', NULL, 'Activo', '2025-01-20 20:16:23', '2025-01-21 00:40:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `validaciones_tanque`
--

CREATE TABLE `validaciones_tanque` (
  `id` int(11) NOT NULL,
  `numero_orden` varchar(50) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `operaria` varchar(100) DEFAULT NULL,
  `supervisor` varchar(100) DEFAULT NULL,
  `control_calidad` varchar(100) DEFAULT NULL,
  `lote` varchar(50) NOT NULL,
  `numero_tanque` varchar(50) NOT NULL,
  `codigo_empaque` varchar(100) DEFAULT NULL,
  `estado` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `validaciones_tanque`
--

INSERT INTO `validaciones_tanque` (`id`, `numero_orden`, `fecha_hora`, `operaria`, `supervisor`, `control_calidad`, `lote`, `numero_tanque`, `codigo_empaque`, `estado`) VALUES
(1, '14096 - 10', '2025-07-29 16:04:00', 'Gabriela Vásquez', 'Jayro Arias', 'Carolina Guillén', '25185', '6', NULL, 3),
(2, '14097 - 10', '2025-07-04 09:55:00', 'Gabriela Vásquez', 'Jayro Arias', 'Carolina Guillén', '25185A', '7', NULL, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `analisis_agua`
--
ALTER TABLE `analisis_agua`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `controles`
--
ALTER TABLE `controles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `control_producto`
--
ALTER TABLE `control_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empaque_materials`
--
ALTER TABLE `empaque_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estandares`
--
ALTER TABLE `estandares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `granel`
--
ALTER TABLE `granel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inspecciones`
--
ALTER TABLE `inspecciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mix_orders`
--
ALTER TABLE `mix_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `packings`
--
ALTER TABLE `packings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resultado_analisis_agua`
--
ALTER TABLE `resultado_analisis_agua`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `validaciones_tanque`
--
ALTER TABLE `validaciones_tanque`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `analisis_agua`
--
ALTER TABLE `analisis_agua`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `controles`
--
ALTER TABLE `controles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `control_producto`
--
ALTER TABLE `control_producto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empaque_materials`
--
ALTER TABLE `empaque_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `estandares`
--
ALTER TABLE `estandares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `granel`
--
ALTER TABLE `granel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inspecciones`
--
ALTER TABLE `inspecciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `mix_orders`
--
ALTER TABLE `mix_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `packings`
--
ALTER TABLE `packings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `resultado_analisis_agua`
--
ALTER TABLE `resultado_analisis_agua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `validaciones_tanque`
--
ALTER TABLE `validaciones_tanque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
