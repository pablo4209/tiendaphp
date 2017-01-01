<?php


if($_POST) {
  require('app/includes/config.php');


  switch (isset($_GET['mode']) ? $_GET['mode'] : null) {
    case 'login':
      require( AJAX . 'goLogin.php');
      break;
    case 'userCheck':
      require( AJAX . 'userCheck.php');
      break;
    case 'lostpass':
      require( AJAX . 'goLostpass.php');
      break;
    default:
      header('location: ?accion=home');
      break;
  }
} else {
  header('location: ?accion=home');
}

?>
