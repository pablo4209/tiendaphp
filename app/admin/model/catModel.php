<?php

class Categorias extends Conectar
{
    private $u;

    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function get_categorias($padre=0, $publicar="todos")
    {        
        

        if( $padre > 0 ){
            $filtro = " WHERE a.idPadre=" . $padre;    
        }
        else{
            if( $padre == 0){
                $filtro = " WHERE a.idPadre=0";       
            }else{
                if($publicar ==1) $filtro = " WHERE ";
            }

        }

        if($publicar == 1) $filtro .= " a.Publicar = 1 ";               
      

        $sql="SELECT a.idCategoria, a.Nombre, a.Descripcion, a.idPadre, a.FechaAlta, a.HoraAlta, a.ImgPath,
              a.Iniciales, a.Color, a.Publicar
              FROM tbcategorias AS a " . $filtro ." order by a.Nombre asc";

        return parent::getRowId($sql, array($padre));
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
		
        return parent::getRowId($sql, array($id));
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
        $result = parent::getRowId($sql, array($id));

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


    
    //
    /// retorna el html del arbol de $idCategoria con vinculos hacia accion=home (esto se puede cambiar para que reciba cualquier accion)
    //
    public function getTree($idCategoria=0, $instancia=0, $accion="home", $varRet="cat")
    {

         if ($idCategoria>0)
         {                

                $sql = "SELECT * FROM tbcategorias where idCategoria = ? Limit 1";
                $rs = parent::getRowId($sql, array($idCategoria));  
                $ruta ="";
                if(sizeof($rs)){                    
                    if($instancia==0){
                        $li = '<li class="active">'.$rs[0]["Nombre"].'</li>';                        
                    }else{
                        $li = '<li><a href="'.BASE_URL.'?accion='. $accion .'&'. $varRet .'='.$rs[0]["idCategoria"].'">'.$rs[0]["Nombre"].'</a></li>';                        
                    }
                    $ruta = $li . $ruta;
                    
                    if($rs[0]["idPadre"]>0) { //la primera vez instancia = 0, no crea vinculo                                           
                            
                            //$cat= new Categorias(); //para recursividad hay que instanciar nuevos objetos
                            $ruta = self::getTree( $rs[0]["idPadre"], $instancia+1, $accion, $varRet ) . $ruta;     

                    }
                    if($instancia==0){
                        $ruta = '<div class="row"><ol class="breadcrumb"><li><a href="'.BASE_URL.'?accion='. $accion .'">Home</a></li>' . $ruta;
                        $ruta  .= '</ol></div>';
                    } 
                    return $ruta;
                }else
                    return "";
         }else return "";
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
    	$rs = parent::getRowId($sql, array($idPadre));

    	$totalRows = sizeof($rs);

       if($totalRows > 0)
       {
    	   if($idPadre==0){
    	   		$sep = "";
    			$instancia  = 0;
                $respuesta  = '<Select id="'.$nombre.'" name="'.$nombre.'" class="form-control">';
                $respuesta .='<option value="0" ';
                if($catSeleccionada == 0) $respuesta .= 'selected="selected"';
                $respuesta .= ' >' . $primerOpcion. '</option>';

    	   }else {
    	   		
                //for($i=1;$i<=($instancia+1);$i++)
    	   		//{
    			//	$sep = $sep."&nbsp;&nbsp;&nbsp;";
    			//}                
    			$instancia = $instancia+1;
                $sep = ' style="padding-left: ' . ($instancia*30) . 'px;"';
    	   }
    	   for($i=0;$i<$totalRows;$i++)
    	   {
    			$respuesta .= '<option value="'. $rs[$i]['idCategoria'].'" ';
                if ($rs[$i]['idCategoria']== $catSeleccionada) $respuesta .='selected="selected"';
                $respuesta .=  $sep . ' >' . $rs[$i]['Nombre'] . '</option>';
                $cat2= new Categorias();
    			$respuesta .= $cat2->getSelCategorias($rs[$i]['idCategoria'], $catSeleccionada,"",$instancia);

    	   }
           if($instancia == 0) $respuesta .= '</Select>';
       }

	   return $respuesta;
    }


}

?>
