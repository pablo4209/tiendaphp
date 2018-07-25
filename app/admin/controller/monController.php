<?php
//require_once( MODEL_PATH . "monModel.php");

//$u=new Moneda();

//$datos=$u->get_monedas();
//Crud( nom_tabla, array(array( nom_campo, tipo_dato , alias , listar , editar , requerido, type, minlenght, maxlenght, placeholder , extraclass  )) )
$crud = new Crud ( "tbmoneda",
          array(
            array( "idMoneda" 	, tipoDato::T_INT , "ID" 		, 1 , 1 , 0, "number"	, 2, 50, "", ""  ),
            array( "Nombre" 	, tipoDato::T_STR , "Nombre" 	, 1 , 1 , 1, "text"		, 2, 50, "ingresa un nombre", ""  ),
            array( "Cambio" 	, tipoDato::T_INT , "Cambio" 	, 1 , 1 , 1, "number"	, 1, 10, "ingresa cambio", ""  ),
            array( "Simbolo" 	, tipoDato::T_STR , "Simbolo de la Moneda" 	, 0 , 1 , 1, "text"	, 1, 10, "ingresa un Simbolo para esta moneda", ""  ),
            array( "Principal" 	, tipoDato::T_CHECK , "Moneda Principal" 	, 0 , 0 , 1, "number"	, 1, 1, "", ""  ),
            array( "Habilitada" 	, tipoDato::T_CHECK , "Habilitada" 	, 0 , 1 , 1, "number"	, 1, 1, "", ""  )
          )
         ); //se pasan datos de tabla al constructor


$crud->setTitulo("Monedas del Sistema");
$crud->setEliminar(false);
$html = $crud->render();


$vista = new View();
$vista->incluir( INC_JQUERYUI . INC_VALIDATE . INC_VALIDATE_REGLAS );
$vista->renderHeader("mon");
echo $html;
//require_once( VIEW_PATH . 'mon.phtml' );
$vista->renderFooter();

?>
