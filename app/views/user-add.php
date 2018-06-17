<?php



if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{


      $keyreg = md5(time()); //crea clave unica para el link de confirmacion, esta clave se guarda en keyreg en el usuario
      $_POST["keyreg"] = $keyreg;
      $email = $_POST["correo"];
      $nombre = $_POST["nom"];
      $user = $_POST["login"];



      $link = BASE_URL . 'index.php?accion=activar&key=' . $keyreg;
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
      $mail->addAddress($email, $user);     // A quien le llega, esto se puede repetir a tantos destinatarios
                                            // como se quiera
      $mail->isHTML(true);    // Set email format to HTML
      $mail->Subject = 'Activación de tu cuenta';
      $mail->Body    = EmailTemplate($user,$link);
      $mail->AltBody = 'Hola ' . $nombre . ' ('.$user.'), para activar tu cuenta accede al siguiente elance: ' . $link;
      if(!$mail->send()) {
          $HTML = '<div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>ERROR:</strong> ' . $mail->ErrorInfo . ' </div>';
      } else {
        require_once( CONN_MODEL_PATH . "userModel.php" );
        $u=new User();
        $u->add(); //retorna $_GET["id"] en la url que redirecciona
        $u->close();

      }
}
if(isset($_GET["id"])){
    $_SESSION['app_id'] = $_GET["id"];
}

if(isset($_GET["st"]))
{
  switch ($_GET["st"])
  {
    case '1':
      ?>
      <div class="alert alert-dismissible alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>ERROR:</strong> Complete todos los campos obligatorios por favor.
      </div>
      <?php
    break;
    case '2':
      ?>
      <div class="alert alert-dismissible alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>El registro se ha creado exitosamente.</strong>
      </div>
      <?php
    break;
        case '3':
      ?>
      <div class="alert alert-dismissible alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>ERROR:</strong> Usuario no Creado.
      </div>
      <?php
    break;


  }
}
?>

<div>
    <form action="" method="post" name="form" id="form">

       <div class="modal-dialog">
         <div class="modal-content">

           <div id="_AJAX_REG_"></div>

           <div class="modal-header">
             <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span> Registro de Usuario</h4>
           </div>
           <div class="modal-body">
             <div role="form">
               <div class="form-group">
                 <label for="login"><span class="glyphicon glyphicon-user"></span> Usuario</label>
                 <div class="validar"><input type="text" class="form-control" id="login" name="login" placeholder="Introduce un nombre de usuario"></div>
                 <label for="nom"><span class="glyphicon glyphicon-user"></span> Nombre y Apellido</label>
                 <div class="validar"><input type="text" class="form-control" id="nom" name="nom" placeholder="Introduce nombre y apellido"></div>
                 <label for="dni"><span class="glyphicon glyphicon-book"></span> Dni</label>
                 <input type="text" class="form-control" id="dni" name="dni" placeholder="Dni">
                 <div class="form-group">
                   <label for="correo"><span class="glyphicon glyphicon-envelope"></span> Email</label>
                   <div class="validar"><input type="email" class="form-control" id="correo" name="correo" placeholder="Introduce tu correo electrónico"></div>
                 </div>
                 <div class="form-group">
                   <label  for="pass"><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
                      <div class="validar"><input type="password" class="form-control" id="pass" name="pass" placeholder="Introduce tu contraseña"></div>
                 </div>
                 <div class="form-group">
                   <label  for="pass_dos"><span class="glyphicon glyphicon-eye-open"></span> Repite tu Contraseña</label>
                   <div class="validar"><input type="password" class="form-control" id="pass_dos" name="pass_dos" placeholder="Introduce tu contraseña de nuevo"></div>
                 </div>
                <div class="form-group">
                 <label for="tel"><span class="glyphicon glyphicon-phone"></span> Telefono</label>
                 <input type="text" class="form-control" id="tel" placeholder="Telefono">
                 <label for="tel2"><span class=" glyphicon glyphicon-phone-alt"></span> Telefono 2</label>
                 <input type="text" class="form-control" id="tel2" placeholder="Telefono 2">
                </div>
                 <div class="form-group">
                   <label><span class=" glyphicon glyphicon-calendar"></span> Fecha de Nacimiento (dd/mm/aa)</label>
                   <?php echo Conectar::crear_selects_fecha(); ?>
                 </div>
                 <label for="dom"><span class="glyphicon glyphicon-home"></span> Domicilio</label>
                 <input type="text" class="form-control" id="dom" placeholder="Domicilio">
                 <label for="loc"><span class="glyphicon glyphicon-map-marker"></span> Localidad</label>
                 <input type="text" class="form-control" id="loc" placeholder="Localidad">
                 <label for="prov"><span class="glyphicon glyphicon-globe"></span> Provincia</label>
                 <input type="text" class="form-control" id="prov" placeholder="Provincia">
                 <label for="cp"><span class="glyphicon glyphicon-tag"></span> Codigo Postal</label>
                 <input type="text" class="form-control" id="cp" placeholder="Codigo postal">
               </div>

               <div class="checkbox">
                 <div class="validar"><label><input type="checkbox" id="tyc_reg" name="tyc_reg" value="1" checked>Acepto los T&C</label></div>
               </div>
               <input type="hidden" name="keyreg" value="">
               <button type="submit" id="btnRegistrar"  class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Registrarme</button>
             </div>
           </div>
           <div class="modal-footer">

             <button type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
           </div>
         </div>
       </div>
     <input type="hidden" name="grabar" value="si" />
    </form>
 </div>

 <script type="text/javascript">

     		$( document ).ready( function () {
     			$( "#form" ).validate( {
            onkeyup: false, //evitar que valide con cada tecla
            rules: {
     					nom: "required",
              login: {
                    required: true,
                    minlength: 5,
                    remote:
                    {
                      url: 'ajax.php?mode=userCheck',
                      type: "post",
                      data: {
                          login: function() {
                              return $('#login').val();
                          }
                      }
                    }
              },
     					pass: {
     						required: true,
     						minlength: 5
     					},
     					pass_dos: {
     						required: true,
     						minlength: 5,
     						equalTo: "#pass"
     					},
     					correo: {
     						email: true,
                required: true,
                remote:
                {
                  url: 'ajax.php?mode=userCheck',
                  type: "post",
                  data: {
                      login: function() {
                          return $('#correo').val();
                      }
                  }
                }
     					},
     					tyc_reg: "required"
     				},
     				messages: {
     					nom: "Ingresa un Nombre",
     					login: {
     						required: "Ingresa un Usuario",
     						minlength: "El Usuario debe tener al menos 5 caracteres.",
                remote: "El Usuario ya esta registrado, prueba con otro."
     					},
     					pass: {
     						required: "Ingresa un password",
     						minlength: "El password debe tener al menos 5 caracteres"
     					},
     					pass_dos: {
     						required: "Confirma el password",
     						minlength: "El password debe tener al menos 5 caracteres",
     						equalTo: "Los password no coinciden"
     					},
     					correo: {
                  email:"Ingresa una direccion de email valida",
                  remote: "El Email ya esta registrado, prueba con otro."
              },
     					tyc_reg: "Por favor acepta los terminos y condiciones"
     				},
     				errorElement: "em",
     				errorPlacement: function ( error, element ) {
     					// Add the `help-block` class to the error element
     					error.addClass( "help-block" );

     					if ( element.prop( "type" ) === "checkbox" ) {
     						error.insertAfter( element.parent( "label" ) );
     					} else {
     						error.insertAfter( element );
     					}
     				},
     				highlight: function ( element, errorClass, validClass ) {
     					$( element ).parents( ".validar" ).addClass( "has-error" ).removeClass( "has-success" );
     				},
     				unhighlight: function (element, errorClass, validClass) {
     					$( element ).parents( ".validar" ).addClass( "has-success" ).removeClass( "has-error" );
     				}
     			} );

     		});

   </script>
