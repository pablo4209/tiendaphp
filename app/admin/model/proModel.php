<?php

class Producto extends Conectar
{
    private $u;

    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function getProductos($where=" order by Nombre asc ", $limit=" ")
    {
        $sql="SELECT `idProducto` ,  `Codigo` ,  `Nombre` , `CodBar` ,  `CodBar2` ,  `idPadre` ,  `idTipo` , `Publicar` ,
              `Destacado`,`Imagen` , `Habilitado`
              FROM  `tbpro` ". $where . $limit ;
        return parent::getRows($sql);
    }

    //recibe cadena de busqueda y retorna conjunto de registros
    public function getProductosBuscar( $txt="" )
    {
    	$sql  = "SELECT a.idProducto, 
	    					ANY_VALUE(a.Nombre), 
							ANY_VALUE(a.Codigo), 
	    					ANY_VALUE(Round(((a.Costo*a.UnidxDef*e.Cambio*c.Margen/100)+a.Costo*a.UnidxDef*e.Cambio),2))  as Precio, 
	    					ANY_VALUE(a.Usado), 
							ANY_VALUE(c.Margen), 
							ANY_VALUE(d.Stock), 
							a.Imagen
					FROM tbpro as a 
			                   LEFT JOIN  tbpro_categorias as b ON a.idProducto = b.idProducto
			                   LEFT JOIN  tbpro_precios as c ON a.idProducto = c.idProducto
			                   LEFT JOIN  tbpro_stock as d ON a.idProducto = d.idProducto
			                   LEFT JOIN  tbmoneda as e ON a.idMoneda = e.idMoneda
					WHERE  a.Publicar = 1 AND a.Habilitado =1 AND c.idLista = 1						
					AND a.Nombre LIKE ? 
	    	 		GROUP BY a.idProducto "; 
	    	 		//LIMIT ?, ?";
	    	
	    	$consulta=$this->dbh->prepare($sql);
	    	$consulta->bindValue(1,'%'.$txt.'%',PDO::PARAM_STR);
	        //$consulta->bindValue(2,$limit_start,PDO::PARAM_INT);
	        //$consulta->bindValue(3,$limit_end,PDO::PARAM_INT);

	        return parent::exePrepare_FetchAssoc($consulta);
    }
  

	//recibe parametros para armar una consulta filtrada y retorna listado en json
    public function getProductosAjax($txtbuscar, $limite="" , $campo_cat="",$campo_orden="", $habilitado)
    {
       if($campo_cat == "")
       {
            $sql="SELECT  `idProducto`, `Codigo` ,  `Nombre` , `idPadre` ,  `idTipo` , `Publicar`
                  FROM  `tbpro` " . $txtbuscar . $habilitado . $campo_orden . $limite;
       }else
       {
            $sql="SELECT tbpro.idProducto, tbpro.Codigo, tbpro.Nombre, tbpro.idPadre, tbpro.idTipo, tbpro.Publicar
                  FROM tbpro
                  Inner Join tbpro_categorias ON tbpro.idProducto = tbpro_categorias.idProducto " . $txtbuscar . $habilitado . $campo_cat . $campo_orden . $limite;
       }
        return parent::getRowsJson($sql);
    }

	public function buscar_codigo($iniciales)
    {
       if($iniciales != "")
       {
			$sql="SELECT Max(`Codigo`) as ultimo FROM  `tbpro` WHERE Codigo LIKE '" . trim($iniciales) . "%'";
			$res = parent::getRows($sql);
			if(sizeof($res))
			{
				return parent::sumarUno($res[0]["ultimo"], $iniciales);
			}else return trim($iniciales)."0001";
       }else
			return "GEN0001";
    }

    public function add()
    {

        if(empty($_POST["Nombre"]) or empty($_POST["Codigo"]) or empty($_POST["idCategoria"]) or empty($_POST["idMoneda"]) or empty($_POST["idIva"]))
        {
            header("Location:".BASE_URL."?accion=pro-add&st=".MSG_WARNING);exit;
        }

        if(!parent::getRowId("SELECT tbpro.Codigo FROM tbpro WHERE Codigo=?",array($_POST["Codigo"]))) //si es codigo ya existe no lo crea
		{
			$sql="INSERT INTO tbpro ( `idProducto`, `Codigo`, `Nombre`, `SEO`, `FechaIngreso`, `HoraIngreso`, `idMoneda`, `Costo`, `UnidxDef`,
				  `MaxDescuento`, `pDescuento`, `Imagen`, `CodBar`, `CodBar2`, `idMarca`, `idPadre`, `idTipo`, `idIva`, `Garantia`, `Descripcion`,
				  `Nota`, `NotaEmerg`, `Publicar`, `Destacado`, `Marcado`, `Usado`, `Reparable`, `VenderSinStock`, `Promociones`, `Habilitado` )
				  VALUES ( NULL ,? ,? ,? ,NOW() ,NOW(),? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )";

			//los checks no tildados no generan variable post!!
			$NotaEmerg  = (isset($_POST["NotaEmerg"]))? 1:0;
			$Publicar  = (isset($_POST["Publicar"]))? 1:0;
			$Destacado  = (isset($_POST["Destacado"]))? 1:0;
			$Marcado  = (isset($_POST["Marcado"]))? 1:0;
			$Usado  = (isset($_POST["Usado"]))? 1:0;
			$Reparable  = (isset($_POST["Reparable"]))? 1:0;
			$VenderSinStock  = (isset($_POST["VenderSinStock"]))? 1:0;
			$Promociones  = (isset($_POST["Promociones"]))? 1:0;
			$Habilitado = (isset($_POST["Habilitado"]))? 1:0;

			$stmt=$this->dbh->prepare($sql);
			$stmt->bindValue(1,$_POST["Codigo"],PDO::PARAM_STR);
			$stmt->bindValue(2,$_POST["Nombre"],PDO::PARAM_STR);
			$stmt->bindValue(3,$_POST["SEO"],PDO::PARAM_STR);
			$stmt->bindValue(4,$_POST["idMoneda"],PDO::PARAM_INT);
			$stmt->bindValue(5,$_POST["Costo"],PDO::PARAM_INT);
			$stmt->bindValue(6,$_POST["UnidxDef"],PDO::PARAM_INT);
			$stmt->bindValue(7,$_POST["MaxDescuento"],PDO::PARAM_INT);
			$stmt->bindValue(8,$_POST["pDescuento"],PDO::PARAM_INT);
			$stmt->bindValue(9,$_POST["Imagen"],PDO::PARAM_STR);
			$stmt->bindValue(10,$_POST["CodBar"],PDO::PARAM_STR);
			$stmt->bindValue(11,$_POST["CodBar2"],PDO::PARAM_STR);
			$stmt->bindValue(12,$_POST["idMarca"],PDO::PARAM_INT);
			$stmt->bindValue(13,$_POST["idPadre"],PDO::PARAM_INT);
			$stmt->bindValue(14,$_POST["idTipo"],PDO::PARAM_INT);
			$stmt->bindValue(15,$_POST["idIva"],PDO::PARAM_INT);
			$stmt->bindValue(16,$_POST["Garantia"],PDO::PARAM_INT);
			$stmt->bindValue(17,$_POST["Descripcion"],PDO::PARAM_STR);
			$stmt->bindValue(18,$_POST["Nota"],PDO::PARAM_STR);
			$stmt->bindValue(19,$NotaEmerg,PDO::PARAM_INT);
			$stmt->bindValue(20,$Publicar,PDO::PARAM_INT);
			$stmt->bindValue(21,$Destacado,PDO::PARAM_INT);
			$stmt->bindValue(22,$Marcado,PDO::PARAM_INT);
			$stmt->bindValue(23,$Usado,PDO::PARAM_INT);
			$stmt->bindValue(24,$Reparable,PDO::PARAM_INT);
			$stmt->bindValue(25,$VenderSinStock,PDO::PARAM_INT);
			$stmt->bindValue(26,$Promociones,PDO::PARAM_INT);
			$stmt->bindValue(27,$Habilitado,PDO::PARAM_INT);


			$res = $stmt->execute();
        }else { header("Location:".BASE_URL."?accion=pro-add&st=".MSG_INFO);exit; }   //ya existe

        if($res)
        {
			return $this->dbh->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
            header("Location:".BASE_URL."?accion=pro-add&st=".MSG_DANGER);exit;
        }


    }

    public function getProductoId($id)
    {
        $sql="SELECT  `idProducto`, `Codigo`, `Nombre`, `SEO`, `FechaIngreso`, `HoraIngreso`, `FechaMod`, `HoraMod`, `FechaUltVenta`, `HoraUltVenta`,
			`idMoneda`, `Costo`, `UnidxDef`, `MaxDescuento`, `pDescuento`, `Vendidas`, `Imagen`, `CodBar`, `CodBar2`, `idMarca`, `idPadre`, `idTipo`,
			`idIva`, `Garantia`, `Descripcion`, `Nota`, `NotaEmerg`, `Publicar`, `Destacado`, `Marcado`, `Usado`, `Reparable`, `VenderSinStock`,
			`Promociones`, `Habilitado`	FROM `tbpro` where idProducto=? LIMIT 1;";

        return parent::getRowId($sql, array($id));                                       
    }

    public function edit()
    {
        if(empty($_POST["Nombre"]) or empty($_POST["Codigo"]) or empty($_POST["idCategoria"]) or empty($_POST["idMoneda"]) or empty($_POST["idIva"]))
        {
            header("Location:".BASE_URL."?accion=pro-edit&st=".MSG_WARNING);exit;
        }

        $sql="UPDATE tbpro
              SET
              `Codigo`=?, `Nombre`=?, `SEO`=?, `FechaMod`=NOW(), `HoraMod`=NOW(), `idMoneda`=?, `Costo`=?, `UnidxDef`=?, `MaxDescuento`=?, `pDescuento`=?,
			  `Imagen`=?, `CodBar`=?, `CodBar2`=?, `idMarca`=?, `idPadre`=?, `idTipo`=?, `idIva`=?, `Garantia`=?, `Descripcion`=?, `Nota`=?,
			  `NotaEmerg`=?, `Publicar`=?, `Destacado`=?, `Marcado`=?, `Usado`=?, `Reparable`=?, `VenderSinStock`=?, `Promociones`=?, `Habilitado`=?
              WHERE
              `idProducto`=?";

		//los checks no tildados no generan variable post!!
		$NotaEmerg  = (isset($_POST["NotaEmerg"]))? 1:0;
		$Publicar  = (isset($_POST["Publicar"]))? 1:0;
		$Destacado  = (isset($_POST["Destacado"]))? 1:0;
		$Marcado  = (isset($_POST["Marcado"]))? 1:0;
		$Usado  = (isset($_POST["Usado"]))? 1:0;
		$Reparable  = (isset($_POST["Reparable"]))? 1:0;
		$VenderSinStock  = (isset($_POST["VenderSinStock"]))? 1:0;
		$Promociones  = (isset($_POST["Promociones"]))? 1:0;
		$Habilitado = (isset($_POST["Habilitado"]))? 1:0;


        $stmt=$this->dbh->prepare($sql);

		$stmt->bindValue(1,$_POST["Codigo"],PDO::PARAM_STR);
		$stmt->bindValue(2,$_POST["Nombre"],PDO::PARAM_STR);
		$stmt->bindValue(3,$_POST["SEO"],PDO::PARAM_STR);
		$stmt->bindValue(4,$_POST["idMoneda"],PDO::PARAM_INT);
		$stmt->bindValue(5,$_POST["Costo"],PDO::PARAM_INT);
		$stmt->bindValue(6,$_POST["UnidxDef"],PDO::PARAM_INT);
		$stmt->bindValue(7,$_POST["MaxDescuento"],PDO::PARAM_INT);
		$stmt->bindValue(8,$_POST["pDescuento"],PDO::PARAM_INT);
		$stmt->bindValue(9,$_POST["Imagen"],PDO::PARAM_STR);
		$stmt->bindValue(10,$_POST["CodBar"],PDO::PARAM_STR);
		$stmt->bindValue(11,$_POST["CodBar2"],PDO::PARAM_STR);
		$stmt->bindValue(12,$_POST["idMarca"],PDO::PARAM_INT);
		$stmt->bindValue(13,$_POST["idPadre"],PDO::PARAM_INT);
		$stmt->bindValue(14,$_POST["idTipo"],PDO::PARAM_INT);
		$stmt->bindValue(15,$_POST["idIva"],PDO::PARAM_INT);
		$stmt->bindValue(16,$_POST["Garantia"],PDO::PARAM_INT);
		$stmt->bindValue(17,$_POST["Descripcion"],PDO::PARAM_STR);
		$stmt->bindValue(18,$_POST["Nota"],PDO::PARAM_STR);
		$stmt->bindValue(19,$NotaEmerg,PDO::PARAM_INT);
		$stmt->bindValue(20,$Publicar,PDO::PARAM_INT);
		$stmt->bindValue(21,$Destacado,PDO::PARAM_INT);
		$stmt->bindValue(22,$Marcado,PDO::PARAM_INT);
		$stmt->bindValue(23,$Usado,PDO::PARAM_INT);
		$stmt->bindValue(24,$Reparable,PDO::PARAM_INT);
		$stmt->bindValue(25,$VenderSinStock,PDO::PARAM_INT);
		$stmt->bindValue(26,$Promociones,PDO::PARAM_INT);
		$stmt->bindValue(27,$Habilitado,PDO::PARAM_INT);
		$stmt->bindValue(28,$_POST["idProducto"],PDO::PARAM_INT);


        return parent::exePrepare($stmt);

    }

    public function delete()
    {
        //primero es necesario checkear la integridad referencial

            $sql="delete from tbmoneda where idMoneda=?";

    		$stmt=$this->dbh->prepare($sql);

            $id=$_GET["id"];
            $stmt->bindValue(1,$id,PDO::PARAM_INT);


    		if($stmt->execute())
            {
                header("Location: ".BASE_URL."?accion=mon&st=".MSG_SUCCESS);
            }else
            {
                header("Location: ".BASE_URL."?accion=mon&st=".MSG_DANGER);
            }

    }

    public function LimpiarArray()
    {
        parent::ClearArray();
    }
}

?>
