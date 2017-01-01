<?php

//el get de los registros esta configurado en la llamada ajax de tablesorter
require_once( MODEL_PATH . "repModel.php" );

$rep= new Reparaciones();
//$chkTipos = $rep->crearChecks( 2,2); //crea un grupo de checks por cada tipo de documento

$vista = new View();
$vista->incluir( INC_JQUERY . INC_JQUERYUI . INC_TABLESORTER . INC_TABLESORTER_PAGER . 
				'<script type="text/javascript" src="' . PATH_JS . 'doc.js" language="javascript"></script>');
$vista->renderHeader("rep");
require_once( VIEW_PATH . 'rep.phtml' );
$vista->renderFooter();

?>