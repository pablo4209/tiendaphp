<?php

/**
 * @author pablo
 * @copyright 2013
 */

require_once( MODEL_PATH . "condFiscalModel.php" );


if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    //print_r($_POST);
    $condf= new CondFiscal();
    $condf->add();
    exit;    
}


$vista = new View();
$vista->incluir( INC_JQUERY . INC_VALIDITY );
$vista->renderHeader("cli");
require_once( VIEW_PATH . 'condFiscal-add.phtml' );
$vista->renderFooter();

?>