<?php 

require_once( MODEL_PATH . 'formModel.php' );


$vista = new View();
$vista->incluir( INC_JQUERY );
$vista->renderHeader("ent");

$cls = new Formulario();
$cls->setTitulo("titulo de prueba");
$cls->setNombre("Formulario_prueba");
$cls->render();
//require_once( VIEW_PATH . 'ent.phtml' );

$vista->renderFooter();

 ?>