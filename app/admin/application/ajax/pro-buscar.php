<?php

/* 
 * utilizado para ajax
 */
//require_once(APP_PATH . 'config.php'); //
//require_once( MODEL_PATH . "proModel.php");

function obtener_datos()
{
  $datos=array();
  
  $datos[]=array('value' => 'modern warfare',
               'categoria' => ''
               'foto' => 'ruta.jpg');
  $datos[]=array('value' => 'modern warfare 2',
               'categoria' => ''
               'foto' => 'ruta.jpg'); 
  $datos[]=array('value' => 'modern warfare 3',
               'categoria' => ''
               'foto' => 'ruta.jpg');
               
  return $datos;
}

echo json_encode( obtener_datos() );



function buscar_codigo(){ //buscar producto en codigo, barcode, barcode2
    
   echo "buscar_codigo" ;
}

function buscar_nombre(){ //buscar por nombre
    echo "buscar_nombre" ;
    
}
function buscar_porCategoria(){ //buscar nombre en categoria
    
    echo "buscar_porCategoria" ;
}
function buscar(){ //buscar por nombre, codigo, barcode, barcode2
    
    echo "buscar todo" ;
}

//comprobamos que sea una petici�n ajax
//if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
//{
	
	//if(isset($_POST["func"]) && $_POST["func"]!="")
	//{
	 	// 		switch ($_POST["func"]) {
		//		case 'cod':
		//			buscar_codigo();
		//			break;
	//			case 'nombre':
	//				buscar_nombre();
	//				break;
	//			case 'enCategoria':
	//				buscar_porCategoria();
//					break;
	//			case 'todos':
	//				buscar();
	//				break;
//			}
//	}	
	
//}else{
//    throw new Exception("Error Processing Request", 1);    
//}