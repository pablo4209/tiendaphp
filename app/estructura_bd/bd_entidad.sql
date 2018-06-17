-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema bd_entidad
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bd_entidad
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bd_entidad` DEFAULT CHARACTER SET utf8 ;
USE `bd_entidad` ;

-- -----------------------------------------------------
-- Table `bd_entidad`.`tbentidad_tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbentidad_tipo` (
  `idEntidadTipo` INT NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(120) NULL DEFAULT NULL,
  PRIMARY KEY (`idEntidadTipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbentidad_nivel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbentidad_nivel` (
  `idNivelAcceso` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Nivel` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`idNivelAcceso`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbentidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbentidad` (
  `idEntidad` INT(11) NOT NULL AUTO_INCREMENT,
  `idEntidadTipo` INT(11) NULL DEFAULT '0',
  `Nombre` VARCHAR(120) NULL DEFAULT NULL,
  `Razonsocial` VARCHAR(120) NULL DEFAULT NULL,
  `Email` VARCHAR(100) NULL DEFAULT NULL,
  `Dom` VARCHAR(120) NULL DEFAULT NULL,
  `Domentrega` VARCHAR(120) NULL DEFAULT NULL,
  `Loc` VARCHAR(50) NULL DEFAULT NULL,
  `Cp` VARCHAR(10) NULL DEFAULT NULL,
  `Prov` VARCHAR(40) NULL DEFAULT NULL,
  `Cuit` VARCHAR(30) NULL DEFAULT NULL,
  `Dni` VARCHAR(20) NULL DEFAULT NULL,
  `Tel` VARCHAR(50) NULL DEFAULT NULL,
  `Tel2` VARCHAR(50) NULL DEFAULT NULL,
  `FechaNacimiento` DATE NULL DEFAULT NULL,
  `Sexo` VARCHAR(1) NULL DEFAULT NULL,
  `idCondFiscal` INT(11) NULL DEFAULT '0',
  `FechaAlta` DATE NULL DEFAULT NULL,
  `HoraAlta` TIME NULL DEFAULT NULL,
  `FechaMod` DATE NULL DEFAULT NULL,
  `HoraMod` TIME NULL DEFAULT NULL,
  `Estado` INT(11) NULL DEFAULT '1',
  `Observaciones` TEXT NULL DEFAULT NULL,
  `AvisoEmergente` VARCHAR(200) NULL DEFAULT NULL,
  `Foto` VARCHAR(255) NULL DEFAULT NULL,
  `Website` VARCHAR(150) NULL DEFAULT NULL,
  `idMoneda` INT(11) NULL DEFAULT '0',
  `Login` VARCHAR(100) NULL DEFAULT NULL,
  `Pass` VARCHAR(50) NULL DEFAULT NULL,
  `KeyReg` VARCHAR(120) NULL DEFAULT NULL COMMENT 'es el codigo de verificacion utilizado durante un lost pass o activacion de usuario',
  `NewPass` VARCHAR(50) NULL DEFAULT NULL COMMENT 'se utiliza para retener la contraseña nueva durante un lostpass',
  `idNivelAcceso` INT(11) NULL DEFAULT 0,
  `ip` VARCHAR(20) NULL DEFAULT NULL COMMENT 'se registra ip donde se produjo el ultimo logueo',
  `FechaLog` DATE NULL DEFAULT NULL COMMENT 'registro de inicio de sesion',
  `HoraLog` TIME NULL DEFAULT NULL,
  PRIMARY KEY (`idEntidad`),
  INDEX `idEntidadTipo_idx` (`idEntidadTipo` ASC),
  INDEX `idNivelAcceso_idx` (`idNivelAcceso` ASC),
  CONSTRAINT `fk_ent_idEntidadTipo`
    FOREIGN KEY (`idEntidadTipo`)
    REFERENCES `bd_entidad`.`tbentidad_tipo` (`idEntidadTipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ent_idNivelAcceso`
    FOREIGN KEY (`idNivelAcceso`)
    REFERENCES `bd_entidad`.`tbentidad_nivel` (`idNivelAcceso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbmoneda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbmoneda` (
  `idMoneda` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Cambio` DECIMAL(19,3) NULL DEFAULT '0.000',
  `Simbolo` VARCHAR(10) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `FechaAlta` DATE NULL DEFAULT NULL,
  `HoraAlta` TIME NULL DEFAULT NULL,
  `FechaMod` DATE NULL DEFAULT NULL,
  `HoraMod` TIME NULL DEFAULT NULL,
  `idEntidad` INT(11) NULL DEFAULT NULL,
  `Habilitada` INT(11) NULL DEFAULT '1',
  `Principal` INT(11) NULL DEFAULT '0',
  `Web` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`idMoneda`),
  INDEX `idEntidad_idx` (`idEntidad` ASC),
  CONSTRAINT `fk_mon_idEntidad`
    FOREIGN KEY (`idEntidad`)
    REFERENCES `bd_entidad`.`tbentidad` (`idEntidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbcart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbcart` (
  `idCart` INT(11) NOT NULL AUTO_INCREMENT,
  `idEntidad` INT(11) NOT NULL DEFAULT '0',
  `Fecha` DATE NULL DEFAULT NULL,
  `Hora` TIME NULL DEFAULT NULL,
  `Fechamod` DATE NULL DEFAULT NULL,
  `Horamod` TIME NULL DEFAULT NULL,
  `ip` TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `idEstado` INT(11) NOT NULL DEFAULT '0',
  `idEstadoPago` INT(11) NOT NULL DEFAULT '0',
  `idMoneda` INT(11) NOT NULL DEFAULT '0',
  `CostoTotal` DECIMAL(19,3) NOT NULL DEFAULT '0.000',
  `pDescuento` DECIMAL(19,3) NOT NULL DEFAULT '0.000',
  `TotalIva` DECIMAL(19,3) NOT NULL DEFAULT '0.000',
  `SubTotal` DECIMAL(19,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`idCart`),
  INDEX `idMoneda_idx` (`idMoneda` ASC),
  INDEX `idEntidad_idx` (`idEntidad` ASC),
  CONSTRAINT `fk_cart_idMoneda`
    FOREIGN KEY (`idMoneda`)
    REFERENCES `bd_entidad`.`tbmoneda` (`idMoneda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cart_idEntidad`
    FOREIGN KEY (`idEntidad`)
    REFERENCES `bd_entidad`.`tbentidad` (`idEntidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro_iva`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro_iva` (
  `idIva` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Porcentaje` DECIMAL(19,3) NULL DEFAULT '0.000',
  `Pordefecto` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`idIva`),
  INDEX `IdIva` (`idIva` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbmarcas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbmarcas` (
  `idMarca` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Descripcion` VARCHAR(120) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Habilitada` INT(11) NULL DEFAULT '1',
  PRIMARY KEY (`idMarca`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro_tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro_tipo` (
  `idTipo` INT(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Stock` INT(11) NULL DEFAULT '0',
  `Juego` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`idTipo`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro` (
  `idProducto` INT(11) NOT NULL AUTO_INCREMENT,
  `Codigo` VARCHAR(20) NULL DEFAULT NULL,
  `Nombre` VARCHAR(120) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `SEO` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `FechaIngreso` DATE NULL DEFAULT NULL,
  `HoraIngreso` TIME NULL DEFAULT NULL,
  `FechaMod` DATE NULL DEFAULT NULL,
  `HoraMod` TIME NULL DEFAULT NULL,
  `FechaUltVenta` DATE NULL DEFAULT NULL,
  `HoraUltVenta` TIME NULL DEFAULT NULL,
  `idMoneda` INT(11) NULL DEFAULT NULL,
  `Costo` DECIMAL(19,3) NULL DEFAULT '0.000',
  `UnidxDef` INT(11) NOT NULL DEFAULT '1',
  `MaxDescuento` DECIMAL(19,3) NULL DEFAULT '0.000',
  `pDescuento` DECIMAL(19,3) NULL DEFAULT '0.000',
  `Vendidas` INT(11) NULL DEFAULT '0',
  `Imagen` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `CodBar` VARCHAR(30) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `CodBar2` VARCHAR(30) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `idMarca` INT(11) NULL DEFAULT NULL,
  `idPadre` INT(11) NULL DEFAULT '0' COMMENT 'si !=0 hay que mirar PrecioPropio, util para manejar talles, colores y demas',
  `idTipo` INT(11) NULL DEFAULT '0',
  `idIva` INT(11) NULL DEFAULT '0',
  `Garantia` INT(11) NULL DEFAULT '0',
  `Descripcion` LONGTEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Nota` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `NotaEmerg` INT(11) NULL DEFAULT '0',
  `Publicar` INT(11) NULL DEFAULT '0',
  `Destacado` INT(11) NULL DEFAULT '0',
  `Marcado` INT(11) NULL DEFAULT '0',
  `Usado` INT(11) NULL DEFAULT '0',
  `Reparable` INT(11) NULL DEFAULT '0',
  `VenderSinStock` INT(11) NULL DEFAULT '1',
  `Promociones` INT(11) NULL DEFAULT '1',
  `Habilitado` INT(11) NULL DEFAULT '1',
  `ImponerPrecio` INT(11) NULL DEFAULT 0 COMMENT 'para uso en subproducto, cuando idPadre !=0',
  `ImponerStock` INT(11) NULL DEFAULT 0 COMMENT 'es util cuando los talles o colores solo son a modo informativo para armar el pedido, el stock es unico',
  `Compuesto` INT(11) NULL DEFAULT 0 COMMENT 'si compuesto =1 todos los hijos forman el costo del padre',
  PRIMARY KEY (`idProducto`),
  INDEX `idProducto` (`idProducto` ASC),
  INDEX `idIva_idx` (`idIva` ASC),
  INDEX `idMarca_idx` (`idMarca` ASC),
  INDEX `idTipo_idx` (`idTipo` ASC),
  INDEX `idMoneda_idx` (`idMoneda` ASC),
  CONSTRAINT `fk_pro_idIva`
    FOREIGN KEY (`idIva`)
    REFERENCES `bd_entidad`.`tbpro_iva` (`idIva`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pro_idMarca`
    FOREIGN KEY (`idMarca`)
    REFERENCES `bd_entidad`.`tbmarcas` (`idMarca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pro_idTipo`
    FOREIGN KEY (`idTipo`)
    REFERENCES `bd_entidad`.`tbpro_tipo` (`idTipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pro_idMoneda`
    FOREIGN KEY (`idMoneda`)
    REFERENCES `bd_entidad`.`tbmoneda` (`idMoneda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbsucursal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbsucursal` (
  `idSucursal` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Direccion` VARCHAR(150) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Telefono` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`idSucursal`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbdep`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbdep` (
  `idDeposito` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Dom` VARCHAR(150) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Cp` VARCHAR(10) NULL DEFAULT NULL,
  `Loc` VARCHAR(30) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Prov` VARCHAR(30) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Tel` VARCHAR(50) NULL DEFAULT NULL,
  `Email` VARCHAR(100) NULL DEFAULT NULL,
  `Observaciones` MEDIUMTEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `FechaAlta` DATE NULL DEFAULT NULL,
  `HoraAlta` TIME NULL DEFAULT NULL,
  `idSucursal` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idDeposito`),
  INDEX `idSucursal_idx` (`idSucursal` ASC),
  CONSTRAINT `fk_dep_idSucursal`
    FOREIGN KEY (`idSucursal`)
    REFERENCES `bd_entidad`.`tbsucursal` (`idSucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbcart_detalle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbcart_detalle` (
  `idItem` INT(11) NOT NULL AUTO_INCREMENT,
  `idCart` INT(11) NOT NULL DEFAULT '0',
  `idProducto` INT(11) NOT NULL DEFAULT '0',
  `Cantidad` INT(11) NOT NULL DEFAULT '0',
  `Serie` TEXT CHARACTER SET 'utf8' NOT NULL,
  `Costo` DECIMAL(19,3) NOT NULL DEFAULT '0.000',
  `pDescuento` DECIMAL(19,3) NOT NULL DEFAULT '0.000',
  `Total` DECIMAL(19,3) NOT NULL DEFAULT '0.000',
  `pIva` DECIMAL(19,3) NOT NULL DEFAULT '0.000',
  `idDeposito` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idItem`),
  INDEX `idCart_idx` (`idCart` ASC),
  INDEX `idProducto_idx` (`idProducto` ASC),
  INDEX `idDeposito_idx` (`idDeposito` ASC),
  CONSTRAINT `fk_cartdet_idCart`
    FOREIGN KEY (`idCart`)
    REFERENCES `bd_entidad`.`tbcart` (`idCart`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartdet_idProducto`
    FOREIGN KEY (`idProducto`)
    REFERENCES `bd_entidad`.`tbpro` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartdet_idDeposito`
    FOREIGN KEY (`idDeposito`)
    REFERENCES `bd_entidad`.`tbdep` (`idDeposito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbcategorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbcategorias` (
  `idCategoria` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `idPadre` INT(11) NULL DEFAULT '0',
  `FechaAlta` DATE NULL DEFAULT NULL,
  `HoraAlta` TIME NULL DEFAULT NULL,
  `ImgPath` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Iniciales` VARCHAR(3) NULL DEFAULT NULL,
  `Color` INT(11) NULL DEFAULT NULL,
  `Publicar` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`idCategoria`),
  INDEX `idCategoria` (`idCategoria` ASC))
ENGINE = MyISAM
AUTO_INCREMENT = 74
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbcondicionfiscal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbcondicionfiscal` (
  `idCondFiscal` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Pordefecto` INT(11) NULL DEFAULT '0',
  `idTipoDoc` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idCondFiscal`),
  INDEX `Id` (`idCondFiscal` ASC))
ENGINE = MyISAM
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbdoc_tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbdoc_tipo` (
  `idTipoDoc` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Letra` VARCHAR(5) NULL DEFAULT NULL,
  `AfectaStock` INT(11) NULL DEFAULT '0',
  `AfectaVendidas` INT(11) NULL DEFAULT '0',
  `Stockresta` INT(11) NULL DEFAULT '0',
  `Color` INT(11) NULL DEFAULT '0',
  `Activo` INT(11) NULL DEFAULT '1',
  `DesglozarIva` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`idTipoDoc`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tblistas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tblistas` (
  `idLista` INT(11) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Ivaincl` INT(11) NULL DEFAULT '1',
  `Margen` DECIMAL(19,3) NULL DEFAULT '0.000',
  `Habilitada` INT(11) NULL DEFAULT '1',
  `NivelAcceso` INT(11) NULL DEFAULT '0',
  `Pordefecto` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`idLista`),
  INDEX `Codigo` (`idLista` ASC))
ENGINE = MyISAM
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbdoc_estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbdoc_estado` (
  `idEstado` INT(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`idEstado`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbdoc_condpago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbdoc_condpago` (
  `idCondpago` INT(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Efectivo` INT(11) NULL DEFAULT '0',
  `Electronico` INT(11) NULL DEFAULT '0',
  `Pordefecto` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`idCondpago`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbdoc`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbdoc` (
  `idDoc` INT(11) NOT NULL AUTO_INCREMENT,
  `idOrden` INT(11) NULL DEFAULT '0',
  `idTipoDoc` INT(11) NULL DEFAULT '0',
  `Fecha` DATE NULL DEFAULT NULL,
  `Hora` TIME NULL DEFAULT NULL,
  `Fechamod` DATE NULL DEFAULT NULL,
  `HoraMod` INT(11) NULL DEFAULT NULL,
  `idDeposito` INT(11) NULL DEFAULT NULL,
  `idUsuario` INT(11) NULL DEFAULT NULL,
  `idEntidad` INT(11) NULL DEFAULT NULL,
  `idLista` INT(11) NULL DEFAULT NULL,
  `idEstado` INT(11) NULL DEFAULT 0,
  `idCondPago` INT(11) NULL DEFAULT 0,
  `CliNom` VARCHAR(120) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `CliDom` VARCHAR(120) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `CliLoc` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `CliCp` VARCHAR(10) NULL DEFAULT NULL,
  `CliProv` VARCHAR(40) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `CliCuit` VARCHAR(20) NULL DEFAULT NULL,
  `CliTel` VARCHAR(30) NULL DEFAULT NULL,
  `CliMail` VARCHAR(100) NULL DEFAULT NULL,
  `idCondfiscal` INT(11) NULL DEFAULT NULL,
  `CostoTotal` DECIMAL(19,3) NULL DEFAULT NULL,
  `pDescuento` DECIMAL(19,3) NULL DEFAULT '0.000',
  `pRecargo` DECIMAL(19,3) NULL DEFAULT '0.000',
  `TotalIva` DECIMAL(19,3) NULL DEFAULT '0.000',
  `SubTotal` DECIMAL(19,3) NULL DEFAULT '0.000',
  `Total` DECIMAL(19,3) NULL DEFAULT '0.000',
  `idMoneda` INT(11) NULL DEFAULT '1',
  `MailNotificaciones` INT(11) NULL DEFAULT '0',
  `Observacion` VARCHAR(200) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `ObsPrivada` VARCHAR(200) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `PtoVenta` INT(11) NULL DEFAULT '0',
  `Unidades` INT(11) NULL DEFAULT '0',
  `Items` INT(11) NULL DEFAULT '0',
  `AfectarVendidas` INT(11) NULL DEFAULT '0',
  `AfectarStock` INT(11) NULL DEFAULT '0',
  `Entregado` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`idDoc`),
  INDEX `idTipoDoc_idx` (`idTipoDoc` ASC),
  INDEX `idDeposito_idx` (`idDeposito` ASC),
  INDEX `idLista_idx` (`idLista` ASC),
  INDEX `idCondFiscal_idx` (`idCondfiscal` ASC),
  INDEX `idMoneda_idx` (`idMoneda` ASC),
  INDEX `idEstado_idx` (`idEstado` ASC),
  INDEX `idCondPago_idx` (`idCondPago` ASC),
  INDEX `idEntidad_idx1` (`idEntidad` ASC),
  INDEX `fk2_idEntidad_idx` (`idUsuario` ASC),
  CONSTRAINT `fk1_idTipoDoc`
    FOREIGN KEY (`idTipoDoc`)
    REFERENCES `bd_entidad`.`tbdoc_tipo` (`idTipoDoc`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk1_idDeposito`
    FOREIGN KEY (`idDeposito`)
    REFERENCES `bd_entidad`.`tbdep` (`idDeposito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk1_idLista`
    FOREIGN KEY (`idLista`)
    REFERENCES `bd_entidad`.`tblistas` (`idLista`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk1_idCondFiscal`
    FOREIGN KEY (`idCondfiscal`)
    REFERENCES `bd_entidad`.`tbcondicionfiscal` (`idCondFiscal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk1_idMoneda`
    FOREIGN KEY (`idMoneda`)
    REFERENCES `bd_entidad`.`tbmoneda` (`idMoneda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk1_idEstado`
    FOREIGN KEY (`idEstado`)
    REFERENCES `bd_entidad`.`tbdoc_estado` (`idEstado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk1_idCondPago`
    FOREIGN KEY (`idCondPago`)
    REFERENCES `bd_entidad`.`tbdoc_condpago` (`idCondpago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk1_idEntidad`
    FOREIGN KEY (`idEntidad`)
    REFERENCES `bd_entidad`.`tbentidad` (`idEntidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk2_idEntidad`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `bd_entidad`.`tbentidad` (`idEntidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbdep_mov`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbdep_mov` (
  `idMov` INT(11) NOT NULL AUTO_INCREMENT,
  `idDoc` INT(11) NULL DEFAULT '0',
  `idProducto` INT(11) NOT NULL,
  `Cantidad` INT(11) NOT NULL DEFAULT 1,
  `idDeposito` INT(11) NULL DEFAULT '0',
  `FechaLog` DATE NULL DEFAULT NULL,
  `HoraLog` TIME NULL DEFAULT NULL,
  `Consolidado` INT(11) NULL DEFAULT 0,
  PRIMARY KEY (`idMov`),
  INDEX `idProducto_idx` (`idProducto` ASC),
  INDEX `idDoc_idx` (`idDoc` ASC),
  INDEX `idDeposito_idx` (`idDeposito` ASC),
  CONSTRAINT `fk_depmov_idProducto`
    FOREIGN KEY (`idProducto`)
    REFERENCES `bd_entidad`.`tbpro` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_depmov_idDoc`
    FOREIGN KEY (`idDoc`)
    REFERENCES `bd_entidad`.`tbdoc` (`idDoc`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_depmov_idDeposito`
    FOREIGN KEY (`idDeposito`)
    REFERENCES `bd_entidad`.`tbdep` (`idDeposito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbdoc_detalle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbdoc_detalle` (
  `idContador` INT(11) NOT NULL AUTO_INCREMENT,
  `idDoc` INT(11) NULL DEFAULT NULL,
  `idProducto` INT(11) NULL DEFAULT NULL,
  `Codigo` VARCHAR(20) NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Serie` VARCHAR(30) NULL DEFAULT NULL,
  `Cantidad` INT(11) NULL DEFAULT '0',
  `pDescuento` DECIMAL(19,3) NULL DEFAULT NULL,
  `Precio` DECIMAL(19,3) NULL DEFAULT '0.000',
  `Total` DECIMAL(19,3) NULL DEFAULT '0.000',
  `pIva` DECIMAL(19,3) NULL DEFAULT '0.000',
  `Costo` DECIMAL(19,3) NULL DEFAULT '0.000',
  `idDeposito` INT(11) NULL DEFAULT '0',
  `Promociones` INT(11) NULL DEFAULT '0',
  `idCategoria` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idContador`),
  INDEX `idDoc_idx` (`idDoc` ASC),
  INDEX `idProducto_idx` (`idProducto` ASC),
  CONSTRAINT `fk2_idDoc`
    FOREIGN KEY (`idDoc`)
    REFERENCES `bd_entidad`.`tbdoc` (`idDoc`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk2_idProducto`
    FOREIGN KEY (`idProducto`)
    REFERENCES `bd_entidad`.`tbpro` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbficha`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbficha` (
  `idFicha` INT(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Descripcioncorta` VARCHAR(25) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `idPadre` INT(11) NULL DEFAULT '0',
  `FechaAlta` DATETIME NULL DEFAULT NULL,
  `FechaMod` DATETIME NULL DEFAULT NULL,
  `Publicar` INT(11) NULL DEFAULT '1',
  PRIMARY KEY (`idFicha`))
ENGINE = InnoDB
AUTO_INCREMENT = 43
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpagos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpagos` (
  `idPago` INT(11) NOT NULL AUTO_INCREMENT,
  `idOrden` INT(11) NULL DEFAULT NULL,
  `Fecha` DATETIME NULL DEFAULT NULL,
  `Pago` DECIMAL(19,3) NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Consolidado` INT(11) NULL DEFAULT '0',
  `idTarjeta` INT(11) NULL DEFAULT NULL,
  `idPlan` INT(11) NULL DEFAULT NULL,
  `Cupon` INT(11) NULL DEFAULT NULL,
  `Lote` INT(11) NULL DEFAULT NULL,
  `Transferencia` VARCHAR(25) NULL DEFAULT NULL,
  PRIMARY KEY (`idPago`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro_categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro_categorias` (
  `Contador` INT(11) NOT NULL AUTO_INCREMENT,
  `idProducto` INT(11) NOT NULL,
  `idCategoria` INT(11) NOT NULL,
  `Principal` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`Contador`),
  INDEX `idProducto_idx` (`idProducto` ASC),
  INDEX `idCategoria_idx` (`idCategoria` ASC),
  CONSTRAINT `fk_procat_idProducto`
    FOREIGN KEY (`idProducto`)
    REFERENCES `bd_entidad`.`tbpro` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_procat_idCategoria`
    FOREIGN KEY (`idCategoria`)
    REFERENCES `bd_entidad`.`tbcategorias` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro_ficha`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro_ficha` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `idProducto` INT(11) NOT NULL,
  `idFicha` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idFicha_idx` (`idFicha` ASC),
  INDEX `idProducto_idx` (`idProducto` ASC),
  CONSTRAINT `fk_proficha_idProducto`
    FOREIGN KEY (`idProducto`)
    REFERENCES `bd_entidad`.`tbpro` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proficha_idFicha`
    FOREIGN KEY (`idFicha`)
    REFERENCES `bd_entidad`.`tbficha` (`idFicha`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro_juegos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro_juegos` (
  `Contador` INT(11) NOT NULL AUTO_INCREMENT,
  `idProducto` INT(11) NULL DEFAULT NULL,
  `Idioma` INT(11) NULL DEFAULT NULL,
  `Camara` INT(11) NULL DEFAULT NULL,
  `CantJugadores` INT(11) NULL DEFAULT '0',
  `Ano` INT(11) NULL DEFAULT '0',
  `Norma_Region` INT(11) NULL DEFAULT NULL,
  `SelectFreq` INT(11) NULL DEFAULT '0',
  `SelectIdioma` INT(11) NULL DEFAULT '0',
  `Red` INT(11) NULL DEFAULT '0',
  `Accesorio` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `LinkWeb` LONGTEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`Contador`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro_precios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro_precios` (
  `Contador` INT(11) NOT NULL AUTO_INCREMENT,
  `idProducto` INT(11) NOT NULL DEFAULT '0',
  `Margen` DECIMAL(19,3) NULL DEFAULT '0.000',
  `idLista` INT(11) NOT NULL,
  PRIMARY KEY (`Contador`),
  INDEX `idProducto_idx` (`idProducto` ASC),
  INDEX `idLista_idx` (`idLista` ASC),
  CONSTRAINT `fk_proprecios_idProducto`
    FOREIGN KEY (`idProducto`)
    REFERENCES `bd_entidad`.`tbpro` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proprecios_idLista`
    FOREIGN KEY (`idLista`)
    REFERENCES `bd_entidad`.`tblistas` (`idLista`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 53
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro_promo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro_promo` (
  `idPromo` INT(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `idCategoria` INT(11) NULL DEFAULT '0',
  `idProducto` INT(11) NULL DEFAULT '0',
  `Cantidad` INT(11) NULL DEFAULT '0',
  `AfectaTodos` INT(11) NULL DEFAULT '1',
  `pDescuento` DECIMAL(19,3) NULL DEFAULT '0.000',
  `Fecha` DATETIME NULL DEFAULT NULL,
  `Activa` INT(11) NULL DEFAULT '1',
  `idLista` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idPromo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro_series`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro_series` (
  `Contador` INT(11) NOT NULL AUTO_INCREMENT,
  `idProducto` INT(11) NULL DEFAULT NULL,
  `idDoc` INT(11) NULL DEFAULT NULL,
  `Serie` VARCHAR(30) NULL DEFAULT NULL,
  `Activo` INT(11) NULL DEFAULT '1',
  PRIMARY KEY (`Contador`),
  INDEX `idProducto_idx` (`idProducto` ASC),
  INDEX `idDoc_idx` (`idDoc` ASC),
  CONSTRAINT `fk_proseries_idProducto`
    FOREIGN KEY (`idProducto`)
    REFERENCES `bd_entidad`.`tbpro` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proseries_idDoc`
    FOREIGN KEY (`idDoc`)
    REFERENCES `bd_entidad`.`tbdoc` (`idDoc`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbpro_stock`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbpro_stock` (
  `Contador` INT(11) NOT NULL AUTO_INCREMENT,
  `idProducto` INT(11) NULL DEFAULT '0',
  `idDeposito` INT(11) NULL DEFAULT '0',
  `Stock_consolidado` INT(11) NULL DEFAULT '0' COMMENT 'informa el stock calculado hasta Fecha_consolidado, hora_consolidado',
  `FechaMod` DATE NULL DEFAULT NULL,
  `HoraMod` TIME NULL DEFAULT NULL,
  `StockMin` INT(11) NULL DEFAULT '0',
  `StockMax` INT(11) NULL DEFAULT '0',
  `Fecha_consolidado` DATE NULL DEFAULT NULL COMMENT 'indica el ultimo punto hasta el que se calculo el stock para el producto en la lista indicada',
  `Hora_consolidado` TIME NULL DEFAULT NULL COMMENT 'indica el ultimo punto hasta el que se calculo el stock para el producto en la lista indicada',
  PRIMARY KEY (`Contador`),
  INDEX `idProducto_idx` (`idProducto` ASC),
  INDEX `idDeposito_idx` (`idDeposito` ASC),
  CONSTRAINT `fk_prostock_idProducto`
    FOREIGN KEY (`idProducto`)
    REFERENCES `bd_entidad`.`tbpro` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_prostock_idDeposito`
    FOREIGN KEY (`idDeposito`)
    REFERENCES `bd_entidad`.`tbdep` (`idDeposito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 27
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbentidad_marcas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbentidad_marcas` (
  `contador` INT(11) NOT NULL AUTO_INCREMENT,
  `idEntidad` INT(11) NOT NULL,
  `idMarca` INT(11) NOT NULL,
  PRIMARY KEY (`contador`),
  INDEX `idMarca_idx` (`idMarca` ASC),
  INDEX `idEntidad_idx` (`idEntidad` ASC),
  CONSTRAINT `fk_entmarcas_idEntidad`
    FOREIGN KEY (`idEntidad`)
    REFERENCES `bd_entidad`.`tbentidad` (`idEntidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entmarcas_idMarca`
    FOREIGN KEY (`idMarca`)
    REFERENCES `bd_entidad`.`tbmarcas` (`idMarca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbrep_equipos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbrep_equipos` (
  `idEquipo` INT(11) NOT NULL AUTO_INCREMENT,
  `idProducto` INT(11) NULL DEFAULT NULL,
  `Serie` VARCHAR(100) NULL DEFAULT NULL,
  `idCliente` INT(11) NULL DEFAULT NULL,
  `FechaIngreso` DATE NULL DEFAULT NULL,
  `Horaingreso` TIME NULL DEFAULT NULL,
  `FechaMod` DATE NULL DEFAULT NULL,
  `HoraMod` TIME NULL DEFAULT NULL,
  PRIMARY KEY (`idEquipo`),
  INDEX `idProducto_idx` (`idProducto` ASC),
  CONSTRAINT `fk_repequipos_idProducto`
    FOREIGN KEY (`idProducto`)
    REFERENCES `bd_entidad`.`tbpro` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbrep_estados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbrep_estados` (
  `idEstado` INT(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`idEstado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbrep`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbrep` (
  `idRep` INT(11) NOT NULL AUTO_INCREMENT,
  `idEquipo` INT(11) NULL DEFAULT NULL,
  `idEntidad` INT(11) NULL DEFAULT NULL,
  `idLista` INT(11) NULL DEFAULT NULL,
  `Razonsocial` VARCHAR(120) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Nombre` VARCHAR(120) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Dom` VARCHAR(120) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Tel` VARCHAR(50) NULL DEFAULT NULL,
  `Tel2` VARCHAR(50) NULL DEFAULT NULL,
  `Email` VARCHAR(100) NULL DEFAULT NULL,
  `Horariocontacto` VARCHAR(120) NULL DEFAULT NULL,
  `idEstado` INT(11) NULL DEFAULT NULL,
  `Fecha` DATE NULL DEFAULT NULL,
  `Hora` TIME NULL DEFAULT NULL,
  `Fechaingreso` DATE NULL DEFAULT NULL,
  `Horaingreso` TIME NULL DEFAULT NULL,
  `Fechaentrega` DATE NULL DEFAULT NULL,
  `Horaentrega` TIME NULL DEFAULT NULL,
  `Falladeclarada` VARCHAR(400) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Observaciones` VARCHAR(600) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Observacionespriv` VARCHAR(600) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Accesorios` VARCHAR(250) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`idRep`),
  INDEX `idEquipo_idx` (`idEquipo` ASC),
  INDEX `idLista_idx` (`idLista` ASC),
  INDEX `idEstado_idx` (`idEstado` ASC),
  INDEX `idEntidad_idx` (`idEntidad` ASC),
  CONSTRAINT `fk_rep_idEquipo`
    FOREIGN KEY (`idEquipo`)
    REFERENCES `bd_entidad`.`tbrep_equipos` (`idEquipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rep_idLista`
    FOREIGN KEY (`idLista`)
    REFERENCES `bd_entidad`.`tblistas` (`idLista`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rep_idEstado`
    FOREIGN KEY (`idEstado`)
    REFERENCES `bd_entidad`.`tbrep_estados` (`idEstado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rep_idEntidad`
    FOREIGN KEY (`idEntidad`)
    REFERENCES `bd_entidad`.`tbentidad` (`idEntidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbrep_detalle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbrep_detalle` (
  `Contador` INT(11) NOT NULL AUTO_INCREMENT,
  `idRep` INT(11) NULL DEFAULT NULL,
  `idProducto` INT(11) NULL DEFAULT NULL,
  `Codigo` VARCHAR(20) NULL DEFAULT NULL,
  `Descripcion` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Serie` VARCHAR(100) NULL DEFAULT NULL,
  `Cantidad` INT(11) NULL DEFAULT NULL,
  `pDescuento` DECIMAL(19,3) NULL DEFAULT NULL,
  `Precio` DECIMAL(19,3) NULL DEFAULT NULL,
  `Total` DECIMAL(19,3) NULL DEFAULT NULL,
  `pIva` DECIMAL(19,3) NULL DEFAULT NULL,
  `Costo` DECIMAL(19,3) NULL DEFAULT NULL,
  `idDeposito` INT(11) NULL DEFAULT NULL,
  `Promociones` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`Contador`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_entidad`.`tbrep_eventos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_entidad`.`tbrep_eventos` (
  `Contador` INT(11) NOT NULL AUTO_INCREMENT,
  `id` INT(11) NULL DEFAULT NULL,
  `idEstado` INT(11) NULL DEFAULT NULL,
  `Descripcion` VARCHAR(400) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Fecha` DATE NULL DEFAULT NULL,
  `Hora` TIME NULL DEFAULT NULL,
  `Notificado` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`Contador`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

USE `bd_entidad` ;

-- -----------------------------------------------------
-- procedure getCartItem
-- -----------------------------------------------------

DELIMITER $$
USE `bd_entidad`$$
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

DELIMITER ;

-- -----------------------------------------------------
-- procedure getCartItems
-- -----------------------------------------------------

DELIMITER $$
USE `bd_entidad`$$
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

DELIMITER ;

-- -----------------------------------------------------
-- procedure getProducto
-- -----------------------------------------------------

DELIMITER $$
USE `bd_entidad`$$
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

DELIMITER ;

-- -----------------------------------------------------
-- procedure getProductosCatPadre
-- -----------------------------------------------------

DELIMITER $$
USE `bd_entidad`$$
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

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
