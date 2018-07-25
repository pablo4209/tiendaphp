<?php

/**
 * @author pablo
 * @copyright 2013
 */

 //Crud( nom_tabla, array(array( nom_campo, tipo_dato , alias , listar , editar , requerido, type, minlenght, maxlenght, placeholder , extraclass  )) )
 $crud = new Crud ( "tbdep",
           array(
             array( "idDeposito" 	, tipoDato::T_INT , "ID" 		, 1 , 1 , 0, "number"	, 2, 50, "", ""  ),
             array( "Nombre" 	, tipoDato::T_STR , "Nombre" 	, 1 , 1 , 1, "text"		, 2, 50, "ingresa un nombre", "input-medium"  ),
             array( "Descripcion" 	, tipoDato::T_STR , "Descripcion" 	, 0 , 1 , 1, "text"	, 1, 100, "ingresa una descripcion para el deposito", "input-large"  ),
             array( "Dom" 	, tipoDato::T_STR , "Domicilio" 	, 0 , 1 , 1, "text"	, 1, 150, "ingresa un domicilio", "input-medium"  ),
             array( "Cp" 	, tipoDato::T_STR , "Codigo Postal" 	, 0 , 1 , 0, "text"	, 1, 10, "ingresa un codigo postal", "input-small"  ),
             array( "Loc" 	, tipoDato::T_STR , "Localidad" 	, 0 , 1 , 0, "text"	, 1, 30, "ingresa una localidad", "input-medium"  ),
             array( "Prov" 	, tipoDato::T_STR , "Provincia" 	, 0 , 1 , 0, "text"	, 1, 30, "ingresa provincia", "input-medium"  ),
             array( "Tel" 	, tipoDato::T_STR , "Telefono" 	, 0 , 1 , 0, "tel"	, 1, 30, "ingresa un telefono", "input-medium"  ),
             array( "Email" 	, tipoDato::T_STR , "Email" 	, 0 , 1 , 0, "mail"	, 1, 100, "ingresa un email", "input-medium"  )
           )
          ); //se pasan datos de tabla al constructor


 $crud->setTitulo("Depositos");
 $crud->setEliminar(false);
 $html = $crud->render();


$vista = new View();
$vista->incluir( INC_JQUERYUI . INC_VALIDATE . INC_VALIDATE_REGLAS );
$vista->renderHeader("dep");
echo $html;
$vista->renderFooter();
?>
