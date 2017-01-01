<?php

//el get de los registros esta configurado en la llamada ajax de tablesorter
require_once( MODEL_PATH . "catModel.php" );

set_time_limit(60);
$cat= new Categorias();
$selCat = $cat->getSelCategorias(0,0,"Seleccionar Categoria");



$vista = new View();
$vista->incluir( INC_JQUERY . INC_TABLESORTER . INC_TABLESORTER_PAGER );
$vista->renderHeader("pro");
require_once( VIEW_PATH . 'pro.phtml' );
$vista->renderFooter();

?>