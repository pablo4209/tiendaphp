<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "catModel.php" );

$cat= new Categorias();

$idCat = 0;
if(isset($_GET["p"]) and $_GET["p"]!="")
{
    $idCat= $_GET["p"];
}
$datos = $cat->get_categorias($idCat);
$ruta  = $cat->getRuta($idCat);

$vista = new View();
$vista->incluir( INC_JQUERY . INC_TABLESORTER );
$vista->renderHeader("pro");
require_once( VIEW_PATH . 'cat.phtml' );
$vista->renderFooter();

?>