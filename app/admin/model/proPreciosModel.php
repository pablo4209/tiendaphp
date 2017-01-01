<?php

class proPrecios extends Conectar 
{
    private $u;
    
    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }
    
    public function getPrecios()
    {
        $sql="SELECT  `Contador` ,  `idProducto` ,  `Margen` ,  `idLista` 
				FROM  `bdconv`.`tbpro_precios`";
        return parent::getRows($sql);
    }
    public function LimpiarArray()
    {
        parent::ClearArray();
    }
    
    
    public function add($idpro, $idlista, $margen)
    {
                
        if(empty($idpro) or empty($margen) or empty($idlista) ) exit;        
		
        $sql="INSERT INTO tbpro_precios ( `Contador`, `idProducto`, `Margen`, `idLista` )
              VALUES ( NULL ,? ,? ,? )";
                        
        $stmt=$this->dbh->prepare($sql);                
        $stmt->bindValue(1,$idpro,PDO::PARAM_INT);
        $stmt->bindValue(2,$margen,PDO::PARAM_INT);
        $stmt->bindValue(3,$idlista,PDO::PARAM_INT);        
        		        
        if($stmt->execute()) 
			return true;
		else
			return false;
		//print_r($stmt->errorInfo());                  
    }
    
    public function getPrecioId($id)
    {       
        $sql="select `Contador`, `idProducto`, `Margen`, `idLista` from tbpro_precios where idProducto=?";
        
        return parent::getRowId($sql, $id);                                       
    }
    
    public function edit($idpro, $idlista, $margen)
    {
        if(empty($margen) or empty($idlista) or empty($idpro))
        {
            return false;
        }
        $sql="UPDATE tbpro_precios SET `Margen`=? WHERE `idProducto`=? AND `idLista`=?";
             
        $stmt=$this->dbh->prepare($sql);
        
        $stmt->bindValue(1,$margen,PDO::PARAM_INT);
        $stmt->bindValue(2,$idpro,PDO::PARAM_INT);
        $stmt->bindValue(3,$idlista,PDO::PARAM_INT);                
        
        if($stmt->execute())        
           return true;
        else        
           return false;
                       
    }
    
    public function delete()
    {        
        //primero es necesario checkear la integridad referencial
            
            
            $sql="DELETE FROM tbpro_precios WHERE idProducto=?";
    		
    		$stmt=$this->dbh->prepare($sql);            
            
            $id=$_GET["id"];
            $stmt->bindValue(1,$id,PDO::PARAM_INT);
    		    		
    		if($stmt->execute())                                    
                return true;
            else            
                return false;                       
    }
}

?>