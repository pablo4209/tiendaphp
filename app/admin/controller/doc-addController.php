<?php

require_once( MODEL_PATH . "monModel.php" );
require_once( MODEL_PATH . "depModel.php");
require_once( MODEL_PATH . "docTipoModel.php");
require_once( MODEL_PATH . "listModel.php");
require_once( MODEL_PATH . "condFiscalModel.php");

$mon= new Moneda();
$selMon = $mon->getSelMonedas(1);
$dep= new Depositos();
$seldep = $dep->crearSelect(1);
$tipodoc = new DocTipo();
$selTipodoc = $tipodoc->crearSelect(1);
$list = new Listas();
$sellista = $list->crearSelect(1);
$condf = new CondFiscal();
$selcondfiscal = $condf->crearSelect(1);


$vista = new View();
$vista->incluir( INC_CONTENT_CSS . INC_JQUERY . INC_JQUERYUI . INC_VALIDITY . '<script type="text/javascript" src="' . PATH_JS . 'doc-mod.js" language="javascript"></script>' );
$vista->renderHeader("doc");
require_once( VIEW_PATH . 'doc-add.phtml' );
$vista->renderFooter();

?>