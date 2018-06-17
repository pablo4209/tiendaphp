<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "provModel.php" );
require_once( MODEL_PATH . "monModel.php" );
require_once( MODEL_PATH . "condFiscalModel.php" );



if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    //print_r($_POST);exit;
	$prov= new Proveedores();
    $prov->add();
    exit;
}

$mon= new Moneda();
$selMon = $mon->getSelMonedas(1);

$cf = new CondFiscal();
$selCondFiscal = $cf->crearSelect();

$vista = new View();
$vista->incluir( INC_JQUERY . INC_VALIDATE );
$vista->renderHeader("prov");
require_once( VIEW_PATH . 'prov-add.phtml' );
$vista->renderFooter();

?>