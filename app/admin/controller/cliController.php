<?php

require_once( MODEL_PATH . "cliModel.php" );

$cli= new Clientes();

$datos=$cli->get_clientes();


$vista = new View();
$vista->incluir( INC_JQUERY . INC_TABLESORTER );
$vista->renderHeader("cli");
require_once( VIEW_PATH . 'cli.phtml' );
$vista->renderFooter();
?>