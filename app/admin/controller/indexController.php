<?php

require_once( MODEL_PATH . "userModel.php" );

$u=new User();

if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    $u->logueo();
    exit;
}
require_once( VIEW_PATH . "index.phtml" );

?>