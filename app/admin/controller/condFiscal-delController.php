<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "condFiscalModel.php" );

$condf= new CondFiscal();
$condf->delete($_GET["id"]);

?>