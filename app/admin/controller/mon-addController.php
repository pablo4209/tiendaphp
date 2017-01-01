<?php

require_once( MODEL_PATH . "monModel.php");



if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    //print_r($_POST);
    $u=new Moneda();
    $u->add();
    exit;
}


$vista = new View();

$inc = INC_JQUERY . INC_VALIDITY ;
$vista->incluir($inc);

$vista->renderHeader("cli");
require_once( VIEW_PATH . 'mon-add.phtml' );
$vista->renderFooter();
?>