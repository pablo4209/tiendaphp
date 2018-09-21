<?php

//Crud( nom_tabla, array(array( nom_campo, tipo_dato , alias , listar , editar , requerido, value , type, minlenght, maxlenght, placeholder , extraclass  )) )
$crud = new Crud ( "tbentidad_tipo",
          array(
            array( "idEntidadTipo" 	, tipoDato::T_INT   , "ID" 		, 1 , 1 , 0, "" , "number"	, 2, 50, "", ""  ),
            array( "Nombre" 	      , tipoDato::T_STR   , "Nombre", 1 , 1 , 1, "" ,  "text"		, 2, 50, "ingresa un nombre", ""  )
          )
         ); //se pasan datos de tabla al constructor


$crud->setTitulo("Tipos de entidades");
$crud->setEliminar(false);
$html = $crud->render();


$vista = new View();
$vista->incluir( INC_JQUERYUI . INC_VALIDATE . INC_VALIDATE_REGLAS );
$vista->renderHeader("ent-tipos");
    echo $html;
$vista->renderFooter();

?>
