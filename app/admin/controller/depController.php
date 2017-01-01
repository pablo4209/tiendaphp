<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "depModel.php" );


$dep= new Depositos();

$datos = $dep->getDepositos();

$vista = new View();
$vista->incluir( INC_JQUERY . INC_TABLESORTER );
$vista->renderHeader("pro");
require_once( VIEW_PATH . 'dep.phtml' );
$vista->renderFooter();
?>