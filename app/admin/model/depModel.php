<?php

class Depositos extends Conectar
{
    private $u;

    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function crearSelect($sel="")
    {
        return parent::crearSelectTabla("tbdepositos", "idDeposito", "Nombre", $sel, "idDeposito");
    }

    public function getDepositos()
    {
        $sql="SELECT tbdepositos.idDeposito, tbdepositos.Nombre, tbdepositos.idSucursal, tbsucursal.Nombre AS nSucursal
              FROM
              tbdepositos
              Left Join tbsucursal ON tbdepositos.idSucursal = tbsucursal.idSucursal
              order by tbdepositos.Nombre asc";
        return parent::getRows($sql);
    }

        public function add()
    {
        //print_r($_POST);exit;

        if(empty($_POST["Nombre"]) or empty($_POST["idSucursal"]) or $_POST["idSucursal"] == 0 )
        {
            header("Location:".BASE_URL."?accion=dep-add&st=1");exit;
        }

        $sql="INSERT INTO `tbdepositos` (
              `idDeposito`, `Nombre`, `Descripcion`, `Dom`, `Cp`, `Loc`, `Prov`, `Tel`, `Email`,
              `Observaciones`, `FechaAlta`, `HoraAlta`, `idSucursal`)
              VALUES ( NULL ,? ,? ,? ,? ,? ,? ,? ,? ,? ,NOW() ,NOW() ,? )";




        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1,$_POST["Nombre"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["Descripcion"],PDO::PARAM_STR);
        $stmt->bindValue(3,$_POST["Dom"],PDO::PARAM_STR);
        $stmt->bindValue(4,$_POST["Cp"],PDO::PARAM_STR);
        $stmt->bindValue(5,$_POST["Loc"],PDO::PARAM_STR);
        $stmt->bindValue(6,$_POST["Prov"],PDO::PARAM_STR);
        $stmt->bindValue(7,$_POST["Tel"],PDO::PARAM_STR);
        $stmt->bindValue(8,$_POST["Email"],PDO::PARAM_STR);
        $stmt->bindValue(9,$_POST["Observaciones"],PDO::PARAM_STR);
        $stmt->bindValue(10,$_POST["idSucursal"],PDO::PARAM_INT);

        $res = $stmt->execute();

        if($res)
        {
            header("Location:".BASE_URL."?accion=dep-add&st=2");exit;
        }else{
            print_r($stmt->errorInfo());
            //header("Location:".BASE_URL."user-add/3/");exit;
        }
        $this->dbh=null;

    }

    public function getDepositoId($id)
    {
        $sql="SELECT `idDeposito`, `Nombre`, `Descripcion`, `Dom`, `Cp`, `Loc` , `Prov` ,  `Tel` ,  `Email` ,  `Observaciones` ,
              `FechaAlta` ,  `HoraAlta` ,  `idSucursal`
              FROM  `tbdepositos` WHERE idDeposito = ?";

        return parent::getRowId($sql, array($id));                                       
    }

    public function edit()
    {
        //print_r($_POST);exit;
        if(empty($_POST["Nombre"]) or empty($_POST["idSucursal"]) or $_POST["idSucursal"] == 0)
        {
            header("Location:".BASE_URL."?accion=dep-edit&id=".$_POST["id"]."&st=1");exit;
        }

        $sql="UPDATE `tbdepositos` SET `Nombre` = ?, `Descripcion` = ?, `Dom` = ?, `Cp` = ?, `Loc` = ?, `Prov` = ?,
              `Tel` = ?, `Email` = ?, `Observaciones` = ?, `idSucursal` = ?
              WHERE  `tbdepositos`.`idDeposito` = ?";


        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1,$_POST["Nombre"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["Descripcion"],PDO::PARAM_STR);
        $stmt->bindValue(3,$_POST["Dom"],PDO::PARAM_STR);
        $stmt->bindValue(4,$_POST["Cp"],PDO::PARAM_STR);
        $stmt->bindValue(5,$_POST["Loc"],PDO::PARAM_STR);
        $stmt->bindValue(6,$_POST["Prov"],PDO::PARAM_STR);
        $stmt->bindValue(7,$_POST["Tel"],PDO::PARAM_STR);
        $stmt->bindValue(8,$_POST["Email"],PDO::PARAM_STR);
        $stmt->bindValue(9,$_POST["Observaciones"],PDO::PARAM_STR);
        $stmt->bindValue(10,$_POST["idSucursal"],PDO::PARAM_INT);
        $stmt->bindValue(11,$_POST["id"],PDO::PARAM_INT);

        if($stmt->execute())
        {
            header("Location:".BASE_URL."?accion=dep-edit&id=".$_POST["id"]."&st=2");
        }else
        {
           header("Location:".BASE_URL."?accion=dep-edit&id=".$_POST["id"]."&st=3");
        }

        $this->dbh=null;
    }

    public function delete($id)
    {
        //primero es necesario checkear la integridad referencial


            $sql="delete from tbdepositos where idDeposito=?";

    		$stmt=$this->dbh->prepare($sql);

            $stmt->bindValue(1,$id,PDO::PARAM_INT);


    		if($stmt->execute())
            {
                header("Location: ".BASE_URL."?accion=dep&st=2");
            }else
            {
                header("Location: ".BASE_URL."?accion=dep&st=1");
            }
            $this->dbh=null;
    }
}
?>
