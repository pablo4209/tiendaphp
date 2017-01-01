<?php

$vista = new View();
$vista->renderHeader("home");
require_once( VIEW_PATH . 'error.phtml' );
$vista->renderFooter();

?>