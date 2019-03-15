<?php
session_start();

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', 'app/admin/');
define('APP_PATH', 'application/' ); //Root se usa para las inclusiones

//define('BASE_URL', 'http://admin.pablo-intranet.com.ar/'); //ruta base para todo lo que no sea include/require
define('BASE_URL', 'http://localhost/tiendaphp/app/admin/'); //ruta base para todo lo que no sea include/require
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_LAYOUT', 'default');
define('PATH_PUBLIC_RELAT', 'public/'); // ruta donde se guardan las carpetas para imagenes del contenido por ejemplo
define('PATH_LAYOUT', BASE_URL . 'view/layout/' . DEFAULT_LAYOUT . '/');
define('PATH_LAYOUT_RELAT', 'view/layout/' . DEFAULT_LAYOUT . '/');
define('DIR_IMG', 'images/');
define('DIR_JS',  'js/');
define('DIR_CSS', 'css/');
define('PATH_IMG', DIR_IMG);
define('PATH_IMG_PUBLIC', DIR_IMG."public/");
define('PATH_JS',  DIR_JS);
define('PATH_CSS', DIR_CSS);
define('AJAX', APP_PATH . 'ajax/');
define('PATH_FUNCTIONS', APP_PATH . 'functions/');


define( 'VIEW_PATH', 'view/');
define('MODEL_PATH', 'model/');
define('CONTR_PATH', 'controller/');

define('APP_NAME', '.::Tienda PHP_ADMIN::.');
define('APP_SLOGAN', 'desarrollado con php y mvc...');
define('APP_COMPANY', 'www.pablo-intranet.com.ar');

//includes de librerias
define('INC_CONTENT_CSS', '<link href="' . PATH_CSS . 'estilosclases.css" rel="stylesheet" type="text/css" />');

define('INC_PRO_JS', '<script type="text/javascript" src="' . PATH_JS . 'pro_js.js" language="javascript"></script>');
//tema tronastic: <link type="text/css" href="' . PATH_JS . 'jqueryui/trontastic/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
define('INC_JQUERYUI', '<link type="text/css" href="' . PATH_JS . 'jqueryui/redmond/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />
						<script type="text/javascript" src="' . PATH_JS . 'jqueryui/jquery-ui-1.9.2.custom.min.js" language="javascript"></script>
						<script type="text/javascript" src="' . PATH_JS . 'jqueryui/jquery.ui.datepicker-es.js" language="javascript"></script>');
define('INC_VALIDITY', '<link href="' . PATH_JS . 'validity/jquery.validity.css" rel="stylesheet" type="text/css" />
                        <script type="text/javascript" src="' . PATH_JS . 'validity/jquery.validity.min.js" language="javascript"></script>');
define('INC_VALIDATE', '<script type="text/javascript" src="' . PATH_JS . 'validate/jquery.validate.min.js" language="javascript"></script>
						<script type="text/javascript" src="' . PATH_JS . 'validate/localization/messages_es_AR.min.js" language="javascript"></script>');
define('INC_VALIDATE_REGLAS', '<script type="text/javascript" src="' . PATH_JS . 'validar.js" language="javascript"></script>
						<script type="text/javascript" src="' . PATH_JS . 'validate/localization/messages_es_AR.min.js" language="javascript"></script>');
define('INC_TABLESORTER', '<link href="' . PATH_JS . 'tablesorter/css/theme.blue.css" rel="stylesheet" type="text/css" />
                           <script type="text/javascript" src="' . PATH_JS . 'tablesorter/jquery.tablesorter.min.js" language="javascript"></script>
                           <script type="text/javascript" src="' . PATH_JS . 'tablesorter/jquery.tablesorter.widgets.min.js" language="javascript"></script>');

define('INC_TABLESORTER_PARSER_IN_SELECT', '<script type="text/javascript" src="' . PATH_JS . 'tablesorter/parsers/parser-input-select.js" language="javascript"></script>');

define('INC_TABLESORTER_PAGER', '<link href="' . PATH_JS . 'tablesorter/addons/pager/jquery.tablesorter.pager.css" rel="stylesheet" type="text/css" />
                                 <script type="text/javascript" src="' . PATH_JS . 'tablesorter/addons/pager/jquery.tablesorter.pager.min.js" language="javascript"></script>');

define('INC_TABLESORTER_GROUPING', '<script type="text/javascript" src="' . PATH_JS . 'tablesorter/widgets/widget-grouping.js" language="javascript"></script>');

define('MSG_SUCCESS',1);
define('MSG_WARNING',2);
define('MSG_DANGER' ,3);
define('MSG_INFO' ,4);

# los tipo de entidad tienen una tabla en la bd pero se suponen fijos en el programa
define('ENT_USUARIO'  	, 1);
define('ENT_PROVEEDOR'	, 2);
define('ENT_CLIENTE'	, 3);

# Activación del DEBUG, solo para desarrollo
define( 'DEBUG', true );
define( 'LOG_SQL' , false );  //registrar todas las consultas en log

//constantes de conexion
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'bd_entidad');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_CHAR', 'utf8');

// Notificar todos los errores de PHP (ver el registro de cambios)
if( DEBUG ){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}else{
	error_reporting(0);
	ini_set('display_errors', '0');
}

//INCLUIDO EN TODO EL SITIO
require_once( MODEL_PATH .'database.php');
require_once( APP_PATH.   'view.php');
require_once( PATH_FUNCTIONS . 'mensajes.php');
require_once( PATH_FUNCTIONS . 'getIp.php');
require_once( PATH_FUNCTIONS . 'log.php');
require_once( "crud/config.php" );
?>
