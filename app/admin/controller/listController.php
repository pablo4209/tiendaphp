<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "listModel.php" );


$dep= new Listas();

$datos = $dep->getListas();

$vista = new View();
$vista->incluir( INC_JQUERY . INC_TABLESORTER );
$vista->renderHeader("conf");
require_once( VIEW_PATH . 'list.phtml' );
$vista->renderFooter();
?>