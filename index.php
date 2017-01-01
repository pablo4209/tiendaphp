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
	        require_once( VIEW . $accion . ".php");
	        include( VIEW . "login.php");
	        include( VIEW . "lost_pass.php");	        
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
