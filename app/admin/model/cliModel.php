<?php

class Clientes extends Conectar
{
    private $u;

    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function get_clientes()
    {
        $sql="SELECT  `idCliente` ,`Nombre` ,`Razonsocial` ,`Email` ,`Login` ,`idLista` ,`Estado`,`Foto`
        FROM  tbclientes order by Nombre asc;";
        return parent::getRows($sql);
    }

    public function add()
    {
        //print_r($_POST);exit;

        if(empty($_POST["Nombre"]) or empty($_POST["Email"]) or empty($_POST["Login"]) or empty($_POST["Pass"])
            or empty($_POST["idLista"]) or empty($_POST["idCondfiscal"]) or Conectar::valida_correo($_POST["Email"])==false)
        {
            header("Location:".BASE_URL."?accion=cli-add&st=1");exit;
        }

        $sql="INSERT INTO `tbclientes` (
             `idCliente`, `Nombre`, `Razonsocial`, `Email`, `Login` , `Pass` , `Dom` , `Domentrega` ,`Loc` ,`Cp` ,`Prov` ,
             `Cuit` ,`Dni` ,`Tel` ,`Tel2` ,`FechaNacimiento` , `Sexo`,`idCondfiscal` ,`FechaAlta` ,`HoraAlta` ,
             `idLista` , `Estado`, `Observaciones`, `AvisoEmergente`, `Promociones`, `Foto`)
             VALUES (NULL ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,
             ? ,? ,? ,? ,? ,? ,? ,NOW() ,NOW() ,? ,? ,? ,? ,? ,? )";


        //concatenar la fecha en formato mysql
        $f = $_POST['anio']."-".$_POST['mes']."-".$_POST['dia'];

        //los checks no tildados no generan variable post!!
        $e = (isset($_POST["Estado"]))? 1:0;
        $p = (isset($_POST["Promociones"]))? 1:0;


        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1,$_POST["Nombre"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["Razonsocial"],PDO::PARAM_STR);
        $stmt->bindValue(3,$_POST["Email"],PDO::PARAM_STR);
        $stmt->bindValue(4,$_POST["Login"],PDO::PARAM_STR);
        $stmt->bindValue(5,$_POST["Pass"],PDO::PARAM_STR);
        $stmt->bindValue(6,$_POST["Dom"],PDO::PARAM_STR);
        $stmt->bindValue(7,$_POST["Domentrega"],PDO::PARAM_STR);
        $stmt->bindValue(8,$_POST["Loc"],PDO::PARAM_STR);
        $stmt->bindValue(9,$_POST["Cp"],PDO::PARAM_STR);
        $stmt->bindValue(10,$_POST["Prov"],PDO::PARAM_STR);
        $stmt->bindValue(11,$_POST["Cuit"],PDO::PARAM_STR);
        $stmt->bindValue(12,$_POST["Dni"],PDO::PARAM_STR);
        $stmt->bindValue(13,$_POST["Tel"],PDO::PARAM_STR);
        $stmt->bindValue(14,$_POST["Tel2"],PDO::PARAM_STR);
        $stmt->bindValue(15,$f,PDO::PARAM_STR);
        $stmt->bindValue(16,$_POST["Sexo"],PDO::PARAM_STR);
        $stmt->bindValue(17,$_POST["idCondfiscal"],PDO::PARAM_INT);
        $stmt->bindValue(18,$_POST["idLista"],PDO::PARAM_INT);
        $stmt->bindValue(19,$e,PDO::PARAM_INT);
        $stmt->bindValue(20,$_POST["Observaciones"],PDO::PARAM_STR);
        $stmt->bindValue(21,$_POST["AvisoEmergente"],PDO::PARAM_STR);
        $stmt->bindValue(22,$p,PDO::PARAM_INT);
        $stmt->bindValue(23,$_POST["Foto"],PDO::PARAM_STR);

        $res = $stmt->execute();

        if($res)
        {
            header("Location:".BASE_URL."?accion=cli-add&st=2");exit;
        }else{
            print_r($stmt->errorInfo());
            //header("Location:".Conectar::ruta()."user-add/3/");exit;
        }
        $this->dbh=null;

    }

    public function get_cliente_id($id)
    {
        $sql="SELECT  `idCliente` ,  `Nombre` ,  `Razonsocial` ,  `Email` ,  `Login` ,  `Pass` ,  `Dom` ,  `Domentrega` ,
            `Loc` ,  `Cp` ,  `Prov` ,  `Cuit` ,  `Dni` ,  `Tel` ,  `Tel2` ,  `FechaNacimiento` ,  `Sexo` ,  `idCondfiscal` ,
            `FechaAlta` ,  `HoraAlta` ,  `FechaMod` ,  `HoraMod` ,  `idLista` ,  `Estado` ,  `Observaciones` ,
            `AvisoEmergente` ,  `Promociones` ,  `RecuperarPass` ,  `Foto` ,  `ip` ,  `FechaLog` ,  `HoraLog`
            FROM  `tbclientes`  where idCliente=?";

        return parent::getRowId($sql, array($id));                                       
    }

    public function edit() //falta implementar
    {
        if(empty($_POST["nom"]) or empty($_POST["correo"]) or empty($_POST["login"]) or empty($_POST["pass"]) or Conectar::valida_correo($_POST["correo"])==false)
        {
            header("Location:".BASE_URL."?accion=user-edit&id=".$_POST["id"]."&st=1");exit;
        }

        $sql="update tbusuarios
              set
              Nombre=?, Login=?, Email=?, Pass=?, NivelAcceso=?, Dom=?, Loc=?, Cp=?, Prov=?, Dni=?, Tel=?, Tel2=?,
              FechaNacimiento=?, Sexo=?, FechaMod=NOW(), HoraMod=NOW(), Estado=?, Observaciones=?,
              AvisoEmergente=?
              where
              idUsuario=?";

        //concatenar la fecha en formato mysql
        $f = $_POST['anio']."-".$_POST['mes']."-".$_POST['dia'];

        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1,$_POST["nom"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["login"],PDO::PARAM_STR);
        $stmt->bindValue(3,$_POST["correo"],PDO::PARAM_STR);
        $stmt->bindValue(4,$_POST["pass"],PDO::PARAM_STR);
        $stmt->bindValue(5,$_POST["nivelacceso"],PDO::PARAM_INT);
        $stmt->bindValue(6,$_POST["dom"],PDO::PARAM_STR);
        $stmt->bindValue(7,$_POST["loc"],PDO::PARAM_STR);
        $stmt->bindValue(8,$_POST["cp"],PDO::PARAM_STR);
        $stmt->bindValue(9,$_POST["prov"],PDO::PARAM_STR);
        $stmt->bindValue(10,$_POST["dni"],PDO::PARAM_STR);
        $stmt->bindValue(11,$_POST["tel"],PDO::PARAM_STR);
        $stmt->bindValue(12,$_POST["tel2"],PDO::PARAM_STR);
        $stmt->bindValue(13,$f,PDO::PARAM_STR);
        $stmt->bindValue(14,$_POST["sexo"],PDO::PARAM_STR);
        $stmt->bindValue(15,$_POST["estado"],PDO::PARAM_INT);
        $stmt->bindValue(16,$_POST["observaciones"],PDO::PARAM_STR);
        $stmt->bindValue(17,$_POST["avisoemergente"],PDO::PARAM_STR);
        $stmt->bindValue(18,$_POST["id"],PDO::PARAM_INT);

        if($stmt->execute())
        {
            header("Location:".BASE_URL."?accion=user-edit&id=".$_POST["id"]."&st=2");
        }else
        {
           header("Location:".BASE_URL."?accion=user-edit&id=".$_POST["id"]."&st=3");
        }

        $this->dbh=null;
    }

    public function delete($id)
    {
        //primero es necesario checkear la integridad referencial


            $sql="delete from tbclientes where idCliente=?";

    		$stmt=$this->dbh->prepare($sql);


            $stmt->bindValue(1,$id,PDO::PARAM_INT);


    		if($stmt->execute())
            {
                header("Location: ".BASE_URL."?accion=cli&st=2");
            }else
            {
                header("Location: ".BASE_URL."?accion=cli&st=1");
            }
            $this->dbh=null;
    }

}

?>
