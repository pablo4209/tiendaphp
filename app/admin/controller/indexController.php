<?php

require_once( MODEL_PATH . "entModel.php" );


$u=new Entidad();

if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{    
    if( $u->logueo() )    	
    	header("Location: ".BASE_URL."?accion=home");
    else    	
    	header("Location: ".BASE_URL."?accion=index&st=1"); //error de login

    exit;
}
require_once( VIEW_PATH . "index.phtml" );

?>