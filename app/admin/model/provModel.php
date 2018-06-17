<?php

class Proveedores extends Conectar
{
    private $u;

    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function crearSelect($sel="")
    {
        return parent::crearSelectTabla("tbprov", "idProveedor", "Razonsocial", $sel, "idProveedor");
    }

    public function getProveedores()
    {
        $sql="SELECT a.idProveedor, a.Razonsocial, a.idMoneda , b.Nombre as NomMoneda, b.Cambio
              FROM
              tbprov as a INNER JOIN tbmoneda as b
              ON a.idMoneda = b.idMoneda              
              ORDER BY a.Nombre ASC";
        return parent::getRows($sql);
    }

        public function add()
    {
        //print_r($_POST);exit;

        if(empty($_POST["Razonsocial"]) or empty($_POST["idMoneda"]) or $_POST["idMoneda"] == 0 )
        {
            header("Location:".BASE_URL."?accion=prov-add&st=" . MSG_DANGER );exit;
        }

        $sql="INSERT INTO `tbprov` (`idProveedor`, `Nombre`, `Razonsocial` , `Dom`, `Loc`, `Cp`, `Prov`, `Cuit`, `Tel`, `Tel2`, `Email`, `FechaAlta`, `FechaMod`, `Activo`, `Observaciones`, `AvisoEmergente`, `Website`, `Pais`, `idCondFiscal`, `idMoneda`) VALUES ( NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?, ?, ?, ?, ?, ? )";


        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue( 1     ,$_POST["Nombre"]       ,PDO::PARAM_STR );
        $stmt->bindValue( 2     ,$_POST["Razonsocial"]  ,PDO::PARAM_STR );
        $stmt->bindValue( 3     ,$_POST["Dom"]          ,PDO::PARAM_STR );        
        $stmt->bindValue( 4     ,$_POST["Loc"]          ,PDO::PARAM_STR );
        $stmt->bindValue( 5     ,$_POST["Cp"]           ,PDO::PARAM_STR );
        $stmt->bindValue( 6     ,$_POST["Prov"]         ,PDO::PARAM_STR );
        $stmt->bindValue( 7     ,$_POST["Cuit"]         ,PDO::PARAM_STR );
        $stmt->bindValue( 8     ,$_POST["Tel"]          ,PDO::PARAM_STR );
        $stmt->bindValue( 9     ,$_POST["Tel2"]         ,PDO::PARAM_STR );
        $stmt->bindValue( 10    ,$_POST["Email"]        ,PDO::PARAM_STR );
        $stmt->bindValue( 11    , 1                     ,PDO::PARAM_INT );
        $stmt->bindValue( 12    ,$_POST["Observaciones"],PDO::PARAM_STR );
        $stmt->bindValue( 13    ,$_POST["AvisoEmergente"],PDO::PARAM_STR );
        $stmt->bindValue( 14    ,$_POST["Website"]      ,PDO::PARAM_STR );
        $stmt->bindValue( 15    ,$_POST["Pais"]         ,PDO::PARAM_STR );
        $stmt->bindValue( 16    ,$_POST["idCondFiscal"] ,PDO::PARAM_INT );
        $stmt->bindValue( 17    ,$_POST["idMoneda"]     ,PDO::PARAM_INT );


        $res = $stmt->execute();

        if($res)
        {
            header("Location:".BASE_URL."?accion=prov&st=" . MSG_SUCCESS );exit;
        }else{
            print_r($stmt->errorInfo());
            //header("Location:".BASE_URL."user-add/3/");exit;
        }
        $this->dbh=null;

    }

    public function getProveedorId($id)
    {
        $sql="SELECT `idProveedor`, `Nombre`, `Razonsocial`, `Dom`, `Loc`, `Cp`, `Prov`, `Cuit`, `Tel`, `Tel2`, `Email`, `FechaAlta`, `FechaMod`, `Activo`, `Observaciones`, `AvisoEmergente`, `Website`, `Pais`, `idCondFiscal`, `idMoneda`
              FROM  `tbprov` WHERE idProveedor = ?";

        return parent::getRowId($sql, array($id));                                       
    }

    public function edit()
    {
        //print_r($_POST);exit;
        if(empty($_POST["Razonsocial"]) or empty($_POST["idProveedor"]) or $_POST["idProveedor"] == 0)
        {
            header("Location:".BASE_URL."?accion=prov-edit&id=".$_POST["idProveedor"]."&st=" . MSG_DANGER );exit;
        }

        $sql="UPDATE `tbprov` SET `Nombre` = ?, `Razonsocial` = ?, `Dom` = ?, `Loc` = ?, `Cp` = ?, `Prov` = ?, `Cuit` = ?, `Tel` = ?, `Tel2` = ?, `Email` = ?, `FechaMod`=NOW() , `Activo`= ? , `Observaciones` = ?, `AvisoEmergente`= ? , `Website` = ? , `Pais` = ? , `idCondFiscal` = ? , `idMoneda` = ?
              WHERE  `idProveedor` = ?";

        // faltan los checks

        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue( 1     ,$_POST["Nombre"]       ,PDO::PARAM_STR );
        $stmt->bindValue( 2     ,$_POST["Razonsocial"]  ,PDO::PARAM_STR );
        $stmt->bindValue( 3     ,$_POST["Dom"]          ,PDO::PARAM_STR );        
        $stmt->bindValue( 4     ,$_POST["Loc"]          ,PDO::PARAM_STR );
        $stmt->bindValue( 5     ,$_POST["Cp"]           ,PDO::PARAM_STR );
        $stmt->bindValue( 6     ,$_POST["Prov"]         ,PDO::PARAM_STR );
        $stmt->bindValue( 7     ,$_POST["Cuit"]         ,PDO::PARAM_STR );
        $stmt->bindValue( 8     ,$_POST["Tel"]          ,PDO::PARAM_STR );
        $stmt->bindValue( 9     ,$_POST["Tel2"]         ,PDO::PARAM_STR );
        $stmt->bindValue( 10    ,$_POST["Email"]        ,PDO::PARAM_STR );
        $stmt->bindValue( 11    , ( isset($_POST["Activo"] ) )? 1  : 0 ,PDO::PARAM_INT );
        $stmt->bindValue( 12    ,$_POST["Observaciones"],PDO::PARAM_STR );
        $stmt->bindValue( 13    ,$_POST["AvisoEmergente"],PDO::PARAM_STR );
        $stmt->bindValue( 14    ,$_POST["Website"]      ,PDO::PARAM_STR );
        $stmt->bindValue( 15    ,$_POST["Pais"]         ,PDO::PARAM_STR );
        $stmt->bindValue( 16    ,$_POST["idCondFiscal"] ,PDO::PARAM_INT );
        $stmt->bindValue( 17    ,$_POST["idMoneda"]     ,PDO::PARAM_INT );
        $stmt->bindValue( 18    ,$_POST["idProveedor"]     ,PDO::PARAM_INT );

        if($stmt->execute())
        {
            header("Location:".BASE_URL."?accion=prov-edit&id=".$_POST["idProveedor"]."&st=" . MSG_SUCCESS );
        }else
        {
           header("Location:".BASE_URL."?accion=prov-edit&id=".$_POST["idProveedor"]."&st=" . MSG_DANGER );
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
