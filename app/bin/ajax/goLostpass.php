<?php

$db = new Conectar();
$email = $_POST['email'];
$reg = $db->getRowId("SELECT idUsuario, Login, Nombre FROM tbusuarios WHERE Email='$email' LIMIT 1;", array($email));
if(!empty($reg)) {

  $id = $reg[0]['idUsuario'];
  $user = $reg[0]['Login'];
  $keyreg = md5(time());
  $newPass = strtoupper(substr(sha1(time()),0,8));
  $link = BASE_URL . '?accion=lostpass&key=' . $keyreg;
  $mail = new PHPMailer;
  $mail->CharSet = "UTF-8";
  $mail->Encoding = "quoted-printable";
  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->Host = PHPMAILER_HOST;  // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
  $mail->Username = PHPMAILER_USER;                 // SMTP username
  $mail->Password = PHPMAILER_PASS;                           // SMTP password
  $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
  $mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      )
  );
  $mail->Port = PHPMAILER_PORT;                                    // TCP port to connect to
  $mail->setFrom(PHPMAILER_USER, APP_TITLE); //Quien manda el correo?
  $mail->addAddress($email, $user);     // A quien le llega
  $mail->isHTML(true);    // Set email format to HTML
  $mail->Subject = 'Recuperar contraseña perdida';
  $mail->Body    = EmailLostpassTemplate($user,$link);
  $mail->AltBody = 'Hola ' . $user . ' para recuperar tu contraseña debes ir a este enlace: ' . $link . ' , si no has solicitado un cambio de contraseña no necesitas hacer nada.';
  if(!$mail->send()) {
      $HTML = '<div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">x</button>
      <strong>ERROR:</strong> ' . $mail->ErrorInfo . ' </div>';
  } else {
    $db->getRowId("UPDATE tbusuarios SET KeyReg=?, newPass=? WHERE idUsuario=?;", array($keyreg,$newPass,$id));
    $HTML = 1;
  }
} else {
  $HTML = '<div class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">x</button>
  <h4>ERROR:</h4> <p>
    El email ingresado no existe en sistema.
  </p></div>';
}
echo $HTML;
?>
