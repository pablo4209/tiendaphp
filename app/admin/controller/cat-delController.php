<?php

require_once( MODEL_PATH . "catModel.php" );

$cat= new Categorias();

$padre = 0;
if(isset($_GET["p"]) and $_GET["p"] !="")
{
    $padre = $_GET["p"];
}

$cat->delete($_GET["id"],$padre);

?>