<?php
/*
    Esta clase asocia categorias a un producto, tabla tpro_categorias:
        - Cada producto tiene al menos una categoria principal, cuyo campo principal = 1 (solo 1 puede ser principal)
        - Al agregar categorias principal o secundarias (principal=0) realiza las comprobaciones si ya existe,
           si es necesario mod secundaria por principal y demás casos.


*/

class proCategorias extends Conectar
{
    private $u;

    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function __destruct(){
    	$this->u=array();
    	parent::__destruct();
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

    //RETORNA LA CANTIDAD DE CATEGORIAS ASOCIADAS A LA RECIBIDA COMO PARAMETRO.
    //util para paginar,
    //es mejor usar un count antes que consultar la tabla entera y hacer sizeof()
    public function getProductosCatCount($idCategoria=0){
		if($idCategoria != 0){
			$sql  = "SELECT a.idProducto
					FROM tbpro as a
			                   LEFT JOIN  tbpro_categorias as b ON a.idProducto = b.idProducto
			                   LEFT JOIN  tbpro_precios as c ON a.idProducto = c.idProducto
			                   LEFT JOIN  tbpro_stock as d ON a.idProducto = d.idProducto
			                   LEFT JOIN  tbmoneda as e ON a.idMoneda = e.idMoneda
					WHERE  a.Publicar = 1 AND a.Habilitado =1 AND c.idLista = 1
	    	 		AND (b.idCategoria = ?
	    	 		OR b.idCategoria IN (SELECT idCategoria FROM tbcategorias WHERE idPadre = ?))
	    	 		GROUP BY a.idProducto";
	 		$var = array($idCategoria, $idCategoria);
		}else{
			$sql  = "SELECT a.idProducto
					FROM tbpro as a
			                   LEFT JOIN  tbpro_categorias as b ON a.idProducto = b.idProducto
			                   LEFT JOIN  tbpro_precios as c ON a.idProducto = c.idProducto
			                   LEFT JOIN  tbpro_stock as d ON a.idProducto = d.idProducto
			                   LEFT JOIN  tbmoneda as e ON a.idMoneda = e.idMoneda
					WHERE  a.Publicar = 1 AND a.Habilitado =1 AND c.idLista = 1
	    	 		GROUP BY a.idProducto";
	 		$var = array();
		}

		$sql = 'SELECT count(*) as total FROM ('.$sql.') AS resultados';

		$res = parent::getRowId($sql, $var);

		if(sizeof($res)){
			return $res[0]['total'];
		}else{
			return 0;
		}

    }

    //retorna listado de productos = idCategoria, con precio calculado, stock, imagen
    //si $idCategoria =0 retorna sin filtro
    public function getProductosCat($idCategoria=0, $pagina=0, $cant_pagina=10000){

    	//Round(((a.Costo*a.UnidxDef*e.Cambio*c.Margen/100)+a.Costo*a.UnidxDef*e.Cambio),2)  as Precio

	    $limit_start = $pagina*$cant_pagina;
	    $limit_end = $limit_start + $cant_pagina;

	    if($idCategoria !=0){
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
	    	 		AND (b.idCategoria = ?
	    	 		OR b.idCategoria IN (SELECT idCategoria FROM tbcategorias WHERE idPadre = ?))
	    	 		GROUP BY a.idProducto LIMIT ?, ?";

 			    $consulta=$this->dbh->prepare($sql);
	        $consulta->bindValue(1,$idCategoria,PDO::PARAM_INT);
	        $consulta->bindValue(2,$idCategoria,PDO::PARAM_INT);
	        $consulta->bindValue(3,$limit_start,PDO::PARAM_INT);
	        $consulta->bindValue(4,$limit_end,PDO::PARAM_INT);

	        return parent::exePrepare_FetchAssoc($consulta);
	    	 //return parent::getRowId($sql, array($idCategoria, $idCategoria, $limit_start, $limit_end));
	    }else{

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
	    	 		GROUP BY a.idProducto LIMIT ?, ?";

	    	  $consulta=$this->dbh->prepare($sql);
	        $consulta->bindValue(1,$limit_start,PDO::PARAM_INT);
	        $consulta->bindValue(2,$limit_end,PDO::PARAM_INT);

	        return parent::exePrepare_FetchAssoc($consulta);

	    	//return parent::getRowId($sql , array($limit_start, $limit_end));
	    }

	}

	  //retorna listado de productos  que pertenecen a idCategoria=idPadre, con precio calculado, stock, imagen
    //si $idCategoria =0 retorna sin filtro
    public function getProductosCatPadre($idCategoria=0, $idLista=1, $idDeposito=1){

    	$sql = "CALL  getProductosCatPadre(?, ?, ?)";


        $consulta=$this->dbh->prepare($sql);
        $consulta->bindValue(1,$idLista,PDO::PARAM_INT);
        $consulta->bindValue(2,$idDeposito,PDO::PARAM_INT);
        $consulta->bindValue(3,$idCategoria,PDO::PARAM_INT);

        return parent::exePrepare_FetchAssoc($consulta);

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

        return parent::exePrepare($stmt);

    }

    public function getCategoriaId($id, $principal=0) //obtiene todas las categorias asociadas a $id (idproducto), segun principal
    {
		if($principal) $principal = 1;
        $sql="select a.`Contador`, a.`idProducto`, a.`idCategoria`, a.`Principal`, b.`Nombre`, b.`ImgPath`, b.`Iniciales`, b.`Publicar` from tbpro_categorias as a, tbcategorias as b where a.idCategoria = b.idCategoria AND a.idProducto=? And Principal=?";

        return parent::getRowId($sql, array($id, $principal));
    }

	public function isCategoriaAsoc($idproducto, $idcategoria, $principal=0) //revisa si la categoria $idproducto ya tiene asociado $idcategoria, segun $principal
    {
		if($principal) $principal = 1;
        $sql="select a.`Contador`, a.`idProducto`, a.`idCategoria`, a.`Principal` from tbpro_categorias as a where  a.idProducto=? AND a.idCategoria = ? AND Principal=?";

		$result = parent::getRowId($sql, array($idproducto, $idcategoria, $principal));
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


			$sql="UPDATE tbpro_categorias SET idCategoria = ? WHERE Principal=1 AND idProducto=?";
			$stmt=$this->dbh->prepare($sql);

			$stmt->bindValue(1,$idcategoria,PDO::PARAM_INT);
			$stmt->bindValue(2,$idpro,PDO::PARAM_INT);

			return parent::exePrepare($stmt);



		//if(self::isCategoriaAsoc($idpro, $idcategoria, 0))  //existe como secundaria?
		//			{echo "entro";exit;self::delete($idpro, $idcategoria,0);} //si, entonces se borra

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
