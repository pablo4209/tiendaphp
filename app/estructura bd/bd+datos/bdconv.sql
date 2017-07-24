-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 24-07-2017 a las 04:05:24
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bdconv`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getCartItem`(IN `IDITEM` INT, IN `IDPRO` INT)
    NO SQL
    SQL SECURITY INVOKER
    COMMENT 'recibe idCart, idProducto, , retorna el item completo'
SELECT 	b.idCart, 
	b.idItem,
        b.idProducto, 
        c.Nombre, 
        c.Codigo, 
        c.Imagen,
	b.Cantidad, 
	b.Serie, 
        b.Costo, 
        b.pDescuento, 
        round(b.Total,2) as Total, 
        b.pIva, 
	b.idDeposito,
        d.idCategoria
FROM tbcart_detalle as b
  INNER JOIN tbpro as c ON b.idProducto = c.idProducto
  LEFT  JOIN tbpro_categorias as d ON c.idProducto = d.idProducto
WHERE b.IdCart = IDITEM AND c.idProducto = IDPRO AND d.Principal = 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCartItems`(IN `IDCART` INT)
    NO SQL
    SQL SECURITY INVOKER
    COMMENT 'devuelve los items con sus caracteristicas segun idCart'
SELECT 	b.idItem, 
	b.idProducto, 
        c.Nombre, 
        c.Codigo, 
        c.Imagen,
	b.Cantidad, 
	b.Serie, 
        b.Costo, 
        b.pDescuento, 
        round(b.Total,2) as Total, 
        b.pIva, 
	b.idDeposito,
        d.idCategoria
FROM tbcart as a
  INNER JOIN tbcart_detalle as b ON a.idCart = b.IdCart
  INNER JOIN tbpro as c ON b.idProducto = c.idProducto
  LEFT  JOIN tbpro_categorias as d ON c.idProducto = d.idProducto
WHERE a.IdCart = IDCART AND d.Principal = 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProducto`(IN `ID_PRO` INT, IN `ID_LISTA` INT, IN `ID_DEPOSITO` INT)
    NO SQL
    SQL SECURITY INVOKER
    COMMENT 'producto con precio calculado, cat princ y stock'
SELECT  a.`idProducto`, 
	a.`Codigo`, 
        a.`Nombre`,
        a.`SEO`,
        a.`FechaIngreso`, 
        a.`HoraIngreso`, 
        a.`FechaMod`, 
        a.`HoraMod`, 
        a.`FechaUltVenta`, 
        a.`HoraUltVenta`,
        a.`idMoneda`,         
        a.`UnidxDef`,         
        Round((a.Costo*a.UnidxDef*e.Cambio),3) as Costo,
        Round(((a.Costo*a.UnidxDef*e.Cambio*c.Margen/100)+a.Costo*a.UnidxDef*e.Cambio),2)  as Precio,
        a.`MaxDescuento`, 
        a.`pDescuento`, 
        a.`Vendidas`, 
        a.`Imagen`, 
        a.`CodBar`, 
        a.`CodBar2`, 
        a.`idMarca`, 
        a.`idPadre`, 
        a.`idTipo`,
        f.`Porcentaje` as pIva, 
        a.`Garantia`, 
        a.`Descripcion`, 
        a.`Nota`, 
        a.`NotaEmerg`, 
        a.`Publicar`, 
        a.`Destacado`, 
        a.`Marcado`, 
        a.`Usado`, 
        a.`Reparable`, 
        a.`VenderSinStock`,
        a.`Promociones`, 
        a.`Habilitado`,	
        b.idCategoria,
        d.Stock
        FROM `tbpro` as a
        LEFT JOIN tbpro_categorias as b ON a.idProducto = b.idProducto
       	LEFT JOIN tbpro_precios as c ON a.idProducto = c.idProducto
       	LEFT JOIN tbpro_stock as d ON a.idProducto = d.idProducto
       	LEFT JOIN tbmoneda as e ON a.idMoneda = e.idMoneda             
        LEFT JOIN tbpro_iva as f ON a.idIva = f.idIva
        WHERE a.idProducto=ID_PRO         
        AND b.Principal = 1    
        AND c.idLista = ID_LISTA 
        AND d.idDeposito = ID_DEPOSITO                
        LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductosCatPadre`(IN `ID_LISTA` INT, IN `ID_DEPOSITO` INT, IN `ID_PADRE` INT)
    NO SQL
    SQL SECURITY INVOKER
    COMMENT 'prod completo cuyas cat esta asoc a idPadre'
SELECT 	a.`idProducto`, 
	a.`Codigo`, 
        a.`Nombre`,
        a.`SEO`,
        a.`FechaIngreso`, 
        a.`HoraIngreso`, 
        a.`FechaMod`, 
        a.`HoraMod`, 
        a.`FechaUltVenta`, 
        a.`HoraUltVenta`,
        a.`idMoneda`,         
        a.`UnidxDef`,         
        Round((a.Costo*a.UnidxDef*e.Cambio),3) as Costo,
        Round(((a.Costo*a.UnidxDef*e.Cambio*c.Margen/100)+a.Costo*a.UnidxDef*e.Cambio),2)  as Precio,
        a.`MaxDescuento`, 
        a.`pDescuento`, 
        a.`Vendidas`, 
        a.`Imagen`, 
        a.`CodBar`, 
        a.`CodBar2`, 
        a.`idMarca`, 
        a.`idPadre`, 
        a.`idTipo`,
        f.`Porcentaje` as pIva, 
        a.`Garantia`, 
        a.`Descripcion`, 
        a.`Nota`, 
        a.`NotaEmerg`, 
        a.`Publicar`, 
        a.`Destacado`, 
        a.`Marcado`, 
        a.`Usado`, 
        a.`Reparable`, 
        a.`VenderSinStock`,
        a.`Promociones`, 
        a.`Habilitado`,	
        b.idCategoria,
        d.Stock
FROM tbpro as a
	LEFT JOIN tbpro_categorias as b ON a.idProducto = b.idProducto
       	LEFT JOIN tbpro_precios as c ON a.idProducto = c.idProducto
       	LEFT JOIN tbpro_stock as d ON a.idProducto = d.idProducto
       	LEFT JOIN tbmoneda as e ON a.idMoneda = e.idMoneda             
        LEFT JOIN tbpro_iva as f ON a.idIva = f.idIva
WHERE      
        c.idLista = ID_LISTA
        AND d.idDeposito = ID_DEPOSITO
        AND b.idCategoria IN ( SELECT g.idCategoria FROM tbcategorias as g WHERE g.idPadre = ID_PADRE )$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcart`
--

CREATE TABLE IF NOT EXISTS `tbcart` (
  `idCart` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL DEFAULT '0',
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Fechamod` date DEFAULT NULL,
  `Horamod` time DEFAULT NULL,
  `ip` text COLLATE utf8_spanish_ci,
  `idEstado` int(11) NOT NULL DEFAULT '0',
  `idEstadoPago` int(11) NOT NULL DEFAULT '0',
  `idMoneda` int(11) NOT NULL DEFAULT '0',
  `CostoTotal` decimal(19,3) NOT NULL DEFAULT '0.000',
  `pDescuento` decimal(19,3) NOT NULL DEFAULT '0.000',
  `TotalIva` decimal(19,3) NOT NULL DEFAULT '0.000',
  `SubTotal` decimal(19,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`idCart`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tbcart`
--

INSERT INTO `tbcart` (`idCart`, `idUsuario`, `Fecha`, `Hora`, `Fechamod`, `Horamod`, `ip`, `idEstado`, `idEstadoPago`, `idMoneda`, `CostoTotal`, `pDescuento`, `TotalIva`, `SubTotal`) VALUES
(1, 10, '2017-01-23', '13:21:59', NULL, NULL, '127.0.0.1', 0, 0, 1, '0.000', '0.000', '0.000', '0.000'),
(2, 11, '2017-01-25', '20:02:13', NULL, NULL, '127.0.0.1', 0, 0, 1, '0.000', '0.000', '0.000', '0.000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcart_detalle`
--

CREATE TABLE IF NOT EXISTS `tbcart_detalle` (
  `idItem` int(11) NOT NULL AUTO_INCREMENT,
  `idCart` int(11) NOT NULL DEFAULT '0',
  `idProducto` int(11) NOT NULL DEFAULT '0',
  `Cantidad` int(11) NOT NULL DEFAULT '0',
  `Serie` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Costo` decimal(19,3) NOT NULL DEFAULT '0.000',
  `pDescuento` decimal(19,3) NOT NULL DEFAULT '0.000',
  `Total` decimal(19,3) NOT NULL DEFAULT '0.000',
  `pIva` decimal(19,3) NOT NULL DEFAULT '0.000',
  `idDeposito` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idItem`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `tbcart_detalle`
--

INSERT INTO `tbcart_detalle` (`idItem`, `idCart`, `idProducto`, `Cantidad`, `Serie`, `Costo`, `pDescuento`, `Total`, `pIva`, `idDeposito`) VALUES
(5, 2, 2, 1, '', '946.400', '0.000', '1400.000', '0.000', 1),
(10, 1, 1, 1, '', '980.200', '0.000', '1450.000', '0.000', 1),
(11, 1, 2, 1, '', '946.400', '0.000', '1400.000', '0.000', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcategorias`
--

CREATE TABLE IF NOT EXISTS `tbcategorias` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idPadre` int(11) DEFAULT '0',
  `FechaAlta` date DEFAULT NULL,
  `HoraAlta` time DEFAULT NULL,
  `ImgPath` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Iniciales` varchar(3) DEFAULT NULL,
  `Color` int(11) DEFAULT NULL,
  `Publicar` int(11) DEFAULT '0',
  PRIMARY KEY (`idCategoria`),
  KEY `idCategoria` (`idCategoria`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- Volcado de datos para la tabla `tbcategorias`
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
(73, 'Accesorios', '', 2, '2017-02-05', '01:13:52', 'XBOX360/', 'XBA', -2147483643, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbclientes`
--

CREATE TABLE IF NOT EXISTS `tbclientes` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Razonsocial` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Login` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Pass` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Dom` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Domentrega` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Loc` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cp` varchar(10) DEFAULT NULL,
  `Prov` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cuit` varchar(30) DEFAULT NULL,
  `Dni` varchar(20) DEFAULT NULL,
  `Tel` varchar(50) DEFAULT NULL,
  `Tel2` varchar(50) DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `Sexo` varchar(1) DEFAULT NULL,
  `idCondFiscal` int(11) DEFAULT NULL,
  `FechaAlta` date DEFAULT NULL,
  `HoraAlta` time DEFAULT NULL,
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  `idLista` int(11) DEFAULT NULL,
  `Estado` int(11) DEFAULT '1',
  `Observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `AvisoEmergente` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Promociones` int(11) DEFAULT '0',
  `RecuperarPass` varchar(50) DEFAULT NULL,
  `Foto` varchar(200) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `FechaLog` date DEFAULT NULL,
  `HoraLog` time DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Volcado de datos para la tabla `tbclientes`
--

INSERT INTO `tbclientes` (`idCliente`, `Nombre`, `Razonsocial`, `Email`, `Login`, `Pass`, `Dom`, `Domentrega`, `Loc`, `Cp`, `Prov`, `Cuit`, `Dni`, `Tel`, `Tel2`, `FechaNacimiento`, `Sexo`, `idCondFiscal`, `FechaAlta`, `HoraAlta`, `FechaMod`, `HoraMod`, `idLista`, `Estado`, `Observaciones`, `AvisoEmergente`, `Promociones`, `RecuperarPass`, `Foto`, `ip`, `FechaLog`, `HoraLog`) VALUES
(1, '-', '-', '', NULL, NULL, '-', 'YYY', '-', '', '', '-', '7654321', '-', '9887656734', '1999-10-05', 'M', 1, '2010-10-19', '00:00:00', '2010-10-19', '00:00:00', 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'U.Doc.B.A.', 'U.Doc.B.A.', '', NULL, NULL, 'Av. Argentina 1197', NULL, 'Merlo', '1722', 'Buenos Aires', '28-30546836-5', NULL, '486-7777', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(3, 'Escuela Secundaria Basica Nº 22', 'Escuela Secundaria Basica Nº 22', '', NULL, NULL, 'Av. Real 47', NULL, 'Merlo', '1722', '', '', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(4, 'PalPan', 'PalPan', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(5, 'Fede', 'Fede', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '15-4038-4632', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 4, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(6, 'ESCUELA DE EDUCACION SECUNDARIA Nº 22', 'ESCUELA DE EDUCACION SECUNDARIA Nº 22', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(7, 'Direccion General de Cultura y Educacion - Secretaria de Asuntos Docentes de Merlo', 'Direccion General de Cultura y Educacion - Secretaria de Asuntos Docentes de Merlo', '', NULL, NULL, 'Calle Real 140', NULL, 'Merlo', '1722', 'Buenos Aires', '30-62739371-3', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(8, 'Direccion de Cultura y Educacion - Direccion Pcial de Planificacion e Infraestructura Escolar - REGION 8 MERLO', 'Direccion de Cultura y Educacion - Direccion Pcial de Planificacion e Infraestructura Escolar - REGION 8 MERLO', '', NULL, NULL, 'Calle 13 entre 56 y 57', NULL, 'La Plata', '1900', 'Buenos Aires', '30-62739371-3', NULL, '011-156148-7137', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(9, 'Jardin Casita de Belen', 'Jardin Casita de Belen', '', NULL, NULL, '25 de Mayo 1225', NULL, 'Merlo', '1722', '', '', NULL, '482-3502', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(10, 'Sergio Lopez', 'Sergio Lopez', '', NULL, NULL, 'Pucheu 717', NULL, '', '', '', '', NULL, '483-5339', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(11, 'Dante Alighieri', 'Dante Alighieri', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '485-0548', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(12, 'Escuela Secundaria Nro 38', 'Escuela Secundaria Nro 38', '', NULL, NULL, 'Rivarola y Santo Domingo', NULL, 'Libertad', '1722', '', '', NULL, '494-8255', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(13, 'Angel (San Justo)', 'Angel (San Justo)', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '1144458622', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 4, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(14, 'Kike', 'Kike', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '483-0835 (neg) - 482-1807 (ca)', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 3, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(15, 'Escuela Primaria N 72', 'Escuela Primaria N 72', '', NULL, NULL, 'Fraga 651', NULL, 'Merlo', '1722', '', '', NULL, '489-2050', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(16, 'AGREFERT (Ortiz Mariana)', 'AGREFERT (Ortiz Mariana)', '', NULL, NULL, '', NULL, 'Moreno', '', '', '', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(17, 'Beto ', 'Beto ', '', NULL, NULL, '', NULL, 'Ituzaingo', '', '', '', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 4, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(18, 'Mirta Helver', 'Mirta Helver', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '485-4578 / 1531921053', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(19, 'EP nº 25', 'EP nº 25', '', NULL, NULL, '', NULL, 'Merlo', '', '', '', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(20, 'Ariel (Hurlingam)', 'Ariel (Hurlingam)', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 4, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(21, 'Sociedad Italiana', 'Sociedad Italiana', '', NULL, NULL, 'Av. Libertador 188', NULL, 'Merlo', '1722', '', '', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(22, 'Cooperativa de Vivienda Credito y Consumo Cash Limitada', 'Cooperativa de Vivienda Credito y Consumo Cash Limitada', '', NULL, NULL, 'Peru 630', NULL, 'Merlo', '1722', '', '30-709422789', NULL, '486-7576', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(23, 'Jardin de Infantes 904', 'Jardin de Infantes 904', '', NULL, NULL, '', NULL, 'Merlo', '1722', '', '', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(24, 'Escuela Orientacion', 'Escuela Orientacion', '', NULL, NULL, 'Bartolome Mitre 40', NULL, 'Merlo', '1722', '', '', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(25, 'Alejandro (Castelar)', 'Alejandro (Castelar)', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '', NULL, NULL, 'M', 0, NULL, NULL, NULL, NULL, 2, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(26, 'Jardin de Infantes 915', 'Jardin de Infantes 915', '', NULL, NULL, '', NULL, 'Merlo', '', '', '', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(27, 'Guille/ariel (tecnico ps2)', 'Guille/ariel (tecnico ps2)', '15-6181-7469 guille', NULL, NULL, '', NULL, '', '', '', '', NULL, '485-4983/15-6453-0083', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 4, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(28, 'Asociacion de Padres IBR', 'Asociacion de Padres IBR', '', NULL, NULL, 'De La Virgen 2260', NULL, 'Pontevedra', '', '', '30-52162309-4', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(29, 'Alejandro juegos PS3', 'Alejandro juegos PS3', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 4, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(30, 'alejandro castelar (tecway)', 'alejandro castelar (tecway)', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '15-6091-3145/4628-0094', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 2, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(31, 'Escuela de Educacion Media Nº1', 'Escuela de Educacion Media Nº1', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(32, 'Agrofinar S.A.', 'Agrofinar S.A.', '', NULL, NULL, 'Concordia 3550', NULL, 'Capital Federal', '', '', '30-70913437-6', NULL, '485-2280', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(33, 'Instituto de Obra Medico Asistencial', 'Instituto de Obra Medico Asistencial', '', NULL, NULL, 'Buen Viaje 1436', NULL, 'Moron', '', '', '30-62824952-7', NULL, '4489-0594', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(34, 'Leonardo (Ramos Mejia)', 'Leonardo (Ramos Mejia)', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '(011) 4464-6341', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 4, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(35, 'Marcelo Lopez (0220 480-0242)', 'Marcelo Lopez (0220 480-0242)', '', NULL, NULL, '', NULL, 'Merlo', '', '', '', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 4, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(36, 'EDENOR S.A.', 'EDENOR S.A.', '', NULL, NULL, 'Av. del Libertador 6363', NULL, 'Ciudad autonoma de Buenos Aires', '1428', 'Bs As', '30-65511620-2', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(37, 'Escuela Estetica de Merlo', 'Escuela Estetica de Merlo', '', NULL, NULL, '', NULL, 'Merlo', '1722', '', '', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(38, 'Ministerio de Educacion de la Nacion (MEN)', 'Ministerio de Educacion de la Nacion (MEN)', '', NULL, NULL, '', NULL, '', '', '', '30-62854078-7', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(39, 'Hector (Castelar)', 'Hector (Castelar)', '', NULL, NULL, '', NULL, 'Castelar', '', '', '', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 4, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(40, 'Rodrigo Gonzalez (11-45635992)', 'Rodrigo Gonzalez (11-45635992)', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 3, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(41, 'JUMBO RETAIL ARGENTINA SOCIEDAD ANONIMA', 'JUMBO RETAIL ARGENTINA SOCIEDAD ANONIMA', '', NULL, NULL, 'SUIPACHA 1111 Piso:18', NULL, 'CIUDAD AUTONOMA BUENOS AIRES', '', '', '30-70877296-4', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(42, 'UEP - PROMEDU', 'UEP - PROMEDU', '', NULL, NULL, 'Calle 8  Nº 713', NULL, 'La Plata', '', '', '30-68460035-0', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(43, 'ADJUGE S.A.', 'ADJUGE S.A.', '', NULL, NULL, '', NULL, 'Merlo', '1722', '', '', NULL, '', NULL, NULL, 'M', 0, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(44, 'Direccion de Escuela', 'Direccion de Escuela', '', NULL, NULL, '', NULL, 'Merlo', '1722', '', '', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(45, 'SB 29', 'SB 29', '', NULL, NULL, 'Heredia y Marimoñes', NULL, 'Ferrari', '1723', 'Buenos Aires', '', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(46, 'U.S. EQUITIES REALTY (ARGENTINA), LLC', 'U.S. EQUITIES REALTY (ARGENTINA), LLC', '', NULL, NULL, 'Av Alem 690 piso 14', NULL, 'Merlo', '1722', '', '33-70753170-9', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(47, 'BACHGOSF S.AA', 'BACHGOSF S.AA', '', NULL, NULL, 'Murray 690', NULL, 'Parque San Martin', '1722', 'Buenos Aires', '30-71189601-1', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(48, 'Raul Nuñez (Digital Data Computacion)', 'Raul Nuñez (Digital Data Computacion)', '', NULL, NULL, '', NULL, 'Marcos paz', '', '', '', NULL, '0220477-3972/15-6011-9667', NULL, NULL, 'M', 5, NULL, NULL, NULL, NULL, 2, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(49, 'PROBA SA-FONTANA NICASTRO SAC-BRICONS SAICFI-GREEN SA-UTE', 'PROBA SA-FONTANA NICASTRO SAC-BRICONS SAICFI-GREEN SA-UTE', '', NULL, NULL, 'RIO CUARTO 1400', NULL, 'CAPITAL FEDERAL', '', 'BUENOS AIRES', '30-71133518-4', NULL, '4303-3206', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(50, 'D.G.CYE (PIIE)', 'D.G.CYE (PIIE)', '', NULL, NULL, 'CALLE 13 E/  56 Y 57', NULL, 'LA PLATA', '', '', '30-62739371-3', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(51, 'D.G.C y Educacion', 'D.G.C y Educacion', '', NULL, NULL, 'Calle 13 Entre 56 y 57', NULL, 'La Plata', '', 'buenos Aires', '30-62739371-3', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(52, 'Astur S.R.L.', 'Astur S.R.L.', '', NULL, NULL, 'Av. Calle Real 53', NULL, 'Merlo', '1722', 'Buenos Aires', '33-57259448-9', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(53, 'Casa Nadal S.R.L.', 'Casa Nadal S.R.L.', '', NULL, NULL, '9 de Julio 79 P.B.B', NULL, 'Merlo', '1722', 'Buenos Aires', '30-71231820-8', NULL, '15-5720-7608 / 486-7991', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(54, 'EDENOR SA', 'EDENOR SA', '', NULL, NULL, '', NULL, 'MERLO', '1722', '', '30-65511620-2', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(55, 'PEDRO PETINARI E HIJO SOCIEDAD ANONIMA', 'PEDRO PETINARI E HIJO SOCIEDAD ANONIMA', '', NULL, NULL, 'AV. GAONA 13247', NULL, 'FRANCISCO ALVAREZ', '1746', '', '30-62072061-1', NULL, '481-7085', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(56, 'Silicomlan', 'Silicomlan', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(57, 'Romero Ana Monica', 'Romero Ana Monica', '', NULL, NULL, 'Hipolito Irigoyen 255', NULL, 'Merlo', '', '', '27-14840432-7', NULL, '485-7382', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(58, 'Colegio Elvira Sullivan', 'Colegio Elvira Sullivan', '', NULL, NULL, '9 de julio', NULL, 'Merlo', '', '', '', NULL, '', NULL, NULL, 'M', 5, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(59, 'Barragan Federico Daniel', 'Barragan Federico Daniel', '', NULL, NULL, 'Av Calle Rel  53 dpto. 2', NULL, 'Merlo', '1722', 'Buenos Aires', '20-25396908-4', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(60, 'Casa de la Cultura', 'Casa de la Cultura', '', NULL, NULL, 'Av Calle Real y Padre Espinal', NULL, 'Merlo', '1722', '', '', NULL, '482-6018', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(61, 'DGEYC - Direccion General de Educacion y Cultura', 'DGEYC - Direccion General de Educacion y Cultura', '', NULL, NULL, 'Calle 13 (entre 56 y 57)', NULL, 'La Plata', '', '', '30-62739371-3', NULL, '497-5209', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(62, 'Hernandez Alejandro Waldemar', 'Hernandez Alejandro Waldemar', '', NULL, NULL, 'Bartolome Mitre 523', NULL, 'Merlo', '', '', '20-25734241-8', NULL, '15-6383-3468', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(63, 'Nestor (bebijuegos)', 'Nestor (bebijuegos)', '', NULL, NULL, '', NULL, '', '', '', '', NULL, '02227-469634/0220-477-5093', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 2, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(64, 'Andrada Hugo Jose', 'Andrada Hugo Jose', '', NULL, NULL, 'General Mariano Acha', NULL, 'Santa Rosa', '', 'La Pampa', '20-11040200-8', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(65, 'San Pablo Diego', 'San Pablo Diego', '', NULL, NULL, 'Av. Calle Real nº 53', NULL, 'Merlo', '1722', 'Buenos Aires', '20-20186902-2', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(66, 'GOMEZ RODRIGO JAVIER', 'GOMEZ RODRIGO JAVIER', '', NULL, NULL, 'LOS PINOS 224', NULL, 'SAN ANTONIO DE PADUA', '1718', 'BUENOS AIRES', '20-25743893-8 ', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(67, 'UNIPRINT', 'UNIPRINT', '', NULL, NULL, 'Rawson 1786', NULL, 'Merlo', '1722', 'Buenos Aires', '', NULL, '15-2424-5275', NULL, NULL, 'M', 1, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(68, 'UNIDAD EJECUTORA PROVINCIAL DIRECC. GRALCULTURA Y EDUCACION BS AS', 'UNIDAD EJECUTORA PROVINCIAL DIRECC. GRALCULTURA Y EDUCACION BS AS', '', NULL, NULL, '8 715 - ENTRE LAS CALLES: : 46 Y 47', NULL, 'la plata noroeste calle 50', '1900', 'buenos Aires', '30-68460035-0', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(69, 'MOTOLOOK S.R.L.', 'MOTOLOOK S.R.L.', '', NULL, NULL, 'CALLE REAL AV. 223', NULL, 'MERLO ', '', '', '30-71112184-2', NULL, '486-5605', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(70, 'KEPNER S A', 'KEPNER S A', '', NULL, NULL, 'AMENABAR 2710', NULL, 'CIUDAD AUTONOMA BUENOS AIRES', '1428', 'Buenos Aires', '30-65539046-0', NULL, '4787 5500', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(71, 'FIORE LUIS EDUARDO', 'FIORE LUIS EDUARDO', '', NULL, NULL, 'VELEZ SARSFIELD 64', NULL, 'Marcos Paz', '1727', 'Buenos Aires', '20-29302441-4', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(72, 'Club de Campo El Solitario S.A.', 'Club de Campo El Solitario S.A.', '', NULL, NULL, 'Bartolome Mitre 1523', NULL, 'Ciudad Autonoma de Buenos Aires', '1037', '', '33-70859926-9', NULL, '', NULL, NULL, 'M', 4, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(73, 'PIRELLI NEUMATICOS SOCIEDAD ANONIMA INDUSTRIAL Y COMERCIAL', 'PIRELLI NEUMATICOS SOCIEDAD ANONIMA INDUSTRIAL Y COMERCIAL', '', NULL, NULL, 'CERVANTES 1901', NULL, 'MERLO', '1722', '', '33-50223253-9', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(74, 'INTEP S R L', 'INTEP S R L', '', NULL, NULL, 'ALVEAR MARCELO T. DE 429 Piso:3 Dpto:C', NULL, 'CIUDAD AUTONOMA BUENOS AIRES', '1058', 'Buenos Aires ', '30-65176906-6', NULL, '15-44929041', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(75, 'SAYAGO SILVIA ROSANA', 'SAYAGO SILVIA ROSANA', '', NULL, NULL, 'SARANDI 358', NULL, 'MERLO', '1722', '', '27-22157959-9', NULL, '', NULL, NULL, 'M', 2, NULL, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcondicionfiscal`
--

CREATE TABLE IF NOT EXISTS `tbcondicionfiscal` (
  `idCondFiscal` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Pordefecto` int(11) DEFAULT '0',
  `idTipoDoc` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idCondFiscal`),
  KEY `Id` (`idCondFiscal`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tbcondicionfiscal`
--

INSERT INTO `tbcondicionfiscal` (`idCondFiscal`, `Nombre`, `Descripcion`, `Pordefecto`, `idTipoDoc`) VALUES
(1, 'Consumidor Final', 'Consumidor Final', 0, 1),
(2, 'Responsable Inscripto', 'Responsable Inscripto', 0, 1),
(3, 'Responsable Monotributo', 'Responsable Monotributo', 0, 1),
(4, 'Exento', 'Exento', 0, 1),
(5, '-', '-', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdepositos`
--

CREATE TABLE IF NOT EXISTS `tbdepositos` (
  `idDeposito` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Dom` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cp` varchar(10) DEFAULT NULL,
  `Loc` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Prov` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tel` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Observaciones` mediumtext CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `FechaAlta` date DEFAULT NULL,
  `HoraAlta` time DEFAULT NULL,
  `idSucursal` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDeposito`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tbdepositos`
--

INSERT INTO `tbdepositos` (`idDeposito`, `Nombre`, `Descripcion`, `Dom`, `Cp`, `Loc`, `Prov`, `Tel`, `Email`, `Observaciones`, `FechaAlta`, `HoraAlta`, `idSucursal`) VALUES
(1, 'Deposito 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Deposito 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdepositos_mov`
--

CREATE TABLE IF NOT EXISTS `tbdepositos_mov` (
  `idMov` int(11) NOT NULL AUTO_INCREMENT,
  `idProveedor` int(11) DEFAULT '0',
  `idMoneda` int(11) DEFAULT '0',
  `idEstado` int(11) DEFAULT '0',
  `idDoc` int(11) DEFAULT '0',
  `idDeposito` int(11) DEFAULT '0',
  `FechaAlta` datetime DEFAULT NULL,
  `FechaMod` datetime DEFAULT NULL,
  `Observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `Consolidado` int(11) DEFAULT '0',
  PRIMARY KEY (`idMov`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdoc`
--

CREATE TABLE IF NOT EXISTS `tbdoc` (
  `idDoc` int(11) NOT NULL AUTO_INCREMENT,
  `idOrden` int(11) DEFAULT '0',
  `idTipoDoc` int(11) DEFAULT '0',
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Fechamod` date DEFAULT NULL,
  `HoraMod` int(11) DEFAULT NULL,
  `idDeposito` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idLista` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `idEstadoPedido` int(11) DEFAULT NULL,
  `idEstadoPago` int(11) DEFAULT NULL,
  `CliNom` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CliDom` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CliLoc` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CliCp` varchar(10) DEFAULT NULL,
  `CliProv` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CliCuit` varchar(20) DEFAULT NULL,
  `CliTel` varchar(30) DEFAULT NULL,
  `CliMail` varchar(100) DEFAULT NULL,
  `idCondfiscal` int(11) DEFAULT NULL,
  `CostoTotal` decimal(19,3) DEFAULT NULL,
  `pDescuento` decimal(19,3) DEFAULT '0.000',
  `pRecargo` decimal(19,3) DEFAULT '0.000',
  `TotalIva` decimal(19,3) DEFAULT '0.000',
  `SubTotal` decimal(19,3) DEFAULT '0.000',
  `Total` decimal(19,3) DEFAULT '0.000',
  `idMoneda` int(11) DEFAULT '1',
  `idCondPago` int(11) DEFAULT '1',
  `MailNotificaciones` int(11) DEFAULT '0',
  `Observacion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ObsPrivada` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `PtoVenta` int(11) DEFAULT '0',
  `Unidades` int(11) DEFAULT '0',
  `Items` int(11) DEFAULT '0',
  `AfectarVendidas` int(11) DEFAULT '0',
  `AfectarStock` int(11) DEFAULT '0',
  `Entregado` int(11) DEFAULT '0',
  PRIMARY KEY (`idDoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdoc_condpago`
--

CREATE TABLE IF NOT EXISTS `tbdoc_condpago` (
  `idCondpago` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Efectivo` int(11) DEFAULT '0',
  `Electronico` int(11) DEFAULT '0',
  `Pordefecto` int(11) DEFAULT '0',
  PRIMARY KEY (`idCondpago`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tbdoc_condpago`
--

INSERT INTO `tbdoc_condpago` (`idCondpago`, `Descripcion`, `Efectivo`, `Electronico`, `Pordefecto`) VALUES
(1, 'Contado', 0, 0, 0),
(2, 'Tarjeta de Credito', 0, 0, 0),
(3, 'Tarjeta de Debito', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdoc_detalle`
--

CREATE TABLE IF NOT EXISTS `tbdoc_detalle` (
  `idContador` int(11) NOT NULL AUTO_INCREMENT,
  `idDoc` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `Codigo` varchar(20) DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Serie` varchar(30) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT '0',
  `pDescuento` decimal(19,3) DEFAULT NULL,
  `Precio` decimal(19,3) DEFAULT '0.000',
  `Total` decimal(19,3) DEFAULT '0.000',
  `pIva` decimal(19,3) DEFAULT '0.000',
  `Costo` decimal(19,3) DEFAULT '0.000',
  `idDeposito` int(11) DEFAULT '0',
  `Promociones` int(11) DEFAULT '0',
  `idCategoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`idContador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdoc_estado`
--

CREATE TABLE IF NOT EXISTS `tbdoc_estado` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `tbdoc_estado`
--

INSERT INTO `tbdoc_estado` (`idEstado`, `Descripcion`) VALUES
(1, 'Pendiente'),
(2, 'Pendiente parcial'),
(3, 'Cobrada'),
(4, 'Devuelta'),
(5, 'Anulada'),
(6, 'Sin cargo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdoc_print`
--

CREATE TABLE IF NOT EXISTS `tbdoc_print` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `iva1` decimal(10,0) NOT NULL,
  `iva2` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdoc_tipo`
--

CREATE TABLE IF NOT EXISTS `tbdoc_tipo` (
  `idTipoDoc` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Letra` varchar(5) DEFAULT NULL,
  `AfectaStock` int(11) DEFAULT '0',
  `AfectaVendidas` int(11) DEFAULT '0',
  `Stockresta` int(11) DEFAULT '0',
  `Color` int(11) DEFAULT '0',
  `Activo` int(11) DEFAULT '1',
  `DesglozarIva` int(11) DEFAULT '0',
  PRIMARY KEY (`idTipoDoc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `tbdoc_tipo`
--

INSERT INTO `tbdoc_tipo` (`idTipoDoc`, `Nombre`, `Letra`, `AfectaStock`, `AfectaVendidas`, `Stockresta`, `Color`, `Activo`, `DesglozarIva`) VALUES
(1, 'Uso Interno', 'X', 1, 1, 0, 16777215, 1, 0),
(2, 'Presupuesto', 'P', 0, 0, 0, 33023, 1, 0),
(3, 'Factura', 'C', 1, 1, 0, 255, 1, 0),
(4, 'Nota de Credito', 'S', 1, 1, 1, 16776960, 1, 0),
(5, 'Nota de Pedido', 'N', 0, 0, 0, 0, 1, 0),
(6, 'Pedidos a Proveedores', 'Q', 1, 0, 1, 0, 1, 0),
(7, 'Factura B', 'B', 1, 1, 0, 65280, 1, 0),
(8, 'Factura A', 'A', 1, 1, 0, 16776960, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbficha`
--

CREATE TABLE IF NOT EXISTS `tbficha` (
  `idFicha` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcioncorta` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idPadre` int(11) DEFAULT '0',
  `FechaAlta` datetime DEFAULT NULL,
  `FechaMod` datetime DEFAULT NULL,
  `Publicar` int(11) DEFAULT '1',
  PRIMARY KEY (`idFicha`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `tbficha`
--

INSERT INTO `tbficha` (`idFicha`, `Descripcion`, `Descripcioncorta`, `idPadre`, `FechaAlta`, `FechaMod`, `Publicar`) VALUES
(1, 'Selector de Frecuencia', NULL, 0, '2013-01-19 03:08:12', '2013-01-20 19:19:40', 1),
(2, 'Idioma', NULL, 0, '2013-01-19 03:10:46', '2013-01-20 19:18:50', 1),
(3, 'Español', NULL, 2, '2013-01-19 03:13:44', NULL, 1),
(4, 'Ingles', NULL, 2, '2013-01-19 03:13:58', NULL, 1),
(5, 'Subtitulos en Español', NULL, 2, '2013-01-19 03:14:41', NULL, 1),
(6, 'Japones', NULL, 2, '2013-01-19 09:57:02', NULL, 1),
(7, 'Vista de Camara', NULL, 0, '2013-01-20 18:49:39', '2013-01-20 19:18:33', 1),
(8, '1ra Persona', NULL, 7, '2013-01-20 18:49:50', NULL, 1),
(9, '3ra Persona', NULL, 7, '2013-01-20 18:49:59', NULL, 1),
(10, 'Año', NULL, 0, '2013-01-20 18:51:55', NULL, 1),
(11, '2013', NULL, 10, '2013-01-20 18:52:06', NULL, 1),
(12, '2012', NULL, 10, '2013-01-20 18:52:12', NULL, 1),
(13, '2011', NULL, 10, '2013-01-20 18:52:19', NULL, 1),
(14, '2010', NULL, 10, '2013-01-20 18:52:25', NULL, 1),
(15, '2009', NULL, 10, '2013-01-20 18:52:31', NULL, 1),
(16, '2008', NULL, 10, '2013-01-20 18:52:35', NULL, 1),
(17, '2007', NULL, 10, '2013-01-20 18:52:40', NULL, 1),
(18, '2006', NULL, 10, '2013-01-20 18:52:44', NULL, 1),
(19, '2005', NULL, 10, '2013-01-20 18:52:49', NULL, 1),
(20, 'Si, 50-60hz', NULL, 1, '2013-01-20 19:19:53', NULL, 1),
(21, 'No', NULL, 1, '2013-01-20 19:20:00', NULL, 1),
(22, 'Selector de Idioma', NULL, 0, '2013-01-20 19:21:02', NULL, 1),
(23, 'Si', NULL, 22, '2013-01-20 19:21:26', NULL, 1),
(24, 'No', NULL, 22, '2013-01-20 19:21:32', NULL, 1),
(25, 'Cantidad de Jugadores', NULL, 0, '2013-01-20 19:22:57', '2013-01-20 19:23:07', 1),
(26, '1-2', NULL, 25, '2013-01-20 19:23:14', NULL, 1),
(27, '1-4', NULL, 25, '2013-01-20 19:23:20', NULL, 1),
(28, '1-8', NULL, 25, '2013-01-20 19:23:30', NULL, 1),
(29, '1-12 Multiplayer', NULL, 25, '2013-01-20 19:23:51', NULL, 1),
(30, 'Formato de Video', NULL, 0, '2013-01-20 19:25:32', NULL, 1),
(31, 'Zona Geografica', NULL, 0, '2013-01-20 19:26:52', NULL, 1),
(32, 'Region Free', 'RF', 31, '2013-01-20 19:27:07', '2013-01-20 19:33:43', 1),
(33, 'Usa', 'US', 31, '2013-01-20 19:39:37', NULL, 1),
(34, 'Europa', 'EU', 31, '2013-01-20 19:39:51', NULL, 1),
(35, 'Japon', 'JAP', 31, '2013-01-20 19:40:02', NULL, 1),
(36, 'Formato de Disco', 'Formato', 0, '2013-01-20 19:42:30', NULL, 1),
(37, 'Dvd Dl XGD2', 'XGD2', 36, '2013-01-20 19:42:56', NULL, 1),
(38, 'Dvd Dl XGD3', 'XGD3', 36, '2013-01-20 19:43:17', NULL, 1),
(39, 'Dvd5', 'Dvd5', 36, '2013-01-20 19:43:34', '2013-01-20 19:43:45', 1),
(40, 'Dvd9', 'Dvd9', 36, '2013-01-20 19:44:01', NULL, 1),
(41, 'Cd', 'CD', 36, '2013-01-20 19:44:23', NULL, 1),
(42, 'BlueRay', 'BlueRay', 36, '2013-01-20 19:44:35', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblistas`
--

CREATE TABLE IF NOT EXISTS `tblistas` (
  `idLista` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ivaincl` int(11) DEFAULT '1',
  `Margen` decimal(19,3) DEFAULT '0.000',
  `Habilitada` int(11) DEFAULT '1',
  `NivelAcceso` int(11) DEFAULT '0',
  `Pordefecto` int(11) DEFAULT '0',
  PRIMARY KEY (`idLista`),
  KEY `Codigo` (`idLista`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tblistas`
--

INSERT INTO `tblistas` (`idLista`, `Nombre`, `Descripcion`, `Ivaincl`, `Margen`, `Habilitada`, `NivelAcceso`, `Pordefecto`) VALUES
(1, 'Lista 1', 'Lista 1', 1, '50.000', 1, 0, 1),
(2, 'Lista 2', 'Lista 2', 1, '35.000', 1, 0, 0),
(3, 'Lista 3', 'Lista 3', 1, '28.000', 1, 0, 0),
(4, 'Lista 4', 'Lista 4', 1, '20.000', 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbmarcas`
--

CREATE TABLE IF NOT EXISTS `tbmarcas` (
  `idMarca` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Habilitada` int(11) DEFAULT '1',
  PRIMARY KEY (`idMarca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbmoneda`
--

CREATE TABLE IF NOT EXISTS `tbmoneda` (
  `idMoneda` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cambio` decimal(19,3) DEFAULT '0.000',
  `Simbolo` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `FechaAlta` date DEFAULT NULL,
  `HoraAlta` time DEFAULT NULL,
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  `idUsuarioMod` int(11) DEFAULT NULL,
  `Habilitada` int(11) DEFAULT '1',
  `Principal` int(11) DEFAULT '0',
  `Web` int(11) DEFAULT '0',
  PRIMARY KEY (`idMoneda`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tbmoneda`
--

INSERT INTO `tbmoneda` (`idMoneda`, `Nombre`, `Cambio`, `Simbolo`, `FechaAlta`, `HoraAlta`, `FechaMod`, `HoraMod`, `idUsuarioMod`, `Habilitada`, `Principal`, `Web`) VALUES
(1, 'Peso/s', '1.000', '$', '2011-02-09', NULL, '2011-02-09', '23:42:00', 1, 1, 1, 0),
(2, 'Dólar/es', '8.300', 'U$S', '2011-02-09', NULL, '2014-03-24', '23:49:15', 1, 1, 0, 0),
(3, 'Dolar2', '16.900', '$$', '2013-10-18', NULL, '2017-01-23', '11:32:14', 10, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpagos`
--

CREATE TABLE IF NOT EXISTS `tbpagos` (
  `idPago` int(11) NOT NULL AUTO_INCREMENT,
  `idOrden` int(11) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Pago` decimal(19,3) DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Consolidado` int(11) DEFAULT '0',
  `idTarjeta` int(11) DEFAULT NULL,
  `idPlan` int(11) DEFAULT NULL,
  `Cupon` int(11) DEFAULT NULL,
  `Lote` int(11) DEFAULT NULL,
  `Transferencia` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro`
--

CREATE TABLE IF NOT EXISTS `tbpro` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(20) DEFAULT NULL,
  `Nombre` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `SEO` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `FechaIngreso` date DEFAULT NULL,
  `HoraIngreso` time DEFAULT NULL,
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  `FechaUltVenta` date DEFAULT NULL,
  `HoraUltVenta` time DEFAULT NULL,
  `idMoneda` int(11) DEFAULT NULL,
  `Costo` decimal(19,3) DEFAULT '0.000',
  `UnidxDef` int(11) NOT NULL DEFAULT '1',
  `MaxDescuento` decimal(19,3) DEFAULT '0.000',
  `pDescuento` decimal(19,3) DEFAULT '0.000',
  `Vendidas` int(11) DEFAULT '0',
  `Imagen` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CodBar` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `CodBar2` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `idMarca` int(11) DEFAULT NULL,
  `idPadre` int(11) DEFAULT '0',
  `idTipo` int(11) DEFAULT '0',
  `idIva` int(11) DEFAULT '0',
  `Garantia` int(11) DEFAULT '0',
  `Descripcion` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `Nota` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `NotaEmerg` int(11) DEFAULT '0',
  `Publicar` int(11) DEFAULT '0',
  `Destacado` int(11) DEFAULT '0',
  `Marcado` int(11) DEFAULT '0',
  `Usado` int(11) DEFAULT '0',
  `Reparable` int(11) DEFAULT '0',
  `VenderSinStock` int(11) DEFAULT '1',
  `Promociones` int(11) DEFAULT '1',
  `Habilitado` int(11) DEFAULT '1',
  PRIMARY KEY (`idProducto`),
  KEY `idProducto` (`idProducto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `tbpro`
--

INSERT INTO `tbpro` (`idProducto`, `Codigo`, `Nombre`, `SEO`, `FechaIngreso`, `HoraIngreso`, `FechaMod`, `HoraMod`, `FechaUltVenta`, `HoraUltVenta`, `idMoneda`, `Costo`, `UnidxDef`, `MaxDescuento`, `pDescuento`, `Vendidas`, `Imagen`, `CodBar`, `CodBar2`, `idMarca`, `idPadre`, `idTipo`, `idIva`, `Garantia`, `Descripcion`, `Nota`, `NotaEmerg`, `Publicar`, `Destacado`, `Marcado`, `Usado`, `Reparable`, `VenderSinStock`, `Promociones`, `Habilitado`) VALUES
(1, 'PS40001', 'Fifa 17', '', '2017-01-23', '11:33:15', '2017-01-23', '11:34:42', NULL, NULL, 3, '58.000', 1, '0.000', '0.000', 0, 'fifa 17_ps4.jpg', '', '', 0, 0, 2, 3, 0, '', '', 0, 1, 1, 0, 0, 0, 1, 1, 1),
(2, 'PS40002', 'Battlefield 1', '', '2017-01-23', '12:58:01', '2017-01-23', '23:07:23', NULL, NULL, 3, '56.000', 1, '0.000', '0.000', 0, 'battlefield1_ps4.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1),
(3, 'PS40003', 'Call of Duty - Infinite Warfare', '', '2017-01-23', '13:15:45', NULL, NULL, NULL, NULL, 3, '45.000', 1, '0.000', '0.000', 0, 'cod infinite warfare_ps4.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1),
(4, 'PS20001', 'Resident Evil 4', '', '2017-01-23', '23:41:22', NULL, NULL, NULL, NULL, 1, '10.000', 1, '0.000', '0.000', 0, 'resident-evil-4-ps2.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1),
(5, 'PS20002', 'Black', '', '2017-01-24', '00:06:28', NULL, NULL, NULL, NULL, 1, '5.000', 1, '0.000', '0.000', 0, 'black-ps2.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1),
(6, 'PS30001', 'Beyond two souls', '', '2017-01-24', '00:12:08', '2017-02-04', '10:37:50', NULL, NULL, 1, '250.000', 1, '0.000', '0.000', 0, 'beyond-two-souls.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 1, 0, 1, 1, 1),
(7, 'PS40004', 'The Last Guardian', '', '2017-01-28', '16:21:37', NULL, NULL, NULL, NULL, 3, '54.000', 1, '0.000', '0.000', 0, 'the last guardian_ps4.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 1, 0, 0, 1, 1, 1),
(8, 'PS40005', 'Mafia III', '', '2017-01-28', '17:42:26', NULL, NULL, NULL, NULL, 3, '34.000', 1, '0.000', '0.000', 0, 'mafia3_ps4.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 1, 0, 0, 1, 1, 1),
(9, 'PS20003', 'Grand theft auto - san andreas', '', '2017-01-28', '17:46:55', '2017-01-28', '17:47:03', NULL, NULL, 1, '5.000', 1, '0.000', '0.000', 0, 'gta-san-andreas.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 1, 0, 0, 1, 1, 1),
(10, 'PS30002', 'Mortal Kombat 9', '', '2017-02-03', '10:04:16', '2017-02-04', '10:38:17', NULL, NULL, 1, '250.000', 1, '0.000', '0.000', 0, 'mk9 ps3.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1),
(11, 'PS30003', 'Call of duty: Modern warfare 3', '', '2017-02-03', '10:07:04', '2017-02-05', '00:49:58', NULL, NULL, 1, '250.000', 1, '0.000', '0.000', 0, 'cod modern warfare 3 ps3.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 1, 0, 1, 1, 1),
(12, '3600001', 'Gears of war 3', '', '2017-02-03', '10:12:16', NULL, NULL, NULL, NULL, 1, '300.000', 1, '0.000', '0.000', 0, 'gear_of_war3_xbox.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1),
(13, 'P3A0001', 'Joystick Sony Dualshock 3', '', '2017-02-04', '10:13:52', '2017-02-04', '10:14:00', NULL, NULL, 1, '700.000', 1, '0.000', '0.000', 0, 'dualshock3.jpg', '', '', 0, 0, 1, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbprov`
--

CREATE TABLE IF NOT EXISTS `tbprov` (
  `idProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Dom` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Loc` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cp` varchar(10) DEFAULT NULL,
  `Prov` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cuit` varchar(30) DEFAULT NULL,
  `Tel` varchar(30) DEFAULT NULL,
  `Tel2` varchar(30) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `FechaAlta` datetime DEFAULT NULL,
  `FechaMod` datetime DEFAULT NULL,
  `Activo` int(11) DEFAULT '1',
  `Observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `AvisoEmergente` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Website` varchar(150) DEFAULT NULL,
  `Pais` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idCondFiscal` int(11) DEFAULT '0',
  `idMoneda` int(11) DEFAULT '0',
  PRIMARY KEY (`idProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbprov_marcas`
--

CREATE TABLE IF NOT EXISTS `tbprov_marcas` (
  `contador` int(11) NOT NULL AUTO_INCREMENT,
  `idProveedor` int(11) NOT NULL,
  `idMarca` int(11) NOT NULL,
  PRIMARY KEY (`contador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro_categorias`
--

CREATE TABLE IF NOT EXISTS `tbpro_categorias` (
  `Contador` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `Principal` int(11) DEFAULT '0',
  PRIMARY KEY (`Contador`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `tbpro_categorias`
--

INSERT INTO `tbpro_categorias` (`Contador`, `idProducto`, `idCategoria`, `Principal`) VALUES
(1, 1, 67, 1),
(2, 2, 67, 1),
(3, 3, 67, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 69, 1),
(7, 7, 67, 1),
(8, 8, 67, 1),
(9, 9, 1, 1),
(10, 10, 69, 1),
(11, 11, 69, 1),
(12, 12, 2, 1),
(13, 13, 68, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro_ficha`
--

CREATE TABLE IF NOT EXISTS `tbpro_ficha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT NULL,
  `idFicha` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro_iva`
--

CREATE TABLE IF NOT EXISTS `tbpro_iva` (
  `idIva` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` decimal(19,3) DEFAULT '0.000',
  `Pordefecto` int(11) DEFAULT '0',
  PRIMARY KEY (`idIva`),
  KEY `IdIva` (`idIva`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tbpro_iva`
--

INSERT INTO `tbpro_iva` (`idIva`, `Nombre`, `Descripcion`, `Porcentaje`, `Pordefecto`) VALUES
(1, '21%', '21%', '21.000', 1),
(2, '10,5%', '10,5%', '10.500', 0),
(3, 'Sin asignar', 'Sin asignar', '0.000', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro_juegos`
--

CREATE TABLE IF NOT EXISTS `tbpro_juegos` (
  `Contador` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT NULL,
  `Idioma` int(11) DEFAULT NULL,
  `Camara` int(11) DEFAULT NULL,
  `CantJugadores` int(11) DEFAULT '0',
  `Ano` int(11) DEFAULT '0',
  `Norma_Region` int(11) DEFAULT NULL,
  `SelectFreq` int(11) DEFAULT '0',
  `SelectIdioma` int(11) DEFAULT '0',
  `Red` int(11) DEFAULT '0',
  `Accesorio` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `LinkWeb` longtext CHARACTER SET utf8,
  PRIMARY KEY (`Contador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro_precios`
--

CREATE TABLE IF NOT EXISTS `tbpro_precios` (
  `Contador` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT '0',
  `Margen` decimal(19,3) DEFAULT '0.000',
  `idLista` int(11) DEFAULT NULL,
  PRIMARY KEY (`Contador`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Volcado de datos para la tabla `tbpro_precios`
--

INSERT INTO `tbpro_precios` (`Contador`, `idProducto`, `Margen`, `idLista`) VALUES
(1, 1, '47.929', 1),
(2, 1, '42.828', 2),
(3, 1, '40.788', 3),
(4, 1, '22.424', 4),
(5, 2, '47.929', 1),
(6, 2, '35.000', 2),
(7, 2, '28.000', 3),
(8, 2, '20.000', 4),
(9, 3, '77.515', 1),
(10, 3, '70.940', 2),
(11, 3, '70.940', 3),
(12, 3, '51.216', 4),
(13, 4, '150.000', 1),
(14, 4, '150.000', 2),
(15, 4, '20.000', 3),
(16, 4, '20.000', 4),
(17, 5, '400.000', 1),
(18, 5, '400.000', 2),
(19, 5, '140.000', 3),
(20, 5, '140.000', 4),
(21, 6, '92.000', 1),
(22, 6, '92.000', 2),
(23, 6, '39.227', 3),
(24, 6, '32.266', 4),
(25, 7, '42.450', 1),
(26, 7, '40.259', 2),
(27, 7, '31.492', 3),
(28, 7, '20.000', 4),
(29, 8, '56.631', 1),
(30, 8, '53.150', 2),
(31, 8, '53.150', 3),
(32, 8, '47.929', 4),
(33, 9, '400.000', 1),
(34, 9, '400.000', 2),
(35, 9, '140.000', 3),
(36, 9, '140.000', 4),
(37, 10, '50.000', 1),
(38, 10, '35.000', 2),
(39, 10, '28.000', 3),
(40, 10, '20.000', 4),
(41, 11, '80.000', 1),
(42, 11, '80.000', 2),
(43, 11, '60.000', 3),
(44, 11, '60.000', 4),
(45, 12, '50.000', 1),
(46, 12, '35.000', 2),
(47, 12, '28.000', 3),
(48, 12, '20.000', 4),
(49, 13, '71.429', 1),
(50, 13, '35.000', 2),
(51, 13, '28.000', 3),
(52, 13, '20.000', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro_promo`
--

CREATE TABLE IF NOT EXISTS `tbpro_promo` (
  `idPromo` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idCategoria` int(11) DEFAULT '0',
  `idProducto` int(11) DEFAULT '0',
  `Cantidad` int(11) DEFAULT '0',
  `AfectaTodos` int(11) DEFAULT '1',
  `pDescuento` decimal(19,3) DEFAULT '0.000',
  `Fecha` datetime DEFAULT NULL,
  `Activa` int(11) DEFAULT '1',
  `idLista` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPromo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro_series`
--

CREATE TABLE IF NOT EXISTS `tbpro_series` (
  `Contador` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT NULL,
  `idDoc` int(11) DEFAULT NULL,
  `Serie` varchar(30) DEFAULT NULL,
  `Activo` int(11) DEFAULT '1',
  PRIMARY KEY (`Contador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro_stock`
--

CREATE TABLE IF NOT EXISTS `tbpro_stock` (
  `Contador` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT '0',
  `idDeposito` int(11) DEFAULT '0',
  `Stock` int(11) DEFAULT '0',
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  `StockMin` int(11) DEFAULT '0',
  `StockMax` int(11) DEFAULT '0',
  PRIMARY KEY (`Contador`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `tbpro_stock`
--

INSERT INTO `tbpro_stock` (`Contador`, `idProducto`, `idDeposito`, `Stock`, `FechaMod`, `HoraMod`, `StockMin`, `StockMax`) VALUES
(1, 1, 1, 2, '2017-01-23', '11:34:43', 0, 0),
(2, 1, 2, 2, '2017-01-23', '11:34:43', 0, 0),
(3, 2, 1, 5, '2017-01-23', '23:07:23', 0, 0),
(4, 2, 2, 5, '2017-01-23', '23:07:23', 0, 0),
(5, 3, 1, 3, '2017-01-23', '13:15:45', 4, 5),
(6, 3, 2, 4, '2017-01-23', '13:15:45', 5, 6),
(7, 4, 1, 22, '2017-01-23', '23:41:22', 0, 0),
(8, 4, 2, 12, '2017-01-23', '23:41:22', 0, 0),
(9, 5, 1, 3, '2017-01-24', '00:06:28', 4, 5),
(10, 5, 2, 5, '2017-01-24', '00:06:28', 4, 2),
(11, 6, 2, 0, '2017-02-04', '10:37:50', 0, 0),
(12, 6, 2, 0, '2017-02-04', '10:37:50', 0, 0),
(13, 7, 1, 3, '2017-01-28', '16:21:38', 1, 5),
(14, 7, 2, 2, '2017-01-28', '16:21:38', 1, 2),
(15, 8, 1, 2, '2017-01-28', '17:42:27', 1, 3),
(16, 8, 2, 1, '2017-01-28', '17:42:27', 1, 4),
(17, 9, 1, 1, '2017-01-28', '17:47:03', 3, 6),
(18, 9, 2, 1, '2017-01-28', '17:47:03', 3, 6),
(19, 10, 2, 5, '2017-02-04', '10:38:17', 6, 7),
(20, 10, 2, 5, '2017-02-04', '10:38:17', 6, 7),
(21, 11, 2, 0, '2017-02-05', '00:49:58', 0, 0),
(22, 11, 2, 0, '2017-02-05', '00:49:58', 0, 0),
(23, 12, 1, 0, '2017-02-03', '10:12:16', 0, 0),
(24, 12, 2, 0, '2017-02-03', '10:12:16', 0, 0),
(25, 13, 2, 0, '2017-02-04', '10:14:00', 0, 0),
(26, 13, 2, 0, '2017-02-04', '10:14:00', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpro_tipo`
--

CREATE TABLE IF NOT EXISTS `tbpro_tipo` (
  `idTipo` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Stock` int(11) DEFAULT '0',
  `Juego` int(11) DEFAULT '0',
  PRIMARY KEY (`idTipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tbpro_tipo`
--

INSERT INTO `tbpro_tipo` (`idTipo`, `Descripcion`, `Stock`, `Juego`) VALUES
(1, 'GENERAL', 1, 0),
(2, 'JUEGO', 1, 1),
(3, 'SERVICIO', 0, 0),
(4, 'TALLER', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbrep`
--

CREATE TABLE IF NOT EXISTS `tbrep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idEquipo` int(11) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idLista` int(11) DEFAULT NULL,
  `Razonsocial` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Dom` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
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
  `Falladeclarada` varchar(400) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Observaciones` varchar(600) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Observacionespriv` varchar(600) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Accesorios` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbrep_detalle`
--

CREATE TABLE IF NOT EXISTS `tbrep_detalle` (
  `Contador` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `Codigo` varchar(20) DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Serie` varchar(100) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `pDescuento` decimal(19,3) DEFAULT NULL,
  `Precio` decimal(19,3) DEFAULT NULL,
  `Total` decimal(19,3) DEFAULT NULL,
  `pIva` decimal(19,3) DEFAULT NULL,
  `Costo` decimal(19,3) DEFAULT NULL,
  `idDeposito` int(11) DEFAULT NULL,
  `Promociones` int(11) DEFAULT NULL,
  PRIMARY KEY (`Contador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbrep_equipos`
--

CREATE TABLE IF NOT EXISTS `tbrep_equipos` (
  `idEquipo` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT NULL,
  `Serie` varchar(100) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `FechaIngreso` date DEFAULT NULL,
  `Horaingreso` time DEFAULT NULL,
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  PRIMARY KEY (`idEquipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbrep_estados`
--

CREATE TABLE IF NOT EXISTS `tbrep_estados` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbrep_eventos`
--

CREATE TABLE IF NOT EXISTS `tbrep_eventos` (
  `Contador` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  `Descripcion` varchar(400) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Notificado` int(11) DEFAULT '0',
  PRIMARY KEY (`Contador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbsucursal`
--

CREATE TABLE IF NOT EXISTS `tbsucursal` (
  `idSucursal` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Telefono` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idSucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbusuarios`
--

CREATE TABLE IF NOT EXISTS `tbusuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Login` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Pass` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `NivelAcceso` int(11) DEFAULT '0',
  `Dom` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Loc` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cp` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `Prov` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Dni` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `Tel` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `Tel2` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `Sexo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
  `FechaAlta` date DEFAULT NULL,
  `HoraAlta` time DEFAULT NULL,
  `FechaMod` date DEFAULT NULL,
  `HoraMod` time DEFAULT NULL,
  `Estado` int(11) DEFAULT '0',
  `Observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `AvisoEmergente` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `KeyReg` varchar(120) CHARACTER SET utf8 DEFAULT '' COMMENT 'se utiliza para activar el usuario o para la recup de contraseña',
  `NewPass` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'para retener la contraseña nueva durante un lostpass',
  `Foto` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `Ip` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `FechaLog` date DEFAULT NULL,
  `HoraLog` time DEFAULT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `tbusuarios`
--

INSERT INTO `tbusuarios` (`idUsuario`, `Nombre`, `Login`, `Email`, `Pass`, `NivelAcceso`, `Dom`, `Loc`, `Cp`, `Prov`, `Dni`, `Tel`, `Tel2`, `FechaNacimiento`, `Sexo`, `FechaAlta`, `HoraAlta`, `FechaMod`, `HoraMod`, `Estado`, `Observaciones`, `AvisoEmergente`, `KeyReg`, `NewPass`, `Foto`, `Ip`, `FechaLog`, `HoraLog`) VALUES
(2, 'Sol', 'soledad', 'sol_mp1@hotmail.com', 'c56d0e9a7ccec67b4ea131655038d604', 3, 'Mitre 2121', 'merlo', '1716', 'buenos aires', '30302012', '1566778899', '23423', '1983-03-12', 'F', '2012-04-30', '00:00:00', '2013-04-21', '18:00:45', 1, 'sin comentarios', 'solucion fisiológica', '', '', '', '', '0000-00-00', '00:00:00'),
(5, 'pablo molinas', 'resident', 'pablo@yahoo.com.ar', 'c0784027b45aa11e848a38e890f8416c', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '0000-00-00', NULL, '2016-12-29', '23:14:53', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL),
(6, 'soledad cordero', 'solmp1', 'solmp1@hotmail.com', 'c0784027b45aa11e848a38e890f8416c', 5, NULL, NULL, NULL, NULL, '', NULL, NULL, '0000-00-00', NULL, '2016-12-30', '00:00:50', NULL, NULL, 1, NULL, NULL, '', '', NULL, NULL, NULL, NULL),
(7, 'soledad cordero', 'solecordero', 'pablo@yahoo.com.ar', '30664dd20fdca429447962da9cdb80c1', 1, NULL, NULL, NULL, NULL, '', NULL, NULL, '0000-00-00', NULL, '2016-12-30', '00:15:50', NULL, NULL, 0, NULL, NULL, '', '', NULL, NULL, NULL, NULL),
(10, 'pablo molinas', 'pablo', 'pablo4209m@gmail.com', '65402f90ef3ceb04c9a50fe3b5aa895d', 10, 'mitre 2121', 'libertad', '1716', 'bs as', '29051614', '2343123432', '22222222', '0000-00-00', '', '2016-12-30', '11:08:23', '2017-01-25', '19:16:30', 1, NULL, NULL, '', '', NULL, NULL, NULL, NULL),
(11, 'Soledad Cordero', 'solita', 'digitalstoremerlo@gmail.com', '08dbdcd72b13c9632358bca48e3f300f', 1, NULL, NULL, NULL, NULL, '30046928', NULL, NULL, '0000-00-00', NULL, '2017-01-05', '23:09:09', NULL, NULL, 1, NULL, NULL, '', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbusuarios_nivel`
--

CREATE TABLE IF NOT EXISTS `tbusuarios_nivel` (
  `idNivel` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `NivelAcceso` int(11) DEFAULT '0',
  PRIMARY KEY (`idNivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
