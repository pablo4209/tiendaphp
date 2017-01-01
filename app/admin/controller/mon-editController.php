<?php
require_once( MODEL_PATH . "monModel.php");
$m= new Moneda;

if(isset($_POST["grabar"]) and $_POST["grabar"]=="si" )
{
    //print_r($_POST);
    $m->edit();
    exit;
}


$datos =$m->get_moneda_id($_GET["id"]);


$vista = new View();

$inc = $inc = INC_JQUERY . INC_VALIDITY ;
$vista->incluir($inc);

$vista->renderHeader("cli");
require_once( VIEW_PATH . 'mon-edit.phtml' );
$vista->renderFooter();

?>