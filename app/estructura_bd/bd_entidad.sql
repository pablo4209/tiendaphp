-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 25, 2018 at 10:00 PM
-- Server version: 10.3.8-MariaDB-1:10.3.8+maria~bionic-log
-- PHP Version: 7.2.7-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_entidad`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbcart`
--

CREATE TABLE `tbcart` (
  `idCart` int(11) NOT NULL,
  `idEntidad` int(11) NOT NULL DEFAULT 0,
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Fechamod` date DEFAULT NULL,
  `Horamod` time DEFAULT NULL,
  `ip` text CHARACTER SET utf8 DEFAULT NULL,
  `idEstado` int(11) NOT NULL DEFAULT 0,
  `idEstadoPago` int(11) NOT NULL DEFAULT 0,
  `idMoneda` int(11) NOT NULL DEFAULT 0,
  `CostoTotal` decimal(19,3) NOT NULL DEFAULT 0.000,
  `pDescuento` decimal(19,3) NOT NULL DEFAULT 0.000,
  `TotalIva` decimal(19,3) NOT NULL DEFAULT 0.000,
  `SubTotal` decimal(19,3) NOT NULL DEFAULT 0.000
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbcart_detalle`
--

CREATE TABLE `tbcart_detalle` (
  `idItem` int(11) NOT NULL,
  `idCart` int(11) NOT NULL DEFAULT 0,
  `idProducto` int(11) NOT NULL DEFAULT 0,
  `Cantidad` int(11) NOT NULL DEFAULT 0,
  `Serie` text CHARACTER SET utf8 NOT NULL,
  `Costo` decimal(19,3) NOT NULL DEFAULT 0.000,
  `pDescuento` decimal(19,3) NOT NULL DEFAULT 0.000,
  `Total` decimal(19,3) NOT NULL DEFAULT 0.000,
  `pIva` decimal(19,3) NOT NULL DEFAULT 0.000,
  `idDeposito` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbcategorias`
--

CREATE TABLE `tbcategorias` (
  `idCategoria` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `idPadre` int(11) DEFAULT 0,
  `FechaAlta` date DEFAULT NULL,
  `HoraAlta` time DEFAULT NULL,
  `ImgPath` varchar(255) DEFAULT NULL,
  `Iniciales` varchar(3) DEFAULT NULL,
  `Color` int(11) DEFAULT NULL,
  `Publicar` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbcategorias`
--

INSERT INTO `tbcategorias` (`idCategoria`, `Nombre`, `Descripcion`, `idPadre`, `FechaAlta`, `HoraAlta`, `ImgPath`, `Iniciales`, `Color`, `Publicar`) VALUES
(50, 'Cartuchos Toner', NULL, 55, '2012-05-14', NULL, '\\ACC', 'C01', -2147483643, 0),
(51, 'Recargas Inkjet', NULL, 55, '2012-05-14', NULL, '\\ACC', 'C02', -2147483643, 0),
(52, 'Recargas Toner', NULL, 55, '2012-05-14', NULL, '\\ACC', 'C03', -2147483643, 0),
(53, 'Reciclados Inkjet', NULL, 55, '2014-02-12', NULL, '\\ACC', 'REI', -2147483643, 0),
(54, 'Reciclados Toner', NULL, 55, '2014-02-12', NULL, '\\ACC', 'RET', -2147483643, 0),
(18, 'Cables', NULL, 57, '2010-04-13', NULL, '\\ACC', 'CAB', -2147483643, 0),
(19, 'Pilas y Cargadores', NULL, 58, '2010-04-13', NULL, '\\ACC', 'PYC', -2147483643, 0),
(20, 'Memorias & Pendrives', NULL, 56, '2010-04-13', NULL, '\\ACC', 'MYP', -2147483643, 0),
(21, 'Monitores', NULL, 56, '2010-04-13', NULL, '\\ACC', 'MON', -2147483643, 0),
(22, 'Auriculares & Microfonos', NULL, 56, '2010-04-13', NULL, '\\ACC', 'AYM', -2147483643, 0),
(23, 'Parlantes', NULL, 56, '2010-04-13', NULL, '\\ACC', 'PAR', -2147483643, 0),
(71, 'Accesorios', '', 67, '2017-02-05', '01:11:44', 'PS4/', 'P4A', -2147483643, 1),
(25, 'Memorias RAM', NULL, 56, '2010-04-13', NULL, '\\ACC', 'RAM', -2147483643, 0),
(26, 'Impresoras Inkjet', NULL, 55, '2010-04-13', NULL, '\\ACC', 'IMI', -2147483643, 0),
(27, 'Impresoras Multifuncion', NULL, 55, '2010-04-13', NULL, '\\ACC', 'IMM', -2147483643, 0),
(28, 'Impresoras Laser', NULL, 55, '2010-04-13', NULL, '\\ACC', 'IML', -2147483643, 0),
(29, 'Impresoras Matriciales', NULL, 55, '2010-04-13', NULL, '\\ACC', 'IMX', -2147483643, 0),
(30, 'Discos Rigidos', NULL, 56, '2010-04-13', NULL, '\\ACC', 'HDD', -2147483643, 0),
(31, 'Grabadoras DVD', NULL, 56, '2010-04-13', NULL, '\\ACC', 'GRB', -2147483643, 0),
(32, 'Gabinetes', NULL, 56, '2010-04-13', NULL, '\\ACC', 'GBT', -2147483643, 0),
(33, 'MotherBoards', NULL, 56, '2010-04-13', NULL, '\\ACC', 'MBD', -2147483643, 0),
(34, 'Microprocesadores', NULL, 56, '2010-04-13', NULL, '\\ACC', 'CPU', -2147483643, 0),
(35, 'Placas de Video & Sintonizadoras', NULL, 56, '2010-04-13', NULL, '\\ACC', 'PLV', -2147483643, 0),
(36, 'Fuentes & Estabilizadores', NULL, 56, '2010-04-13', NULL, '\\ACC', 'FYE', -2147483643, 0),
(37, 'Hardware', NULL, 56, '2010-04-13', NULL, 'ACC/', 'HWR', -2147483643, 1),
(38, 'Conectividad', NULL, 56, '2010-04-13', NULL, '\\ACC', 'CTV', -2147483643, 0),
(70, 'Juegos', '', 67, '2017-02-05', '01:11:17', 'PS4/', 'PS4', -2147483643, 1),
(40, 'Webcam', '', 62, '2010-04-13', NULL, '\\ACC', 'CAM', -2147483643, 0),
(42, 'Playstation 3', '', 59, '2010-04-14', NULL, 'PS3/', 'PS3', 255, 1),
(17, 'Papel Fotografico', NULL, 55, '2010-04-13', NULL, '\\ACC', 'PPF', -2147483643, 0),
(15, 'Insumos Varios', NULL, 57, '2010-04-13', NULL, '\\ACC', 'INS', -2147483643, 0),
(16, 'Papel en Resmas', NULL, 55, '2010-04-12', NULL, '\\ACC', 'PPL', -2147483643, 0),
(9, 'Mouse & Teclados', NULL, 56, '2010-04-09', NULL, '\\ACC', 'MOU', -2147483643, 0),
(10, 'Cartuchos Inkjet', NULL, 55, '2010-04-09', NULL, '\\ACC', 'CAR', -2147483643, 0),
(11, 'CDs', NULL, 57, '2010-04-12', NULL, '\\ACC', 'CDS', -2147483643, 0),
(12, 'DVDs', NULL, 57, '2010-04-12', NULL, '\\ACC', 'DVD', -2147483643, 0),
(13, 'Diskette', NULL, 57, '2010-04-12', NULL, '\\ACC', 'DKT', -2147483643, 0),
(14, 'Cajas CD/DVD', NULL, 57, '2010-04-12', NULL, '\\ACC', 'BOX', -2147483643, 0),
(1, 'Playstation 2', '', 59, '2010-04-02', NULL, 'PS2/', 'PS2', 65535, 1),
(2, 'XBOX 360', '', 59, '2010-04-02', NULL, 'XBOX360/', '360', 65280, 1),
(3, 'WII', NULL, 59, '2010-04-02', NULL, '\\WII', 'WII', 16776960, 0),
(4, 'PC', NULL, 59, '2010-04-02', NULL, '\\PC', 'PCG', 33023, 0),
(43, 'Notebooks', NULL, 60, '2010-05-07', NULL, '\\ACC', 'NBK', -2147483643, 0),
(44, 'Notebooks Accesorios', NULL, 60, '2010-05-07', NULL, '\\ACC', 'NAC', -2147483643, 0),
(45, 'Reproductores de Audio', NULL, 58, '2010-06-04', NULL, '\\ACC', 'R45', -2147483643, 0),
(46, 'Original', '', 2, '2011-02-01', NULL, 'XBOX360/', 'XBO', 16770000, 0),
(48, 'Servicio Tecnico', '', 0, '2011-06-15', NULL, '\\ACC', 'SRV', -2147483643, 0),
(72, 'Juegos', '', 2, '2017-02-05', '01:13:21', 'XBOX360/', '360', -2147483643, 1),
(55, 'Impresión', '', 0, '2010-04-13', NULL, '', 'IMP', 5, 0),
(56, 'Informatica', '', 0, '2010-04-09', NULL, '', 'INF', 2, 0),
(57, 'Insumos', '', 0, '2010-04-09', NULL, '', 'INS', 3, 0),
(58, 'Electronica', '', 0, '2010-04-12', NULL, '', 'ETR', 4, 0),
(59, 'Plataforma', '', 0, '2010-04-02', NULL, '', 'VDJ', 1, 1),
(60, 'NoteBooks', NULL, 0, '2010-05-07', NULL, NULL, 'NBK', 6, 0),
(61, 'Genero', '', 0, '2017-01-08', '14:04:55', 'GEN/', 'GEN', 0, 1),
(62, 'Accion', '', 61, '2017-01-08', '14:05:40', '', '', -2147483643, 1),
(63, 'Shooter', '', 61, '2017-01-08', '14:06:01', '', '', -2147483643, 1),
(64, 'Aventura', '', 61, '2017-01-08', '14:06:09', '', '', -2147483643, 0),
(65, 'Deportes', '', 61, '2017-01-08', '14:06:14', '', '', -2147483643, 0),
(66, 'Rol', '', 61, '2017-01-08', '14:06:25', '', '', -2147483643, 0),
(67, 'Playstation 4', 'PS4', 59, '2017-01-21', '19:43:22', 'PS4/', 'PS4', -2147483643, 1),
(68, 'Accesorios', '', 42, '2017-02-03', '23:58:03', 'PS3/', 'P3A', -2147483643, 1),
(69, 'Juegos', '', 42, '2017-02-03', '23:58:45', 'PS3/', 'P3J', -2147483643, 1),
(73, 'Accesorios', '', 2, '2017-02-05', '01:13:52', 'XBOX360/', 'XBA', -2147483643, 1),
(74, 'Coleccion', '', 0, '2017-12-05', '00:27:10', '', 'COL', -2147483643, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbcondicionfiscal`
--

CREATE TABLE `tbcondicionfiscal` (
  `idCondFiscal` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Pordefecto` int(11) DEFAULT 0,
  `idTipoDoc` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbdep`
--

CREATE TABLE `tbdep` (
  `idDeposito` int(11) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Dom` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `Cp` varchar(10) DEFAULT NULL,
  `Loc` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `Prov` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `Tel` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Observaciones` mediumtext CHARACTER SET utf8 DEFAULT NULL,
  `FechaAlta` date DEFAULT NULL,
  `HoraAlta` time DEFAULT NULL,
  `idSucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbdep_mov`
--

CREATE TABLE `tbdep_mov` (
  `idMov` int(11) NOT NULL,
  `idDoc` int(11) DEFAULT 0,
  `idProducto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL DEFAULT 1,
  `idDeposito` int(11) DEFAULT 0,
  `FechaLog` date DEFAULT NULL,
  `HoraLog` time DEFAULT NULL,
  `Consolidado` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbdoc`
--

CREATE TABLE `tbdoc` (
  `idDoc` int(11) NOT NULL,
  `idOrden` int(11) DEFAULT 0,
  `idTipoDoc` int(11) DEFAULT 0,
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Fechamod` date DEFAULT NULL,
  `HoraMod` int(11) DEFAULT NULL,
  `idDeposito` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idEntidad` int(11) DEFAULT NULL,
  `idLista` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT 0,
  `idCondPago` int(11) DEFAULT 0,
  `CliNom` varchar(120) DEFAULT NULL,
  `CliDom` varchar(120) DEFAULT NULL,
  `CliLoc` varchar(100) DEFAULT NULL,
  `CliCp` varchar(10) DEFAULT NULL,
  `CliProv` varchar(40) DEFAULT NULL,
  `CliCuit` varchar(20) DEFAULT NULL,
  `CliTel` varchar(30) DEFAULT NULL,
  `CliMail` varchar(100) DEFAULT NULL,
  `idCondfiscal` int(11) DEFAULT NULL,
  `CostoTotal` decimal(19,3) DEFAULT NULL,
  `pDescuento` decimal(19,3) DEFAULT 0.000,
  `pRecargo` decimal(19,3) DEFAULT 0.000,
  `TotalIva` decimal(19,3) DEFAULT 0.000,
  `SubTotal` decimal(19,3) DEFAULT 0.000,
  `Total` decimal(19,3) DEFAULT 0.000,
  `idMoneda` int(11) DEFAULT 1,
  `MailNotificaciones` int(11) DEFAULT 0,
  `Observacion` varchar(200) DEFAULT NULL,
  `ObsPrivada` varchar(200) DEFAULT NULL,
  `PtoVenta` int(11) DEFAULT 0,
  `Unidades` int(11) DEFAULT 0,
  `Items` int(11) DEFAULT 0,
  `AfectarVendidas` int(11) DEFAULT 0,
  `AfectarStock` int(11) DEFAULT 0,
  `Entregado` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbdoc_condpago`
--

CREATE TABLE `tbdoc_condpago` (
  `idCondpago` int(11) NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL,
  `Efectivo` int(11) DEFAULT 0,
  `Electronico` int(11) DEFAULT 0,
  `Pordefecto` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbdoc_detalle`
--

CREATE TABLE `tbdoc_detalle` (
  `idContador` int(11) NOT NULL,
  `idDoc` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `Codigo` varchar(20) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Serie` varchar(30) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT 0,
  `pDescuento` decimal(19,3) DEFAULT NULL,
  `Precio` decimal(19,3) DEFAULT 0.000,
  `Total` decimal(19,3) DEFAULT 0.000,
  `pIva` decimal(19,3) DEFAULT 0.000,
  `Costo` decimal(19,3) DEFAULT 0.000,
  `idDeposito` int(11) DEFAULT 0,
  `Promociones` int(11) DEFAULT 0,
  `idCategoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbdoc_estado`
--

CREATE TABLE `tbdoc_estado` (
  `idEstado` int(11) NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbdoc_tipo`
--

CREATE TABLE `tbdoc_tipo` (
  `idTipoDoc` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Letra` varchar(5) DEFAULT NULL,
  `AfectaStock` int(11) DEFAULT 0,
  `AfectaVendidas` int(11) DEFAULT 0,
  `Stockresta` int(11) DEFAULT 0,
  `Color` int(11) DEFAULT 0,
  `Activo` int(11) DEFAULT 1,
  `DesglozarIva` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbdoc_tipo`
--

INSERT INTO `tbdoc_tipo` (`idTipoDoc`, `Nombre`, `Letra`, `AfectaStock`, `AfectaVendidas`, `Stockresta`, `Color`, `Activo`, `DesglozarIva`) VALUES
(1, 'Uso Interno', 'X', 1, 1, 0, 16777215, 1, 0),
(2, 'Presupuesto', 'P', 0, 0, 0, 33023, 1, 0),
(3, 'Factura', 'C', 1, 1, 0, 255, 1, 0),
(4, 'Nota de Credito', 'S', 1, 1, 1, 16776960, 1, 0),
(5, 'Nota de Pedido', 'N', 0, 0, 0, 0, 1, 0),
(6, 'Ingreso de mercaderias por Proveedor', 'Q', 1, 0, 1, 0, 1, 0),
(7, 'Factura B', 'B', 1, 1, 0, 65280, 0, 0),
(8, 'Factura A', 'A', 1, 1, 0, 16776960, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbentidad`
--

CREATE TABLE `tbentidad` (
  `idEntidad` int(11) NOT NULL,
  `idEntidadTipo` int(11) DEFAULT 0,
  `Nombre` varchar(120) DEFAULT NULL,
  `Razonsocial` varchar(120) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Dom` varchar(120) DEFAULT NULL,
  `Domentrega` varchar(120) DEFAULT NULL,
  `Loc` varchar(50) DEFAULT NULL,
  `Cp` varchar(10) DEFAULT NULL,
  `Prov` varchar(40) DEFAULT NULL,
  `Cuit` varchar(30) DEFAULT NULL,
  `Dni` varchar(20) DEFAULT NULL,
  `Tel` varchar(50) DEFAULT NULL,
  `Tel2` varchar(50) DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `Sexo` varchar(1) DEFAULT NULL,
  `idCondFiscal` int(11) DEFAULT 0,
  `FechaAlta` date DEFAULT NULL,
  `HoraAlta` time DEFAULT NULL,
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  `Estado` int(11) DEFAULT 1,
  `Observaciones` text DEFAULT NULL,
  `AvisoEmergente` varchar(200) DEFAULT NULL,
  `Foto` varchar(255) DEFAULT NULL,
  `Website` varchar(150) DEFAULT NULL,
  `idMoneda` int(11) DEFAULT 0,
  `Login` varchar(100) DEFAULT NULL,
  `Pass` varchar(50) DEFAULT NULL,
  `KeyReg` varchar(120) DEFAULT NULL COMMENT 'es el codigo de verificacion utilizado durante un lost pass o activacion de usuario',
  `NewPass` varchar(50) DEFAULT NULL COMMENT 'se utiliza para retener la contraseña nueva durante un lostpass',
  `idNivelAcceso` int(11) DEFAULT 0,
  `ip` varchar(20) DEFAULT NULL COMMENT 'se registra ip donde se produjo el ultimo logueo',
  `FechaLog` date DEFAULT NULL COMMENT 'registro de inicio de sesion',
  `HoraLog` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbentidad`
--

INSERT INTO `tbentidad` (`idEntidad`, `idEntidadTipo`, `Nombre`, `Razonsocial`, `Email`, `Dom`, `Domentrega`, `Loc`, `Cp`, `Prov`, `Cuit`, `Dni`, `Tel`, `Tel2`, `FechaNacimiento`, `Sexo`, `idCondFiscal`, `FechaAlta`, `HoraAlta`, `FechaMod`, `HoraMod`, `Estado`, `Observaciones`, `AvisoEmergente`, `Foto`, `Website`, `idMoneda`, `Login`, `Pass`, `KeyReg`, `NewPass`, `idNivelAcceso`, `ip`, `FechaLog`, `HoraLog`) VALUES
(1, 1, 'Pablo', NULL, 'pablo4209m@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 'pablo', '65402f90ef3ceb04c9a50fe3b5aa895d', NULL, NULL, 4, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbentidad_marcas`
--

CREATE TABLE `tbentidad_marcas` (
  `contador` int(11) NOT NULL,
  `idEntidad` int(11) NOT NULL,
  `idMarca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbentidad_nivel`
--

CREATE TABLE `tbentidad_nivel` (
  `idNivelAcceso` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Nivel` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbentidad_nivel`
--

INSERT INTO `tbentidad_nivel` (`idNivelAcceso`, `Nombre`, `Descripcion`, `Nivel`) VALUES
(1, 'Nivel 1', 'acceso con permisos de cliente/proveedor', 1),
(2, 'Nivel 2', 'Acceso con nivel de operador', 5),
(3, 'Nivel 3 (Admin)', 'Acceso nivel administrador', 50),
(4, 'Nivel 4 (debug)', 'Acceso nivel desarrollador', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tbentidad_tipo`
--

CREATE TABLE `tbentidad_tipo` (
  `idEntidadTipo` int(11) NOT NULL,
  `Nombre` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbentidad_tipo`
--

INSERT INTO `tbentidad_tipo` (`idEntidadTipo`, `Nombre`) VALUES
(1, 'Usuario'),
(2, 'Proveedor'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Table structure for table `tbficha`
--

CREATE TABLE `tbficha` (
  `idFicha` int(11) NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL,
  `Descripcioncorta` varchar(25) DEFAULT NULL,
  `idPadre` int(11) DEFAULT 0,
  `FechaAlta` datetime DEFAULT NULL,
  `FechaMod` datetime DEFAULT NULL,
  `Publicar` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblistas`
--

CREATE TABLE `tblistas` (
  `idLista` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Ivaincl` int(11) DEFAULT 1,
  `Margen` decimal(19,3) DEFAULT 0.000,
  `Habilitada` int(11) DEFAULT 1,
  `NivelAcceso` int(11) DEFAULT 0,
  `Pordefecto` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblistas`
--

INSERT INTO `tblistas` (`idLista`, `Nombre`, `Descripcion`, `Ivaincl`, `Margen`, `Habilitada`, `NivelAcceso`, `Pordefecto`) VALUES
(1, 'Lista 1', 'Lista 1', 1, '50.000', 1, 0, 1),
(2, 'Lista 2', 'Lista 2', 1, '35.000', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbmarcas`
--

CREATE TABLE `tbmarcas` (
  `idMarca` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(120) DEFAULT NULL,
  `Habilitada` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbmoneda`
--

CREATE TABLE `tbmoneda` (
  `idMoneda` int(11) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Cambio` decimal(19,3) DEFAULT 0.000,
  `Simbolo` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `FechaAlta` date DEFAULT NULL,
  `HoraAlta` time DEFAULT NULL,
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  `idEntidad` int(11) DEFAULT NULL,
  `Habilitada` int(11) DEFAULT 1,
  `Principal` int(11) DEFAULT 0,
  `Web` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbmoneda`
--

INSERT INTO `tbmoneda` (`idMoneda`, `Nombre`, `Cambio`, `Simbolo`, `FechaAlta`, `HoraAlta`, `FechaMod`, `HoraMod`, `idEntidad`, `Habilitada`, `Principal`, `Web`) VALUES
(1, 'Peso(s)', '1.000', '$', '2011-02-09', NULL, '2017-12-28', '08:35:12', NULL, 1, 1, 0),
(2, 'Dólar(es)', '28.850', 'U$$', '2011-02-09', NULL, '2017-12-28', '09:09:28', NULL, 1, 0, 0),
(3, 'Dolar2', '19.990', 'UU', '2013-10-18', NULL, '2017-12-28', '09:20:04', NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbpagos`
--

CREATE TABLE `tbpagos` (
  `idPago` int(11) NOT NULL,
  `idOrden` int(11) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Pago` decimal(19,3) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Consolidado` int(11) DEFAULT 0,
  `idTarjeta` int(11) DEFAULT NULL,
  `idPlan` int(11) DEFAULT NULL,
  `Cupon` int(11) DEFAULT NULL,
  `Lote` int(11) DEFAULT NULL,
  `Transferencia` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbpro`
--

CREATE TABLE `tbpro` (
  `idProducto` int(11) NOT NULL,
  `Codigo` varchar(20) DEFAULT NULL,
  `Nombre` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `SEO` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `FechaIngreso` date DEFAULT NULL,
  `HoraIngreso` time DEFAULT NULL,
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  `FechaUltVenta` date DEFAULT NULL,
  `HoraUltVenta` time DEFAULT NULL,
  `idMoneda` int(11) DEFAULT NULL,
  `Costo` decimal(19,3) DEFAULT 0.000,
  `UnidxDef` int(11) NOT NULL DEFAULT 1,
  `MaxDescuento` decimal(19,3) DEFAULT 0.000,
  `pDescuento` decimal(19,3) DEFAULT 0.000,
  `Vendidas` int(11) DEFAULT 0,
  `Imagen` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `CodBar` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `CodBar2` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `idMarca` int(11) DEFAULT NULL,
  `idPadre` int(11) DEFAULT 0 COMMENT 'si !=0 hay que mirar PrecioPropio, util para manejar talles, colores y demas',
  `idTipo` int(11) DEFAULT 0,
  `idIva` int(11) DEFAULT 0,
  `Garantia` int(11) DEFAULT 0,
  `Descripcion` longtext CHARACTER SET utf8 DEFAULT NULL,
  `Nota` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `NotaEmerg` int(11) DEFAULT 0,
  `Publicar` int(11) DEFAULT 0,
  `Destacado` int(11) DEFAULT 0,
  `Marcado` int(11) DEFAULT 0,
  `Usado` int(11) DEFAULT 0,
  `Reparable` int(11) DEFAULT 0,
  `VenderSinStock` int(11) DEFAULT 1,
  `Promociones` int(11) DEFAULT 1,
  `Habilitado` int(11) DEFAULT 1,
  `ImponerPrecio` int(11) DEFAULT 0 COMMENT 'para uso en subproducto, cuando idPadre !=0',
  `ImponerStock` int(11) DEFAULT 0 COMMENT 'es util cuando los talles o colores solo son a modo informativo para armar el pedido, el stock es unico',
  `Compuesto` int(11) DEFAULT 0 COMMENT 'si compuesto =1 todos los hijos forman el costo del padre'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbpro_categorias`
--

CREATE TABLE `tbpro_categorias` (
  `Contador` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `Principal` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbpro_ficha`
--

CREATE TABLE `tbpro_ficha` (
  `id` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idFicha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbpro_iva`
--

CREATE TABLE `tbpro_iva` (
  `idIva` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Porcentaje` decimal(19,3) DEFAULT 0.000,
  `Pordefecto` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbpro_iva`
--

INSERT INTO `tbpro_iva` (`idIva`, `Nombre`, `Descripcion`, `Porcentaje`, `Pordefecto`) VALUES
(1, '21%', '21%', '21.000', 1),
(2, '10,5%', '10,5%', '10.500', 0),
(3, 'Sin asignar', 'Sin asignar', '0.000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbpro_juegos`
--

CREATE TABLE `tbpro_juegos` (
  `Contador` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `Idioma` int(11) DEFAULT NULL,
  `Camara` int(11) DEFAULT NULL,
  `CantJugadores` int(11) DEFAULT 0,
  `Ano` int(11) DEFAULT 0,
  `Norma_Region` int(11) DEFAULT NULL,
  `SelectFreq` int(11) DEFAULT 0,
  `SelectIdioma` int(11) DEFAULT 0,
  `Red` int(11) DEFAULT 0,
  `Accesorio` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `LinkWeb` longtext CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbpro_precios`
--

CREATE TABLE `tbpro_precios` (
  `Contador` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL DEFAULT 0,
  `Margen` decimal(19,3) DEFAULT 0.000,
  `idLista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbpro_promo`
--

CREATE TABLE `tbpro_promo` (
  `idPromo` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `Cantidad` int(11) DEFAULT 0,
  `AfectaTodos` int(11) DEFAULT 1,
  `pDescuento` decimal(19,3) DEFAULT 0.000,
  `Fecha` datetime DEFAULT NULL,
  `Activa` int(11) DEFAULT 1,
  `idLista` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbpro_series`
--

CREATE TABLE `tbpro_series` (
  `Contador` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `idDoc` int(11) DEFAULT NULL,
  `Serie` varchar(30) DEFAULT NULL,
  `Activo` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbpro_stock`
--

CREATE TABLE `tbpro_stock` (
  `Contador` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT 0,
  `idDeposito` int(11) DEFAULT 0,
  `Stock_consolidado` int(11) DEFAULT 0 COMMENT 'informa el stock calculado hasta Fecha_consolidado, hora_consolidado',
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  `StockMin` int(11) DEFAULT 0,
  `StockMax` int(11) DEFAULT 0,
  `Fecha_consolidado` date DEFAULT NULL COMMENT 'indica el ultimo punto hasta el que se calculo el stock para el producto en la lista indicada',
  `Hora_consolidado` time DEFAULT NULL COMMENT 'indica el ultimo punto hasta el que se calculo el stock para el producto en la lista indicada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbpro_tipo`
--

CREATE TABLE `tbpro_tipo` (
  `idTipo` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Stock` int(11) DEFAULT 0,
  `Juego` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbpro_tipo`
--

INSERT INTO `tbpro_tipo` (`idTipo`, `Descripcion`, `Stock`, `Juego`) VALUES
(1, 'GENERAL', 1, 0),
(2, 'JUEGO', 1, 1),
(3, 'SERVICIO', 0, 0),
(4, 'TALLER', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbrep`
--

CREATE TABLE `tbrep` (
  `idRep` int(11) NOT NULL,
  `idEquipo` int(11) DEFAULT NULL,
  `idEntidad` int(11) DEFAULT NULL,
  `idLista` int(11) DEFAULT NULL,
  `Razonsocial` varchar(120) DEFAULT NULL,
  `Nombre` varchar(120) DEFAULT NULL,
  `Dom` varchar(120) DEFAULT NULL,
  `Tel` varchar(50) DEFAULT NULL,
  `Tel2` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Horariocontacto` varchar(120) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Fechaingreso` date DEFAULT NULL,
  `Horaingreso` time DEFAULT NULL,
  `Fechaentrega` date DEFAULT NULL,
  `Horaentrega` time DEFAULT NULL,
  `Falladeclarada` varchar(400) DEFAULT NULL,
  `Observaciones` varchar(600) DEFAULT NULL,
  `Observacionespriv` varchar(600) DEFAULT NULL,
  `Accesorios` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbrep_detalle`
--

CREATE TABLE `tbrep_detalle` (
  `Contador` int(11) NOT NULL,
  `idRep` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `Codigo` varchar(20) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Serie` varchar(100) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `pDescuento` decimal(19,3) DEFAULT NULL,
  `Precio` decimal(19,3) DEFAULT NULL,
  `Total` decimal(19,3) DEFAULT NULL,
  `pIva` decimal(19,3) DEFAULT NULL,
  `Costo` decimal(19,3) DEFAULT NULL,
  `idDeposito` int(11) DEFAULT NULL,
  `Promociones` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbrep_equipos`
--

CREATE TABLE `tbrep_equipos` (
  `idEquipo` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `Serie` varchar(100) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `FechaIngreso` date DEFAULT NULL,
  `Horaingreso` time DEFAULT NULL,
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbrep_estados`
--

CREATE TABLE `tbrep_estados` (
  `idEstado` int(11) NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbrep_eventos`
--

CREATE TABLE `tbrep_eventos` (
  `Contador` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  `Descripcion` varchar(400) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Notificado` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbsucursal`
--

CREATE TABLE `tbsucursal` (
  `idSucursal` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Direccion` varchar(150) DEFAULT NULL,
  `Telefono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbcart`
--
ALTER TABLE `tbcart`
  ADD PRIMARY KEY (`idCart`),
  ADD KEY `idMoneda_idx` (`idMoneda`),
  ADD KEY `idEntidad_idx` (`idEntidad`);

--
-- Indexes for table `tbcart_detalle`
--
ALTER TABLE `tbcart_detalle`
  ADD PRIMARY KEY (`idItem`),
  ADD KEY `idCart_idx` (`idCart`),
  ADD KEY `idProducto_idx` (`idProducto`),
  ADD KEY `idDeposito_idx` (`idDeposito`);

--
-- Indexes for table `tbcategorias`
--
ALTER TABLE `tbcategorias`
  ADD PRIMARY KEY (`idCategoria`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indexes for table `tbcondicionfiscal`
--
ALTER TABLE `tbcondicionfiscal`
  ADD PRIMARY KEY (`idCondFiscal`),
  ADD KEY `Id` (`idCondFiscal`);

--
-- Indexes for table `tbdep`
--
ALTER TABLE `tbdep`
  ADD PRIMARY KEY (`idDeposito`),
  ADD KEY `idSucursal_idx` (`idSucursal`);

--
-- Indexes for table `tbdep_mov`
--
ALTER TABLE `tbdep_mov`
  ADD PRIMARY KEY (`idMov`),
  ADD KEY `idProducto_idx` (`idProducto`),
  ADD KEY `idDoc_idx` (`idDoc`),
  ADD KEY `idDeposito_idx` (`idDeposito`);

--
-- Indexes for table `tbdoc`
--
ALTER TABLE `tbdoc`
  ADD PRIMARY KEY (`idDoc`),
  ADD KEY `idTipoDoc_idx` (`idTipoDoc`),
  ADD KEY `idDeposito_idx` (`idDeposito`),
  ADD KEY `idLista_idx` (`idLista`),
  ADD KEY `idCondFiscal_idx` (`idCondfiscal`),
  ADD KEY `idMoneda_idx` (`idMoneda`),
  ADD KEY `idEstado_idx` (`idEstado`),
  ADD KEY `idCondPago_idx` (`idCondPago`),
  ADD KEY `idEntidad_idx1` (`idEntidad`),
  ADD KEY `fk2_idEntidad_idx` (`idUsuario`);

--
-- Indexes for table `tbdoc_condpago`
--
ALTER TABLE `tbdoc_condpago`
  ADD PRIMARY KEY (`idCondpago`);

--
-- Indexes for table `tbdoc_detalle`
--
ALTER TABLE `tbdoc_detalle`
  ADD PRIMARY KEY (`idContador`),
  ADD KEY `idDoc_idx` (`idDoc`),
  ADD KEY `idProducto_idx` (`idProducto`);

--
-- Indexes for table `tbdoc_estado`
--
ALTER TABLE `tbdoc_estado`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indexes for table `tbdoc_tipo`
--
ALTER TABLE `tbdoc_tipo`
  ADD PRIMARY KEY (`idTipoDoc`);

--
-- Indexes for table `tbentidad`
--
ALTER TABLE `tbentidad`
  ADD PRIMARY KEY (`idEntidad`),
  ADD KEY `idEntidadTipo_idx` (`idEntidadTipo`),
  ADD KEY `idNivelAcceso_idx` (`idNivelAcceso`);

--
-- Indexes for table `tbentidad_marcas`
--
ALTER TABLE `tbentidad_marcas`
  ADD PRIMARY KEY (`contador`),
  ADD KEY `idMarca_idx` (`idMarca`),
  ADD KEY `idEntidad_idx` (`idEntidad`);

--
-- Indexes for table `tbentidad_nivel`
--
ALTER TABLE `tbentidad_nivel`
  ADD PRIMARY KEY (`idNivelAcceso`);

--
-- Indexes for table `tbentidad_tipo`
--
ALTER TABLE `tbentidad_tipo`
  ADD PRIMARY KEY (`idEntidadTipo`);

--
-- Indexes for table `tbficha`
--
ALTER TABLE `tbficha`
  ADD PRIMARY KEY (`idFicha`);

--
-- Indexes for table `tblistas`
--
ALTER TABLE `tblistas`
  ADD PRIMARY KEY (`idLista`),
  ADD KEY `Codigo` (`idLista`);

--
-- Indexes for table `tbmarcas`
--
ALTER TABLE `tbmarcas`
  ADD PRIMARY KEY (`idMarca`);

--
-- Indexes for table `tbmoneda`
--
ALTER TABLE `tbmoneda`
  ADD PRIMARY KEY (`idMoneda`),
  ADD KEY `idEntidad_idx` (`idEntidad`);

--
-- Indexes for table `tbpagos`
--
ALTER TABLE `tbpagos`
  ADD PRIMARY KEY (`idPago`);

--
-- Indexes for table `tbpro`
--
ALTER TABLE `tbpro`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idProducto` (`idProducto`),
  ADD KEY `idIva_idx` (`idIva`),
  ADD KEY `idMarca_idx` (`idMarca`),
  ADD KEY `idTipo_idx` (`idTipo`),
  ADD KEY `idMoneda_idx` (`idMoneda`);

--
-- Indexes for table `tbpro_categorias`
--
ALTER TABLE `tbpro_categorias`
  ADD PRIMARY KEY (`Contador`),
  ADD KEY `idProducto_idx` (`idProducto`),
  ADD KEY `idCategoria_idx` (`idCategoria`);

--
-- Indexes for table `tbpro_ficha`
--
ALTER TABLE `tbpro_ficha`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idFicha_idx` (`idFicha`),
  ADD KEY `idProducto_idx` (`idProducto`);

--
-- Indexes for table `tbpro_iva`
--
ALTER TABLE `tbpro_iva`
  ADD PRIMARY KEY (`idIva`),
  ADD KEY `IdIva` (`idIva`);

--
-- Indexes for table `tbpro_juegos`
--
ALTER TABLE `tbpro_juegos`
  ADD PRIMARY KEY (`Contador`);

--
-- Indexes for table `tbpro_precios`
--
ALTER TABLE `tbpro_precios`
  ADD PRIMARY KEY (`Contador`),
  ADD KEY `idProducto_idx` (`idProducto`),
  ADD KEY `idLista_idx` (`idLista`);

--
-- Indexes for table `tbpro_promo`
--
ALTER TABLE `tbpro_promo`
  ADD PRIMARY KEY (`idPromo`);

--
-- Indexes for table `tbpro_series`
--
ALTER TABLE `tbpro_series`
  ADD PRIMARY KEY (`Contador`),
  ADD KEY `idProducto_idx` (`idProducto`),
  ADD KEY `idDoc_idx` (`idDoc`);

--
-- Indexes for table `tbpro_stock`
--
ALTER TABLE `tbpro_stock`
  ADD PRIMARY KEY (`Contador`),
  ADD KEY `idProducto_idx` (`idProducto`),
  ADD KEY `idDeposito_idx` (`idDeposito`);

--
-- Indexes for table `tbpro_tipo`
--
ALTER TABLE `tbpro_tipo`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indexes for table `tbrep`
--
ALTER TABLE `tbrep`
  ADD PRIMARY KEY (`idRep`),
  ADD KEY `idEquipo_idx` (`idEquipo`),
  ADD KEY `idLista_idx` (`idLista`),
  ADD KEY `idEstado_idx` (`idEstado`),
  ADD KEY `idEntidad_idx` (`idEntidad`);

--
-- Indexes for table `tbrep_detalle`
--
ALTER TABLE `tbrep_detalle`
  ADD PRIMARY KEY (`Contador`);

--
-- Indexes for table `tbrep_equipos`
--
ALTER TABLE `tbrep_equipos`
  ADD PRIMARY KEY (`idEquipo`),
  ADD KEY `idProducto_idx` (`idProducto`);

--
-- Indexes for table `tbrep_estados`
--
ALTER TABLE `tbrep_estados`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indexes for table `tbrep_eventos`
--
ALTER TABLE `tbrep_eventos`
  ADD PRIMARY KEY (`Contador`);

--
-- Indexes for table `tbsucursal`
--
ALTER TABLE `tbsucursal`
  ADD PRIMARY KEY (`idSucursal`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbcart`
--
ALTER TABLE `tbcart`
  MODIFY `idCart` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbcart_detalle`
--
ALTER TABLE `tbcart_detalle`
  MODIFY `idItem` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbcategorias`
--
ALTER TABLE `tbcategorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `tbcondicionfiscal`
--
ALTER TABLE `tbcondicionfiscal`
  MODIFY `idCondFiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbdep`
--
ALTER TABLE `tbdep`
  MODIFY `idDeposito` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbdep_mov`
--
ALTER TABLE `tbdep_mov`
  MODIFY `idMov` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbdoc`
--
ALTER TABLE `tbdoc`
  MODIFY `idDoc` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbdoc_condpago`
--
ALTER TABLE `tbdoc_condpago`
  MODIFY `idCondpago` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbdoc_detalle`
--
ALTER TABLE `tbdoc_detalle`
  MODIFY `idContador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbdoc_estado`
--
ALTER TABLE `tbdoc_estado`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbdoc_tipo`
--
ALTER TABLE `tbdoc_tipo`
  MODIFY `idTipoDoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbentidad`
--
ALTER TABLE `tbentidad`
  MODIFY `idEntidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbentidad_marcas`
--
ALTER TABLE `tbentidad_marcas`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbentidad_nivel`
--
ALTER TABLE `tbentidad_nivel`
  MODIFY `idNivelAcceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbentidad_tipo`
--
ALTER TABLE `tbentidad_tipo`
  MODIFY `idEntidadTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbficha`
--
ALTER TABLE `tbficha`
  MODIFY `idFicha` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblistas`
--
ALTER TABLE `tblistas`
  MODIFY `idLista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbmarcas`
--
ALTER TABLE `tbmarcas`
  MODIFY `idMarca` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbmoneda`
--
ALTER TABLE `tbmoneda`
  MODIFY `idMoneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbpagos`
--
ALTER TABLE `tbpagos`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbpro`
--
ALTER TABLE `tbpro`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbpro_categorias`
--
ALTER TABLE `tbpro_categorias`
  MODIFY `Contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbpro_ficha`
--
ALTER TABLE `tbpro_ficha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbpro_iva`
--
ALTER TABLE `tbpro_iva`
  MODIFY `idIva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbpro_juegos`
--
ALTER TABLE `tbpro_juegos`
  MODIFY `Contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbpro_precios`
--
ALTER TABLE `tbpro_precios`
  MODIFY `Contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbpro_promo`
--
ALTER TABLE `tbpro_promo`
  MODIFY `idPromo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbpro_series`
--
ALTER TABLE `tbpro_series`
  MODIFY `Contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbpro_stock`
--
ALTER TABLE `tbpro_stock`
  MODIFY `Contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbpro_tipo`
--
ALTER TABLE `tbpro_tipo`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbrep`
--
ALTER TABLE `tbrep`
  MODIFY `idRep` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbrep_detalle`
--
ALTER TABLE `tbrep_detalle`
  MODIFY `Contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbrep_equipos`
--
ALTER TABLE `tbrep_equipos`
  MODIFY `idEquipo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbrep_estados`
--
ALTER TABLE `tbrep_estados`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbrep_eventos`
--
ALTER TABLE `tbrep_eventos`
  MODIFY `Contador` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbsucursal`
--
ALTER TABLE `tbsucursal`
  MODIFY `idSucursal` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbcart`
--
ALTER TABLE `tbcart`
  ADD CONSTRAINT `fk_cart_idEntidad` FOREIGN KEY (`idEntidad`) REFERENCES `tbentidad` (`idEntidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cart_idMoneda` FOREIGN KEY (`idMoneda`) REFERENCES `tbmoneda` (`idMoneda`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbcart_detalle`
--
ALTER TABLE `tbcart_detalle`
  ADD CONSTRAINT `fk_cartdet_idCart` FOREIGN KEY (`idCart`) REFERENCES `tbcart` (`idCart`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cartdet_idDeposito` FOREIGN KEY (`idDeposito`) REFERENCES `tbdep` (`idDeposito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cartdet_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `tbpro` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbdep`
--
ALTER TABLE `tbdep`
  ADD CONSTRAINT `fk_dep_idSucursal` FOREIGN KEY (`idSucursal`) REFERENCES `tbsucursal` (`idSucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbdep_mov`
--
ALTER TABLE `tbdep_mov`
  ADD CONSTRAINT `fk_depmov_idDeposito` FOREIGN KEY (`idDeposito`) REFERENCES `tbdep` (`idDeposito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_depmov_idDoc` FOREIGN KEY (`idDoc`) REFERENCES `tbdoc` (`idDoc`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_depmov_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `tbpro` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbdoc`
--
ALTER TABLE `tbdoc`
  ADD CONSTRAINT `fk1_idCondFiscal` FOREIGN KEY (`idCondfiscal`) REFERENCES `tbcondicionfiscal` (`idCondFiscal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk1_idCondPago` FOREIGN KEY (`idCondPago`) REFERENCES `tbdoc_condpago` (`idCondpago`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk1_idDeposito` FOREIGN KEY (`idDeposito`) REFERENCES `tbdep` (`idDeposito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk1_idEntidad` FOREIGN KEY (`idEntidad`) REFERENCES `tbentidad` (`idEntidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk1_idEstado` FOREIGN KEY (`idEstado`) REFERENCES `tbdoc_estado` (`idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk1_idLista` FOREIGN KEY (`idLista`) REFERENCES `tblistas` (`idLista`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk1_idMoneda` FOREIGN KEY (`idMoneda`) REFERENCES `tbmoneda` (`idMoneda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk1_idTipoDoc` FOREIGN KEY (`idTipoDoc`) REFERENCES `tbdoc_tipo` (`idTipoDoc`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk2_idEntidad` FOREIGN KEY (`idUsuario`) REFERENCES `tbentidad` (`idEntidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbdoc_detalle`
--
ALTER TABLE `tbdoc_detalle`
  ADD CONSTRAINT `fk2_idDoc` FOREIGN KEY (`idDoc`) REFERENCES `tbdoc` (`idDoc`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk2_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `tbpro` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbentidad`
--
ALTER TABLE `tbentidad`
  ADD CONSTRAINT `fk_ent_idEntidadTipo` FOREIGN KEY (`idEntidadTipo`) REFERENCES `tbentidad_tipo` (`idEntidadTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ent_idNivelAcceso` FOREIGN KEY (`idNivelAcceso`) REFERENCES `tbentidad_nivel` (`idNivelAcceso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbentidad_marcas`
--
ALTER TABLE `tbentidad_marcas`
  ADD CONSTRAINT `fk_entmarcas_idEntidad` FOREIGN KEY (`idEntidad`) REFERENCES `tbentidad` (`idEntidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_entmarcas_idMarca` FOREIGN KEY (`idMarca`) REFERENCES `tbmarcas` (`idMarca`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbmoneda`
--
ALTER TABLE `tbmoneda`
  ADD CONSTRAINT `fk_mon_idEntidad` FOREIGN KEY (`idEntidad`) REFERENCES `tbentidad` (`idEntidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbpro`
--
ALTER TABLE `tbpro`
  ADD CONSTRAINT `fk_pro_idIva` FOREIGN KEY (`idIva`) REFERENCES `tbpro_iva` (`idIva`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pro_idMarca` FOREIGN KEY (`idMarca`) REFERENCES `tbmarcas` (`idMarca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pro_idMoneda` FOREIGN KEY (`idMoneda`) REFERENCES `tbmoneda` (`idMoneda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pro_idTipo` FOREIGN KEY (`idTipo`) REFERENCES `tbpro_tipo` (`idTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbpro_categorias`
--
ALTER TABLE `tbpro_categorias`
  ADD CONSTRAINT `fk_procat_idCategoria` FOREIGN KEY (`idCategoria`) REFERENCES `tbcategorias` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_procat_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `tbpro` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbpro_ficha`
--
ALTER TABLE `tbpro_ficha`
  ADD CONSTRAINT `fk_proficha_idFicha` FOREIGN KEY (`idFicha`) REFERENCES `tbficha` (`idFicha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proficha_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `tbpro` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbpro_precios`
--
ALTER TABLE `tbpro_precios`
  ADD CONSTRAINT `fk_proprecios_idLista` FOREIGN KEY (`idLista`) REFERENCES `tblistas` (`idLista`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proprecios_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `tbpro` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbpro_series`
--
ALTER TABLE `tbpro_series`
  ADD CONSTRAINT `fk_proseries_idDoc` FOREIGN KEY (`idDoc`) REFERENCES `tbdoc` (`idDoc`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proseries_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `tbpro` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbpro_stock`
--
ALTER TABLE `tbpro_stock`
  ADD CONSTRAINT `fk_prostock_idDeposito` FOREIGN KEY (`idDeposito`) REFERENCES `tbdep` (`idDeposito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_prostock_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `tbpro` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbrep`
--
ALTER TABLE `tbrep`
  ADD CONSTRAINT `fk_rep_idEntidad` FOREIGN KEY (`idEntidad`) REFERENCES `tbentidad` (`idEntidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rep_idEquipo` FOREIGN KEY (`idEquipo`) REFERENCES `tbrep_equipos` (`idEquipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rep_idEstado` FOREIGN KEY (`idEstado`) REFERENCES `tbrep_estados` (`idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rep_idLista` FOREIGN KEY (`idLista`) REFERENCES `tblistas` (`idLista`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbrep_equipos`
--
ALTER TABLE `tbrep_equipos`
  ADD CONSTRAINT `fk_repequipos_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `tbpro` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
