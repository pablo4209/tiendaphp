<?php

class CondFiscal extends Conectar
{
    private $u;

    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function crearSelect($sel="")
    {
        return parent::crearSelectTabla("tbcondicionfiscal", "idCondFiscal", "Nombre", $sel);
    }

    public function get_condFiscal()
    {
        $sql="select idCondFiscal, Nombre, Descripcion, Pordefecto, idTipoDoc
              from tbcondicionfiscal order by Nombre asc;";
        return parent::getRows($sql);
    }

        public function add()
    {
        //print_r($_POST);exit;

        if(empty($_POST["Nombre"]))
        {
            header("Location:".BASE_URL."?accion=condFiscal-add&st=1");exit;
        }

        $sql="INSERT INTO tbcondicionfiscal ( `idCondFiscal` ,  `Nombre` ,  `Descripcion` ,  `Pordefecto` ,  `idTipoDoc` )
              VALUES ( NULL ,? ,? ,? , ? )";

        //los checks no tildados no generan variable post!!
        $p = (isset($_POST["Pordefecto"]))? 1:0;
        $d = (isset($_POST["Discrimina"]))? 1:0;



        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1,$_POST["Nombre"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["Descripcion"],PDO::PARAM_STR);
        $stmt->bindValue(3,$p,PDO::PARAM_INT);
        $stmt->bindValue(4,$d,PDO::PARAM_INT);

        $res = $stmt->execute();

        if($res)
        {
            header("Location:".BASE_URL."?accion=condFiscal-add&st=2");exit;
        }else{
            print_r($stmt->errorInfo());
            //header("Location:".BASE_URL."user-add/3/");exit;
        }
        $this->dbh=null;

    }

    public function get_condFiscal_id($id)
    {
        $sql="select idCondFiscal, Nombre, Descripcion, Pordefecto, idTipoDoc
              from tbcondicionfiscal where idCondFiscal=?";

        return parent::getRowId($sql, array($id));                                       
    }

    public function edit()
    {
        if(empty($_POST["Nombre"]))
        {
            header("Location:".BASE_URL."?accion=condFiscal-edit&id=".$_POST["id"]."&st=1");exit;
        }

        $sql="update tbcondicionfiscal
              set
              Nombre=?, Descripcion=?, Pordefecto=?, Discrimina=?
              where
              idCondFiscal=?";

        //los checks no tildados no generan variable post!!
        $p = (isset($_POST["Pordefecto"]))? 1:0;
        $d = (isset($_POST["Discrimina"]))? 1:0;

        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1,$_POST["Nombre"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["Descripcion"],PDO::PARAM_STR);
        $stmt->bindValue(3,$p,PDO::PARAM_INT);
        $stmt->bindValue(4,$d,PDO::PARAM_INT);
        $stmt->bindValue(5,$_POST["id"],PDO::PARAM_INT);

        if($stmt->execute())
        {
            header("Location:".BASE_URL."?accion=condFiscal-edit&id=".$_POST["id"]."&st=2");
        }else
        {
           header("Location:".BASE_URL."?accion=condFiscal-edit&id=".$_POST["id"]."&st=3");
        }

        $this->dbh=null;
    }

    public function delete($id)
    {
        //primero es necesario checkear la integridad referencial


            $sql="delete from tbcondicionfiscal where idCondFiscal=?";

    		$stmt=$this->dbh->prepare($sql);

            $stmt->bindValue(1,$id,PDO::PARAM_INT);


    		if($stmt->execute())
            {
                header("Location: ".BASE_URL."?accion=condFiscal&st=2");
            }else
            {
                header("Location: ".BASE_URL."?accion=condFiscal&st=1");
            }
            $this->dbh=null;
    }
}
?>
