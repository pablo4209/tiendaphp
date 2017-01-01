<?php

class proStock extends Conectar 
{
    private $u;
    
    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }
    
    public function getStock()
    {
        $sql="SELECT  `Contador` ,  `idProducto` ,  `idDeposito` ,  `Stock` ,  `FechaMod` ,  `HoraMod` ,  `StockMin` ,  `StockMax` 
				FROM `tbpro_stock` ";
        return parent::getRows($sql);
    }
    public function LimpiarArray()
    {
        parent::ClearArray();
    }
    
    
    public function add($idpro, $iddeposito, $stock=0, $stockmin=0, $stockmax=0)
    {
                
        if(empty($idpro) or empty($iddeposito)) exit;
        
		
        $sql="INSERT INTO tbpro_stock ( `Contador`, `idProducto`, `idDeposito`, `Stock`, `FechaMod`, `HoraMod`, `StockMin`, `StockMax` )
              VALUES ( NULL ,? ,? ,?, NOW(), NOW(), ?, ? )";
                        
        $stmt=$this->dbh->prepare($sql);                
        $stmt->bindValue(1,$idpro,PDO::PARAM_INT);
        $stmt->bindValue(2,$iddeposito,PDO::PARAM_INT);
        $stmt->bindValue(3,$stock,PDO::PARAM_INT);        
        $stmt->bindValue(4,$stockmin,PDO::PARAM_INT);        
		$stmt->bindValue(5,$stockmax,PDO::PARAM_INT);        		
		
        if($stmt->execute()) 
			return true;
		else
			return false;      
    }
    
    public function getStockId($id)
    {       
        $sql="select `Contador`, `idProducto`, `idDeposito`, `Stock`, `FechaMod`, `HoraMod`, `StockMin`, `StockMax` from tbpro_stock where idProducto=?";
        
        return parent::getRowId($sql, $id);                                       
    }
    
    public function edit($idpro, $iddeposito, $stock=0, $stockmin=0, $stockmax=0)
    {
        if(empty($idpro) or empty($iddeposito))
        {
            return false;
        }
        
        $sql="UPDATE tbpro_stock
              SET 
              `idDeposito`=?, `Stock`=?, `FechaMod`=NOW(), `HoraMod`=NOW(), `StockMin`=?, `StockMax`=?
              WHERE
              `idProducto`=?";
             
        $stmt=$this->dbh->prepare($sql);
        
        $stmt->bindValue(1,$iddeposito,PDO::PARAM_INT);
        $stmt->bindValue(2,$stock,PDO::PARAM_INT);
        $stmt->bindValue(3,$stockmin,PDO::PARAM_INT);        
        $stmt->bindValue(4,$stockmax,PDO::PARAM_INT);
        $stmt->bindValue(5,$idpro,PDO::PARAM_INT);
        
        if($stmt->execute())
        {
            return true;
        }else
        {
           return false;
        }             
    }
    
    public function delete()
    {        
        //primero es necesario checkear la integridad referencial
            
            
            $sql="delete from tbpro_stock where idProducto=?";
    		
    		$stmt=$this->dbh->prepare($sql);            
            
            $id=$_GET["id"];
            $stmt->bindValue(1,$id,PDO::PARAM_INT);
    		    		
    		if($stmt->execute())
            {                        
                return true;
            }else
            {
                return false;
            }            
    }
}

?>