<?php
require_once( MODEL_PATH . "userModel.php");


if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    $u=new User();
    $u->add();
    exit;
}

$vista = new View();


$vista->incluir(INC_VALIDITY);

$vista->renderHeader("conf");
require_once( VIEW_PATH . 'user-add.phtml' );
$vista->renderFooter();
?>