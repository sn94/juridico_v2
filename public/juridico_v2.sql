/*
 Navicat Premium Data Transfer

 Source Server         : MYSQL LOCAL
 Source Server Type    : MySQL
 Source Server Version : 100414
 Source Host           : localhost:3306
 Source Schema         : cli_19

 Target Server Type    : MySQL
 Target Server Version : 100414
 File Encoding         : 65001

 Date: 16/11/2020 18:54:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for abogados
-- ----------------------------
DROP TABLE IF EXISTS `abogados`;
CREATE TABLE `abogados`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `APELLIDO` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `DOMICILIO` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `TELEFONO` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CELULAR` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CEDULA` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `PIN` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `EMAIL` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;


DROP TABLE IF EXISTS `actuaria`;
CREATE TABLE `actuaria`  (
  `DESCR` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of actuaria
-- ----------------------------

-- ----------------------------
-- Table structure for arr_extr_cuotas
-- ----------------------------
DROP TABLE IF EXISTS `arr_extr_cuotas`;
CREATE TABLE `arr_extr_cuotas`  (
  `ARREGLO` int UNSIGNED NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `VENCIMIENTO` date NULL DEFAULT NULL,
  `IMPORTE` int UNSIGNED NOT NULL DEFAULT 0,
  `FECHA_PAGO` date NULL DEFAULT NULL,
  `NUMERO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of arr_extr_cuotas
-- ----------------------------

-- ----------------------------
-- Table structure for arreglo_extrajudicial
-- ----------------------------
DROP TABLE IF EXISTS `arreglo_extrajudicial`;
CREATE TABLE `arreglo_extrajudicial`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `TIPO` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `IMPORTE_T` int UNSIGNED NOT NULL DEFAULT 0,
  `CANT_CUOTAS` int NOT NULL DEFAULT 0,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 84 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

 
-- ----------------------------
-- Table structure for bancos
-- ----------------------------
DROP TABLE IF EXISTS `bancos`;
CREATE TABLE `bancos`  (
  `DESCR` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bancos
-- ----------------------------

-- ----------------------------
-- Table structure for cod_gasto
-- ----------------------------
DROP TABLE IF EXISTS `cod_gasto`;
CREATE TABLE `cod_gasto`  (
  `CODIGO` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DESCRIPCION` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ACUMULADOS` int NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cod_gasto
-- ----------------------------

-- ----------------------------
-- Table structure for ctas_banco
-- ----------------------------
DROP TABLE IF EXISTS `ctas_banco`;
CREATE TABLE `ctas_banco`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `BANCO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CUENTA` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TIPO_CTA` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TITULAR` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SALDO` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ctas_banco
-- ----------------------------

-- ----------------------------
-- Table structure for ctasban_mov
-- ----------------------------
DROP TABLE IF EXISTS `ctasban_mov`;
CREATE TABLE `ctasban_mov`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `BANCO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CUENTA` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FECHA` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NUMERO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CODIGO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IMPORTE` int NULL DEFAULT 0,
  `CONCEPTO` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PROJECTO` varchar(22) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NRO_RECIBO` varchar(17) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PROVEEDOR` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TIPO_MOV` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDBANCO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ctasban_mov
-- ----------------------------

-- ----------------------------
-- Table structure for cuenta_judicial
-- ----------------------------
DROP TABLE IF EXISTS `cuenta_judicial`;
CREATE TABLE `cuenta_judicial`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `BANCO` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CTA_JUDICI` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ID_DEMA` int UNSIGNED NULL DEFAULT NULL,
  `CI` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cuenta_judicial
-- ----------------------------

-- ----------------------------
-- Table structure for demandado
-- ----------------------------
DROP TABLE IF EXISTS `demandado`;
CREATE TABLE `demandado`  (
  `IDNRO` int NOT NULL AUTO_INCREMENT,
  `TITULAR` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOMICILIO` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CI` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TELEFONO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CELULAR` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CELULAR2` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TRABAJO` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `LABORAL` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TEL_TRABAJ` varchar(21) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `GARANTE` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CI_GARANTE` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TEL_GARANT` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CEL_GARANT` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOM_GARANT` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `LABORAL_G` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TEL_LAB_G` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOC_DENUNC` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `LOCALIDAD` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOC_DEN_GA` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `LOCALIDA_G` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TRABAJO_G` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `GARANTE_3` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CI_GAR_3` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DIR_GAR_3` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TEL_GAR_3` varchar(17) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CEL_GAR_3` varchar(17) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 60 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for demandan
-- ----------------------------
DROP TABLE IF EXISTS `demandan`;
CREATE TABLE `demandan`  (
  `DESCR` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of demandan
-- ----------------------------

-- ----------------------------
-- Table structure for demandas2
-- ----------------------------
DROP TABLE IF EXISTS `demandas2`;
CREATE TABLE `demandas2`  (
  `IDNRO` int NOT NULL AUTO_INCREMENT,
   `DEMANDADO` int UNSIGNED DEFAULT NULL,
  `CI` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DEMANDANTE` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `O_DEMANDA` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `COD_EMP` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `JUZGADO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ACTUARIA` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `JUEZ` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FINCA_NRO` int NULL DEFAULT NULL,
  `CTA_CATAST` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DEMANDA` int NULL DEFAULT NULL,
  `SALDO` int UNSIGNED NULL DEFAULT NULL,
  `EMBARGO_NR` int NULL DEFAULT NULL,
  `FEC_EMBARG` date NULL DEFAULT NULL,
  `INSTITUCIO` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `INST_TIPO` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CTA_BANCO` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `BANCO` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `EXPED_NRO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FOLIO_EXPED` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ADJ_LEV_EMB_FEC` date NULL DEFAULT NULL,
  `LEV_EMB_CAP_NRO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `LEV_EMB_CAP_FEC` date NULL DEFAULT NULL,
  `LEV_EMB_CAP_INST` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CON_DEPOSITO` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `OBS` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ARR_EXTRAJUDI` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 84 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for filtros
-- ----------------------------
DROP TABLE IF EXISTS `filtros`;
CREATE TABLE `filtros`  (
  `NRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FILTRO` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`NRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 116 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of filtros
-- ----------------------------

-- ----------------------------
-- Table structure for gastos
-- ----------------------------
DROP TABLE IF EXISTS `gastos`;
CREATE TABLE `gastos`  (
  `CODIGO` int UNSIGNED NULL DEFAULT NULL,
  `FECHA` date NULL DEFAULT NULL,
  `NUMERO` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `DETALLE1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `DETALLE2` varchar(46) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `IMPORTE` int NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ID_DEMA` int UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gastos
-- ----------------------------

-- ----------------------------
-- Table structure for honorarios
-- ----------------------------
DROP TABLE IF EXISTS `honorarios`;
CREATE TABLE `honorarios`  (
  `IDNRO` int UNSIGNED NOT NULL,
  `ADJ_HONORARIOS` date NULL DEFAULT NULL,
  `AI_NRO` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `FECHA` date NULL DEFAULT NULL,
  `GS` double(20, 0) UNSIGNED NULL DEFAULT 0,
  `NOTIFI_1` date NULL DEFAULT NULL,
  `ADJ_CITA` date NULL DEFAULT NULL,
  `PROVIDENCIA` date NULL DEFAULT NULL,
  `NOTIFI_2` date NULL DEFAULT NULL,
  `ADJ_SD` date NULL DEFAULT NULL,
  `SD_NRO` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `FECHA_SD` date NULL DEFAULT NULL,
  `NOTIFI_3` date NULL DEFAULT NULL,
  `FECHA_EMB` date NULL DEFAULT NULL,
  `GS2` double(20, 0) UNSIGNED NULL DEFAULT 0,
  `INSTI` int UNSIGNED NULL DEFAULT NULL,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of honorarios
-- ----------------------------


-- ----------------------------
-- Table structure for instipo
-- ----------------------------
DROP TABLE IF EXISTS `instipo`;
CREATE TABLE `instipo`  (
  `DESCR` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

 

-- ----------------------------
-- Table structure for instituc
-- ----------------------------
DROP TABLE IF EXISTS `instituc`;
CREATE TABLE `instituc`  (
  `DESCR` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 322 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of instituc
-- ----------------------------


-- ----------------------------
-- Table structure for inter_contraparte
-- ----------------------------
DROP TABLE IF EXISTS `inter_contraparte`;
CREATE TABLE `inter_contraparte`  (
  `IDNRO` int UNSIGNED NOT NULL,
  `ABOGADO` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `DIRLEGAL` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `OBS` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `ABOGADO_` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;



-- ----------------------------
-- Table structure for juez
-- ----------------------------
DROP TABLE IF EXISTS `juez`;
CREATE TABLE `juez`  (
  `DESCR` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of juez
-- ----------------------------

-- ----------------------------
-- Table structure for juzgado
-- ----------------------------
DROP TABLE IF EXISTS `juzgado`;
CREATE TABLE `juzgado`  (
  `DESCR` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of juzgado
-- ----------------------------

-- ----------------------------
-- Table structure for liquida
-- ----------------------------
DROP TABLE IF EXISTS `liquida`;
CREATE TABLE `liquida`  (
  `CTA_BANCO` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CAPITAL` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `ULT_PAGO` date NULL DEFAULT NULL,
  `ULT_CHEQUE` date NULL DEFAULT NULL,
  `CTA_MESES` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `INT_X_MES` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IMP_INTERE` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `GAST_NOTIF` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `GAST_NOTIG` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `GAST_EMBAR` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `GAST_INTIM` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `HONO_PORCE` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `HONORARIOS` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `IVA` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `LIQUIDACIO` int NULL DEFAULT NULL,
  `TOTAL` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `EXTRAIDO` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `SALDO` int NULL DEFAULT 0,
  `EXT_LIQUID` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `NEW_SALDO` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `TITULAR` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ID_DEMA` int UNSIGNED NULL DEFAULT NULL,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of liquida
-- ----------------------------

-- ----------------------------
-- Table structure for localida
-- ----------------------------
DROP TABLE IF EXISTS `localida`;
CREATE TABLE `localida`  (
  `DESCR` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of localida
-- ----------------------------

-- ----------------------------
-- Table structure for mensajes
-- ----------------------------
DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `REMITENTE` int UNSIGNED NULL DEFAULT NULL,
  `DESTINATARIO` int UNSIGNED NULL DEFAULT NULL,
  `ASUNTO` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `MENSAJE` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `LEIDO` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mensajes
-- ----------------------------

-- ----------------------------
-- Table structure for mov_cta_judicial
-- ----------------------------
DROP TABLE IF EXISTS `mov_cta_judicial`;
CREATE TABLE `mov_cta_judicial`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `CTA_JUDICIAL` int UNSIGNED NULL DEFAULT NULL,
  `TIPO_CTA` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `TIPO_MOVI` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `FECHA` date NULL DEFAULT NULL,
  `TIPO_EXT` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `IMPORTE` int UNSIGNED NOT NULL DEFAULT 0,
  `CHEQUE_NRO` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `CUENTA` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mov_cta_judicial
-- ----------------------------

-- ----------------------------
-- Table structure for noti_pre
-- ----------------------------
DROP TABLE IF EXISTS `noti_pre`;
CREATE TABLE `noti_pre`  (
  `LOCALIDAD` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PRECIO` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of noti_pre
-- ----------------------------

-- ----------------------------
-- Table structure for notificaciones
-- ----------------------------
DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE `notificaciones`  (
  `IDNRO` int NOT NULL,
  `CI` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PRESENTADO` date NULL DEFAULT NULL,
  `PROVI_1` date NULL DEFAULT NULL,
  `NOTIFI_1` date NULL DEFAULT NULL,
  `ADJ_AI` date NULL DEFAULT NULL,
  `AI_NRO` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `AI_FECHA` date NULL DEFAULT NULL,
  `INTIMACI_1` date NULL DEFAULT NULL,
  `INTIMACI_2` date NULL DEFAULT NULL,
  `CITACION` date NULL DEFAULT NULL,
  `PROVI_CITA` date NULL DEFAULT NULL,
  `NOTIFI_2` date NULL DEFAULT NULL,
  `ADJ_SD` date NULL DEFAULT NULL,
  `SD_NRO` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SD_FECHA` date NULL DEFAULT NULL,
  `NOTIFI_3` date NULL DEFAULT NULL,
  `ADJ_LIQUI` date NULL DEFAULT NULL,
  `LIQUIDACIO` int NULL DEFAULT NULL,
  `PROVI_2` date NULL DEFAULT NULL,
  `NOTIFI_4` date NULL DEFAULT NULL,
  `ADJ_APROBA` date NULL DEFAULT NULL,
  `APROBA_AI` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `APRO_FECHA` date NULL DEFAULT NULL,
  `APROB_IMPO` int NULL DEFAULT NULL,
  `SALDO_EXT` int NULL DEFAULT NULL,
  `ADJ_OFICIO` date NULL DEFAULT NULL,
  `NOTIFI_5` date NULL DEFAULT NULL,
  `EMBARGO_N` int NULL DEFAULT 0,
  `EMB_FECHA` date NULL DEFAULT NULL,
  `EMBAR_EJEC` int NULL DEFAULT NULL,
  `SD_FINIQUI` int NULL DEFAULT 0,
  `FEC_FINIQU` date NULL DEFAULT NULL,
  `INIVISION` int NULL DEFAULT NULL,
  `FEC_INIVI` date NULL DEFAULT NULL,
  `ARREGLO_EX` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `LEVANTA` int NULL DEFAULT NULL,
  `FEC_LEVANT` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DEPOSITADO` int NULL DEFAULT NULL,
  `EXTRAIDO_C` int NULL DEFAULT NULL,
  `EXTRAIDO_L` int NULL DEFAULT NULL,
  `OTRA_INSTI` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `EXCEPCION` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `APELACION` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `INCIDENTE` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ADJ_INHI_FEC` date NULL DEFAULT NULL,
  `INHI_AI_FEC` date NULL DEFAULT NULL,
  `INHI_NRO` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SALDO_LIQUI` int UNSIGNED NULL DEFAULT 0,
  `IMPORT_LIQUI` int UNSIGNED NULL DEFAULT 0,
  `HONO_MAS_IVA` int UNSIGNED NULL DEFAULT 0,
  `NOTIFI_LIQUI` date NULL DEFAULT NULL,
  `CON_DEPOSITO` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `OBSERVACION` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ADJ_INFO_FECHA` date NULL DEFAULT NULL,
  `INFO_AUTOMOTOR` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `INFO_AUTOVEHIC` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `INFO_AUTOCHASI` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `INFO_INMUEBLES` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `INFO_INMUFINCA` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `INFO_INMUDISTRI` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `EMB_INMUEBLE` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `EMB_VEHICULO` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `NOTIFI_HONOIVA` date NULL DEFAULT NULL,
  `INHI_AI_NRO` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NOTIFI1_AI_TIT` date NULL DEFAULT NULL,
  `NOTIFI1_AI_GAR` date NULL DEFAULT NULL,
  `NOTIFI2_AI_TIT` date NULL DEFAULT NULL,
  `NOTIFI2_AI_GAR` date NULL DEFAULT NULL,
  `FLAG` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

 
-- ----------------------------
-- Table structure for obs_demanda
-- ----------------------------
DROP TABLE IF EXISTS `obs_demanda`;
CREATE TABLE `obs_demanda`  (
  `IDNRO` int UNSIGNED NOT NULL,
  `CI` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `OBS_ABOGAD` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `GARANTE_3` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DIR_GAR_3` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TEL_GAR_3` varchar(17) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CI_GAR_3` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `OBS_PREVEN` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `OBS_EJECUT` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;




-- ----------------------------
-- Table structure for odemanda
-- ----------------------------
DROP TABLE IF EXISTS `odemanda`;
CREATE TABLE `odemanda`  (
  `CODIGO` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NOMBRES` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TELEFONO` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `OBS` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of odemanda
-- ----------------------------

-- ----------------------------
-- Table structure for param_filtros
-- ----------------------------
DROP TABLE IF EXISTS `param_filtros`;
CREATE TABLE `param_filtros`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `TABLA` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `TABLA_FRONT` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CAMPO` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CAMPO_FRONT` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `TIPO` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `LONGITUD` int NULL DEFAULT NULL,
  `FUENTE` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ORDEN` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 235 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of param_filtros
-- ----------------------------
INSERT INTO `param_filtros` VALUES (138, 'arreglo_extrajudicial', 'ARREGLO EXTRAJ.', 'TIPO', 'TIPO', NULL, 1, NULL, 3);
INSERT INTO `param_filtros` VALUES (139, 'arreglo_extrajudicial', 'ARREGLO EXTRAJ.', 'IMPORTE_T', 'IMPORTE TOTAL', 'N', 10, NULL, 3);
INSERT INTO `param_filtros` VALUES (140, 'arreglo_extrajudicial', 'ARREGLO EXTRAJ.', 'CANT_CUOTAS', 'CANT_CUOTAS', 'N', 2, NULL, 3);
INSERT INTO `param_filtros` VALUES (142, 'demandas2', 'DEMANDAS', 'CI', 'CI', 'N', 9, NULL, 1);
INSERT INTO `param_filtros` VALUES (143, 'demandas2', 'DEMANDAS', 'DEMANDANTE', 'DEMANDANTE', 'L', 10, 'demandan', 1);
INSERT INTO `param_filtros` VALUES (144, 'demandas2', 'DEMANDAS', 'O_DEMANDA', 'ORIGEN DEMANDA', 'L', 20, 'odemanda', 1);
INSERT INTO `param_filtros` VALUES (145, 'demandas2', 'DEMANDAS', 'COD_EMP', 'COD_EMP', 'C', 15, NULL, 1);
INSERT INTO `param_filtros` VALUES (146, 'demandas2', 'DEMANDAS', 'JUZGADO', 'JUZGADO', 'L', 20, 'juzgado', 1);
INSERT INTO `param_filtros` VALUES (147, 'demandas2', 'DEMANDAS', 'ACTUARIA', 'ACTUARIA', 'L', 25, 'actuaria', 1);
INSERT INTO `param_filtros` VALUES (148, 'demandas2', 'DEMANDAS', 'JUEZ', 'JUEZ', 'L', 30, 'juez', 1);
INSERT INTO `param_filtros` VALUES (149, 'demandas2', 'DEMANDAS', 'FINCA_NRO', 'FINCA_NRO', 'N', 5, NULL, 1);
INSERT INTO `param_filtros` VALUES (150, 'demandas2', 'DEMANDAS', 'CTA_CATAST', 'CTA_CATAST', 'C', 20, NULL, 1);
INSERT INTO `param_filtros` VALUES (151, 'demandas2', 'DEMANDAS', 'DEMANDA', 'DEMANDA', 'N', 8, NULL, 1);
INSERT INTO `param_filtros` VALUES (152, 'demandas2', 'DEMANDAS', 'SALDO', 'SALDO', 'N', 8, NULL, 1);
INSERT INTO `param_filtros` VALUES (153, 'demandas2', 'DEMANDAS', 'EMBARGO_NR', 'NRO. EMBARGO', 'N', 4, NULL, 1);
INSERT INTO `param_filtros` VALUES (154, 'demandas2', 'DEMANDAS', 'FEC_EMBARG', 'FECHA EMBARGO', 'F', 10, NULL, 1);
INSERT INTO `param_filtros` VALUES (155, 'demandas2', 'DEMANDAS', 'INSTITUCIO', 'EMBARG. INSTITUCION', 'L', 35, 'instituc', 1);
INSERT INTO `param_filtros` VALUES (156, 'demandas2', 'DEMANDAS', 'INST_TIPO', 'TIPO INSTITUCION', 'L', 7, 'instipo', 1);
INSERT INTO `param_filtros` VALUES (157, 'demandas2', 'DEMANDAS', 'CTA_BANCO', 'CTA_BANCO', 'C', 13, NULL, 1);
INSERT INTO `param_filtros` VALUES (158, 'demandas2', 'DEMANDAS', 'BANCO', 'BANCO', 'L', 3, 'bancos', 1);
INSERT INTO `param_filtros` VALUES (159, 'demandas2', 'DEMANDAS', 'EXPED_NRO', 'EXPED_NRO', 'C', 20, NULL, 1);
INSERT INTO `param_filtros` VALUES (160, 'demandas2', 'DEMANDAS', 'FOLIO_EXPED', 'FOLIO_EXPEDIENTE', 'C', 20, NULL, 1);
INSERT INTO `param_filtros` VALUES (161, 'demandas2', 'DEMANDAS', 'ADJ_LEV_EMB_FEC', 'FECHA ADJ.LEV.EMBARGO', 'F', 10, NULL, 1);
INSERT INTO `param_filtros` VALUES (162, 'demandas2', 'DEMANDAS', 'LEV_EMB_CAP_NRO', 'NRO LEV.EMBARG.CAPITAL', 'C', 20, NULL, 1);
INSERT INTO `param_filtros` VALUES (163, 'demandas2', 'DEMANDAS', 'LEV_EMB_CAP_FEC', 'FECHA LEV. EMBARGO CAPITAL', 'F', 10, NULL, 1);
INSERT INTO `param_filtros` VALUES (164, 'demandas2', 'DEMANDAS', 'LEV_EMB_CAP_INST', 'INSTITUCION LEV.EMBARG.CAPITAL', 'L', 35, NULL, 1);
INSERT INTO `param_filtros` VALUES (165, 'demandas2', 'DEMANDAS', 'CON_DEPOSITO', 'CON_DEPOSITO', 'B', 1, NULL, 1);
INSERT INTO `param_filtros` VALUES (166, 'demandas2', 'DEMANDAS', 'OBS', 'OBSERVACION', 'C', 100, NULL, 1);
INSERT INTO `param_filtros` VALUES (167, 'demandas2', 'DEMANDAS', 'ARR_EXTRAJUDI', 'ARREGLO EXTRAJUDICIAL', 'B', 1, NULL, 1);
INSERT INTO `param_filtros` VALUES (169, 'inter_contraparte', 'INTERV. CONTRAPARTE', 'ABOGADO', 'ABOGADO', 'C', 40, NULL, 4);
INSERT INTO `param_filtros` VALUES (172, 'notificaciones', 'SEGUIMIENTO', 'PRESENTADO', 'PRESENTADO', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (173, 'notificaciones', 'SEGUIMIENTO', 'PROVI_1', 'PROVIDENCIA 1', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (174, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_1', 'NOTIFICACION', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (175, 'notificaciones', 'SEGUIMIENTO', 'ADJ_AI', 'ADJUNTO A.I', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (176, 'notificaciones', 'SEGUIMIENTO', 'AI_NRO', 'NRO. A.I', 'C', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (177, 'notificaciones', 'SEGUIMIENTO', 'AI_FECHA', 'FECHA A.I', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (178, 'notificaciones', 'SEGUIMIENTO', 'INTIMACI_1', 'INTIMACION', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (179, 'notificaciones', 'SEGUIMIENTO', 'INTIMACI_2', 'INTIMACION 2', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (180, 'notificaciones', 'SEGUIMIENTO', 'CITACION', 'ADJ. CITACION', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (181, 'notificaciones', 'SEGUIMIENTO', 'PROVI_CITA', 'PROVIDENCIA CITACION', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (182, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_2', 'NOTIFICACION 2', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (183, 'notificaciones', 'SEGUIMIENTO', 'ADJ_SD', 'ADJUNTO SD', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (184, 'notificaciones', 'SEGUIMIENTO', 'SD_NRO', 'NRO. S.D', 'C', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (185, 'notificaciones', 'SEGUIMIENTO', 'SD_FECHA', 'FECHA S.D', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (186, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_3', 'NOTIFICACION 3', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (187, 'notificaciones', 'SEGUIMIENTO', 'ADJ_LIQUI', 'ADJ. LIQUIDACION', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (188, 'notificaciones', 'SEGUIMIENTO', 'LIQUIDACIO', 'MONTO LIQUIDACION', 'N', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (189, 'notificaciones', 'SEGUIMIENTO', 'PROVI_2', 'PROVIDENCIA 2', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (190, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_4', 'NOTIFI_4', NULL, 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (191, 'notificaciones', 'SEGUIMIENTO', 'ADJ_APROBA', 'ADJ. APROBACION', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (192, 'notificaciones', 'SEGUIMIENTO', 'APROBA_AI', 'APROBACION A.I', 'N', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (193, 'notificaciones', 'SEGUIMIENTO', 'APRO_FECHA', 'APROBACION FECHA', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (194, 'notificaciones', 'SEGUIMIENTO', 'APROB_IMPO', 'IMPORTE APROBACION', 'N', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (195, 'notificaciones', 'SEGUIMIENTO', 'SALDO_EXT', 'SALDO_EXT', NULL, NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (196, 'notificaciones', 'SEGUIMIENTO', 'ADJ_OFICIO', 'ADJUNTO OFICIO', 'F', 9, NULL, 2);
INSERT INTO `param_filtros` VALUES (197, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_5', 'NOTIFI_5', NULL, 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (198, 'notificaciones', 'SEGUIMIENTO', 'EMBARGO_N', 'EMBARGO_N', NULL, NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (199, 'notificaciones', 'SEGUIMIENTO', 'EMB_FECHA', 'EMB_FECHA', NULL, 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (200, 'notificaciones', 'SEGUIMIENTO', 'EMBAR_EJEC', 'EMBAR_EJEC', NULL, NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (201, 'notificaciones', 'SEGUIMIENTO', 'SD_FINIQUI', 'SD_FINIQUI', NULL, NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (202, 'notificaciones', 'SEGUIMIENTO', 'FEC_FINIQU', 'FEC_FINIQU', NULL, 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (203, 'notificaciones', 'SEGUIMIENTO', 'INIVISION', 'INIVISION', NULL, NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (204, 'notificaciones', 'SEGUIMIENTO', 'FEC_INIVI', 'FECHA INHIBICION', 'F', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (205, 'notificaciones', 'SEGUIMIENTO', 'ARREGLO_EX', 'ARREGLO_EX', NULL, 1, NULL, 2);
INSERT INTO `param_filtros` VALUES (206, 'notificaciones', 'SEGUIMIENTO', 'LEVANTA', 'LEVANTA', NULL, NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (207, 'notificaciones', 'SEGUIMIENTO', 'FEC_LEVANT', 'FEC_LEVANT', NULL, 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (208, 'notificaciones', 'SEGUIMIENTO', 'DEPOSITADO', 'DEPOSITADO', NULL, NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (209, 'notificaciones', 'SEGUIMIENTO', 'EXTRAIDO_C', 'EXTRAIDO_C', NULL, NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (210, 'notificaciones', 'SEGUIMIENTO', 'EXTRAIDO_L', 'EXTRAIDO_L', NULL, NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (211, 'notificaciones', 'SEGUIMIENTO', 'OTRA_INSTI', 'INSTITUCION EMBAR.LIQUID.', 'L', 30, NULL, 2);
INSERT INTO `param_filtros` VALUES (212, 'notificaciones', 'SEGUIMIENTO', 'EXCEPCION', 'EXCEPCION', NULL, 1, NULL, 2);
INSERT INTO `param_filtros` VALUES (213, 'notificaciones', 'SEGUIMIENTO', 'APELACION', 'APELACION', NULL, 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (214, 'notificaciones', 'SEGUIMIENTO', 'INCIDENTE', 'INCIDENTE', NULL, 1, NULL, 2);
INSERT INTO `param_filtros` VALUES (215, 'notificaciones', 'SEGUIMIENTO', 'ADJ_INHI_FEC', 'FECHA ADJ.INHIBICION', 'F', NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (216, 'notificaciones', 'SEGUIMIENTO', 'INHI_AI_FEC', 'FECHA INHIBICION A.I', 'F', NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (217, 'notificaciones', 'SEGUIMIENTO', 'INHI_NRO', 'NRO. INHIBICION', 'C', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (218, 'notificaciones', 'SEGUIMIENTO', 'SALDO_LIQUI', 'SALDO LIQUIDACION', 'N', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (219, 'notificaciones', 'SEGUIMIENTO', 'IMPORT_LIQUI', 'IMPORTE LIQUIDACION', 'N', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (220, 'notificaciones', 'SEGUIMIENTO', 'HONO_MAS_IVA', 'HONORARIO+IVA', 'N', 10, NULL, 2);
INSERT INTO `param_filtros` VALUES (221, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_LIQUI', 'NOTIFICACION LIQUIDAC.', 'F', NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (222, 'notificaciones', 'SEGUIMIENTO', 'CON_DEPOSITO', 'CON DEPOSITO', 'B', 1, NULL, 2);
INSERT INTO `param_filtros` VALUES (223, 'notificaciones', 'SEGUIMIENTO', 'OBSERVACION', 'OBSERVACION', 'C', 100, NULL, 2);
INSERT INTO `param_filtros` VALUES (224, 'notificaciones', 'SEGUIMIENTO', 'ADJ_INFO_FECHA', 'FECHA ADJ. INFORME AL REG.', 'F', NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (225, 'notificaciones', 'SEGUIMIENTO', 'INFO_AUTOMOTOR', 'INFORME AUTOMOTOR', 'C', 30, NULL, 2);
INSERT INTO `param_filtros` VALUES (226, 'notificaciones', 'SEGUIMIENTO', 'INFO_AUTOVEHIC', 'INFORME VEHICULO', 'C', 30, NULL, 2);
INSERT INTO `param_filtros` VALUES (227, 'notificaciones', 'SEGUIMIENTO', 'INFO_AUTOCHASI', 'INFORME CHASIS', 'C', 30, NULL, 2);
INSERT INTO `param_filtros` VALUES (228, 'notificaciones', 'SEGUIMIENTO', 'INFO_INMUEBLES', 'INFORME INMUEBLES', 'C', 30, NULL, 2);
INSERT INTO `param_filtros` VALUES (229, 'notificaciones', 'SEGUIMIENTO', 'INFO_INMUFINCA', 'INFORME FINCA', 'C', 30, NULL, 2);
INSERT INTO `param_filtros` VALUES (230, 'notificaciones', 'SEGUIMIENTO', 'INFO_INMUDISTRI', 'INFORME DISTRITO', 'C', 30, NULL, 2);
INSERT INTO `param_filtros` VALUES (231, 'notificaciones', 'SEGUIMIENTO', 'EMB_INMUEBLE', 'EMBARGO INMUEBLE', 'B', 1, NULL, 2);
INSERT INTO `param_filtros` VALUES (232, 'notificaciones', 'SEGUIMIENTO', 'EMB_VEHICULO', 'EMBARGO VEHICULO', 'B', 1, NULL, 2);
INSERT INTO `param_filtros` VALUES (233, 'notificaciones', 'SEGUIMIENTO', 'NOTIFI_HONOIVA', 'NOTIFICACION 4', 'F', NULL, NULL, 2);
INSERT INTO `param_filtros` VALUES (234, 'notificaciones', 'SEGUIMIENTO', 'INHI_AI_NRO', 'INHIBICION NRO. A.I.', 'C', 10, NULL, 2);

-- ----------------------------
-- Table structure for parametros
-- ----------------------------
DROP TABLE IF EXISTS `parametros`;
CREATE TABLE `parametros`  (
  `INTERES` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MORA` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IVA` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SEGURO` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `REDONDEO` int NULL DEFAULT NULL,
  `HONORARIOS` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PUNITORIO` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `GASTOSADMIN` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DIASVTO` int NULL DEFAULT NULL,
  `FACTURA` int NULL DEFAULT NULL,
  `RECIBO` int NULL DEFAULT NULL,
  `FECMIN` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FECMAX` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `EMAIL` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SHOW_COUNTERS` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `DEPOSITO_CTA_JUDICI` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parametros
-- ----------------------------

-- ----------------------------
-- Table structure for password_recovery
-- ----------------------------
DROP TABLE IF EXISTS `password_recovery`;
CREATE TABLE `password_recovery`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `USUARIO` int UNSIGNED NULL DEFAULT NULL,
  `TOKEN` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `EXPIRA` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_recovery
-- ----------------------------

-- ----------------------------
-- Table structure for recibo
-- ----------------------------
DROP TABLE IF EXISTS `recibo`;
CREATE TABLE `recibo`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `IMPORTE` int UNSIGNED NOT NULL DEFAULT 0,
  `DEUDOR` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `ARREGLO` int UNSIGNED NULL DEFAULT NULL,
  `CONCEPTO` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `FECHA_L` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of recibo
-- ----------------------------

-- ----------------------------
-- Table structure for relaciones_filtros
-- ----------------------------
DROP TABLE IF EXISTS `relaciones_filtros`;
CREATE TABLE `relaciones_filtros`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `TABLA` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `TABLA_REL` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CAMPO_REL` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of relaciones_filtros
-- ----------------------------
INSERT INTO `relaciones_filtros` VALUES (1, 'demandas2', 'notificaciones', 'IDNRO');
INSERT INTO `relaciones_filtros` VALUES (2, 'demandas2', 'inter_contraparte', 'IDNRO');
INSERT INTO `relaciones_filtros` VALUES (3, 'demandas2', 'arreglo_extrajudicial', 'IDNRO');
INSERT INTO `relaciones_filtros` VALUES (4, 'notificaciones', 'demandas2', 'IDNRO');
INSERT INTO `relaciones_filtros` VALUES (5, 'inter_contraparte', 'demandas2', 'IDNRO');
INSERT INTO `relaciones_filtros` VALUES (6, 'arreglo_extrajudicial', 'demandas2', 'IDNRO');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `IDNRO` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pass` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipo` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`IDNRO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

 
-- ----------------------------
-- Table structure for vtos
-- ----------------------------
DROP TABLE IF EXISTS `vtos`;
CREATE TABLE `vtos`  (
  `ID` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `IDNRO` int UNSIGNED NULL DEFAULT NULL,
  `FECHA` date NULL DEFAULT NULL,
  `FECHAV` date NULL DEFAULT NULL,
  `OBS` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `VENCIDO` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ABOGADO` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vtos
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
