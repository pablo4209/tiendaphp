<?php
require_once( MODEL_PATH . "monModel.php");

$m= new Moneda;

if(isset($_POST["grabar"]) and $_POST["grabar"]=="si" )
{
    //print_r($_POST);exit;
    $m->edit();    
}


$datos =$m->get_moneda_id($_GET["id"]);


$vista = new View();

 
$vista->incluir( INC_JQUERY . INC_VALIDATE . INC_VALIDATE_REGLAS );

$vista->renderHeader("cli");
require_once( VIEW_PATH . 'mon-edit.phtml' );
$vista->renderFooter();

?>