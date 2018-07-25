<?php

require_once( MODEL_PATH . "entModel.php" );
require_once( MODEL_PATH . "entTipoModel.php" );
//require_once( MODEL_PATH . 'formModel.php' );

$v= new EntidadTipo();
$seltipo = $v->crearSelect(ENT_USUARIO);

$u=new Entidad();
$datos=$u->getRowsTipo(ENT_USUARIO);

//edicion
//$clsEdit = new Formulario();
//$clsEdit->setTitulo("titulo de prueba");
//$clsEdit->setNombre("Formulario_prueba");



$vista = new View();
$vista->incluir( INC_JQUERY . INC_TABLESORTER );
$vista->renderHeader("ent");
//$clsEdit->render();


require_once( VIEW_PATH . 'ent.phtml' );
$vista->renderFooter();


 ?>
