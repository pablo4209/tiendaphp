<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "condFiscalModel.php" );

$condf= new CondFiscal();

if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    //print_r($_POST);    
    $condf->edit();
    exit;    
}


$datos = $condf->get_condFiscal_id($_GET["id"]);

$vista = new View();
$vista->incluir( INC_JQUERY . INC_VALIDITY );
$vista->renderHeader("cli");
require_once( VIEW_PATH . 'condFiscal-edit.phtml' );
$vista->renderFooter();

?>