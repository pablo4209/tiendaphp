<?php

require_once( MODEL_PATH . "listModel.php");
require_once( MODEL_PATH . "userNivelModel.php");

$u=new Listas();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    //print_r($_POST);    
    $u->edit();
    exit;
}


$datos = $u->getListaId($_GET["id"]);

$nivel = new userNivel();
$selNivel = $nivel->crearSelect($datos[0]["NivelAcceso"]);

$vista = new View();

$inc = INC_JQUERY . INC_VALIDITY ;
$vista->incluir($inc);

$vista->renderHeader("conf");
require_once( VIEW_PATH . 'list-edit.phtml' );
$vista->renderFooter();
?>