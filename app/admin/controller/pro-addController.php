<?php


//el get de los registros esta configurado en la llamada ajax de tablesorter
require_once( MODEL_PATH . "catModel.php" );
require_once( MODEL_PATH . "monModel.php" );
require_once( MODEL_PATH . "proModel.php");
require_once( MODEL_PATH . "proTipoModel.php");
require_once( MODEL_PATH . "ivaModel.php");
require_once( MODEL_PATH . "listModel.php");
require_once( MODEL_PATH . "depModel.php");

if(isset($_POST["grabar"]) and $_POST["grabar"] !="" )
{
	
	//print_r($_POST);exit;

	require_once( MODEL_PATH . "proPreciosModel.php");
	require_once( MODEL_PATH . "proStockModel.php");
	require_once( MODEL_PATH . "proCatModel.php");
	require_once( MODEL_PATH . "catModel.php");
	
    
	///////////////////tratar la IMAGEN	
	if(isset($_POST["Imagen"]) && $_POST["Imagen"]!="" ) 
	{	
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
			$destino = DIR_IMG . $dircat . "/";
			//comprobamos si existe un directorio de la categoria para subir el archivo    
			if(!is_dir($destino)){  	
				mkdir($destino, 0777); //si no es as�, lo creamos			
			}
			//mover		
			rename($pathorigen.$_POST["Imagen"], $destino.$_POST["Imagen"]);		
			array_map( "unlink", glob( $pathorigen . '*.*' )); //borrar el contenido del directorio temporal		
		}
	}
	
	
	$pro=new Producto();
    $ultimo_id = $pro->add();
	
	if(is_numeric($ultimo_id))
	{		
		/////////////////////CREAR LISTAS en tbpro_precios			
		if(isset($_POST["margen"]))
		{
			$pp=new proPrecios();			
			foreach ($_POST['margen'] as $idlista => $margen){ 
					//echo $id. ' '.$lista.'</br>';
					$pp->add($ultimo_id, $idlista, $margen );
			}
		}
		
		/////////////////////CREAR STOCK		
		if(isset($_POST["stock"]))
		{
			$ps = new proStock();
			foreach ($_POST['stock'] as $id => $stock){ 					
					$min = (isset($_POST['stockmin'][$id])) ? $_POST['stockmin'][$id]: 0;
					$max = (isset($_POST['stockmax'][$id])) ? $_POST['stockmax'][$id]: 0;
					$ps->add($ultimo_id, $id, $stock, $min, $max);
			}		
		}
		
		/////////////////////Asociar Categorias
		if(isset($_POST["idCategoria"]))
		{
			$pc = new proCategorias();
			$pc->add($ultimo_id, $_POST["idCategoria"], 1); // set como categoria principal
			if(isset($_POST["otrasCat"]))
			{				
				foreach ($_POST['otrasCat'] as $otracat){
					$pc->add($ultimo_id, $otracat, 0); // set como categoria secundaria
				}				
			}
		}		
		
		header("Location:".BASE_URL."?accion=pro-edit&id=".$ultimo_id."&st=".MSG_SUCCESS);exit; 	
	}else
		header("Location:".BASE_URL."?accion=pro-add&st=".MSG_DANGER);
		
	exit;
	   
}

$idCat = 0;
if(isset($_GET['cat']) && $_GET['cat'] != 0){
	$idCat = $_GET['cat'];
}

$cat= new Categorias();
$selCat = $cat->getSelCategorias(0,$idCat,"Seleccionar Categoria");
$selCat2 = $cat->getSelCategorias(0,0 ,"Seleccionar Categoria",0 , "idCategoria2");
$ruta = ($idCat>0)? $cat->getTree($idCat): "";
$mon= new Moneda();
$selMon = $mon->getSelMonedas(1);
$tipo= new ProductoTipo();
$seltipo = $tipo->crearSelect(1);
$iva = new iva();
$seliva = $iva->crearSelect(1);
$l = new Listas();
$listas = $l->getListas();
$dep= new Depositos();
$depositos = $dep->getDepositos();

$vista = new View();
$vista->incluir( INC_CONTENT_CSS . INC_JQUERYUI . INC_VALIDITY . INC_PRO_JS );
$vista->renderHeader("pro");
require_once( VIEW_PATH . 'pro-add.phtml' );
$vista->renderFooter();

?>