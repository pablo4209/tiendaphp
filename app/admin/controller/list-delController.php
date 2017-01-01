<?php

require_once( MODEL_PATH . "listModel.php");

$u=new Listas();
$u->delete($_GET["id"]);

?>