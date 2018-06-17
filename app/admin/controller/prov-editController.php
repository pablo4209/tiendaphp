<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "provModel.php" );
require_once( MODEL_PATH . "monModel.php" );
require_once( MODEL_PATH . "condFiscalModel.php" );

$prov= new Proveedores();

if( isset($_POST["grabar"]) and $_POST["grabar"]=="si" )
{
    //print_r($_POST);exit;
    $prov->edit();
    exit;
}

$datos =$prov->getProveedorId( $_GET["id"] );

if( sizeof($datos) ){
	$mon= new Moneda();
	$selMon = $mon->getSelMonedas( $datos[0]["idMoneda"] );

	$cf = new CondFiscal();
	$selCondFiscal = $cf->crearSelect( $datos[0]["idCondFiscal"] );	
}




$vista = new View();
$vista->incluir( INC_JQUERY . INC_VALIDATE );
$vista->renderHeader("prov");
require_once( VIEW_PATH . 'prov-edit.phtml' );
$vista->renderFooter();

?>