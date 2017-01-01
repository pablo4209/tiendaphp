<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "depModel.php" );
require_once( MODEL_PATH . "sucModel.php" );

$dep= new Depositos();

if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    //print_r($_POST);
    $dep->add();
    exit;
}

$suc= new Sucursales();
$selsucursal = $suc->crearSelect();

$vista = new View();
$vista->incluir( INC_JQUERY . INC_VALIDITY );
$vista->renderHeader("pro");
require_once( VIEW_PATH . 'dep-add.phtml' );
$vista->renderFooter();

?>