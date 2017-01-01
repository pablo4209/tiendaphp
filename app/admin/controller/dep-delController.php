<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "depModel.php" );

$dep= new Depositos();
$dep->delete($_GET["id"]);



?>