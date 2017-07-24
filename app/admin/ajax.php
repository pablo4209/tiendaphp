<?php

if($_GET){
  
  require_once('application/config.php');


  switch (isset($_GET['mode']) ? $_GET['mode'] : null) {
    case 'pro-list':
      require( AJAX . 'pro-list.php');
      break;
    case 'pro-cat':
      require( AJAX . 'pro-cat.php');
      break;
    case 'uploadimg':
      require( AJAX . 'pro-upload-img.php');
      break;
    default:
      header('location: ?accion=home');
      break;
  }

}else{
      header('location: ?accion=home');
}


?>