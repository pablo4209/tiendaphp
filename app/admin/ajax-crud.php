<?php

require_once('application/config.php'); //si no cargo esto no tengo las constantes de la tienda
require_once( 'crud/config.php');


if($_GET){

	switch ( $_GET["mode"] ) {
		case 'crud-add':
			require_once( CRUD_AJAX . "crud-add.php");
			break;
		case 'crud-edit':
			require_once( CRUD_AJAX . "crud-edit.php");
			break;
		case 'crud-list':
			require_once( CRUD_AJAX . "crud-list.php");
			break;
		case 'crud-del':
			require_once( CRUD_AJAX . "crud-del.php");
			break;
		case 'crud-get':
			require_once( "crud/application/ajax/crud-get.php");
			break;
		default:
			# code...
			break;
	}

}

 ?>
