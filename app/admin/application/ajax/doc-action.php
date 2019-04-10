<?php
/**
 *  respuestas ajax para las acciones en documentos
 *
 * @var [type]
 */

 if(isset($_SESSION["doc"]))
 {
		 require_once(APP_PATH . 'config.php');
		 require_once( MODEL_PATH . "proModel.php");
		 require_once( MODEL_PATH . "docRenderModel.php");
     
			$doc = $_SESSION["doc"];
 			$doc = unserialize($doc);
 			$items = $doc->getItems();

			if( isset( $_POST["buscarCodigo"] ) && $_POST["buscarCodigo"] == 1 && isset( $_POST["txtBuscar"] ) ){

					$cantidad =1;
					if( is_numeric($_POST["txtCantidad"]) )
							if( $_POST["txtCantidad"] >0 )
									$cantidad = $_POST["txtCantidad"];

					$items->add(
											 array( "Codigo"=>$_POST["txtBuscar"],
				 											"Cantidad"=>$cantidad
														)
										 );
			}

			if( isset( $_POST["eliminarItem"] ) && $_POST["eliminarItem"] == 1 && isset($_POST["idProducto"]) ){
						$items->del($_POST["idProducto"]);
			}

			$_SESSION["doc"] = serialize($doc);
			echo $items->getTBody();

 }else {
 			echo "SE HA PERDIDO LA SESION.:(";
 }


?>
