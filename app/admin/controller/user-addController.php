<?php
require_once( MODEL_PATH . "userModel.php");


if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    $u=new User();
    $u->add();
    exit;
}

$vista = new View();

$inc = $inc = INC_JQUERY . INC_VALIDITY ;
$vista->incluir($inc);

$vista->renderHeader("conf");
require_once( VIEW_PATH . 'user-add.phtml' );
$vista->renderFooter();
?>