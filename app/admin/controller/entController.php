<?php

require_once( MODEL_PATH . "entModel.php" );
require_once( MODEL_PATH . "entTipoModel.php" );

$crud ="";

if( isset($_POST["idEntidadTipo"]) && $_POST["idEntidadTipo"] != 0 ){
    $clsCrud = new Crud ( "tbentidad",
                          array(
                            array( "idEntidad" 	, tipoDato::T_INT   , "ID" 		, 1 , 1 , 0, "" , "number"	, 2, 50, "", ""  ),
                            array( "Nombre" 	  , tipoDato::T_STR   , "Nombre", 1 , 1 , 1, "" ,  "text"		, 2, 50, "ingresa un nombre", ""  )
                          ),
                          "idEntidadTipo = ".$_POST["idEntidadTipo"]
             ); //se pasan datos de tabla al constructor

    //$clsCrud->setTitulo("");
    $clsCrud->setEliminar(false);
    $crud = $clsCrud->render();

}

$contCrud = '<div class="row" id="contCrud">'.$crud.'</div>';

$v= new EntidadTipo();
$seltipo = $v->crearSelect( (isset($_POST["idEntidadTipo"]))? $_POST["idEntidadTipo"] : ENT_USUARIO ); //creacion del select de entidades

//$u=new Entidad();
//$datos=$u->getRowsTipo(ENT_USUARIO);

$script = '
          <script>
                $(document).ready(function(){
                      $("body").on( "change" , "#idEntidadTipo" , function(){
                            if( $(this).val() > 0 )
                                        $("#frmEnt").submit();
                            else {
                                $("#contCrud").html("");
                            }

                      });
                });
          </script>';



$vista = new View();
$vista->incluir( INC_JQUERYUI . INC_VALIDATE . INC_VALIDATE_REGLAS );
$vista->renderHeader("ent");

  echo '<div class="row">
                <form id="frmEnt" action="" method="post">'.
                  $seltipo.
                '</form>
        </div>';
  echo $contCrud;
  echo $script;
//require_once( VIEW_PATH . 'ent.phtml' );
$vista->renderFooter();


 ?>
