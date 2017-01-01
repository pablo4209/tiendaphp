<?php

/**
 * @author pablo
 * @copyright 2013
 */

$vista = new View();

$vista->renderHeader("conf");
require_once( VIEW_PATH . 'conf.phtml' );
$vista->renderFooter();

?>