<?php


//para usar tipo enumeracion ej: if( $campo == tipoDato::INTEGER ) ...sentencias...;
abstract class tipoDato {
    const T_INT = 0;
    const T_STR = 1;
    const T_DATETIME = 2;
    const T_DATE = 3;
    const T_TIME = 4;
    const T_CHECK = 5;
    const T_HIDDEN = 6;

}
//distinto de 0 para activarlo
define( 'CRUD_DEBUG' , 1 );

//directorios usados
//define( "CRUD-ROOT" , ROOT . "var/www/html/crudPHP/" );

//ya definida
//define ( "MODEL" , ROOT . "model/" );

//carpeta del crud
define ( 'CRUD_AJAX' , 'crud/application/ajax/' );


 //constantes de conexion
// define('DB_HOST', '127.0.0.1');
// define('DB_NAME', 'bd_prueba');
// define('DB_USER', 'root');
// define('DB_PASS', 'root');
// define('DB_CHAR', 'utf8');

//clase de conexion BD
//require_once( MODEL . MODEL_PATH . 'database.php' );

require_once( 'crud/formModel.php' );
require_once( 'crud/crudModel.php' );


//
if(CRUD_DEBUG){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

 ?>
