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

$vista->incluir(INC_VALIDITY);

$vista->renderHeader("conf");
require_once( VIEW_PATH . 'user-edit.phtml' );
$vista->renderFooter();

?>