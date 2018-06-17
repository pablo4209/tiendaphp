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
$vista->incluir( INC_CONTENT_CSS . 
				 '<link href="css/tabla_selec.css" rel="stylesheet" type="text/css" />' . 
				 INC_JQUERYUI . 
				 INC_VALIDATE . INC_VALIDATE_REGLAS . 
				 '<script type="text/javascript" src="' . PATH_JS . 'doc-mod.js" language="javascript"></script>' . 
				 INC_TABLESORTER . 
				 INC_TABLESORTER_PAGER );
$vista->renderHeader("doc");
require_once( VIEW_PATH . 'doc-add.phtml' );
require_once( VIEW_PATH . 'buscar-prod.php' );
$vista->renderFooter();

?>