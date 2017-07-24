<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "catModel.php" );

$cat= new Categorias();

$idCat = 0;
if(isset($_GET["p"]) && $_GET["p"] != "")
{
    $idCat= $_GET["p"];
}


$datos = $cat->get_categorias($idCat);

$ret = $cat->getCategoriaId($idCat); //para generar el link de pagina anterior
$idpadre=0;
if(sizeof($ret)){ $idpadre = $ret[0]['idPadre']; }

$ruta  = $cat->getTree($idCat, 0, "cat", "p");

$vista = new View();
$vista->incluir( INC_TABLESORTER );
$vista->renderHeader("pro");
require_once( VIEW_PATH . 'cat.phtml' );
$vista->renderFooter();

?>