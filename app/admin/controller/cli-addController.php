<?php

require_once( MODEL_PATH . "cliModel.php" );
require_once( MODEL_PATH . "condFiscalModel.php" );
require_once( MODEL_PATH . "listModel.php" );



if(isset($_POST["grabar"]) and $_POST["grabar"]=='si')
{
    $cli= new Clientes();
    $cli->add();
    exit;
}

$condf=new CondFiscal();
$selCF = $condf->crearSelect();


$lista=new Listas();
$selLista =$lista->crearSelect(1);


$vista = new View();


$vista->incluir(INC_VALIDITY);

$vista->renderHeader("cli");
require_once( VIEW_PATH . 'cli-add.phtml' );
$vista->renderFooter();

?>