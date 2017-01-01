<?php

class Listas extends Conectar
{
    private $u;
    
    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }
    
    public function crearSelect($sel="")
    {
        return parent::crearSelectTabla("tblistas", "idLista", "Nombre", $sel);       
    }
     
    public function getListas()
    {
        $sql="SELECT  `idLista` ,  `Nombre` ,  `Descripcion` ,  `Ivaincl` ,  `Margen` ,  `Habilitada` ,  `NivelAcceso` ,  `Pordefecto` 
              FROM  `tblistas`
              order by Nombre asc";
        return parent::getRows($sql);
    }
    
    public function add()
    {
        //print_r($_POST);exit;
        
        if(empty($_POST["Nombre"]) or empty($_POST["Margen"]) or !is_numeric($_POST["Margen"]) )
        {
            header("Location:".BASE_URL."?accion=list-add&st=1");exit;
        }       
        
        $sql="INSERT INTO `tblistas` ( `idLista` , `Nombre` , `Descripcion` , `Ivaincl` ,
              `Margen` ,`Habilitada` ,`NivelAcceso` ,`Pordefecto`)
              VALUES ( NULL , ? , ?, ?, ?, ?, ?, ? )";       
            
        $h = (isset($_POST["Habilitada"]))? 1:0;
        $iva = (isset($_POST["Ivaincl"]))? 1:0;
        $p = (isset($_POST["Pordefecto"]))? 1:0;
        
        $stmt=$this->dbh->prepare($sql);
                
        $stmt->bindValue(1,$_POST["Nombre"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["Descripcion"],PDO::PARAM_STR);
        $stmt->bindValue(3,$iva,PDO::PARAM_INT);        
        $stmt->bindValue(4,$_POST["Margen"],PDO::PARAM_INT);        
        $stmt->bindValue(5,$h,PDO::PARAM_INT);
        $stmt->bindValue(6,$_POST["NivelAcceso"],PDO::PARAM_INT);
        $stmt->bindValue(7,$p,PDO::PARAM_INT);
        
        $res = $stmt->execute();       
        
        if($res)
        {
            header("Location:".BASE_URL."?accion=list-add&st=2");exit;  
        }else{
            print_r($stmt->errorInfo());
            //header("Location:".BASE_URL."user-add/3/");exit; 
        }
        $this->dbh=null;
                
    }
    
    public function getListaId($id)
    {       
        $sql="SELECT  `idLista` ,  `Nombre` ,  `Descripcion` ,  `Ivaincl` ,  `Margen` ,  `Habilitada` ,  `NivelAcceso` ,  `Pordefecto` 
              FROM  `tblistas` WHERE idLista = ?";
        
        return parent::getRowId($sql, $id);                                       
    }
    
    public function edit()
    {
        //print_r($_POST);exit;
        if(empty($_POST["Nombre"]) or empty($_POST["Margen"]) or !is_numeric($_POST["Margen"]))
        {
            header("Location:".BASE_URL."?accion=list-edit&id=".$_POST["id"]."&st=1");exit;
        }
        
        $sql="UPDATE `tblistas` SET  `Nombre` = ?, `Descripcion` = ?, `Ivaincl` = ?, `Margen` = ?,
              `Habilitada` = ?, `NivelAcceso` = ?, `Pordefecto` = ? 
              WHERE  `tblistas`.`idLista` = ?";

        $h = (isset($_POST["Habilitada"]))? 1:0;
        $iva = (isset($_POST["Ivaincl"]))? 1:0;
        $p = (isset($_POST["Pordefecto"]))? 1:0;
             
        $stmt=$this->dbh->prepare($sql);
        
        $stmt->bindValue(1,$_POST["Nombre"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["Descripcion"],PDO::PARAM_STR);
        $stmt->bindValue(3,$iva,PDO::PARAM_INT);        
        $stmt->bindValue(4,$_POST["Margen"],PDO::PARAM_INT);        
        $stmt->bindValue(5,$h,PDO::PARAM_INT);
        $stmt->bindValue(6,$_POST["NivelAcceso"],PDO::PARAM_INT);
        $stmt->bindValue(7,$p,PDO::PARAM_INT);
        $stmt->bindValue(8,$_POST["id"],PDO::PARAM_INT);
        
        if($stmt->execute())
        {
            header("Location:".BASE_URL."?accion=list-edit&id=".$_POST["id"]."&st=2");
        }else
        {
           header("Location:".BASE_URL."?accion=list-edit&id=".$_POST["id"]."&st=3"); 
        }       
        
        $this->dbh=null;
    }
    
    public function delete($id)
    {        
        //primero es necesario checkear la integridad referencial
            
            
            $sql="delete from tblistas where idLista=?";
    		
    		$stmt=$this->dbh->prepare($sql);            
            
            $stmt->bindValue(1,$id,PDO::PARAM_INT);
    		
    		
    		if($stmt->execute())
            {                        
                header("Location: ".BASE_URL."?accion=list&st=2");
            }else
            {
                header("Location: ".BASE_URL."?accion=list&st=1");
            }
            $this->dbh=null;
    }
    
}
?>