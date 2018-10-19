<?php

//Crud( nom_tabla, array(array( nom_campo, tipo_dato , alias , listar , editar , requerido, value , type, minlenght, maxlenght, placeholder , extraclass  )) )
$crud = new Crud ( "tbentidad_tipo",
          array(
            array( "idEntidadTipo" 	, tipoDato::T_INT   , "ID" 		            , 1 , 1 , 0, "" , "number"	, 2, 50, "", ""  ),
            array( "Nombre" 	      , tipoDato::T_STR   , "Nombre"            , 1 , 1 , 1, "" ,  "text"		, 2, 50, "ingresa un nombre", ""  ),
            array( "asoc_contacto"  , tipoDato::T_CHECK , "Asociar contactos" , 0 , 1 , 1, "" ,  "number"	, 2,  2, "tildar si esta entidad registra datos de contacto", ""  ),
            array( "asoc_nivel"     , tipoDato::T_CHECK , "Asociar Nivel"     , 0 , 1 , 1, "" ,  "number"	, 2,  2, "tildar si esta entidad registra nivel de acceso", ""  ),
            array( "asoc_fiscal"    , tipoDato::T_CHECK , "Asociar Fiscal"    , 0 , 1 , 1, "" ,  "number"	, 2,  2, "tildar si esta entidad registra condicion fiscal", ""  ),
            array( "asoc_marcas"    , tipoDato::T_CHECK , "Asociar Marcas"    , 0 , 1 , 1, "" ,  "number"	, 2,  2, "tildar si esta entidad tiene asociada marcas", ""  )
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
