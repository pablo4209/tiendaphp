<?php
require_once( MODEL_PATH . "userModel.php");
$u=new User();

$datos=$u->get_usuarios();


$vista = new View();
$vista->incluir( INC_TABLESORTER );
$vista->renderHeader("conf");
require_once( VIEW_PATH . 'user.phtml' );
$vista->renderFooter();
?>