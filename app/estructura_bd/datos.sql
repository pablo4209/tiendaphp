-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-02-2018 a las 12:34:52
-- Versión del servidor: 5.7.21-0ubuntu0.17.10.1
-- Versión de PHP: 7.1.11-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



--
-- Volcado de datos para la tabla `tbmoneda`
--

INSERT INTO `tbmoneda` (`idMoneda`, `Nombre`, `Cambio`, `Simbolo`, `FechaAlta`, `HoraAlta`, `FechaMod`, `HoraMod`, `idEntidad`, `Habilitada`, `Principal`, `Web`) VALUES
(1, 'Peso(s)', '1.000', '$', '2011-02-09', NULL, '2017-12-28', '08:35:12', NULL, 1, 1, 0),
(2, 'Dólar(es)', '8.300', 'U$S', '2011-02-09', NULL, '2017-12-28', '09:09:28', NULL, 1, 0, 0),
(3, 'Dolar2', '19.300', '$$', '2013-10-18', NULL, '2017-12-28', '09:20:04', NULL, 1, 0, 0);



--
-- Volcado de datos para la tabla `tblistas`
--

INSERT INTO `tblistas` (`idLista`, `Nombre`, `Descripcion`, `Ivaincl`, `Margen`, `Habilitada`, `NivelAcceso`, `Pordefecto`) VALUES
(1, 'Lista 1', 'Lista 1', 1, '50.000', 1, 0, 1),
(2, 'Lista 2', 'Lista 2', 1, '35.000', 1, 0, 0);

--
-- Volcado de datos para la tabla `tbdoc_tipo`
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



--
-- Volcado de datos para la tabla `tbpro_iva`
--

INSERT INTO `tbpro_iva` (`idIva`, `Nombre`, `Descripcion`, `Porcentaje`, `Pordefecto`) VALUES
(1, '21%', '21%', '21.000', 1),
(2, '10,5%', '10,5%', '10.500', 0),
(3, 'Sin asignar', 'Sin asignar', '0.000', 0);

--
-- Volcado de datos para la tabla `tbentidad_tipo`
--

INSERT INTO `tbentidad_tipo` (`idEntidadTipo`, `Nombre`) VALUES
(1, 'Usuario'),
(2, 'Proveedor'),
(3, 'Cliente');

--
-- Volcado de datos para la tabla `tbentidad_nivel`
--

INSERT INTO `tbentidad_nivel` (`idNivelAcceso`, `Nombre`, `Descripcion`, `Nivel`) VALUES
(1, 'Nivel 1', 'acceso con permisos de cliente/proveedor', 1),
(2, 'Nivel 2', 'Acceso con nivel de operador', 5),
(3, 'Nivel 3 (Admin)', 'Acceso nivel administrador', 50),
(4, 'Nivel 4 (debug)', 'Acceso nivel desarrollador', 100);


--
-- Volcado de datos para la tabla `tbentidad`
--

INSERT INTO `tbentidad` (`idEntidad`, `idEntidadTipo`, `Nombre`, `Razonsocial`, `Email`, `Dom`, `Domentrega`, `Loc`, `Cp`, `Prov`, `Cuit`, `Dni`, `Tel`, `Tel2`, `FechaNacimiento`, `Sexo`, `idCondFiscal`, `FechaAlta`, `HoraAlta`, `FechaMod`, `HoraMod`, `Estado`, `Observaciones`, `AvisoEmergente`, `Foto`, `Website`, `idMoneda`, `Login`, `Pass`, `KeyReg`, `NewPass`, `idNivelAcceso`, `ip`, `FechaLog`, `HoraLog`) VALUES (NULL, '1', 'Pablo', NULL, 'pablo4209m@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '0', 'pablo', '65402f90ef3ceb04c9a50fe3b5aa895d', NULL, NULL, '4', NULL, NULL, NULL);



--
-- Volcado de datos para la tabla `tbpro_tipo`
--

INSERT INTO `tbpro_tipo` (`idTipo`, `Descripcion`, `Stock`, `Juego`) VALUES
(1, 'GENERAL', 1, 0),
(2, 'JUEGO', 1, 1),
(3, 'SERVICIO', 0, 0),
(4, 'TALLER', 0, 0);


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
(73, 'Accesorios', '', 2, '2017-02-05', '01:13:52', 'XBOX360/', 'XBA', -2147483643, 1),
(74, 'Coleccion', '', 0, '2017-12-05', '00:27:10', '', 'COL', -2147483643, 1);



--
-- Volcado de datos para la tabla `tbpro`
--

INSERT INTO `tbpro` (`idProducto`, `Codigo`, `Nombre`, `SEO`, `FechaIngreso`, `HoraIngreso`, `FechaMod`, `HoraMod`, `FechaUltVenta`, `HoraUltVenta`, `idMoneda`, `Costo`, `UnidxDef`, `MaxDescuento`, `pDescuento`, `Vendidas`, `Imagen`, `CodBar`, `CodBar2`, `idMarca`, `idPadre`, `idTipo`, `idIva`, `Garantia`, `Descripcion`, `Nota`, `NotaEmerg`, `Publicar`, `Destacado`, `Marcado`, `Usado`, `Reparable`, `VenderSinStock`, `Promociones`, `Habilitado`, `ImponerPrecio`) VALUES
(1, 'PS40001', 'Fifa 17', '', '2017-01-23', '11:33:15', '2017-01-23', '11:34:42', NULL, NULL, 3, '58.000', 1, '0.000', '0.000', 0, 'fifa 17_ps4.jpg', '', '', 0, 0, 2, 3, 0, '', '', 0, 1, 1, 0, 0, 0, 1, 1, 1, 1),
(2, 'PS40002', 'Battlefield 1', '', '2017-01-23', '12:58:01', '2017-12-09', '07:36:51', NULL, NULL, 3, '56.000', 1, '0.000', '0.000', 0, 'battlefield1_ps4.jpg', '', '', 0, NULL, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1, 0),
(3, 'PS40003', 'Call of Duty - Infinite Warfare', '', '2017-01-23', '13:15:45', '2017-12-20', '09:16:32', NULL, NULL, 3, '45.000', 3, '0.000', '0.000', 0, 'cod infinite warfare_ps4.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1, 1),
(4, 'PS20001', 'Resident Evil 4', '', '2017-01-23', '23:41:22', NULL, NULL, NULL, NULL, 1, '10.000', 1, '0.000', '0.000', 0, 'resident-evil-4-ps2.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1, 1),
(5, 'PS20002', 'Black', '', '2017-01-24', '00:06:28', '2017-12-10', '09:50:48', NULL, NULL, 1, '5.000', 1, '0.000', '0.000', 0, 'black-ps2.jpg', '', '', 0, NULL, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1, 1),
(6, 'PS30001', 'Beyond two souls', '', '2017-01-24', '00:12:08', '2017-12-01', '14:14:14', NULL, NULL, 1, '250.000', 1, '0.000', '0.000', 0, 'beyond-two-souls.jpg', '', '', 0, NULL, 2, 3, 0, '', '', 1, 1, 1, 0, 1, 0, 1, 1, 1, 1),
(7, 'PS40004', 'The Last Guardian', '', '2017-01-28', '16:21:37', NULL, NULL, NULL, NULL, 3, '54.000', 1, '0.000', '0.000', 0, 'the last guardian_ps4.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 1, 0, 0, 1, 1, 1, 1),
(8, 'PS40005', 'Mafia III', '', '2017-01-28', '17:42:26', NULL, NULL, NULL, NULL, 3, '34.000', 1, '0.000', '0.000', 0, 'mafia3_ps4.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 1, 0, 0, 1, 1, 1, 1),
(9, 'PS20003', 'Grand theft auto - san andreas', '', '2017-01-28', '17:46:55', '2017-01-28', '17:47:03', NULL, NULL, 1, '5.000', 1, '0.000', '0.000', 0, 'gta-san-andreas.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 1, 0, 0, 1, 1, 1, 1),
(10, 'PS30002', 'Mortal Kombat 9', '', '2017-02-03', '10:04:16', '2017-02-04', '10:38:17', NULL, NULL, 1, '250.000', 1, '0.000', '0.000', 0, 'mk9 ps3.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1, 1),
(11, 'PS30003', 'Call of duty: Modern warfare 3', '', '2017-02-03', '10:07:04', '2017-02-05', '00:49:58', NULL, NULL, 1, '250.000', 1, '0.000', '0.000', 0, 'cod modern warfare 3 ps3.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 1, 0, 1, 1, 1, 1),
(12, '3600001', 'Gears of war 3', '', '2017-02-03', '10:12:16', NULL, NULL, NULL, NULL, 1, '300.000', 1, '0.000', '0.000', 0, 'gear_of_war3_xbox.jpg', '', '', 0, 0, 2, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1, 1),
(13, 'P3A0001', 'Joystick Sony Dualshock 3', '', '2017-02-04', '10:13:52', '2017-02-04', '10:14:00', NULL, NULL, 1, '700.000', 1, '0.000', '0.000', 0, 'dualshock3.jpg', '', '', 0, 0, 1, 3, 0, '', '', 1, 1, 1, 0, 0, 0, 1, 1, 1, 1),
(14, 'RMR0001', 'Remeras estampadas', '', '2017-11-17', '20:40:57', '2017-12-12', '02:16:52', NULL, NULL, 1, '100.000', 1, '0.000', '0.000', 0, '', '', '', 0, 0, 1, 1, 0, '', '', 1, 1, 0, 0, 0, 0, 1, 0, 1, 1),
(15, 'RMR0001-M', 'TALLE M', '', '2017-11-28', '01:26:57', NULL, NULL, NULL, NULL, 1, '0.000', 1, '0.000', '0.000', 0, '', '', '', 0, 14, 1, 1, 0, '', '', 1, 1, 0, 0, 0, 0, 1, 1, 1, 0),
(16, 'RMR0001-L', 'TALLE L', '', '2017-11-28', '01:28:03', '2017-12-13', '23:34:32', NULL, NULL, 0, '0.000', 1, '0.000', '0.000', 0, '', '', '', 0, 14, 1, 0, 0, '', '', 1, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(17, 'RMR0001-XL', 'TALLE XL', '', '2017-12-01', '08:48:02', '2017-12-10', '09:53:12', NULL, NULL, 1, '0.000', 1, '0.000', '0.000', 0, '', '', '', 0, 14, 1, 1, 0, '', '', 1, 1, 0, 0, 0, 0, 1, 1, NULL, 0),
(18, 'COL0001', 'Gorra', '', '2017-12-05', '00:29:08', NULL, NULL, NULL, NULL, 1, '50.000', 1, '0.000', '0.000', 0, '', '', '', 0, 0, 1, 3, 0, '', '', 1, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(19, 'COL0001-1', 'Call of duty: Black Ops 2', '', '2017-12-05', '00:30:47', NULL, NULL, NULL, NULL, 1, '0.000', 1, '0.000', '0.000', 0, '', '', '', 0, 18, 1, 1, 0, '', '', 1, 1, 0, 0, 0, 0, 1, 1, 1, 0),
(20, 'PS40002-2', 'Usado, buenas condiciones', '', '2017-12-09', '07:38:34', NULL, NULL, NULL, NULL, 1, '50.000', 1, '0.000', '0.000', 0, '', '32423654565645654654', '', 0, 2, 1, 1, 0, '', '', 1, 1, 0, 0, 1, 0, 1, 1, 1, 0),
(21, 'RMR0001-S', 'TALLE S', '', '2017-12-12', '14:43:10', '2017-12-13', '23:34:17', NULL, NULL, 0, '0.000', 1, '0.000', '0.000', 0, '', '', '', 0, 14, 1, 0, 0, '', '', 1, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(22, 'asdf', 'asdf', '', '2017-12-28', '09:47:24', '2017-12-29', '17:40:20', NULL, NULL, 1, '34.000', 1, '0.000', '0.000', 0, '', '', '', 0, 0, 1, 1, 0, '', '', 1, 1, 0, 0, 0, 0, 1, 1, 1, 1);



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
(13, 13, 68, 1),
(14, 14, 15, 1),
(15, 18, 74, 1),
(16, 2, 62, 0);


--
-- Volcado de datos para la tabla `tbpro_stock`
--

INSERT INTO `tbpro_stock` (`Contador`, `idProducto`, `idDeposito`, `Stock_consolidado`, `FechaMod`, `HoraMod`, `StockMin`, `StockMax`) VALUES
(1, 1, 1, 2, '2017-01-23', '11:34:43', 0, 0),
(2, 1, 2, 2, '2017-01-23', '11:34:43', 0, 0),
(3, 2, 2, 5, '2017-12-09', '07:36:51', 0, 0),
(4, 2, 1, 5, '2017-12-09', '07:36:51', 0, 0),
(5, 3, 1, 3, '2017-12-20', '09:16:32', 4, 5),
(6, 3, 2, 11, '2017-12-20', '09:16:32', 41, 55),
(7, 4, 1, 22, '2017-01-23', '23:41:22', 0, 0),
(8, 4, 2, 12, '2017-01-23', '23:41:22', 0, 0),
(9, 5, 2, 5, '2017-12-10', '09:50:48', 4, 2),
(10, 5, 1, 5, '2017-12-10', '09:50:48', 4, 2),
(11, 6, 2, 0, '2017-12-01', '14:14:14', 0, 0),
(12, 6, 2, 0, '2017-12-01', '14:14:14', 0, 0),
(13, 7, 1, 3, '2017-01-28', '16:21:38', 1, 5),
(14, 7, 2, 2, '2017-01-28', '16:21:38', 1, 2),
(15, 8, 1, 2, '2017-01-28', '17:42:27', 1, 3),
(16, 8, 2, 1, '2017-01-28', '17:42:27', 1, 4),
(17, 9, 1, 1, '2017-01-28', '17:47:03', 3, 6),
(18, 9, 2, 1, '2017-01-28', '17:47:03', 3, 6),
(19, 10, 2, 5, '2017-02-04', '10:38:17', 6, 7),
(20, 10, 1, 5, '2017-02-04', '10:38:17', 6, 7),
(21, 11, 2, 0, '2017-02-05', '00:49:58', 0, 0),
(22, 11, 1, 0, '2017-02-05', '00:49:58', 0, 0),
(23, 12, 1, 0, '2017-02-03', '10:12:16', 0, 0),
(24, 12, 2, 0, '2017-02-03', '10:12:16', 0, 0),
(25, 13, 2, 0, '2017-02-04', '10:14:00', 0, 0),
(26, 13, 1, 0, '2017-02-04', '10:14:00', 0, 0),
(27, 14, 2, 1, '2017-12-12', '02:16:52', 0, 0),
(28, 14, 1, 1, '2017-12-12', '02:16:52', 0, 0),
(29, 15, 1, 0, '2017-11-28', '01:26:57', 0, 0),
(30, 15, 2, 0, '2017-11-28', '01:26:57', 0, 0),
(31, 16, 2, 44, '2017-12-13', '23:34:32', 0, 0),
(32, 16, 1, 2, '2017-12-13', '23:34:32', 0, 0),
(33, 17, 2, 0, '2017-12-10', '09:53:12', 0, 0),
(34, 17, 1, 0, '2017-12-10', '09:53:12', 0, 0),
(35, 18, 1, 0, '2017-12-05', '00:29:08', 0, 0),
(36, 18, 2, 0, '2017-12-05', '00:29:08', 0, 0),
(37, 19, 1, 0, '2017-12-05', '00:30:47', 0, 0),
(38, 19, 2, 0, '2017-12-05', '00:30:47', 0, 0),
(39, 20, 1, 1, '2017-12-09', '07:38:34', 0, 0),
(40, 20, 2, 0, '2017-12-09', '07:38:34', 0, 0),
(41, 21, 2, 2, '2017-12-13', '23:34:17', 44, 66),
(42, 21, 1, 22, '2017-12-13', '23:34:17', 33, 55),
(43, 22, 1, 0, '2017-12-29', '17:40:20', 0, 0),
(44, 22, 2, 0, '2017-12-29', '17:40:20', 0, 0);




--
-- Volcado de datos para la tabla `tbpro_precios`
--

INSERT INTO `tbpro_precios` (`Contador`, `idProducto`, `Margen`, `idLista`) VALUES
(1, 1, '47.929', 1),
(2, 1, '42.828', 2),
(65, 20, '98.347', 1),
(5, 2, '47.929', 1),
(6, 2, '35.000', 2),
(64, 19, '35.000', 2),
(9, 3, '30.178', 1),
(10, 3, '24.918', 2),
(63, 19, '50.000', 1),
(13, 4, '150.000', 1),
(14, 4, '150.000', 2),
(62, 18, '35.000', 2),
(17, 5, '400.000', 1),
(18, 5, '400.000', 2),
(61, 18, '50.000', 1),
(21, 6, '100.000', 1),
(22, 6, '92.000', 2),
(60, 17, '35.000', 2),
(25, 7, '42.450', 1),
(26, 7, '40.259', 2),
(59, 17, '50.000', 1),
(29, 8, '56.631', 1),
(30, 8, '53.150', 2),
(58, 16, '35.000', 2),
(33, 9, '400.000', 1),
(34, 9, '400.000', 2),
(57, 16, '50.000', 1),
(37, 10, '50.000', 1),
(38, 10, '35.000', 2),
(56, 15, '35.000', 2),
(41, 11, '80.000', 1),
(42, 11, '80.000', 2),
(68, 22, '60.000', 2),
(55, 15, '50.000', 1),
(45, 12, '50.000', 1),
(46, 12, '35.000', 2),
(67, 22, '54.000', 1),
(54, 14, '23.967', 2),
(49, 13, '71.429', 1),
(50, 13, '35.000', 2),
(66, 20, '35.000', 2),
(53, 14, '65.289', 1);




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


--
-- Volcado de datos para la tabla `tbdoc_condpago`
--

INSERT INTO `tbdoc_condpago` (`idCondpago`, `Descripcion`, `Efectivo`, `Electronico`, `Pordefecto`) VALUES
(1, 'Contado', 0, 0, 0),
(2, 'Tarjeta de Credito', 0, 0, 0),
(3, 'Tarjeta de Debito', 0, 0, 0);

--
-- Volcado de datos para la tabla `tbcondicionfiscal`
--

INSERT INTO `tbcondicionfiscal` (`idCondFiscal`, `Nombre`, `Descripcion`, `Pordefecto`, `idTipoDoc`) VALUES
(1, 'Consumidor Final', 'Consumidor Final', 0, 1),
(2, 'Responsable Inscripto', 'Responsable Inscripto', 0, 1),
(3, 'Responsable Monotributo', 'Responsable Monotributo', 0, 1),
(4, 'Exento', 'Exento', 0, 1),
(5, '-', '-', 0, 1);



--
-- Volcado de datos para la tabla `tbdep`
--

INSERT INTO `tbdep` (`idDeposito`, `Nombre`, `Descripcion`, `Dom`, `Cp`, `Loc`, `Prov`, `Tel`, `Email`, `Observaciones`, `FechaAlta`, `HoraAlta`, `idSucursal`) VALUES
(1, 'Deposito 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Deposito 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


