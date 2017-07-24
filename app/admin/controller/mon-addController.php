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

$vista->incluir(INC_VALIDITY);

$vista->renderHeader("cli");
require_once( VIEW_PATH . 'mon-add.phtml' );
$vista->renderFooter();
?>