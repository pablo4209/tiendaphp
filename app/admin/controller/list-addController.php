<?php

require_once( MODEL_PATH . "listModel.php");
require_once( MODEL_PATH . "userNivelModel.php");


if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    //print_r($_POST);
    $u=new Listas();
    $u->add();
    exit;
}

$nivel = new userNivel();
$selNivel = $nivel->crearSelect();

$vista = new View();

$inc = INC_JQUERY . INC_VALIDITY ;
$vista->incluir($inc);

$vista->renderHeader("conf");
require_once( VIEW_PATH . 'list-add.phtml' );
$vista->renderFooter();
?>