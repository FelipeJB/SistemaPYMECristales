SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "-05:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `latorre` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `latorre`;

CREATE TABLE `clientes` (
  `cltID` int(10) UNSIGNED NOT NULL,
  `cltNombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cltApellido` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cltEmail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cltTipoDocumento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cltCedula` bigint(20) NOT NULL,
  `cltCiudad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cltFechaCreacion` date NOT NULL,
  `cltCelular1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cltCelular2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cltDireccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cltTipoCliente` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cltTarifaICA` int(11) NOT NULL,
  `cltUsuarioCreador` int(11) NOT NULL,
  `cltMigrado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `codigo_wo_vidrios` (
  `cdgID` int(10) UNSIGNED NOT NULL,
  `cdgMilimID` int(11) NOT NULL,
  `cdgColorID` int(11) NOT NULL,
  `cdgWO` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `codigo_wo_vidrios` (`cdgID`, `cdgMilimID`, `cdgColorID`, `cdgWO`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Indefinido', '2018-10-03 04:12:41', '2018-10-03 04:12:41'),
(2, 3, 2, 'Indefinido', '2018-10-03 04:12:41', '2018-10-03 04:12:41'),
(3, 1, 3, 'Indefinido', '2018-10-03 04:14:00', '2018-10-03 04:14:00'),
(4, 2, 3, 'Indefinido', '2018-10-03 04:14:01', '2018-10-03 04:14:01'),
(5, 3, 3, 'Indefinido', '2018-10-03 04:14:01', '2018-10-03 04:14:01'),
(6, 1, 4, 'Indefinido', '2018-10-03 04:14:22', '2018-10-03 04:14:22'),
(7, 2, 4, 'Indefinido', '2018-10-03 04:14:22', '2018-10-03 04:14:22'),
(8, 3, 4, 'Indefinido', '2018-10-03 04:14:22', '2018-10-03 04:14:22'),
(9, 1, 5, 'Indefinido', '2018-10-03 04:14:36', '2018-10-03 04:14:36'),
(10, 2, 5, 'Indefinido', '2018-10-03 04:14:36', '2018-10-03 04:14:36'),
(11, 3, 5, 'Indefinido', '2018-10-03 04:14:36', '2018-10-03 04:14:36'),
(12, 1, 6, 'Indefinido', '2018-10-03 04:14:53', '2018-10-03 04:14:53'),
(13, 2, 6, 'Indefinido', '2018-10-03 04:14:53', '2018-10-03 04:14:53'),
(14, 3, 6, 'Indefinido', '2018-10-03 04:14:54', '2018-10-03 04:14:54'),
(15, 1, 7, 'Indefinido', '2018-10-03 04:15:31', '2018-10-03 04:15:31'),
(16, 2, 7, 'Indefinido', '2018-10-03 04:15:32', '2018-10-03 04:15:32'),
(17, 3, 7, 'Indefinido', '2018-10-03 04:15:32', '2018-10-03 04:15:32'),
(18, 1, 8, 'Indefinido', '2018-10-03 04:15:50', '2018-10-03 04:15:50'),
(19, 2, 8, 'Indefinido', '2018-10-03 04:15:50', '2018-10-03 04:15:50'),
(20, 3, 8, 'Indefinido', '2018-10-03 04:15:50', '2018-10-03 04:15:50'),
(21, 1, 9, 'Indefinido', '2018-10-03 04:16:26', '2018-10-03 04:16:26'),
(22, 2, 9, 'Indefinido', '2018-10-03 04:16:26', '2018-10-03 04:16:26'),
(23, 3, 9, 'Indefinido', '2018-10-03 04:16:27', '2018-10-03 04:16:27'),
(24, 1, 10, 'Indefinido', '2018-10-03 04:17:08', '2018-10-03 04:17:08'),
(25, 2, 10, 'Indefinido', '2018-10-03 04:17:09', '2018-10-03 04:17:09'),
(26, 3, 10, 'Indefinido', '2018-10-03 04:17:09', '2018-10-03 04:17:09'),
(27, 1, 11, 'Indefinido', '2018-10-03 04:17:26', '2018-10-03 04:17:26'),
(28, 2, 11, 'Indefinido', '2018-10-03 04:17:26', '2018-10-03 04:17:26'),
(29, 3, 11, 'Indefinido', '2018-10-03 04:17:27', '2018-10-03 04:17:27'),
(30, 1, 12, 'Indefinido', '2018-10-03 04:17:43', '2018-10-03 04:17:43'),
(31, 2, 12, 'Indefinido', '2018-10-03 04:17:44', '2018-10-03 04:17:44'),
(32, 3, 12, 'Indefinido', '2018-10-03 04:17:44', '2018-10-03 04:17:44'),
(33, 1, 13, 'Indefinido', '2018-10-03 04:18:02', '2018-10-03 04:18:02'),
(34, 2, 13, 'Indefinido', '2018-10-03 04:18:02', '2018-10-03 04:18:02'),
(35, 3, 13, 'Indefinido', '2018-10-03 04:18:03', '2018-10-03 04:18:03'),
(36, 1, 1, 'Indefinido', '2018-10-03 04:41:56', '2018-10-03 04:41:56'),
(37, 1, 2, 'Indefinido', '2018-10-03 04:41:56', '2018-10-03 04:41:56'),
(38, 1, 3, 'Indefinido', '2018-10-03 04:41:56', '2018-10-03 04:41:56'),
(39, 1, 4, 'Indefinido', '2018-10-03 04:41:56', '2018-10-03 04:41:56'),
(40, 1, 5, 'Indefinido', '2018-10-03 04:41:56', '2018-10-03 04:41:56'),
(41, 1, 6, 'Indefinido', '2018-10-03 04:41:56', '2018-10-03 04:41:56'),
(42, 1, 7, 'Indefinido', '2018-10-03 04:41:56', '2018-10-03 04:41:56'),
(43, 1, 8, 'Indefinido', '2018-10-03 04:41:57', '2018-10-03 04:41:57'),
(44, 1, 9, 'Indefinido', '2018-10-03 04:41:57', '2018-10-03 04:41:57'),
(45, 1, 10, 'Indefinido', '2018-10-03 04:41:57', '2018-10-03 04:41:57'),
(46, 1, 11, 'Indefinido', '2018-10-03 04:41:57', '2018-10-03 04:41:57'),
(47, 1, 12, 'Indefinido', '2018-10-03 04:41:57', '2018-10-03 04:41:57'),
(48, 1, 13, 'Indefinido', '2018-10-03 04:41:57', '2018-10-03 04:41:57'),
(49, 2, 1, 'Indefinido', '2018-10-03 04:42:02', '2018-10-03 04:42:02'),
(50, 2, 2, 'Indefinido', '2018-10-03 04:42:02', '2018-10-03 04:42:02'),
(51, 2, 3, 'Indefinido', '2018-10-03 04:42:02', '2018-10-03 04:42:02'),
(52, 2, 4, 'Indefinido', '2018-10-03 04:42:02', '2018-10-03 04:42:02'),
(53, 2, 5, 'Indefinido', '2018-10-03 04:42:02', '2018-10-03 04:42:02'),
(54, 2, 6, 'Indefinido', '2018-10-03 04:42:02', '2018-10-03 04:42:02'),
(55, 2, 7, 'Indefinido', '2018-10-03 04:42:02', '2018-10-03 04:42:02'),
(56, 2, 8, 'Indefinido', '2018-10-03 04:42:02', '2018-10-03 04:42:02'),
(57, 2, 9, 'Indefinido', '2018-10-03 04:42:03', '2018-10-03 04:42:03'),
(58, 2, 10, 'Indefinido', '2018-10-03 04:42:03', '2018-10-03 04:42:03'),
(59, 2, 11, 'Indefinido', '2018-10-03 04:42:03', '2018-10-03 04:42:03'),
(60, 2, 12, 'Indefinido', '2018-10-03 04:42:03', '2018-10-03 04:42:03'),
(61, 2, 13, 'Indefinido', '2018-10-03 04:42:03', '2018-10-03 04:42:03'),
(62, 3, 1, 'Indefinido', '2018-10-03 04:42:08', '2018-10-03 04:42:08'),
(63, 3, 2, 'Indefinido', '2018-10-03 04:42:08', '2018-10-03 04:42:08'),
(64, 3, 3, 'Indefinido', '2018-10-03 04:42:08', '2018-10-03 04:42:08'),
(65, 3, 4, 'Indefinido', '2018-10-03 04:42:08', '2018-10-03 04:42:08'),
(66, 3, 5, 'Indefinido', '2018-10-03 04:42:08', '2018-10-03 04:42:08'),
(67, 3, 6, 'Indefinido', '2018-10-03 04:42:08', '2018-10-03 04:42:08'),
(68, 3, 7, 'Indefinido', '2018-10-03 04:42:09', '2018-10-03 04:42:09'),
(69, 3, 8, 'Indefinido', '2018-10-03 04:42:09', '2018-10-03 04:42:09'),
(70, 3, 9, 'Indefinido', '2018-10-03 04:42:09', '2018-10-03 04:42:09'),
(71, 3, 10, 'Indefinido', '2018-10-03 04:42:09', '2018-10-03 04:42:09'),
(72, 3, 11, 'Indefinido', '2018-10-03 04:42:09', '2018-10-03 04:42:09'),
(73, 3, 12, 'Indefinido', '2018-10-03 04:42:09', '2018-10-03 04:42:09'),
(74, 3, 13, 'Indefinido', '2018-10-03 04:42:09', '2018-10-03 04:42:09');

CREATE TABLE `colors` (
  `clrID` int(10) UNSIGNED NOT NULL,
  `clrCodigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clrDescripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clrPrecioVenta` int(11) NOT NULL,
  `clrPrecioCompra` int(11) NOT NULL,
  `clrActivo` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `colors` (`clrID`, `clrCodigo`, `clrDescripcion`, `clrPrecioVenta`, `clrPrecioCompra`, `clrActivo`, `created_at`, `updated_at`) VALUES
(1, '12245', 'Incoloro', 0, 0, 1, '2018-09-06 22:32:02', '2018-10-03 04:22:15'),
(2, '73623', 'Bronce', 0, 0, 1, '2018-09-09 03:32:06', '2018-10-03 04:22:27'),
(3, '84734', 'Gris', 50000, 50000, 1, '2018-10-03 04:14:00', '2018-10-03 04:22:42'),
(4, '83745', 'Azul', 50000, 50000, 1, '2018-10-03 04:14:21', '2018-10-03 04:22:36'),
(5, '84756', 'Verde', 50000, 50000, 1, '2018-10-03 04:14:36', '2018-10-03 04:22:55'),
(6, '92854', 'RLW 1', 0, 0, 1, '2018-10-03 04:14:53', '2018-10-03 04:23:25'),
(7, '98453', 'RLW 2', 0, 0, 1, '2018-10-03 04:15:31', '2018-10-03 04:23:19'),
(8, '12543', 'RLW 3', 0, 0, 1, '2018-10-03 04:15:50', '2018-10-03 04:22:20'),
(9, '92325', 'RLW 4', 0, 0, 1, '2018-10-03 04:16:26', '2018-10-03 04:23:03'),
(10, '14325', 'RLW 5', 0, 0, 1, '2018-10-03 04:17:07', '2018-10-03 04:22:24'),
(11, '11432', 'RLW 6', 0, 0, 1, '2018-10-03 04:17:26', '2018-10-03 04:22:11'),
(12, '99786', 'RLW 7', 0, 0, 1, '2018-10-03 04:17:43', '2018-10-03 04:23:09'),
(13, '98465', 'RLW 8', 0, 0, 1, '2018-10-03 04:18:02', '2018-10-03 04:23:15');

CREATE TABLE `disenos` (
  `dsnID` int(10) UNSIGNED NOT NULL,
  `dsnCodigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dsnDescripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dsnActivo` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `estados` (
  `stdID` int(10) UNSIGNED NOT NULL,
  `stdDescripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `estados` (`stdID`, `stdDescripcion`, `created_at`, `updated_at`) VALUES
(1, 'Venta registrada, en espera de toma de medidas.', NULL, NULL),
(2, 'Medidas tomadas parcialmente para la orden. En espera de terminar la toma de medidas.', NULL, NULL),
(3, 'Medidas tomadas totalmente para la orden. En espera de programar la instalación.', NULL, NULL),
(4, 'Instalación programada para la orden.', NULL, NULL);

CREATE TABLE `forma_pagos` (
  `fpID` int(10) UNSIGNED NOT NULL,
  `fpDescripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `forma_pagos` (`fpID`, `fpDescripcion`, `created_at`, `updated_at`) VALUES
(1, 'Efectivo', NULL, NULL),
(2, 'Tarjeta', NULL, NULL),
(3, 'PayU', NULL, NULL);

CREATE TABLE `garantias` (
  `grnID` int(10) UNSIGNED NOT NULL,
  `grnFecha` date NOT NULL,
  `grnOrdenID` int(11) NOT NULL,
  `grnObservaciones` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `instaladors` (
  `insID` int(10) UNSIGNED NOT NULL,
  `insNombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insApellido` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insTipoDocumento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insCedula` bigint(20) NOT NULL,
  `insCiudad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insFechaCreacion` date NOT NULL,
  `insCelular` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insDireccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insActivo` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `medida_vidrios` (
  `mvdID` int(10) UNSIGNED NOT NULL,
  `mvdOrddID` int(11) NOT NULL,
  `mvdOrdID` int(11) NOT NULL,
  `mvdAlto` int(11) NOT NULL,
  `mvdAnchoArriba` int(11) NOT NULL,
  `mvdAnchoAbajo` int(11) NOT NULL,
  `mvdTipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mvdLado` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migracions` (
  `mgcID` int(10) UNSIGNED NOT NULL,
  `mgcFecha` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(18, '2014_10_12_000000_create_users_table', 1),
(19, '2014_10_12_100000_create_password_resets_table', 1),
(20, '2018_08_20_212519_create_rols_table', 1),
(21, '2018_08_22_003533_create_instaladors_table', 1),
(22, '2018_08_24_194802_create_punto_ventas_table', 2),
(23, '2018_08_27_210412_create_disenos_table', 3),
(24, '2018_08_28_002815_create_colors_table', 4),
(25, '2018_08_28_021326_create_milimetrajes_table', 5),
(52, '2018_08_28_190255_create_sistemas_table', 6),
(53, '2018_08_28_235457_create_sistema_detalles_table', 6),
(54, '2018_08_31_221216_create_precio_vidrios_table', 6),
(55, '2018_08_31_235143_create_codigo_wo_vidrios_table', 6),
(56, '2018_09_03_004516_create_garantias_table', 6),
(57, '2018_09_04_201749_create_clientes_table', 6),
(58, '2018_09_04_221828_create_ordens_table', 6),
(59, '2018_09_05_001803_create_forma_pagos_table', 6),
(60, '2018_09_05_015753_create_estados_table', 6),
(66, '2018_09_05_024125_create_orden_detalles_table', 7),
(67, '2018_09_11_143207_create_medida_vidrios_table', 7),
(68, '2018_10_16_191304_create_migracions_table', 8);

CREATE TABLE `milimetrajes` (
  `mlmID` int(10) UNSIGNED NOT NULL,
  `mlmNumero` int(11) NOT NULL,
  `mlmActivo` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `milimetrajes` (`mlmID`, `mlmNumero`, `mlmActivo`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2018-10-03 04:41:56', '2018-10-03 04:41:56'),
(2, 6, 1, '2018-10-03 04:42:02', '2018-10-03 04:42:02'),
(3, 8, 1, '2018-10-03 04:42:08', '2018-10-03 04:42:08');

CREATE TABLE `ordens` (
  `ordID` int(10) UNSIGNED NOT NULL,
  `ordNumeroPedido` int(11) DEFAULT NULL,
  `ordFecha` date NOT NULL,
  `ordPuntoVentaID` int(11) NOT NULL,
  `ordVendedorID` int(11) NOT NULL,
  `ordClienteID` int(11) NOT NULL,
  `ordFormaPagoID` int(11) NOT NULL,
  `ordTotal` int(11) NOT NULL,
  `ordTotalCompra` int(11) NOT NULL,
  `ordAbono` int(11) NOT NULL,
  `ordSaldo` int(11) NOT NULL,
  `ordEstadoInstalacionID` int(11) NOT NULL,
  `ordRazonNegativa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordFechaInstalacion` datetime DEFAULT NULL,
  `ordInstaladorID` int(11) DEFAULT NULL,
  `ordObservaciones` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordMigrado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `orden_detalles` (
  `orddID` int(10) UNSIGNED NOT NULL,
  `orddOrdenID` int(11) NOT NULL,
  `orddItem` int(11) NOT NULL,
  `orddDescuento` int(11) DEFAULT NULL,
  `orddTotal` int(11) NOT NULL,
  `orddTotalCompra` int(11) NOT NULL,
  `orddCantVidrio` int(11) NOT NULL,
  `orddCantToalleros` int(11) NOT NULL,
  `orddSistemaID` int(11) NOT NULL,
  `orddMilimID` int(11) NOT NULL,
  `orddColorID` int(11) NOT NULL,
  `orddDisenoID` int(11) NOT NULL,
  `orddEstadoMedidasID` int(11) DEFAULT NULL,
  `orddRazonNegativa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orddFechaMedidas` datetime DEFAULT NULL,
  `orddAuxiliarID` int(11) DEFAULT NULL,
  `orddObservaciones` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orddAlto` int(11) DEFAULT NULL,
  `orddAncho` int(11) DEFAULT NULL,
  `orddRelacion` int(11) DEFAULT NULL,
  `orddValorAdicional` int(11) DEFAULT NULL,
  `orddDescripcionAdicional` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orddLadoPuerta` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orddObservacionesVidrio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orddDescuadre` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `precio_vidrios` (
  `pvdID` int(10) UNSIGNED NOT NULL,
  `pvdMilimID` int(11) NOT NULL,
  `pvdSistemaID` int(11) NOT NULL,
  `pvdPrecioVenta` int(11) NOT NULL,
  `pvdPrecioCompra` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `precio_vidrios` (`pvdID`, `pvdMilimID`, `pvdSistemaID`, `pvdPrecioVenta`, `pvdPrecioCompra`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 210000, 190400, '2018-10-03 04:41:57', '2018-10-03 04:43:25'),
(2, 1, 2, 210000, 148155, '2018-10-03 04:41:57', '2018-10-03 04:45:26'),
(3, 1, 3, 210000, 168147, '2018-10-03 04:41:57', '2018-10-03 04:47:50'),
(4, 1, 4, 210000, 201110, '2018-10-03 04:41:57', '2018-10-03 04:51:28'),
(5, 1, 5, 210000, 260610, '2018-10-03 04:41:57', '2018-10-03 04:53:44'),
(6, 1, 6, 210000, 96509, '2018-10-03 04:41:57', '2018-10-03 04:57:04'),
(7, 1, 7, 210000, 148155, '2018-10-03 04:41:57', '2018-10-03 04:55:33'),
(8, 1, 8, 250000, 139706, '2018-10-03 04:41:57', '2018-10-03 05:22:06'),
(9, 1, 9, 250000, 139706, '2018-10-03 04:41:57', '2018-10-03 05:20:39'),
(10, 1, 10, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 05:21:29'),
(11, 1, 11, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 05:24:57'),
(12, 1, 12, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 05:23:00'),
(13, 1, 13, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 05:23:45'),
(14, 1, 14, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 05:19:53'),
(15, 1, 15, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 05:18:19'),
(16, 1, 16, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 05:19:09'),
(17, 1, 17, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 05:16:59'),
(18, 1, 18, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 04:59:39'),
(19, 1, 19, 250000, 139706, '2018-10-03 04:41:58', '2018-10-03 05:16:46'),
(20, 2, 1, 240000, 200158, '2018-10-03 04:42:03', '2018-10-03 04:43:44'),
(21, 2, 2, 240000, 158032, '2018-10-03 04:42:03', '2018-10-03 04:45:43'),
(22, 2, 3, 240000, 178500, '2018-10-03 04:42:03', '2018-10-03 04:48:09'),
(23, 2, 4, 240000, 210987, '2018-10-03 04:42:03', '2018-10-03 04:52:31'),
(24, 2, 5, 240000, 270487, '2018-10-03 04:42:03', '2018-10-03 04:54:00'),
(25, 2, 6, 240000, 107695, '2018-10-03 04:42:03', '2018-10-03 04:57:49'),
(26, 2, 7, 240000, 158032, '2018-10-03 04:42:03', '2018-10-03 04:55:48'),
(27, 2, 8, 270000, 150892, '2018-10-03 04:42:03', '2018-10-03 05:22:25'),
(28, 2, 9, 270000, 150892, '2018-10-03 04:42:03', '2018-10-03 05:20:50'),
(29, 2, 10, 270000, 150892, '2018-10-03 04:42:03', '2018-10-03 05:21:42'),
(30, 2, 11, 270000, 150892, '2018-10-03 04:42:03', '2018-10-03 05:25:06'),
(31, 2, 12, 270000, 150892, '2018-10-03 04:42:03', '2018-10-03 05:23:13'),
(32, 2, 13, 270000, 150892, '2018-10-03 04:42:03', '2018-10-03 05:24:06'),
(33, 2, 14, 270000, 150892, '2018-10-03 04:42:03', '2018-10-03 05:20:08'),
(34, 2, 15, 270000, 150892, '2018-10-03 04:42:03', '2018-10-03 05:18:36'),
(35, 2, 16, 270000, 150892, '2018-10-03 04:42:04', '2018-10-03 05:19:20'),
(36, 2, 17, 270000, 150892, '2018-10-03 04:42:04', '2018-10-03 05:17:11'),
(37, 2, 18, 270000, 150892, '2018-10-03 04:42:04', '2018-10-03 04:59:53'),
(38, 2, 19, 270000, 150892, '2018-10-03 04:42:04', '2018-10-03 05:16:38'),
(39, 3, 1, 290000, 237286, '2018-10-03 04:42:09', '2018-10-03 04:43:59'),
(40, 3, 2, 290000, 195279, '2018-10-03 04:42:09', '2018-10-03 04:46:02'),
(41, 3, 3, 290000, 215271, '2018-10-03 04:42:09', '2018-10-03 04:48:28'),
(42, 3, 4, 290000, 248115, '2018-10-03 04:42:09', '2018-10-03 04:52:41'),
(43, 3, 5, 290000, 307615, '2018-10-03 04:42:09', '2018-10-03 04:54:24'),
(44, 3, 6, 290000, 133994, '2018-10-03 04:42:09', '2018-10-03 04:57:59'),
(45, 3, 7, 290000, 195279, '2018-10-03 04:42:09', '2018-10-03 04:56:07'),
(46, 3, 8, 320000, 176953, '2018-10-03 04:42:09', '2018-10-03 05:22:41'),
(47, 3, 9, 320000, 176953, '2018-10-03 04:42:09', '2018-10-03 05:21:04'),
(48, 3, 10, 320000, 176953, '2018-10-03 04:42:09', '2018-10-03 05:21:53'),
(49, 3, 11, 320000, 176953, '2018-10-03 04:42:09', '2018-10-03 05:25:27'),
(50, 3, 12, 320000, 176953, '2018-10-03 04:42:09', '2018-10-03 05:23:25'),
(51, 3, 13, 320000, 176953, '2018-10-03 04:42:10', '2018-10-03 05:24:40'),
(52, 3, 14, 320000, 176953, '2018-10-03 04:42:10', '2018-10-03 05:20:23'),
(53, 3, 15, 320000, 176953, '2018-10-03 04:42:10', '2018-10-03 05:18:51'),
(54, 3, 16, 320000, 176953, '2018-10-03 04:42:10', '2018-10-03 05:19:40'),
(55, 3, 17, 320000, 176953, '2018-10-03 04:42:10', '2018-10-03 05:17:55'),
(56, 3, 18, 320000, 176953, '2018-10-03 04:42:10', '2018-10-03 05:00:10'),
(57, 3, 19, 320000, 176953, '2018-10-03 04:42:10', '2018-10-03 05:16:28');

CREATE TABLE `punto_ventas` (
  `pvID` int(10) UNSIGNED NOT NULL,
  `pvNombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pvDireccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pvActivo` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `rols` (
  `rusrID` int(10) UNSIGNED NOT NULL,
  `rusrDescripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rols` (`rusrID`, `rusrDescripcion`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', NULL, NULL),
(2, 'Asesor Comercial', NULL, NULL),
(3, 'Auxiliar Toma de Medidas', NULL, NULL),
(4, 'Auxiliar Logístico', NULL, NULL);

CREATE TABLE `sistemas` (
  `stmID` int(10) UNSIGNED NOT NULL,
  `stmTipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stmCodigoWO` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stmDescripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stmPrecioVenta` int(11) NOT NULL,
  `stmPrecioCompra` int(11) NOT NULL,
  `stmCantPerforaciones` int(11) NOT NULL,
  `stmCantBoquetes` int(11) NOT NULL,
  `stmCantBPB` int(11) NOT NULL,
  `stmCantChaflan` int(11) NOT NULL,
  `stmActivo` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sistemas` (`stmID`, `stmTipo`, `stmCodigoWO`, `stmDescripcion`, `stmPrecioVenta`, `stmPrecioCompra`, `stmCantPerforaciones`, `stmCantBoquetes`, `stmCantBPB`, `stmCantChaflan`, `stmActivo`, `created_at`, `updated_at`) VALUES
(1, 'Corrediza', '12345', 'K1', 130000, 0, 3, 1, 5, 2, 1, '2018-09-25 00:49:37', '2018-10-03 04:24:53'),
(2, 'Corrediza', '16543', 'K2', 100000, 0, 2, 2, 3, 2, 1, '2018-09-25 00:51:38', '2018-10-03 04:25:40'),
(3, 'Corrediza', '25364', 'K3', 150000, 0, 3, 3, 3, 3, 1, '2018-09-26 00:32:03', '2018-10-03 04:25:51'),
(4, 'Corrediza', '90453', 'K4', 200000, 0, 1, 1, 1, 1, 1, '2018-09-26 00:33:05', '2018-10-03 04:26:12'),
(5, 'Corrediza', '87654', 'K7', 300000, 0, 1, 1, 1, 1, 1, '2018-09-26 00:33:32', '2018-10-03 04:26:25'),
(6, 'Corrediza', '24634', 'DIALAN', 0, 0, 1, 1, 1, 1, 1, '2018-09-26 00:33:59', '2018-10-03 04:27:15'),
(7, 'Corrediza', '12543', 'TOGO', 100000, 0, 3, 2, 1, 2, 1, '2018-09-26 00:34:22', '2018-10-03 04:27:05'),
(8, 'Batiente', '32543', 'BATIENTE NORMAL TRASLAPADA', 0, 0, 2, 2, 2, 2, 1, '2018-09-26 00:35:46', '2018-10-03 04:28:03'),
(9, 'Batiente', '86473', 'BATIENTE NORMAL CHAFLAN', 0, 0, 3, 2, 1, 1, 1, '2018-09-26 00:36:55', '2018-10-03 04:28:18'),
(10, 'Batiente', '12348', 'BATIENTE NORMAL IMAN', 30000, 30000, 2, 2, 1, 1, 1, '2018-09-26 00:37:59', '2018-10-03 04:29:15'),
(11, 'Batiente', '85027', 'BATIENTE REDONDA TRASLAPADA', 0, 0, 2, 2, 1, 1, 1, '2018-09-26 03:40:12', '2018-10-03 04:29:39'),
(12, 'Batiente', '03865', 'BATIENTE REDONDA CHAFLAN', 0, 0, 2, 0, 1, 1, 1, '2018-09-26 03:40:40', '2018-10-03 04:29:50'),
(13, 'Batiente', '33759', 'BATIENTE REDONDA IMAN', 30000, 30000, 2, 1, 1, 1, 1, '2018-09-26 03:41:17', '2018-10-03 04:30:22'),
(14, 'Batiente', '92759', 'BATIENTE ESQUINAS TRASLAPADA', 0, 0, 1, 2, 1, 1, 1, '2018-09-26 03:42:09', '2018-10-03 04:31:03'),
(15, 'Batiente', '82634', 'BATIENTE ESQUINAS CHAFLAN', 0, 0, 2, 2, 3, 1, 1, '2018-09-26 03:42:37', '2018-10-03 04:31:12'),
(16, 'Batiente', '82745', 'BATIENTE ESQUINAS IMAN', 30000, 30000, 2, 2, 1, 1, 1, '2018-09-26 03:43:12', '2018-10-03 04:31:38'),
(17, 'Batiente', '82745', 'BATIENTE ARAÑA TRASLAPADA', 200000, 200000, 2, 2, 2, 2, 1, '2018-09-26 03:43:50', '2018-10-03 04:32:11'),
(18, 'Batiente', '92854', 'BATIENTE ARAÑA CHAFLAN', 200000, 200000, 2, 2, 1, 1, 1, '2018-09-26 03:46:37', '2018-10-03 04:32:25'),
(19, 'Batiente', '19503', 'BATIENTE ARAÑA IMAN', 230000, 230000, 2, 2, 5, 1, 1, '2018-09-26 03:47:13', '2018-10-03 04:32:47');

CREATE TABLE `sistema_detalles` (
  `stmdID` int(10) UNSIGNED NOT NULL,
  `stmdSistemaID` int(11) NOT NULL,
  `stmdCodigoWO` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stmdDescripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stmdCantidad` int(11) NOT NULL,
  `stmdActivo` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `usrNombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usrUsuario` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usrRolID` int(11) NOT NULL,
  `usrCedula` bigint(20) NOT NULL,
  `usrApellido` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usrTipoDocumento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usrActivo` int(11) NOT NULL,
  `usrCiudad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usrFechaCreacion` date NOT NULL,
  `usrCelular` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usrDireccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `usrNombre`, `usrUsuario`, `password`, `usrRolID`, `usrCedula`, `usrApellido`, `usrTipoDocumento`, `usrActivo`, `usrCiudad`, `usrFechaCreacion`, `usrCelular`, `usrDireccion`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Usuario', 'admin', '$2y$10$VwmgsbJPlHvvF18NiCleQecFfHlKMscNTI5xFeTHuRg5w1Sq02DTa', 1, 0, 'Administrador', 'CC', 1, 'Bogota', '2018-08-20', '3150000000', 'Calle 0#0-0.', 'WenswewJpgGHNoytyjWuRkZsVKqhLcLJ6UZUahCHHZAQMVGgrWB8EOln3UIp', NULL, '2018-09-01 07:45:22');


ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cltID`);

ALTER TABLE `codigo_wo_vidrios`
  ADD PRIMARY KEY (`cdgID`);

ALTER TABLE `colors`
  ADD PRIMARY KEY (`clrID`);

ALTER TABLE `disenos`
  ADD PRIMARY KEY (`dsnID`);

ALTER TABLE `estados`
  ADD PRIMARY KEY (`stdID`);

ALTER TABLE `forma_pagos`
  ADD PRIMARY KEY (`fpID`);

ALTER TABLE `garantias`
  ADD PRIMARY KEY (`grnID`);

ALTER TABLE `instaladors`
  ADD PRIMARY KEY (`insID`);

ALTER TABLE `medida_vidrios`
  ADD PRIMARY KEY (`mvdID`);

ALTER TABLE `migracions`
  ADD PRIMARY KEY (`mgcID`);

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `milimetrajes`
  ADD PRIMARY KEY (`mlmID`);

ALTER TABLE `ordens`
  ADD PRIMARY KEY (`ordID`);

ALTER TABLE `orden_detalles`
  ADD PRIMARY KEY (`orddID`);

ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

ALTER TABLE `precio_vidrios`
  ADD PRIMARY KEY (`pvdID`);

ALTER TABLE `punto_ventas`
  ADD PRIMARY KEY (`pvID`);

ALTER TABLE `rols`
  ADD PRIMARY KEY (`rusrID`);

ALTER TABLE `sistemas`
  ADD PRIMARY KEY (`stmID`);

ALTER TABLE `sistema_detalles`
  ADD PRIMARY KEY (`stmdID`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_usrusuario_unique` (`usrUsuario`);


ALTER TABLE `clientes`
  MODIFY `cltID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `codigo_wo_vidrios`
  MODIFY `cdgID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

ALTER TABLE `colors`
  MODIFY `clrID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `disenos`
  MODIFY `dsnID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `estados`
  MODIFY `stdID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `forma_pagos`
  MODIFY `fpID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `garantias`
  MODIFY `grnID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `instaladors`
  MODIFY `insID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `medida_vidrios`
  MODIFY `mvdID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `migracions`
  MODIFY `mgcID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

ALTER TABLE `milimetrajes`
  MODIFY `mlmID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `ordens`
  MODIFY `ordID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `orden_detalles`
  MODIFY `orddID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `precio_vidrios`
  MODIFY `pvdID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

ALTER TABLE `punto_ventas`
  MODIFY `pvID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `rols`
  MODIFY `rusrID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `sistemas`
  MODIFY `stmID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `sistema_detalles`
  MODIFY `stmdID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
