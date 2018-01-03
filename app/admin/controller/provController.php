<?php

/**
 * @author pablo
 * @copyright 2013
 */



require_once( MODEL_PATH . "provModel.php" );




$prov= new Proveedores();

$datos = $prov->getProveedores();

$vista = new View();
$vista->incluir( INC_JQUERY . INC_TABLESORTER );
$vista->renderHeader("prov");
require_once( VIEW_PATH . 'prov.phtml' );
$vista->renderFooter(); 
?>