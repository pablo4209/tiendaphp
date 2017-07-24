<?php

require_once( "application/config.php");


if(isset($_SESSION["admin_id"]))
{
    if(isset($_GET["accion"]))
    {
        $accion= strtolower($_GET["accion"]);

    }else
    {
        $accion="home";
    }

    if(is_file( CONTR_PATH . $accion. "Controller.php"))
    {
        require_once( CONTR_PATH . $accion . "Controller.php");
    }else
    {
        require_once( CONTR_PATH . "errorController.php");
    }
}else
{
    require_once( CONTR_PATH . "indexController.php");
}


?>
