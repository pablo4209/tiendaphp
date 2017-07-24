<?php 

//RETORNA TRUE O FALSE
//$nivel : checkea si cumple con nivel de acceso minimo y retorna TRUE O FALSE
function sesionIniciada($nivel=0){
	if(isset($_SESSION["user_id"]))
		if($_SESSION['NivelAcceso'] >= $nivel )
			return true;
		else 
			return false;
	else
		return false;
}

?>