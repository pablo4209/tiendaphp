<?php
/*
*	recibe la constante e imprime un div con los mensajes preseados, 
*	aunque se pueden incluir los mensajes personalizados
*
*/

function mensaje($tipo=MSG_WARNING, $mensaje="", $titulo=""){		
	

		$msg="";$tit="";$clase="";
		switch ($tipo) {
			case MSG_SUCCESS:
				$tit = "información:";
				$clase = "success";
				$msg = "La operacion se completo con éxito.";
				break;
			case MSG_WARNING:
				$tit = "Atención:";
				$clase = "warning";
				$msg = "Revisar datos, no se puede ejecutar la operación.";		
				break;
			case MSG_DANGER:
				$tit = "Error...!!:";
				$clase = "danger";
				$msg = "No se completo la operación.";		
				break;
			case MSG_INFO:
				$tit = "Información:";
				$clase="info";	
				break;
			default:
				$tit = "Información:";					
				$clase = "info";
				$msg = "Mensaje sin identificador adecuado.";
		}
		if( $mensaje != "" ) $msg = $mensaje;
		if( $titulo !="" ) $tit = $titulo;

		echo '
			<div class="content">
			  <div class="row" >
			    <div class="col-md-8 center-block" style="padding-top:30px;">
			      <div class="alert alert-'. $clase .'" role="alert">
			          <h4><strong>' . $tit . '</strong></h4>
			          <p><strong>' . $msg . '</strong></p>
			      </div>
			    </div>
			  </div>
			</div>
		';	
	
}

?>