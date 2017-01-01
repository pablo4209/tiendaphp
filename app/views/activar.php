<?php
if(isset($_GET['key'], $_SESSION["user_id"])){

      require_once( CONN_MODEL_PATH . "database.php" );
      $id = $_SESSION['user_id'];
      $key = $_GET['key'];
      $db = new Conectar();
      $reg = $db->getRowId("SELECT idUsuario FROM tbusuarios WHERE idUsuario = ? AND KeyReg=? LIMIT 1;", array($id, $key));

      if(!empty($reg)){
            $db->getRowId("UPDATE tbusuarios SET Estado='1', keyreg='' WHERE idUsuario=?;", array($id));
            echo '<div class="clearfix" style="margin-bottom:50px;"></div>
            <div class="content">
              <div class="row" >
                <div class="col-md-6 .col-md-offset-3" style="margin: 0 auto;float:none;">
                  <div class="alert alert-dismissible alert-success">
                    <strong>Activado!</strong><br>tu usuario ha sido activado correctamente.
                  </div>
                </div>
              </div>
            </div>';
      }else{
            echo '<div class="clearfix" style="margin-bottom:50px;"></div>
            <div class="content">
              <div class="row" >
                <div class="col-md-6 .col-md-offset-3" style="margin: 0 auto;float:none;">
                  <div class="alert alert-dismissible alert-danger">
                    <strong>Error!</strong><br>La clave no es valida. no se ha podido activar usuario.
                  </div>
                </div>
              </div>
            </div>';
      }
      $db->close();

}else{
  include( VIEW . '/logueate.php');
}
 ?>
