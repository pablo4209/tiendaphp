<?php
require_once( MODEL_PATH . "monModel.php");

$u=new Moneda();

$datos=$u->get_monedas();


$vista = new View();
$vista->incluir( INC_JQUERY . INC_TABLESORTER );
$vista->renderHeader("cli");
require_once( VIEW_PATH . 'mon.phtml' );
$vista->renderFooter();

?>