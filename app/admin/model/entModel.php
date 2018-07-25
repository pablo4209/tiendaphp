<?php

class Entidad extends Conectar
{
	private $u;

	public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function getRows()
    {
        $sql = "SELECT `idEntidad`, `idEntidadTipo`, `Nombre`, `Razonsocial`, `Email`, `Dom`, `Domentrega`, `Loc`, `Cp`, `Prov`, `Cuit`, `Dni`, `Tel`, `Tel2`, `FechaNacimiento`, `Sexo`, `idCondFiscal`, `FechaAlta`, `HoraAlta`, `FechaMod`, `HoraMod`, `Estado`, `Observaciones`, `AvisoEmergente`, `Foto`, `Website`, `idMoneda`, `Login`, `Pass`, `KeyReg`, `NewPass`, `idNivelAcceso`, `ip`, `FechaLog`, `HoraLog` "
								." 	FROM `tbentidad`;";
        return parent::getRows($sql);
    }

    public function add()
    {
        //print_r($_POST);exit;

    	//verifica segun el tipo de entidad que se quiere crear, estan definidos: ENT_USUARIO, ENT_PROVEEDOR, ENT_CLIENTE

        if( empty($_POST["idEntidadTipo"]) or  empty($_POST["Nombre"]) or $_POST["idEntidadTipo"] == 0
    		OR ($_POST["idEntidadTipo"] == ENT_USUARIO AND !isset($_POST["idNivelAcceso"]) AND empty($_POST["Login"]) AND empty($_POST["Pass"]) )
    	)
            									return false;

        $sql = "INSERT INTO `tbentidad` (`idEntidad`, `idEntidadTipo`, `Nombre`, `Razonsocial`, `Email`, `Dom`, `Domentrega`, `Loc`, `Cp`, `Prov`, `Cuit`, `Dni`, `Tel`, `Tel2`, `FechaNacimiento`, `Sexo`, `idCondFiscal`, `FechaAlta`, `HoraAlta`, `Estado`, `Observaciones`, `AvisoEmergente`, `Foto`, `Website`, `idMoneda`, `Login`, `Pass`, `KeyReg`, `idNivelAcceso`, `ip` )
        	   VALUES ( NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

       	$f_nac = ( isset($_POST['anio']) AND isset($_POST['mes']) AND isset($_POST['dia']) )? $_POST['anio']."-".$_POST['mes']."-".$_POST['dia'] : '';
       	$condfiscal = ( isset( $_POST['idCondFiscal'] ) )? $_POST['idCondFiscal'] : 0 ;
		$mon = ( isset( $_POST['idMoneda'] ) )? $_POST['idMoneda'] : 1 ;
		$keyreg = (isset($_POST["keyreg"]))? $_POST["keyreg"] : "";
		$ip = ( isset( $_POST["ip"] ) )? $_POST["ip"] : "" ;


        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1		,$_POST["idEntidadTipo"]		,PDO::PARAM_INT);
        $stmt->bindValue(2		,$_POST["Nombre"]				,PDO::PARAM_STR);
        $stmt->bindValue(3		,$_POST["Razonsocial"]			,PDO::PARAM_STR);
        $stmt->bindValue(4		,$_POST["Email"]				,PDO::PARAM_STR);
        $stmt->bindValue(5		,$_POST["Dom"]					,PDO::PARAM_STR);
        $stmt->bindValue(6		,$_POST["Domentrega"]			,PDO::PARAM_STR);
        $stmt->bindValue(7		,$_POST["Loc"]					,PDO::PARAM_STR);
        $stmt->bindValue(8		,$_POST["Cp"]					,PDO::PARAM_STR);
        $stmt->bindValue(9		,$_POST["Prov"]					,PDO::PARAM_STR);
        $stmt->bindValue(10		,$_POST["Cuit"]					,PDO::PARAM_STR);
        $stmt->bindValue(11		,$_POST["Dni"]					,PDO::PARAM_STR);
        $stmt->bindValue(12		,$_POST["Tel"]					,PDO::PARAM_STR);
        $stmt->bindValue(13		,$_POST["Tel2"]					,PDO::PARAM_STR);
        $stmt->bindValue(14		,$f_nac 						,PDO::PARAM_STR); //fecha formato: '2018-02-06'
        $stmt->bindValue(15		,$_POST["Sexo"]					,PDO::PARAM_STR);
		$stmt->bindValue(16		,$idCondFiscal 					,PDO::PARAM_INT);
        $stmt->bindValue(17		,$_POST["Observaciones"]		,PDO::PARAM_STR);
        $stmt->bindValue(18		,$_POST["AvisoEmergente"]		,PDO::PARAM_STR);
        $stmt->bindValue(19		,$_POST["Foto"]					,PDO::PARAM_STR);
        $stmt->bindValue(20		,$_POST["Website"]				,PDO::PARAM_STR);
        $stmt->bindValue(21		,$mon 							,PDO::PARAM_INT);
        $stmt->bindValue(22		,$_POST["Login"]				,PDO::PARAM_STR);
        $stmt->bindValue(23		,self::Encrypt($_POST["pass"]) 	,PDO::PARAM_STR);
        $stmt->bindValue(24		,$keyreg 						,PDO::PARAM_STR);
        $stmt->bindValue(25		,$ip 							,PDO::PARAM_INT);

        $res = $stmt->execute();

        if($res)
            return true;
        else
        {
        	print_r($stmt->errorInfo());
        	return false;
        }

    }

    public function getRowsTipo( $id ){
        $sql = "SELECT `idEntidad`, `idEntidadTipo`, `Nombre`, `Razonsocial`, `Email`, `Dom`, `Domentrega`, `Loc`,  `Cp`, `Prov`, `Cuit`, `Dni`, `Tel`, `Tel2`, `FechaNacimiento`, `Sexo`, `idCondFiscal`, `FechaAlta`,  `HoraAlta`, `FechaMod`, `HoraMod`, `Estado`, `Observaciones`, `AvisoEmergente`, `Foto`, `Website`,   `idMoneda`, `Login`, `Pass`, `KeyReg`, `NewPass`, `idNivelAcceso`, `ip`, `FechaLog`, `HoraLog`
            FROM  `tbentidad` WHERE idEntidadTipo = ?";

        return parent::getRowId($sql, array($id));
    }

    public function getId( $id )
    {
        $sql="SELECT `idEntidad`, `idEntidadTipo`, `Nombre`, `Razonsocial`, `Email`, `Dom`, `Domentrega`, `Loc`, `Cp`, `Prov`, `Cuit`, `Dni`, `Tel`, `Tel2`, `FechaNacimiento`, `Sexo`, `idCondFiscal`, `FechaAlta`, `HoraAlta`, `FechaMod`, `HoraMod`, `Estado`, `Observaciones`, `AvisoEmergente`, `Foto`, `Website`, `idMoneda`, `Login`, `Pass`, `KeyReg`, `NewPass`, `idNivelAcceso`, `ip`, `FechaLog`, `HoraLog`
            FROM  `tbentidad` WHERE idEntidad = ?";

        return parent::getRowId($sql, array($id));
    }

    public function edit()
    {
        //print_r($_POST);exit;
        if( empty($_POST["idEntidadTipo"]) or  empty($_POST["Nombre"]) or $_POST["idEntidadTipo"] == 0
    		OR ($_POST["idEntidadTipo"] == ENT_USUARIO AND !isset($_POST["idNivelAcceso"]) AND empty($_POST["Login"]) AND empty($_POST["Pass"]) )
    	)
            									return false;

        $sql = "UPDATE `tbentidad` SET `idEntidadTipo` = ?,
        								`Nombre` = ?,
        								`Razonsocial` = ?,
        								`Email` = ?,
        								`Dom` = ?,
        								`Domentrega` = ?,
        								`Loc` = ?,
        								`Cp` = ?,
        								`Prov` = ?,
        								`Cuit` = ?,
        								`Dni` = ?,
        								`Tel` = ?,
        								`Tel2` = ?,
        								`FechaNacimiento` = ?,
        								`Sexo` = ?,
        								`idCondFiscal` = ?,
        								`FechaMod` = NOW(),
        								`HoraMod` = NOW(),
        								`Estado` = ?,
        								`Observaciones` = ?,
        								`AvisoEmergente` = ?,
        								`Foto` = ?,
        								`Website` = ?,
        								`idMoneda` = ?,
        								`Login` = ?,
        								`Pass` = ?,
        								`idNivelAcceso` = ?,
        								`ip` = ?,
        								`FechaLog` = NOW(),
        								`HoraLog` = NOW()
        								WHERE
        								`tbentidad`.`idEntidad` = ? " ;


        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1		,$_POST["idEntidadTipo"]		,PDO::PARAM_INT);
        $stmt->bindValue(2		,$_POST["Nombre"]				,PDO::PARAM_STR);
        $stmt->bindValue(3		,$_POST["Razonsocial"]			,PDO::PARAM_STR);
        $stmt->bindValue(4		,$_POST["Email"]				,PDO::PARAM_STR);
        $stmt->bindValue(5		,$_POST["Dom"]					,PDO::PARAM_STR);
        $stmt->bindValue(6		,$_POST["Domentrega"]			,PDO::PARAM_STR);
        $stmt->bindValue(7		,$_POST["Loc"]					,PDO::PARAM_STR);
        $stmt->bindValue(8		,$_POST["Cp"]					,PDO::PARAM_STR);
        $stmt->bindValue(9		,$_POST["Prov"]					,PDO::PARAM_STR);
        $stmt->bindValue(10		,$_POST["Cuit"]					,PDO::PARAM_STR);
        $stmt->bindValue(11		,$_POST["Dni"]					,PDO::PARAM_STR);
        $stmt->bindValue(12		,$_POST["Tel"]					,PDO::PARAM_STR);
        $stmt->bindValue(13		,$_POST["Tel2"]					,PDO::PARAM_STR);
        $stmt->bindValue(14		,$_POST["FechaNacimiento"]		,PDO::PARAM_STR);
        $stmt->bindValue(15		,$_POST["Sexo"]					,PDO::PARAM_STR);
        $stmt->bindValue(16		,$_POST["idCondFiscal"]			,PDO::PARAM_INT);
        $stmt->bindValue(17		,$_POST["Estado"]				,PDO::PARAM_STR);
        $stmt->bindValue(18		,$_POST["Observaciones"]		,PDO::PARAM_STR);
        $stmt->bindValue(19		,$_POST["AvisoEmergente"]		,PDO::PARAM_STR);
        $stmt->bindValue(20		,$_POST["Foto"]					,PDO::PARAM_STR);
        $stmt->bindValue(21		,$_POST["Website"]				,PDO::PARAM_STR);
        $stmt->bindValue(22		,$_POST["idMoneda"]				,PDO::PARAM_INT);
        $stmt->bindValue(23		,$_POST["Login"]				,PDO::PARAM_STR);
        $stmt->bindValue(24		,$_POST["Pass"]					,PDO::PARAM_STR);
        $stmt->bindValue(25		,$_POST["idNivelAcceso"]		,PDO::PARAM_INT);
        $stmt->bindValue(26		,$_POST["idEntidad"]			,PDO::PARAM_int);


        if( $stmt->execute() )
        	return true;
        else
        	return false;
    }

    private function Encrypt($string) {
      $long = strlen($string);
      $str = '';
      for($x = 0; $x < $long; $x++) {
        $str .= ($x % 2) != 0 ? md5($string[$x]) : $x;
      }
      return md5($str);
    }

 	public function logueo()
    {
    	$sql = "SELECT a.`idEntidad`, a.`idEntidadTipo`, a.`Nombre`, a.`Login`,  a.`Estado`, a.`AvisoEmergente`,
    			a.`Foto` , a.`idNivelAcceso` , b.`Nivel`
             	FROM  `tbentidad` as a
             	INNER JOIN `tbentidad_nivel` as b ON a.`idNivelAcceso` = b.`idNivelAcceso`
             	WHERE Estado = 1 AND Login = ? AND Pass = ? ";

        $pass = self::Encrypt( $_POST["pass"] );
        $stmt = $this->dbh->prepare( $sql );

        if( $stmt->execute( array( $_POST["login"] , $pass ) ) )
        {
           if( $reg = $stmt->fetch() )
            {
                if( $reg["Estado"]==1 AND $reg["Nivel"] > 5 )
                {
						$_SESSION["admin_id"]=$reg["idEntidad"];
						$_SESSION["admin_login"]=$reg["Login"];
						$_SESSION["admin_nombre"]=$reg["Nombre"];
						$_SESSION["NivelAcceso"]=$reg["Nivel"];
						return true;
                }
                else
                    return false;
            } else
            	return false;

        }else
        	return false;
    }


}

 ?>
