-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2020 a las 22:37:25
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


 
-- --------------------------------------------------------



CREATE TABLE  `abogados` ( 
  `IDNRO` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
   `NOMBRE` VARCHAR(60) NULL , `APELLIDO` VARCHAR(60) NULL , 
   `DOMICILIO` VARCHAR(150) NULL ,
    `TELEFONO` VARCHAR(20) NULL , 
   `CELULAR` VARCHAR(20) NULL , 
   `CEDULA` VARCHAR(9) NULL ,
   `EMAIL`  VARCHAR(60)  NULL, 
   `created_at` TIMESTAMP NULL,
   `updated_at` TIMESTAMP NULL,
   PRIMARY KEY (`IDNRO`)) ENGINE = InnoDB; 




--
-- Estructura de tabla para la tabla `actuaria`
--

CREATE TABLE `actuaria` (
  `DESCR` varchar(50) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arreglo_extrajudicial`
--

CREATE TABLE `arreglo_extrajudicial` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `TIPO` varchar(20) DEFAULT NULL,
  `IMPORTE_T` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `CANT_CUOTAS` int(3) NOT NULL DEFAULT 0,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arr_extr_cuotas`
--

CREATE TABLE `arr_extr_cuotas` (
  `ARREGLO` int(10) UNSIGNED DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `EXPIRA` date DEFAULT NULL,
  `IMPORTE` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `FECHA_PAGO` date DEFAULT NULL,
  `NUMERO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `DESCR` varchar(50) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cod_gasto`
--

CREATE TABLE `cod_gasto` (
  `CODIGO` varchar(10) DEFAULT NULL,
  `DESCRIPCION` varchar(50) DEFAULT NULL,
  `ACUMULADOS` int(1) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ctasban_mov`
--

CREATE TABLE `ctasban_mov` (
  `IDNRO` int(11) UNSIGNED NOT NULL,
  `BANCO` varchar(20) DEFAULT NULL,
  `CUENTA` varchar(20) DEFAULT NULL,
  `FECHA` varchar(10) DEFAULT NULL,
  `NUMERO` varchar(20) DEFAULT NULL,
  `CODIGO` varchar(20) DEFAULT NULL,
  `IMPORTE` int(10) DEFAULT 0,
  `CONCEPTO` varchar(50) DEFAULT NULL,
  `PROJECTO` varchar(22) DEFAULT NULL,
  `NRO_RECIBO` varchar(17) DEFAULT NULL,
  `PROVEEDOR` varchar(20) DEFAULT NULL,
  `TIPO_MOV` char(1) DEFAULT NULL,
  `IDBANCO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ctas_banco`
--

CREATE TABLE `ctas_banco` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `BANCO` varchar(20) DEFAULT NULL,
  `CUENTA` varchar(20) DEFAULT NULL,
  `TIPO_CTA` varchar(6) DEFAULT NULL,
  `TITULAR` varchar(60) DEFAULT NULL,
  `SALDO` varchar(12) DEFAULT '0',
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_judicial`
--

CREATE TABLE `cuenta_judicial` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `BANCO` varchar(25) DEFAULT NULL,
  `CTA_JUDICI` varchar(25) DEFAULT NULL,
  `ID_DEMA` int(10) UNSIGNED DEFAULT NULL,
  `CI` varchar(10) DEFAULT NULL,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demandado`
--

CREATE TABLE `demandado` (
  `IDNRO` int(4) NOT NULL,
  `TITULAR` varchar(60) DEFAULT NULL,
  `DOMICILIO` varchar(150) DEFAULT NULL,
  `CI` varchar(9) DEFAULT NULL,
  `TELEFONO` varchar(20) DEFAULT NULL,
  `CELULAR` varchar(20) DEFAULT NULL,
  `CELULAR2` varchar(20) DEFAULT NULL,
  `TRABAJO` varchar(30) DEFAULT NULL,
  `LABORAL` varchar(150) DEFAULT NULL,
  `TEL_TRABAJ` varchar(21) DEFAULT NULL,
  `GARANTE` varchar(35) DEFAULT NULL,
  `CI_GARANTE` varchar(9) DEFAULT NULL,
  `TEL_GARANT` varchar(20) DEFAULT NULL,
  `CEL_GARANT` varchar(20) DEFAULT NULL,
  `DOM_GARANT` varchar(150) DEFAULT NULL,
  `LABORAL_G` varchar(150) DEFAULT NULL,
  `TEL_LAB_G` varchar(20) DEFAULT NULL,
  `DOC_DENUNC` varchar(75) DEFAULT NULL,
  `LOCALIDAD` varchar(15) DEFAULT NULL,
  `DOC_DEN_GA` varchar(75) DEFAULT NULL,
  `LOCALIDA_G` varchar(15) DEFAULT NULL,
  `TRABAJO_G` varchar(30) DEFAULT NULL,
  `GARANTE_3` varchar(35) DEFAULT NULL,
  `CI_GAR_3` varchar(7) DEFAULT NULL,
  `DIR_GAR_3` varchar(50) DEFAULT NULL,
  `TEL_GAR_3` varchar(17) DEFAULT NULL,
  `CEL_GAR_3` varchar(17) DEFAULT NULL,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demandan`
--

CREATE TABLE `demandan` (
  `DESCR` varchar(50) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demandas2`
--

CREATE TABLE `demandas2` (
  `IDNRO` int(4) NOT NULL,
  `CI` varchar(9) DEFAULT NULL,
  `DEMANDANTE` varchar(10) DEFAULT NULL,
  `O_DEMANDA` varchar(20) DEFAULT NULL,
  `COD_EMP` varchar(15) DEFAULT NULL,
  `JUZGADO` varchar(20) DEFAULT NULL,
  `ACTUARIA` varchar(25) DEFAULT NULL,
  `JUEZ` varchar(30) DEFAULT NULL,
  `FINCA_NRO` int(5) DEFAULT NULL,
  `CTA_CATAST` varchar(20) DEFAULT NULL,
  `DEMANDA` int(8) DEFAULT NULL,
  `SALDO` int(10) UNSIGNED DEFAULT NULL,
  `EMBARGO_NR` int(4) DEFAULT NULL,
  `FEC_EMBARG` date DEFAULT NULL,
  `INSTITUCIO` varchar(35) DEFAULT NULL,
  `INST_TIPO` varchar(7) DEFAULT NULL,
  `CTA_BANCO` varchar(13) DEFAULT NULL,
  `BANCO` varchar(3) DEFAULT NULL,
  `EXPED_NRO` varchar(20) DEFAULT NULL,
  `FOLIO_EXPED` varchar(20) DEFAULT NULL,
  `ADJ_LEV_EMB_FEC` date DEFAULT NULL,
  `LEV_EMB_CAP_NRO` varchar(20) DEFAULT NULL,
  `LEV_EMB_CAP_FEC` date DEFAULT NULL,
  `LEV_EMB_CAP_INST` varchar(35) DEFAULT NULL,
  `CON_DEPOSITO` char(1) DEFAULT 'N',
  `OBS` varchar(100) DEFAULT NULL,
  `ARR_EXTRAJUDI` char(1) DEFAULT 'N',
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filtros`
--

CREATE TABLE `filtros` (
  `NRO` int(2) UNSIGNED NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `FILTRO` text DEFAULT NULL,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `CODIGO` int(10) UNSIGNED DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `NUMERO` varchar(10) DEFAULT '',
  `DETALLE1` varchar(50) DEFAULT NULL,
  `DETALLE2` varchar(46) DEFAULT NULL,
  `IMPORTE` int(11) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `ID_DEMA` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `honorarios`
--

CREATE TABLE `honorarios` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `ADJ_HONORARIOS` date DEFAULT NULL,
  `AI_NRO` varchar(20) DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `GS` double(20,0) UNSIGNED DEFAULT 0,
  `NOTIFI_1` date DEFAULT NULL,
  `ADJ_CITA` date DEFAULT NULL,
  `PROVIDENCIA` date DEFAULT NULL,
  `NOTIFI_2` date DEFAULT NULL,
  `ADJ_SD` date DEFAULT NULL,
  `SD_NRO` varchar(20) DEFAULT NULL,
  `FECHA_SD` date DEFAULT NULL,
  `NOTIFI_3` date DEFAULT NULL,
  `FECHA_EMB` date DEFAULT NULL,
  `GS2` double(20,0) UNSIGNED DEFAULT 0,
  `INSTI` int(10) UNSIGNED DEFAULT NULL,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instipo`
--

CREATE TABLE `instipo` (
  `DESCR` varchar(50) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituc`
--

CREATE TABLE `instituc` (
  `DESCR` varchar(50) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inter_contraparte`
--

CREATE TABLE `inter_contraparte` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `ABOGADO` varchar(40) DEFAULT NULL,
  `DIRLEGAL` varchar(80) DEFAULT '',
  `OBS` longtext DEFAULT NULL,
  `ABOGADO_` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juez`
--

CREATE TABLE `juez` (
  `DESCR` varchar(50) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juzgado`
--

CREATE TABLE `juzgado` (
  `DESCR` varchar(50) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquida`
--

CREATE TABLE `liquida` (
  `CTA_BANCO` varchar(13) DEFAULT NULL,
  `CAPITAL` varchar(10) DEFAULT '0',
  `ULT_PAGO` date DEFAULT NULL,
  `ULT_CHEQUE` date DEFAULT NULL,
  `CTA_MESES` varchar(10) DEFAULT NULL,
  `INT_X_MES` varchar(4) DEFAULT NULL,
  `IMP_INTERE` varchar(10) DEFAULT '0',
  `GAST_NOTIF` varchar(10) DEFAULT '0',
  `GAST_NOTIG` varchar(10) DEFAULT '0',
  `GAST_EMBAR` varchar(10) DEFAULT '0',
  `GAST_INTIM` varchar(10) DEFAULT '0',
  `HONO_PORCE` varchar(4) DEFAULT NULL,
  `HONORARIOS` varchar(10) DEFAULT '0',
  `IVA` varchar(10) DEFAULT NULL,
  `LIQUIDACIO` int(10) DEFAULT NULL,
  `TOTAL` varchar(10) DEFAULT '0',
  `EXTRAIDO` varchar(10) DEFAULT '0',
  `SALDO` int(10) DEFAULT 0,
  `EXT_LIQUID` varchar(10) DEFAULT '0',
  `NEW_SALDO` varchar(10) DEFAULT '0',
  `TITULAR` varchar(40) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `ID_DEMA` int(10) UNSIGNED DEFAULT NULL,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localida`
--

CREATE TABLE `localida` (
  `DESCR` varchar(50) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `REMITENTE` int(10) UNSIGNED DEFAULT NULL,
  `DESTINATARIO` int(10) UNSIGNED DEFAULT NULL,
  `ASUNTO` varchar(150) DEFAULT NULL,
  `MENSAJE` longtext DEFAULT NULL,
  `LEIDO` char(1) NOT NULL DEFAULT 'N',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mov_cta_judicial`
--

CREATE TABLE `mov_cta_judicial` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `CTA_JUDICIAL` int(10) UNSIGNED DEFAULT NULL,
  `TIPO_CTA` char(1) DEFAULT NULL,
  `TIPO_MOVI` char(1) NOT NULL,
  `FECHA` date DEFAULT NULL,
  `TIPO_EXT` char(1) DEFAULT NULL,
  `IMPORTE` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `CHEQUE_NRO` varchar(20) DEFAULT '',
  `CUENTA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `IDNRO` int(4) NOT NULL,
  `CI` varchar(9) DEFAULT NULL,
  `PRESENTADO` date DEFAULT NULL,
  `PROVI_1` date DEFAULT NULL,
  `NOTIFI_1` date DEFAULT NULL,
  `ADJ_AI` date DEFAULT NULL,
  `AI_NRO` varchar(10) DEFAULT NULL,
  `AI_FECHA` date DEFAULT NULL,
  `INTIMACI_1` date DEFAULT NULL,
  `INTIMACI_2` date DEFAULT NULL,
  `CITACION` date DEFAULT NULL,
  `PROVI_CITA` date DEFAULT NULL,
  `NOTIFI_2` date DEFAULT NULL,
  `ADJ_SD` date DEFAULT NULL,
  `SD_NRO` varchar(10) DEFAULT NULL,
  `SD_FECHA` date DEFAULT NULL,
  `NOTIFI_3` date DEFAULT NULL,
  `ADJ_LIQUI` date DEFAULT NULL,
  `LIQUIDACIO` int(10) DEFAULT NULL,
  `PROVI_2` date DEFAULT NULL,
  `NOTIFI_4` date DEFAULT NULL,
  `ADJ_APROBA` date DEFAULT NULL,
  `APROBA_AI` varchar(10) DEFAULT NULL,
  `APRO_FECHA` date DEFAULT NULL,
  `APROB_IMPO` int(10) DEFAULT NULL,
  `SALDO_EXT` int(8) DEFAULT NULL,
  `ADJ_OFICIO` date DEFAULT NULL,
  `NOTIFI_5` date DEFAULT NULL,
  `EMBARGO_N` int(8) DEFAULT 0,
  `EMB_FECHA` date DEFAULT NULL,
  `EMBAR_EJEC` int(7) DEFAULT NULL,
  `SD_FINIQUI` int(9) DEFAULT 0,
  `FEC_FINIQU` date DEFAULT NULL,
  `INIVISION` int(7) DEFAULT NULL,
  `FEC_INIVI` date DEFAULT NULL,
  `ARREGLO_EX` char(1) DEFAULT 'N',
  `LEVANTA` int(7) DEFAULT NULL,
  `FEC_LEVANT` varchar(10) DEFAULT NULL,
  `DEPOSITADO` int(7) DEFAULT NULL,
  `EXTRAIDO_C` int(7) DEFAULT NULL,
  `EXTRAIDO_L` int(7) DEFAULT NULL,
  `OTRA_INSTI` varchar(30) DEFAULT NULL,
  `EXCEPCION` varchar(1) DEFAULT NULL,
  `APELACION` varchar(10) DEFAULT NULL,
  `INCIDENTE` varchar(1) DEFAULT NULL,
  `ADJ_INHI_FEC` date DEFAULT NULL,
  `INHI_AI_FEC` date DEFAULT NULL,
  `INHI_NRO` varchar(10) DEFAULT NULL,
  `SALDO_LIQUI` int(10) UNSIGNED DEFAULT 0,
  `IMPORT_LIQUI` int(10) UNSIGNED DEFAULT 0,
  `HONO_MAS_IVA` int(10) UNSIGNED DEFAULT 0,
  `NOTIFI_LIQUI` date DEFAULT NULL,
  `CON_DEPOSITO` char(1) DEFAULT 'N',
  `OBSERVACION` varchar(100) DEFAULT NULL,
  `ADJ_INFO_FECHA` date DEFAULT NULL,
  `INFO_AUTOMOTOR` varchar(30) DEFAULT NULL,
  `INFO_AUTOVEHIC` varchar(30) DEFAULT NULL,
  `INFO_AUTOCHASI` varchar(30) DEFAULT NULL,
  `INFO_INMUEBLES` varchar(30) DEFAULT NULL,
  `INFO_INMUFINCA` varchar(30) DEFAULT NULL,
  `INFO_INMUDISTRI` varchar(30) DEFAULT NULL,
  `EMB_INMUEBLE` char(1) DEFAULT 'N',
  `EMB_VEHICULO` char(1) DEFAULT 'N',
  `NOTIFI_HONOIVA` date DEFAULT NULL,
  `INHI_AI_NRO` varchar(10) DEFAULT NULL,
  `NOTIFI1_AI_TIT` date DEFAULT NULL,
  `NOTIFI1_AI_GAR` date DEFAULT NULL,
  `NOTIFI2_AI_TIT` date DEFAULT NULL,
  `NOTIFI2_AI_GAR` date DEFAULT NULL,
  `FLAG` char(1) NOT NULL DEFAULT 'N',
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noti_pre`
--

CREATE TABLE `noti_pre` (
  `LOCALIDAD` varchar(15) DEFAULT NULL,
  `PRECIO` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obs_demanda`
--

CREATE TABLE `obs_demanda` (
  `IDNRO` int(4) UNSIGNED NOT NULL,
  `CI` varchar(9) DEFAULT NULL,
  `OBS_ABOGAD` varchar(32) DEFAULT NULL,
  `GARANTE_3` varchar(35) DEFAULT NULL,
  `DIR_GAR_3` varchar(50) DEFAULT NULL,
  `TEL_GAR_3` varchar(17) DEFAULT NULL,
  `CI_GAR_3` varchar(7) DEFAULT NULL,
  `OBS_PREVEN` longtext DEFAULT NULL,
  `OBS_EJECUT` longtext DEFAULT NULL,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odemanda`
--

CREATE TABLE `odemanda` (
  `CODIGO` varchar(10) DEFAULT NULL,
  `NOMBRES` varchar(50) DEFAULT NULL,
  `TELEFONO` varchar(7) DEFAULT NULL,
  `OBS` varchar(10) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE `parametros` (
  `INTERES` varchar(4) DEFAULT NULL,
  `MORA` varchar(4) DEFAULT NULL,
  `IVA` varchar(4) DEFAULT NULL,
  `SEGURO` varchar(4) DEFAULT NULL,
  `REDONDEO` int(1) DEFAULT NULL,
  `HONORARIOS` varchar(5) DEFAULT NULL,
  `PUNITORIO` varchar(4) DEFAULT NULL,
  `GASTOSADMIN` varchar(4) DEFAULT NULL,
  `DIASVTO` int(1) DEFAULT NULL,
  `FACTURA` int(4) DEFAULT NULL,
  `RECIBO` int(3) DEFAULT NULL,
  `FECMIN` varchar(10) DEFAULT NULL,
  `FECMAX` varchar(10) DEFAULT NULL,
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `EMAIL` varchar(60) DEFAULT NULL,
  `SHOW_COUNTERS` char(1) NOT NULL DEFAULT 'N',
  `DEPOSITO_CTA_JUDICI` char(1) NOT NULL DEFAULT 'N',
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_filtros`
--

CREATE TABLE `param_filtros` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `TABLA` varchar(30) DEFAULT NULL,
  `TABLA_FRONT` varchar(30) DEFAULT NULL,
  `CAMPO` varchar(30) DEFAULT NULL,
  `CAMPO_FRONT` varchar(30) DEFAULT NULL,
  `TIPO` char(1) DEFAULT NULL,
  `LONGITUD` int(3) DEFAULT NULL,
  `FUENTE` varchar(20) DEFAULT NULL,
  `ORDEN` int(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `param_filtros`
--

INSERT INTO `param_filtros` (`IDNRO`, `TABLA`, `TABLA_FRONT`, `CAMPO`, `CAMPO_FRONT`, `TIPO`, `LONGITUD`, `FUENTE`, `ORDEN`) VALUES
(138, 'arreglo_extrajudicial', 'ARREGLO EXTRAJ.', 'TIPO', 'TIPO', NULL, 1, NULL, 3),
(139, 'arreglo_extrajudicial', 'ARREGLO EXTRAJ.', 'IMPORTE_T', 'IMPORTE TOTAL', 'N', 10, NULL, 3),
(140, 'arreglo_extrajudicial', 'ARREGLO EXTRAJ.', 'CANT_CUOTAS', 'CANT_CUOTAS', 'N', 2, NULL, 3),
(142, 'demandas2', 'DEMANDAS', 'CI', 'CI', 'N', 9, NULL, 1),
(143, 'demandas2', 'DEMANDAS', 'DEMANDANTE', 'DEMANDANTE', 'L', 10, 'demandan', 1),
(144, 'demandas2', 'DEMANDAS', 'O_DEMANDA', 'ORIGEN DEMANDA', 'L', 20, 'odemanda', 1),
(145, 'demandas2', 'DEMANDAS', 'COD_EMP', 'COD_EMP', 'C', 15, NULL, 1),
(146, 'demandas2', 'DEMANDAS', 'JUZGADO', 'JUZGADO', 'L', 20, 'juzgado', 1),
(147, 'demandas2', 'DEMANDAS', 'ACTUARIA', 'ACTUARIA', 'L', 25, 'actuaria', 1),
(148, 'demandas2', 'DEMANDAS', 'JUEZ', 'JUEZ', 'L', 30, 'juez', 1),
(149, 'demandas2', 'DEMANDAS', 'FINCA_NRO', 'FINCA_NRO', 'N', 5, NULL, 1),
(150, 'demandas2', 'DEMANDAS', 'CTA_CATAST', 'CTA_CATAST', 'C', 20, NULL, 1),
(151, 'demandas2', 'DEMANDAS', 'DEMANDA', 'DEMANDA', 'N', 8, NULL, 1),
(152, 'demandas2', 'DEMANDAS', 'SALDO', 'SALDO', 'N', 8, NULL, 1),
(153, 'demandas2', 'DEMANDAS', 'EMBARGO_NR', 'NRO. EMBARGO', 'N', 4, NULL, 1),
(154, 'demandas2', 'DEMANDAS', 'FEC_EMBARG', 'FECHA EMBARGO', 'F', 10, NULL, 1),
(155, 'demandas2', 'DEMANDAS', 'INSTITUCIO', 'EMBARG. INSTITUCION', 'L', 35, 'instituc', 1),
(156, 'demandas2', 'DEMANDAS', 'INST_TIPO', 'TIPO INSTITUCION', 'L', 7, 'instipo', 1),
(157, 'demandas2', 'DEMANDAS', 'CTA_BANCO', 'CTA_BANCO', 'C', 13, NULL, 1),
(158, 'demandas2', 'DEMANDAS', 'BANCO', 'BANCO', 'L', 3, 'bancos', 1),
(159, 'demandas2', 'DEMANDAS', 'EXPED_NRO', 'EXPED_NRO', 'C', 20, NULL, 1),
(160, 'demandas2', 'DEMANDAS', 'FOLIO_EXPED', 'FOLIO_EXPEDIENTE', 'C', 20, NULL, 1),
(161, 'demandas2', 'DEMANDAS', 'ADJ_LEV_EMB_FEC', 'FECHA ADJ.LEV.EMBARGO', 'F', 10, NULL, 1),
(162, 'demandas2', 'DEMANDAS', 'LEV_EMB_CAP_NRO', 'NRO LEV.EMBARG.CAPITAL', 'C', 20, NULL, 1),
(163, 'demandas2', 'DEMANDAS', 'LEV_EMB_CAP_FEC', 'FECHA LEV. EMBARGO CAPITAL', 'F', 10, NULL, 1),
(164, 'demandas2', 'DEMANDAS', 'LEV_EMB_CAP_INST', 'INSTITUCION LEV.EMBARG.CAPITAL', 'L', 35, NULL, 1),
(165, 'demandas2', 'DEMANDAS', 'CON_DEPOSITO', 'CON_DEPOSITO', 'B', 1, NULL, 1),
(166, 'demandas2', 'DEMANDAS', 'OBS', 'OBSERVACION', 'C', 100, NULL, 1),
(167, 'demandas2', 'DEMANDAS', 'ARR_EXTRAJUDI', 'ARREGLO EXTRAJUDICIAL', 'B', 1, NULL, 1),
(169, 'inter_contraparte', 'INTERV. CONTRAPARTE', 'ABOGADO', 'ABOGADO', 'C', 40, NULL, 4),
(172, 'notificaciones', 'SEGUIMIENTO', 'PRESENTADO', 'PRESENTADO', 'F', 10, NULL, 2),
(173, 'notificaciones', 'SEGUIMIENTO', 'PROVI_1', 'PROVIDENCIA 1', 'F', 10, NULL, 2),
(174, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_1', 'NOTIFICACION', 'F', 10, NULL, 2),
(175, 'notificaciones', 'SEGUIMIENTO', 'ADJ_AI', 'ADJUNTO A.I', 'F', 10, NULL, 2),
(176, 'notificaciones', 'SEGUIMIENTO', 'AI_NRO', 'NRO. A.I', 'C', 10, NULL, 2),
(177, 'notificaciones', 'SEGUIMIENTO', 'AI_FECHA', 'FECHA A.I', 'F', 10, NULL, 2),
(178, 'notificaciones', 'SEGUIMIENTO', 'INTIMACI_1', 'INTIMACION', 'F', 10, NULL, 2),
(179, 'notificaciones', 'SEGUIMIENTO', 'INTIMACI_2', 'INTIMACION 2', 'F', 10, NULL, 2),
(180, 'notificaciones', 'SEGUIMIENTO', 'CITACION', 'ADJ. CITACION', 'F', 10, NULL, 2),
(181, 'notificaciones', 'SEGUIMIENTO', 'PROVI_CITA', 'PROVIDENCIA CITACION', 'F', 10, NULL, 2),
(182, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_2', 'NOTIFICACION 2', 'F', 10, NULL, 2),
(183, 'notificaciones', 'SEGUIMIENTO', 'ADJ_SD', 'ADJUNTO SD', 'F', 10, NULL, 2),
(184, 'notificaciones', 'SEGUIMIENTO', 'SD_NRO', 'NRO. S.D', 'C', 10, NULL, 2),
(185, 'notificaciones', 'SEGUIMIENTO', 'SD_FECHA', 'FECHA S.D', 'F', 10, NULL, 2),
(186, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_3', 'NOTIFICACION 3', 'F', 10, NULL, 2),
(187, 'notificaciones', 'SEGUIMIENTO', 'ADJ_LIQUI', 'ADJ. LIQUIDACION', 'F', 10, NULL, 2),
(188, 'notificaciones', 'SEGUIMIENTO', 'LIQUIDACIO', 'MONTO LIQUIDACION', 'N', 10, NULL, 2),
(189, 'notificaciones', 'SEGUIMIENTO', 'PROVI_2', 'PROVIDENCIA 2', 'F', 10, NULL, 2),
(190, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_4', 'NOTIFI_4', NULL, 10, NULL, 2),
(191, 'notificaciones', 'SEGUIMIENTO', 'ADJ_APROBA', 'ADJ. APROBACION', 'F', 10, NULL, 2),
(192, 'notificaciones', 'SEGUIMIENTO', 'APROBA_AI', 'APROBACION A.I', 'N', 10, NULL, 2),
(193, 'notificaciones', 'SEGUIMIENTO', 'APRO_FECHA', 'APROBACION FECHA', 'F', 10, NULL, 2),
(194, 'notificaciones', 'SEGUIMIENTO', 'APROB_IMPO', 'IMPORTE APROBACION', 'N', 10, NULL, 2),
(195, 'notificaciones', 'SEGUIMIENTO', 'SALDO_EXT', 'SALDO_EXT', NULL, NULL, NULL, 2),
(196, 'notificaciones', 'SEGUIMIENTO', 'ADJ_OFICIO', 'ADJUNTO OFICIO', 'F', 9, NULL, 2),
(197, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_5', 'NOTIFI_5', NULL, 10, NULL, 2),
(198, 'notificaciones', 'SEGUIMIENTO', 'EMBARGO_N', 'EMBARGO_N', NULL, NULL, NULL, 2),
(199, 'notificaciones', 'SEGUIMIENTO', 'EMB_FECHA', 'EMB_FECHA', NULL, 10, NULL, 2),
(200, 'notificaciones', 'SEGUIMIENTO', 'EMBAR_EJEC', 'EMBAR_EJEC', NULL, NULL, NULL, 2),
(201, 'notificaciones', 'SEGUIMIENTO', 'SD_FINIQUI', 'SD_FINIQUI', NULL, NULL, NULL, 2),
(202, 'notificaciones', 'SEGUIMIENTO', 'FEC_FINIQU', 'FEC_FINIQU', NULL, 10, NULL, 2),
(203, 'notificaciones', 'SEGUIMIENTO', 'INIVISION', 'INIVISION', NULL, NULL, NULL, 2),
(204, 'notificaciones', 'SEGUIMIENTO', 'FEC_INIVI', 'FECHA INHIBICION', 'F', 10, NULL, 2),
(205, 'notificaciones', 'SEGUIMIENTO', 'ARREGLO_EX', 'ARREGLO_EX', NULL, 1, NULL, 2),
(206, 'notificaciones', 'SEGUIMIENTO', 'LEVANTA', 'LEVANTA', NULL, NULL, NULL, 2),
(207, 'notificaciones', 'SEGUIMIENTO', 'FEC_LEVANT', 'FEC_LEVANT', NULL, 10, NULL, 2),
(208, 'notificaciones', 'SEGUIMIENTO', 'DEPOSITADO', 'DEPOSITADO', NULL, NULL, NULL, 2),
(209, 'notificaciones', 'SEGUIMIENTO', 'EXTRAIDO_C', 'EXTRAIDO_C', NULL, NULL, NULL, 2),
(210, 'notificaciones', 'SEGUIMIENTO', 'EXTRAIDO_L', 'EXTRAIDO_L', NULL, NULL, NULL, 2),
(211, 'notificaciones', 'SEGUIMIENTO', 'OTRA_INSTI', 'INSTITUCION EMBAR.LIQUID.', 'L', 30, NULL, 2),
(212, 'notificaciones', 'SEGUIMIENTO', 'EXCEPCION', 'EXCEPCION', NULL, 1, NULL, 2),
(213, 'notificaciones', 'SEGUIMIENTO', 'APELACION', 'APELACION', NULL, 10, NULL, 2),
(214, 'notificaciones', 'SEGUIMIENTO', 'INCIDENTE', 'INCIDENTE', NULL, 1, NULL, 2),
(215, 'notificaciones', 'SEGUIMIENTO', 'ADJ_INHI_FEC', 'FECHA ADJ.INHIBICION', 'F', NULL, NULL, 2),
(216, 'notificaciones', 'SEGUIMIENTO', 'INHI_AI_FEC', 'FECHA INHIBICION A.I', 'F', NULL, NULL, 2),
(217, 'notificaciones', 'SEGUIMIENTO', 'INHI_NRO', 'NRO. INHIBICION', 'C', 10, NULL, 2),
(218, 'notificaciones', 'SEGUIMIENTO', 'SALDO_LIQUI', 'SALDO LIQUIDACION', 'N', 10, NULL, 2),
(219, 'notificaciones', 'SEGUIMIENTO', 'IMPORT_LIQUI', 'IMPORTE LIQUIDACION', 'N', 10, NULL, 2),
(220, 'notificaciones', 'SEGUIMIENTO', 'HONO_MAS_IVA', 'HONORARIO+IVA', 'N', 10, NULL, 2),
(221, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_LIQUI', 'NOTIFICACION LIQUIDAC.', 'F', NULL, NULL, 2),
(222, 'notificaciones', 'SEGUIMIENTO', 'CON_DEPOSITO', 'CON DEPOSITO', 'B', 1, NULL, 2),
(223, 'notificaciones', 'SEGUIMIENTO', 'OBSERVACION', 'OBSERVACION', 'C', 100, NULL, 2),
(224, 'notificaciones', 'SEGUIMIENTO', 'ADJ_INFO_FECHA', 'FECHA ADJ. INFORME AL REG.', 'F', NULL, NULL, 2),
(225, 'notificaciones', 'SEGUIMIENTO', 'INFO_AUTOMOTOR', 'INFORME AUTOMOTOR', 'C', 30, NULL, 2),
(226, 'notificaciones', 'SEGUIMIENTO', 'INFO_AUTOVEHIC', 'INFORME VEHICULO', 'C', 30, NULL, 2),
(227, 'notificaciones', 'SEGUIMIENTO', 'INFO_AUTOCHASI', 'INFORME CHASIS', 'C', 30, NULL, 2),
(228, 'notificaciones', 'SEGUIMIENTO', 'INFO_INMUEBLES', 'INFORME INMUEBLES', 'C', 30, NULL, 2),
(229, 'notificaciones', 'SEGUIMIENTO', 'INFO_INMUFINCA', 'INFORME FINCA', 'C', 30, NULL, 2),
(230, 'notificaciones', 'SEGUIMIENTO', 'INFO_INMUDISTRI', 'INFORME DISTRITO', 'C', 30, NULL, 2),
(231, 'notificaciones', 'SEGUIMIENTO', 'EMB_INMUEBLE', 'EMBARGO INMUEBLE', 'B', 1, NULL, 2),
(232, 'notificaciones', 'SEGUIMIENTO', 'EMB_VEHICULO', 'EMBARGO VEHICULO', 'B', 1, NULL, 2),
(233, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_HONOIVA', 'NOTIFICACION 4', 'F', NULL, NULL, 2),
(234, 'notificaciones', 'SEGUIMIENTO', 'INHI_AI_NRO', 'INHIBICION NRO. A.I.', 'C', 10, NULL, 2);

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

CREATE TABLE `recibo` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `IMPORTE` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `DEUDOR` varchar(100) NOT NULL DEFAULT '',
  `ARREGLO` int(10) UNSIGNED DEFAULT NULL,
  `CONCEPTO` varchar(100) NOT NULL DEFAULT '',
  `FECHA_L` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relaciones_filtros`
--

CREATE TABLE `relaciones_filtros` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `TABLA` varchar(30) DEFAULT NULL,
  `TABLA_REL` varchar(30) DEFAULT NULL,
  `CAMPO_REL` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `relaciones_filtros`
--

INSERT INTO `relaciones_filtros` (`IDNRO`, `TABLA`, `TABLA_REL`, `CAMPO_REL`) VALUES
(1, 'demandas2', 'notificaciones', 'IDNRO'),
(2, 'demandas2', 'inter_contraparte', 'IDNRO'),
(3, 'demandas2', 'arreglo_extrajudicial', 'IDNRO'),
(4, 'notificaciones', 'demandas2', 'IDNRO'),
(5, 'inter_contraparte', 'demandas2', 'IDNRO'),
(6, 'arreglo_extrajudicial', 'demandas2', 'IDNRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IDNRO` int(10) UNSIGNED NOT NULL,
  `nick` varchar(20) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `tipo` char(1) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vtos`
--

CREATE TABLE `vtos` (
  `ID` int(10) UNSIGNED NOT NULL,
  `IDNRO` int(10) UNSIGNED DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `FECHAV` date DEFAULT NULL,
  `OBS` varchar(100) DEFAULT NULL,
  `VENCIDO` char(1) DEFAULT NULL,
  `ABOGADO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actuaria`
--
ALTER TABLE `actuaria`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `arreglo_extrajudicial`
--
ALTER TABLE `arreglo_extrajudicial`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `arr_extr_cuotas`
--
ALTER TABLE `arr_extr_cuotas`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `cod_gasto`
--
ALTER TABLE `cod_gasto`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `ctasban_mov`
--
ALTER TABLE `ctasban_mov`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `ctas_banco`
--
ALTER TABLE `ctas_banco`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `cuenta_judicial`
--
ALTER TABLE `cuenta_judicial`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `demandado`
--
ALTER TABLE `demandado`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `demandan`
--
ALTER TABLE `demandan`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `demandas2`
--
ALTER TABLE `demandas2`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `filtros`
--
ALTER TABLE `filtros`
  ADD PRIMARY KEY (`NRO`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `honorarios`
--
ALTER TABLE `honorarios`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `instipo`
--
ALTER TABLE `instipo`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `instituc`
--
ALTER TABLE `instituc`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `inter_contraparte`
--
ALTER TABLE `inter_contraparte`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `juez`
--
ALTER TABLE `juez`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `juzgado`
--
ALTER TABLE `juzgado`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `liquida`
--
ALTER TABLE `liquida`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `localida`
--
ALTER TABLE `localida`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `mov_cta_judicial`
--
ALTER TABLE `mov_cta_judicial`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `obs_demanda`
--
ALTER TABLE `obs_demanda`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `odemanda`
--
ALTER TABLE `odemanda`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `param_filtros`
--
ALTER TABLE `param_filtros`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `password_recovery`
--
ALTER TABLE `password_recovery`
  ADD PRIMARY KEY (`IDNRO`) USING BTREE;

--
-- Indices de la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `relaciones_filtros`
--
ALTER TABLE `relaciones_filtros`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IDNRO`);

--
-- Indices de la tabla `vtos`
--
ALTER TABLE `vtos`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actuaria`
--
ALTER TABLE `actuaria`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `arreglo_extrajudicial`
--
ALTER TABLE `arreglo_extrajudicial`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `arr_extr_cuotas`
--
ALTER TABLE `arr_extr_cuotas`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bancos`
--
ALTER TABLE `bancos`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cod_gasto`
--
ALTER TABLE `cod_gasto`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `ctasban_mov`
--
ALTER TABLE `ctasban_mov`
  MODIFY `IDNRO` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ctas_banco`
--
ALTER TABLE `ctas_banco`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuenta_judicial`
--
ALTER TABLE `cuenta_judicial`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `demandado`
--
ALTER TABLE `demandado`
  MODIFY `IDNRO` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `demandan`
--
ALTER TABLE `demandan`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `demandas2`
--
ALTER TABLE `demandas2`
  MODIFY `IDNRO` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `filtros`
--
ALTER TABLE `filtros`
  MODIFY `NRO` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `instipo`
--
ALTER TABLE `instipo`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `instituc`
--
ALTER TABLE `instituc`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT de la tabla `juez`
--
ALTER TABLE `juez`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `juzgado`
--
ALTER TABLE `juzgado`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `liquida`
--
ALTER TABLE `liquida`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `localida`
--
ALTER TABLE `localida`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mov_cta_judicial`
--
ALTER TABLE `mov_cta_judicial`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `odemanda`
--
ALTER TABLE `odemanda`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `parametros`
--
ALTER TABLE `parametros`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `param_filtros`
--
ALTER TABLE `param_filtros`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT de la tabla `password_recovery`
--
ALTER TABLE `password_recovery`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recibo`
--
ALTER TABLE `recibo`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relaciones_filtros`
--
ALTER TABLE `relaciones_filtros`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IDNRO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `vtos`
--
ALTER TABLE `vtos`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
