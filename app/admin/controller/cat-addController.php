<?php

require_once( MODEL_PATH . "catModel.php" );

$cat= new Categorias();

$padre = 0;
if(isset($_GET["p"]) and $_GET["p"]!="")
{
    $padre= $_GET["p"];
}

if(isset($_POST["grabar"]) and $_POST["grabar"] == "si")
{
    //print_r($_POST);
    $cat->add();
    exit;
}

//$ruta  = $cat->getRuta($idCat);
$selCategorias = $cat->getSelCategorias(0,$padre);

$vista = new View();
$vista->incluir( INC_JQUERY . INC_VALIDITY);
$vista->renderHeader("pro");
require_once( VIEW_PATH . 'cat-add.phtml' );
$vista->renderFooter();

?>