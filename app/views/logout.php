<?php  
	
unset($_SESSION['user_id'], $_SESSION['user_login'], $_SESSION['user_email'], $_SESSION['NivelAcceso']);
session_destroy();
header('location: ?accion=home');

?>