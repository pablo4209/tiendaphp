<?php
if(isset($_GET['key'])) {
  $db = new Conectar();
  $keyreg = $_GET['key'];
  $data = $db->getRowId("SELECT idUsuario, NewPass FROM tbusuarios WHERE KeyReg=? LIMIT 1;", array($keyreg));

  if(!empty($data)){
    $id_user = $data[0]['idUsuario'];
    $newPass = Encrypt($data[0]['NewPass']);
    $password = $data[0]['NewPass'];
    $db->getRowId("UPDATE tbusuarios SET KeyReg='',NewPass='',Pass=? WHERE idUsuario=?;", array($newPass,$id_user));
    //include('html/lostpass_mensaje.php');
        ?><section class="mbr-section mbr-after-navbar">
        <div class="clearfix" style="margin-bottom:50px;"></div>
        <div class="mbr-section__container container mbr-section__container--isolated">

          <div class="alert alert-dismissible alert-success">
              <strong>Contraseña cambiada!</strong><br>Tu nueva contraseña generada es:<strong><?php echo $password ?></strong><br>Prueba <a data-toggle="modal" data-target="#loginmodal">iniciar sesión</a>, recomendamos cambiar la contraseña automatica una vez iniciada la sesion.
          </div>

        </div>
      </section>
  <?php
  } else {
    header('location: ?accion=home');
  }
} else {
  header('location: ?accion=home');
}
?>
