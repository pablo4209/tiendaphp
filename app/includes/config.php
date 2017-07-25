<?php
	session_start();


	define('APP_TITLE', "TiendaPHP");
	define('ROOT', "app/");
	define('COMPOSER', ROOT . "vendor/");
	define('CSS' ,  ROOT . "css/");
	define('IMG' ,  ROOT . "images/");
	define('JS'  ,	ROOT . "js/");
	define('AJAX'  ,	ROOT . "bin/ajax/");
	define('FUNCTIONS'  ,	ROOT . "bin/functions/");
	define('VIEW'  ,	ROOT . "views/");
	define('CONN_MODEL_PATH'  ,	ROOT . "admin/model/");
	define('BASE_URL' , "http://localhost/tiendaphp/" );

	define('IMG_PROD' ,  ROOT . "admin/images/");

	#Configuraciones
	define('PRO_POR_PAGINA', 10);

	#Constantes de PHPMailer
	define('PHPMAILER_HOST','p3plcpnl0173.prod.phx3.secureserver.net');
	define('PHPMAILER_USER','public@ocrend.com');
	define('PHPMAILER_PASS','Prinick2016');
	define('PHPMAILER_PORT',465);

	require( COMPOSER . "autoload.php" );
	require_once(  FUNCTIONS . "Encrypt.php" );
	require_once(  FUNCTIONS . "EmailTemplate.php" );
	//require_once(  FUNCTIONS . "EmailLostpassTemplate.php" );
	require_once(  CONN_MODEL_PATH . "database.php" );
	require_once(  FUNCTIONS . "Categorias.php" );
	require_once(  FUNCTIONS . "Sesion.php" );
	require_once(  FUNCTIONS . "getUserIp.php" );
?>
