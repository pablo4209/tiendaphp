<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS); //Root se usa para las inclusiones

require_once(APP_PATH . 'config.php');
require_once(MODEL_PATH . 'database.php');
require_once(APP_PATH . 'view.php');


if(isset($_SESSION["user_id"]))
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
