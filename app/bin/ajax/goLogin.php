<?php

if(!empty($_POST['user']) and !empty($_POST['pass']))
{

  require_once( CONN_MODEL_PATH . "userModel.php" );


  $acceso = new User();
  $reg = $acceso->loginweb();


  if( sizeof($reg) >0 )
  { //si hay registro y el usuario este activo

      $_SESSION["user_id"]=$reg["idUsuario"];
      $_SESSION["user_nombre"]=$reg["Nombre"];
      $_SESSION["user_login"]=$reg["Login"];
      $_SESSION["user_email"]=$reg["Email"];
      $_SESSION["NivelAcceso"]=$reg["NivelAcceso"];
      //si se tilda mantener login, se setea la cookie para que mantenga la sesion dos dias
      if($_POST["session"] == true){ ini_set('session.cookie_lifetime', time()+(60*60*24*2));}
      echo 1;
  }else{
    echo '<div class="alert alert-dismissible alert-danger">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>ERROR:</strong> Las credenciales son incorrectas.
    </div>';
  }
  $acceso->close();


} else {
  echo '<div class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">x</button>
  <strong>ERROR:</strong> Todos los datos deben estar llenos.
  </div>';
}

?>
