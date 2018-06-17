<?php

require_once( MODEL_PATH . "cliModel.php" );
require_once( MODEL_PATH . "condFiscalModel.php" );
require_once( MODEL_PATH . "listModel.php" );

$cli= new Clientes();

if(isset($_POST["grabar"]) and $_POST["grabar"]=='si')
{
    $cli->edit();    
    exit;
}

$datos=$cli->get_cliente_id($_GET["id"]);

$condf=new CondFiscal();
$selCF = $condf->crearSelect($datos[0]["idCondfiscal"]);

$lista=new Listas();
$selLista =$lista->crearSelect($datos[0]["idLista"]);



$vista = new View();


$vista->incluir(INC_VALIDITY);

$vista->renderHeader("cli");
require_once( VIEW_PATH . 'cli-edit.phtml' );
$vista->renderFooter();

?>