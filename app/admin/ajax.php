<?php

if($_GET){

  require_once('application/config.php');


  switch (isset($_GET['mode']) ? $_GET['mode'] : null) {
    case 'pro-list':
      require( AJAX . 'pro-list.php' );
      break;
    case 'pro-cat':
      require( AJAX . 'pro-cat.php' );
      break;
    case 'uploadimg':
      require( AJAX . 'pro-upload-img.php' );
      break;
    case 'doc-action':
      require_once( AJAX . 'doc-action.php' );
      break;
    case 'pro-buscar':
        require_once( AJAX . 'pro-buscar.php' );
        break;
    case 'ent-list':
      require_once( AJAX . 'ent-list.php' );
      break;
    default:
      header( 'location: ?accion=home' );
      break;
  }

}else{
      header( 'location: ?accion=home' );
}


?>
