<?php
/*
	REVISA LAS CATEGORIAS ASOCIADAS A UN PRODUCTO

*/
function buscar_codigo()
{
	if(isset($_POST["idcat"]) && $_POST["idcat"]!="" )
	{			
		//config.php esta incluido
		//require_once( $_POST["apppath"] . "database.php");
		require_once( MODEL_PATH . "catModel.php");
				
		$cat= new Categorias();
		$var=$cat->getCategoriaId($_POST["idcat"]);
		if(sizeof($var))
		{						
			require_once( MODEL_PATH . "proModel.php");				
			$pro=new Producto();				
			echo $pro->buscar_codigo($var[0]["Iniciales"]); //buscar codigo libre de la categoria		
		}else echo "";		
		
	}else echo "";
	
}

function cargar_tabla_cat()
{
	if(isset($_POST["idProducto"]) && $_POST["idProducto"]!="" )
	{			
		
		
		require_once( MODEL_PATH . "proCatModel.php");		
				
		$pc = new proCategorias();
		$cat = $pc->getCategoriaId($_POST["idProducto"]); // devuelve todos los que no son principal					
		$strFila="";
		if(sizeof($cat))
		{				
			foreach($cat as $reg){
				$strFila .= '<tr><td>'.$reg["Nombre"].'
					<input type="hidden" value="'.$reg["idCategoria"].'" name="otrasCat[]" id="otrasCat'.$reg["idCategoria"].'" class="clsFilas"/></td>
					<td><input type="button" value="x" id="delCat'.$reg["idCategoria"].'" title="Eliminar" class="clsEliminarFila"/></td></tr>';
			}	
				echo $strFila;
		}else echo "";				
	}else echo "";
	
}

function delCat()
{
	if(isset($_POST["idProducto"]) && $_POST["idProducto"]!="" )
	{
		require_once( MODEL_PATH . "proCatModel.php");
		
		$pc = new proCategorias();
		$cat = $pc->delete($_POST["idProducto"], $_POST["idCategoria"]); 
		cargar_tabla_cat();	
		
	}else echo "";
}

function addCat()
{
	if(isset($_POST["idProducto"]) && $_POST["idProducto"]!="" )
	{		
		require_once( MODEL_PATH . "proCatModel.php");
		
		$pc = new proCategorias();
		$cat = $pc->add($_POST["idProducto"], $_POST["idCategoria"]); 
		cargar_tabla_cat();	
		
	}else echo "";
}

//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	
	if(isset($_POST["func"]) && $_POST["func"]!="")
	{
			
			switch ($_POST["func"]) {
				case 'cod':
					buscar_codigo();
					break;
				case 'cargarCat':
					cargar_tabla_cat();
					break;
				case 'addCat':
					addCat();
					break;
				case 'delCat':
					delCat();
					break;
			}
	}	
	
}else{
    throw new Exception("Error Processing Request", 1);    
}