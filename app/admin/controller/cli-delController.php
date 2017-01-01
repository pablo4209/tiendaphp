<?php

require_once( MODEL_PATH . "cliModel.php" );

$cli= new Clientes();
$cli->delete($_GET["id"]);


?>