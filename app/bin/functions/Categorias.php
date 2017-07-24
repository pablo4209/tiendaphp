<?php
	require_once( CONN_MODEL_PATH . "catModel.php");


$db = new Categorias();
$cat = $db->get_categorias( -1, 1); //retorna las categorias que tienen habilitado publicar

//
// recibe el $idCategoria y retorna el html con la ruta de categorias o "breadcumbs"
//
function getRuta($id=0, $accion="", $get="", $enable=true){

	if($id>0){			
		$db = new Categorias();
		
		return $db->getTree($id, 0, ($accion !="")? $accion:"home", ($get !="")? $get:"cat" , $enable); //funcion ubicada en el modelo que crea el arbol de rutas

	}else
		return "";
}

//retorna las categoria de un producto, recibe el $idProducto,
//$principal =1 retorna la categoria principal, sino las otras asociadas
//retorna un array, para accederlo: $res[0]['idCategoria']
function catProd($idProducto=0, $principal=0){
	require_once( CONN_MODEL_PATH . "proCatModel.php");
	$db = new proCategorias();
	$res = $db->getCategoriaId($idProducto, $principal); //getCategoriaId($id, $principal=0) //obtiene todas las categorias asociadas a $id (idproducto), segun($idProducto principal	
	return $res;
	
}

//devuelve la ruta de la carpeta asignada a la categoria, recibe el id del producto
function pathCategoriaProd($id=0){
		
	$result = catProd($id, 1);	

	if( sizeof($result) && $result[0]['Publicar'] ){		
			return $result[0]['ImgPath'];
	}else
			return "";
}

//retorna un array con las categorias idpadre = $id,  por defecto $id=0
function getSubCategorias($id=0){
	global $cat;

	$subs = array();
	foreach($cat as $row){
		if($row['idPadre'] == $id){
			$subs[]=$row;	
		}
		
	}
	return $subs;
}

//$cat : array de categorias
//$idpadre
//$instancia: uso interno para recurrencia
function menuCategorias($idpadre = 0, $cat, $activa = 0 ,$instancia = 0){

 	$result = sizeof($cat);
 	if($result>0){
	 	switch  ($instancia){
	 		case 0: echo '<ul class="nav in" id="side-menu" aria-expanded="true">';   break;
	 		case 1: echo '<span class="fa arrow"></span></a><ul class="nav nav-2-level collapse">';break;
	 		case 2: echo '<span class="fa arrow"></span></a><ul class="nav nav-3-level collapse">';break;
	 		case 3: echo '<span class="fa arrow"></span></a><ul class="nav nav-4-level collapse">';break;
	 	}
 	}else echo "</a>";

	//for($i=0;$i<$instancia;$i++){ $separador .= ">>"; }	
	$instancia++;
	foreach($cat as $sub){							
			if($sub['idPadre'] == $idpadre){	
				$clase =  ($activa == $sub['idCategoria'])? ' class="active':'';
				echo '<li'.$clase.'><a href="'.BASE_URL.'?accion=catalogo&cat='.$sub['idCategoria'].'"  aria-expanded="true">'. $sub['Nombre'] ;	

				menuCategorias($sub['idCategoria'], getSubCategorias($sub['idCategoria'] ),0 ,$instancia);				
				echo "</li>";	
			}			
		}
	if($result) echo "</ul>";

}
?>