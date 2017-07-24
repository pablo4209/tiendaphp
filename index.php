<?php
	require_once('app/includes/config.php');
	require_once( VIEW . 'header.php');

	if(session_status() == PHP_SESSION_ACTIVE)
	{

		if(isset($_GET["accion"]))
	    {
	        $accion= strtolower($_GET["accion"]);

	    }else
	    {
	        $accion="home";
	    }

		if(is_file( VIEW . $accion. ".php"))
	    {
	    	if( !isset($_SESSION['user_id']) &&
	    		$accion != 'home' &&
	    		$accion != 'lostpass' && 
	    		$accion != 'details_item' && 
	    		$accion != 'user-add' && 
	    		$accion != 'activar' && 
	    		$accion != 'debug' &&
	    		$accion != 'catalogo' ) 
    		{ //solo permitir entrar a home
	        	$accion = 'logueate';	
	        }

	        require_once( VIEW . $accion . ".php");
	        include( VIEW . "login.php");
	        include( VIEW . "lostpass_modal.php");	

	    }else
	    {
	        header("Location:".VIEW."404.html");
			exit;
	    }

	}else{
		header("Location:".VIEW."404.html");
			exit;
	}


	require_once( VIEW . 'footer.php');?>
