<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "condFiscalModel.php" );

$condf= new CondFiscal();


$datos = $condf->get_condFiscal();


$vista = new View();
$vista->incluir( INC_TABLESORTER );
$vista->renderHeader("cli");
require_once( VIEW_PATH . 'condFiscal.phtml' );
$vista->renderFooter();

?>