<?php

class Categorias extends Conectar
{
    private $u;   

    public function __construct()
    {
        parent::__construct();
        $this->u=array();   
    }
    
    public function get_categorias($padre="0")
    {
        
        if(!is_numeric($padre))$padre = 0;
        
        $sql="SELECT a.idCategoria, a.Nombre, a.Descripcion, a.idPadre, a.FechaAlta, a.HoraAlta, a.ImgPath,
              a.Iniciales, a.Color, a.Publicar
              FROM tbcategorias AS a              
              WHERE a.idPadre = ". $padre ." order by a.Nombre asc";
        
        return parent::getRowId($sql, $padre);
    }
    
    public function add()
    {
        //print_r($_POST);exit;
        
        if(empty($_POST["Nombre"]))        
        {   
            header("Location:".BASE_URL."?accion=cat-add&p=".$_POST["p"]."&st=1");exit;
        }        
        
        $sql = "INSERT INTO `tbcategorias`(
                `idCategoria`, `Nombre`, `Descripcion`, `idPadre`, `FechaAlta`, `HoraAlta`, `ImgPath`, `Iniciales`,
                `Color`, `Publicar`)
                VALUES (NULL , ?, ?, ?, NOW( ) , NOW( ) , ?, ?, ?, ?)";    
                
        //los checks no tildados no generan variable post!!        
        $p = (isset($_POST["Publicar"]))? 1:0;
        $c = (is_numeric($_POST["Color"]))? $_POST["Color"]:-2147483643; //campos numericos dan error si estan null
        
        $stmt=$this->dbh->prepare($sql);
                
        $stmt->bindValue(1,$_POST["Nombre"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["Descripcion"],PDO::PARAM_STR);
        $stmt->bindValue(3,$_POST["idCategoria"],PDO::PARAM_INT);
        $stmt->bindValue(4,$_POST["ImgPath"],PDO::PARAM_STR);
        $stmt->bindValue(5,$_POST["Iniciales"],PDO::PARAM_STR);
        $stmt->bindValue(6,$c,PDO::PARAM_INT);
        $stmt->bindValue(7,$p,PDO::PARAM_STR);
        
        
        $res = $stmt->execute();       
        
        if($res)
        {
            header("Location:".BASE_URL."?accion=cat-add&p=".$_POST["p"]."&st=2");exit;  
        }else{
            print_r($stmt->errorInfo());
            //header("Location:".Conectar::ruta()."user-add/3/");exit; 
        }
        $this->dbh=null;
                
    }
    
    public function getCategoriaId($id)
    {       
        $sql="SELECT a.idCategoria, a.Nombre, a.Descripcion, a.idPadre, a.FechaAlta, a.HoraAlta, a.ImgPath,
              a.Iniciales, a.Color, a.Publicar
              FROM tbcategorias AS a              
              WHERE a.idCategoria = ?";
        
		parent::ClearArray();
        return parent::getRowId($sql, $id);                                       
    }     
    
    public function edit()
    {
        if(empty($_POST["Nombre"]))
        {
            header("Location:".BASE_URL."?accion=cat-edit&id=".$_POST["id"]."&st=1");exit;
        }
        
        $sql="update tbcategorias
              set
              Nombre=?, Descripcion=?, idPadre=?, ImgPath=?, Iniciales=?, Color=?, Publicar=?              
              where
              idCategoria=?";
              
        $p = (isset($_POST["Publicar"]))? 1:0;
        $c = (is_numeric($_POST["Color"]))? $_POST["Color"]:-2147483643;
        
        $stmt=$this->dbh->prepare($sql);
        
        $stmt->bindValue(1,$_POST["Nombre"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["Descripcion"],PDO::PARAM_STR);
        $stmt->bindValue(3,$_POST["idCategoria"],PDO::PARAM_STR);
        $stmt->bindValue(4,$_POST["ImgPath"],PDO::PARAM_STR);
        $stmt->bindValue(5,$_POST["Iniciales"],PDO::PARAM_INT);
        $stmt->bindValue(6,$c,PDO::PARAM_INT);
        $stmt->bindValue(7,$p,PDO::PARAM_INT);
        $stmt->bindValue(8,$_POST["id"],PDO::PARAM_INT);
        
        if($stmt->execute())
        {
            header("Location:".BASE_URL."?accion=cat-edit&id=".$_POST["id"]."&st=2");
        }else
        {
           header("Location:".BASE_URL."?accion=cat-edit&id=".$_POST["id"]."&st=3"); 
        }       
        
        $this->dbh=null;
    }
    
    public function delete($id, $catRegreso)
    {        
        //primero es necesario checkear la integridad referencial
        
        $sql = "SELECT * FROM tbcategorias WHERE idPadre = ?";    
        $result = parent::getRowId($sql, $id);
        
        if(!sizeof($result))    
        {   
            
            $sql="delete from tbcategorias where idCategoria=?";
    		
    		$stmt=$this->dbh->prepare($sql);            
            
            
            $stmt->bindValue(1,$id,PDO::PARAM_INT);
    		
    		
    		if($stmt->execute())
            {                        
                header("Location: ".BASE_URL."?accion=cat&st=2&p=".$catRegreso);
            }else
            {
                header("Location: ".BASE_URL."?accion=cat&st=1&p=".$catRegreso);
            }
            $this->dbh=null;  
        }else
        {
            header("Location: ".BASE_URL."?accion=cat&st=3&p=".$catRegreso);
        }
        $this->dbh=null;                
    }
	
	
    
    //*++++++++******************+++++++++++++++++*+++++++++++++++*++++++++++++++++
	//solo devuelve true cuando existe $iniciales, cualquier otra posibilidad false
    public function extistenIniciales($iniciales)
    {
       if($iniciales != "")
       {            
			$sql="SELECT `Iniciales` FROM `tbcategorias` WHERE `Iniciales`='" . trim($iniciales) . "%'";
			$res = parent::getRows($sql);
			if(sizeof($res))
			{					
				return true;
			}else return false;
       }else       
			return false;
    }
    
    //LISTA Ruta DE PARENTS DE "$id"
    //
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function getRuta($padre, $flag=0)
    {	
         if (isset($padre) and $padre != "")
         {		
         		//separamos las variables que vamos a modificar del QUERY_STRING
        		$queryString_Datos = "";
        		if (!empty($_SERVER['QUERY_STRING'])) {
        		  $params = explode("&", $_SERVER['QUERY_STRING']); //se separan las variables en un string delimitado
        		  $newParams = array();
        		  foreach ($params as $param) { //cada elemento delimitado guardo en array menos las var que necesito mod
        			if (stristr($param, "p") == false) {
        			  array_push($newParams, $param);
        			}
        		  }
        		  if (count($newParams) != 0) { //se crea la cadena con formato query para la url
        			$queryString_Datos = "&" . htmlentities(implode("&", $newParams));
        		  }
        		} 
                
                $sql = "SELECT * FROM tbcategorias where idCategoria = ? ";                
                $rs = parent::getRowId($sql, $padre);	        
                $ruta ="";
        			if($rs[0]["idPadre"]>0) {				 
        				if($flag==0){        					
                            $ruta = " > <hr></br>"; //la primera vez flag es = 0, no crea vinculo                                                                                                                                      
        				}else{					
        					$link = '<a href="'.sprintf("%s?p=%d%s", BASE_URL,$rs[0]["idCategoria"], $queryString_Datos).'">'.$rs[0]["Nombre"].'</a>';
        					$ruta = " > ".$link.$ruta;					
        				}
                        $cat= new Categorias(); //para recursividad hay que instanciar nuevos objetos
                        $ruta = $cat->getRuta( $rs[0]["idPadre"],1 ).$ruta;        				                        
        			}else{			
        				$ruta = ' > <a href="'.sprintf("%s?p=%d%s",BASE_URL,$rs[0]["idCategoria"], $queryString_Datos).'">'.$rs[0]["Nombre"].'</a>'.$ruta;	
        				$ruta = '<a href="'.sprintf("%s?p=%d%s", BASE_URL, 0, $queryString_Datos).'">Root</a>'.$ruta;
                        				
    			        
                    }		        				
        	return $ruta;			
         }
    }
    
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //si la llamo con $idPadre = 0 crea la lista completa de categorias
    //$catSeleccionada es la categoria que figura seleccionada en el control
    //$primerOpcion es el titulo de la primer opcion del select
    //$instancia es de uso interno    
    public function getSelCategorias($idPadre, $catSeleccionada=0, $primerOpcion="Categoria Principal", $instancia=0, $nombre="idCategoria")
    {	
    	$sep="";
		$respuesta ="";		
    	$sql = "SELECT * FROM tbcategorias WHERE idPadre = ? ORDER BY tbcategorias.Nombre ASC";
    	$rs = parent::getRowId($sql, $idPadre);
        
    	$totalRows = sizeof($rs);
	
       if($totalRows > 0)
       {
    	   if($idPadre==0){
    	   		$sep = "";
    			$instancia  = 0; 
                $respuesta  = '<Select id="'.$nombre.'" name="'.$nombre.'" class="select input">';
                $respuesta .='<option value="0" ';
                if($catSeleccionada == 0) $respuesta .= 'selected="selected"';                   
                $respuesta .= ' >' . $primerOpcion. '</option>';
           
    	   }else {
    	   		for($i=1;$i<=($instancia+1);$i++)
    	   		{
    				$sep = $sep."&nbsp;&nbsp;&nbsp;";			
    			}
    			$instancia = $instancia+1;
    	   }
    	   for($i=0;$i<$totalRows;$i++)
    	   {
    			$respuesta .= '<option value="'. $rs[$i]['idCategoria'].'" ';
                if ($rs[$i]['idCategoria']== $catSeleccionada) $respuesta .='selected="selected"';
                $respuesta .= ' >'. $sep . $rs[$i]['Nombre'].'</option>';					
                $cat2= new Categorias();
    			$respuesta .= $cat2->getSelCategorias($rs[$i]['idCategoria'], $catSeleccionada,"",$instancia);
				
    	   } 
           if($instancia == 0) $respuesta .= '</Select>';
       }	   
       
	   return $respuesta;    
    }

}

?>