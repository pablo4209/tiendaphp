<?php

class proCategorias extends Conectar 
{
    private $u;
    
    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }
    
    public function getCategorias()
    {
        $sql="SELECT  `Contador` ,  `idProducto` ,  `idCategoria` ,  `Principal` 
			FROM `tbpro_categorias` ";
        return parent::getRows($sql);
    }
    public function LimpiarArray()
    {
        parent::ClearArray();
    }
    
    
    public function add($idpro, $idcategoria, $principal=0)
    {
                
        if(empty($idpro) or empty($idcategoria) ) exit;        
		
        $sql="INSERT INTO tbpro_categorias ( `Contador`, `idProducto`, `idCategoria`, `Principal` )
              VALUES ( NULL ,? ,? ,? )";
                        
        $stmt=$this->dbh->prepare($sql);                
        $stmt->bindValue(1,$idpro,PDO::PARAM_INT);
        $stmt->bindValue(2,$idcategoria,PDO::PARAM_INT);
        $stmt->bindValue(3,$principal,PDO::PARAM_INT);        
        		        
        if($stmt->execute()) 
        	return true;
        else
			return false;                
                
    }
    
    public function getCategoriaId($id, $principal=0) //obtiene todas las categorias asociadas a $id (idproducto), segun principal
    {       
		if($principal) $principal = 1;
        $sql="select a.`Contador`, a.`idProducto`, a.`idCategoria`, a.`Principal`, b.`Nombre` from tbpro_categorias as a, tbcategorias as b where a.idCategoria = b.idCategoria AND a.idProducto=? And Principal=".$principal;
        
        return parent::getRowId($sql, $id);                                       
    }
	
	public function isCategoriaAsoc($idproducto, $idcategoria, $principal=0) //revisa si la categoria $idproducto ya tiene asociado $idcategoria, segun $principal
    {       
		if($principal) $principal = 1;
        $sql="select a.`Contador`, a.`idProducto`, a.`idCategoria`, a.`Principal` from tbpro_categorias as a where  a.idProducto=? AND a.idCategoria = ? AND Principal=".$principal;
        
		$result = parent::getRowId($sql, $idproducto.", ".$idcategoria);                                       
		if(empty($result) OR $result == false)
				return false;
		else
				return true;
    }
	
	//recibe idproducto y array con categorias nuevas $categorias
	//compara las nuevas con las ya asociadas y agrega o elimina las que no corresponden segun se requiera
	public function editSecundarias($idpro, $categorias)
	{
		if(empty($categorias) || $idpro == 0) exit;
				
		$catasoc = self::getCategoriaId($idpro);
		$cant = sizeof($catasoc);		
		
		foreach ($categorias as $catnueva)//recorrer asociaciones nuevas bucle								
		{	
				if(!$cant)
					self::add($idpro, $catnueva);//agregar registro directamente				
				else
				{
					$flag = false;
					for($i=0;$i<$cant;$i++) {
						if($catnueva == $catasoc[$i]['idCategoria']){	//$nueva = $actual?
							$catasoc[$i]['idCategoria'] == 0;	//si >> elimina actual de la lista(la igualo a 0 porque no se puede eliminar)
							$flag = true;
						}
						elseif($i == $cant-1 && $flag == false){  //no >> es la ultima y no existia ya?								
								self::add($idpro, $catnueva);  	//si >> agrega nuevo registro							
							//no >> continua loop
						}
					}
				}			
		}		
		for($i=0;$i<$cant;$i++){	//quedan registros en $actual !=0? 
			if($catasoc[$i]['idCategoria'] > 0 ) self::delete($idpro, $catasoc[$i]['idCategoria']);//si >> eliminar todo		
		}
	}    
	
    public function edit($idpro, $idcategoria, $principal=0) //edit en este caso se usa para set $idcategoria=principal, y borra cualquier principal anterior
    {
        if(empty($idpro) or empty($idcategoria))
        {
            return false;
        }
		
       
        /*  tiene categoria principal asociada 
				no >> existe como secundario?
					si >> se modifica y termina
					no >> sigue
				si >> idcatactual = idant?
						si >> se deja como esta y termina
						no >> se crea nueva fila
							existe este idcat seteado como secundario ?
								si >> se borra
								no >> termina        */		
		
		if( self::getCategoriaId($idpro, 1) ) //tiene principal asociada?
		{ //si, actualiza
			$sql="UPDATE tbpro_categorias SET Principal=1 WHERE idProducto=? AND idCategoria=?";             
			$stmt=$this->dbh->prepare($sql);
					
			$stmt->bindValue(1,$idpro,PDO::PARAM_INT);
			$stmt->bindValue(2,$idcategoria,PDO::PARAM_INT);
					
			if($stmt->execute())		
				return true;
			else
				return false;	
		}else
			{ //no, se crea			
				self::add($idpro, $idcategoria, 1); //se crea nueva fila				
		}	

		
		if(self::isCategoriaAsoc($idpro, $idcategoria, 0))  //existe como secundaria?
					{echo "entro";exit;self::delete($idpro, $idcategoria,0);} //si, entonces se borra
									
    }
    
    public function delete($idpro, $idcat, $principal=0)
    {        
        //primero es necesario checkear la integridad referencial
            
            if(empty($idpro) or empty($idcat) ) exit;
            $sql="delete from tbpro_categorias where idProducto=? AND idCategoria=? AND Principal=?";
    		
    		$stmt=$this->dbh->prepare($sql);            
                        
            $stmt->bindValue(1,$idpro,PDO::PARAM_INT);
    		$stmt->bindValue(2,$idcat,PDO::PARAM_INT);
			$stmt->bindValue(3,$principal,PDO::PARAM_INT);
    		
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