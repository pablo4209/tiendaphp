<?php

  require_once( CONN_MODEL_PATH . "userModel.php" );
$HTML="false";
$acceso = new User();
$user = (isset($_POST["login"]))? $_POST["login"]:"";
$email = (isset($_POST["correo"]))? $_POST["correo"]:"";

$reg = $acceso->existeUsuario($user, $email); //la funcion retorna el registro, sirve para revisar que es lo que existe user o email

if(sizeof($reg) == 0){   //}$db->rows($sql) == 0) {
    $HTML ="true";
}
$acceso->close();
echo $HTML;
?>
