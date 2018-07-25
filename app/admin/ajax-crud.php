<?php

if($_GET){

	require_once('application/config.php');
	require_once( 'crud/config.php' );

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
		default:
			# code...
			break;
	}

}

 ?>
