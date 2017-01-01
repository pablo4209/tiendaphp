<?php
require_once( MODEL_PATH . "userModel.php");

$u=new User();

if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    
    $u->edit();
    exit;
}


$datos=$u->get_usuarios_por_id($_GET["id"]);

$vista = new View();

$inc = $inc = INC_JQUERY . INC_VALIDITY ;
$vista->incluir($inc);

$vista->renderHeader("conf");
require_once( VIEW_PATH . 'user-edit.phtml' );
$vista->renderFooter();

?>