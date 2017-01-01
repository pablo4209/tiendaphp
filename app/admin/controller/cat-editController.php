<?php

require_once( MODEL_PATH . "catModel.php" );

$cat= new Categorias();

$id = 0;
if(isset($_GET["id"]) and $_GET["id"]!="")
{
    $id= $_GET["id"];
}

if(isset($_POST["grabar"]) and $_POST["grabar"] == "si")
{
    //print_r($_POST);
    $cat->edit();
    exit;
}

$datos = $cat->getCategoriaId($id);

//$ruta  = $cat->getRuta($idCat);
$selCategorias = $cat->getSelCategorias(0,$datos[0]["idPadre"]);

$vista = new View();
$vista->incluir( INC_JQUERY . INC_VALIDITY);
$vista->renderHeader("pro");
require_once( VIEW_PATH . 'cat-edit.phtml' );
$vista->renderFooter();

?>