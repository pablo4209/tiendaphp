<?php
//ini_set("display_errors" , "1" );

//el get de los registros esta configurado en la llamada ajax de tablesorter
require_once( MODEL_PATH . "catModel.php" );
require_once( MODEL_PATH . "monModel.php" );
require_once( MODEL_PATH . "proModel.php");
require_once( MODEL_PATH . "proTipoModel.php");
require_once( MODEL_PATH . "ivaModel.php");
require_once( MODEL_PATH . "listModel.php");
require_once( MODEL_PATH . "depModel.php");
require_once( MODEL_PATH . "proPreciosModel.php");
require_once( MODEL_PATH . "proStockModel.php");
require_once( MODEL_PATH . "proCatModel.php");
require_once( MODEL_PATH . "catModel.php");



if(isset($_POST["grabar"]) && $_POST["grabar"] !="" )
{	
	//print_r($_POST);exit;
	
	$pro=new Producto();  
	$p=$pro->getProductoId($_POST["idProducto"]);	
	
	//////////////////////////tratar la IMAGEN	
	if(isset($_POST["Imagen"]) && $_POST["Imagen"]!="" )  //si la imagen no se cambia este campo no esta seteado
	{		
		
		//guardar la imagen nueva en la carpeta correspondiente		
		$pathorigen = PATH_JS."upload/temp/"; //carpeta tmp donde esta la imagen actualmente
		if(file_exists($pathorigen.$_POST["Imagen"]))	//existe la imagen?
		{
			if(isset($_POST["idCategoria"]) && $_POST["idCategoria"]!="") 
			{
				$cm = new Categorias();		
				$cat=$cm->getCategoriaId($_POST["idCategoria"]); //buscar directorio destino de la imagen
				if($cat[0]["ImgPath"] !="")
				{
					$dircat = $cat[0]["ImgPath"];
				}else
					$dircat="GEN";	
			}	
			$destino = PATH_IMG.$dircat."/";
			//comprobamos si existe un directorio de la categoria para subir el archivo    
			if(!is_dir($destino)){  	
				mkdir($destino, 0777); //si no es así, lo creamos			
			}
			//mover y guardar usando id de nombre
			rename($pathorigen.$_POST["Imagen"], $destino.$_POST["idProducto"]);					
			array_map( "unlink", glob( $pathorigen . '*.*' )); //borrar el contenido del directorio temporal		
			//borrar imagen vieja					
			array_map( "unlink", glob( $destino.$p[0]["Imagen"])); 
		}
	} 
	

		
	if($pro->edit()) //true si success
	{				
		/////////////////////MODIFICAR LISTAS en tbpro_precios		*** REVISADO	OK		
		if(isset($_POST["margen"]))
		{
			$pp=new proPrecios();			
			foreach ($_POST['margen'] as $idlista => $margen){ 
					//echo $id. ' '.$lista.'</br>';
					if(! $pp->edit($_POST["idProducto"], $idlista, $margen)) 
					{
						$pp->add($_POST["idProducto"], $idlista, $margen ); // si da error por no poder modificarse se crea
					}
					
			}
		}		
		/////////////////////MODIFICAR STOCK		*** REVISADO	OK		
		if(isset($_POST["stock"]))
		{
			$ps = new proStock();
			foreach ($_POST['stock'] as $id => $stock){ 					
					$min = (isset($_POST['stockmin'][$id])) ? $_POST['stockmin'][$id]: 0;
					$max = (isset($_POST['stockmax'][$id])) ? $_POST['stockmax'][$id]: 0;
					
					if(! $ps->edit( $_POST["idProducto"], $id, $stock, $min, $max ) )
					{
						$ps->add($_POST["idProducto"], $id, $stock, $min, $max);
					}
				
			}	
		}
	// HASTA ACA EDIT ESTA REVISADO VER XQ SOLO SE MODIFICA ACA LA CAT PRINCIPAL
	
		/////////////////////Asociar Categorias
		// idCategoria es el select principal, 
		// $_POST["otrasCat"] es un array de categorias secundarias que tambien es necesario recorrer y asociar/eliminar
		if(isset($_POST["idCategoria"]) && $_POST["idCategoria"]>0) 
		{
			$pc = new proCategorias();			
						
			$pc->edit($_POST["idProducto"], $_POST["idCategoria"], 1); // se setea la categoria principal					
		}		
		
		header("Location:".BASE_URL."?accion=pro-edit&id=".$_POST["idProducto"]."&st=".MSG_SUCCESS);exit; 	
	}else
	{
		header("Location:".BASE_URL."?accion=pro-edit&id=".$_POST["idProducto"]."&st=".MSG_DANGER);exit;
	}
	   
}
else
{	
	
	$Titulo = "Producto no econtrado";
	$Regreso = BASE_URL . '?accion=pro'; //regresa al listado por defecto

	if(isset($_GET["id"]) && $_GET["id"]!="")
	{
		
		$id=$_GET["id"];	

		$pro=new Producto();
		$p= $pro->getProductoId($id);		
		
		if(!empty($p))
		{
			
			$Titulo = $p[0]['Nombre']; 
			$idPadre = $p[0]["idPadre"];
			$ImponerPrecio = 0;

			//PRODUCTO O SUB?
			if( $idPadre > 0 ){

				$Regreso .= '-edit&id=' . $idPadre ; //regresa al producto padre
				$clsPadre = new Producto(); //es un subproducto, cargar datos de padre
				$pPadre = $clsPadre->getProductoId( $idPadre );
				if( !empty( $pPadre ) ){				
					$Titulo = $pPadre[0]['Nombre'].'('.$pPadre[0]['Codigo'].') ->' . $Titulo;
					$ImponerPrecio = $pPadre[0]['ImponerPrecio'];
				}

				
			}else{								
				$subpro=new Producto();
				$sp= $subpro->getSubProductos($id);		//SUBPRODUCTOS ASOCIADOS
			

			}

			
			//CATEGORIAS

			$idProCat = ( $idPadre > 0 )? $idPadre : $id ; //si es hijo mostrar categorias del padre

			$pc = new proCategorias();
			$pcat = $pc->getCategoriaId($idProCat, 1); //segundo parametro principal = 1
			if(sizeof($pcat)) {
				$idcatp = $pcat[0]["idCategoria"];	
			}else $idcatp = 0;
			

			$cat= new Categorias();
			$selCat = $cat->getSelCategorias(0,$idcatp,"Seleccionar Categoria");
			$selCat2 = $cat->getSelCategorias(0,0 ,"Seleccionar Categoria",0 , "idCategoria2"); //sin seleccionar ninguno
			$ruta  = $cat->getTree($idcatp, 0, "cat", "p");
			$catprinc = $cat->getCategoriaId($idcatp); //obtener la carpeta donde estan las imagenes
			
			//IMAGEN
			$imgdir = "ACC";
			 if(sizeof($catprinc))
				if($catprinc[0]["ImgPath"] != "")$imgdir = $catprinc[0]["ImgPath"];

			$mon= new Moneda();
			$selMon = $mon->getSelMonedas($p[0]["idMoneda"]);
			$tipo= new ProductoTipo();
			$seltipo = $tipo->crearSelect($p[0]["idTipo"]);
			$iva = new iva();
			$seliva = $iva->crearSelect($p[0]["idIva"]);

				//faltan cargar prolistas, prodepositos
				$l = new Listas();
				$listas = $l->getListas();
				$dep= new Depositos();
				$depositos = $dep->getDepositos();
				
				$proP = new proPrecios();
				$proPrecios = $proP->getPrecioId($id); 
				
				$proS = new proStock();
				$proStock = $proS->getStockId($id);
			
			

		}
	}
	
}

	$Titulo  = '<h2>' . $Titulo . '</h2>' .'<a class="btn btn-success" href="#" role="button">Edicion <span class="badge">X</span></a>';
	$Titulo .= ( $p[0]["Habilitado"] )? '' : '<a class="btn btn-warning" href="#" role="button">Deshabilitado <span class="badge">X</span></a>' ;
	

	$vista = new View();
	$vista->incluir( INC_CONTENT_CSS . INC_JQUERYUI . INC_VALIDATE . INC_VALIDATE_REGLAS . INC_PRO_JS . INC_TABLESORTER . INC_TABLESORTER_PAGER );
	$vista->renderHeader("pro");
	require_once( VIEW_PATH . 'pro-edit.phtml' );
	//require_once( VIEW_PATH . 'buscar-prod.php' ); //dialogo de busqueda de productos
	$vista->renderFooter();

?>