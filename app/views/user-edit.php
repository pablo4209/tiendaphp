<?php

if(isset($_SESSION['user_id'])){
      require_once(CONN_MODEL_PATH . "userModel.php");
      $u = new User();
      if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
      {
        $u->editFront();
      }else{
        $d = $u->get_usuarios_por_id($_SESSION['user_id']);
        if(empty($d)){ header('Location: ?accion=logueate'); }
      }

}else{
    header('Location: ?accion=logueate');
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
        <strong>El registro se ha Modificado exitosamente.</strong>
      </div>
      <?php
    break;
        case '3':
      ?>
      <div class="alert alert-dismissible alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>ERROR:</strong> El usuario no se modifico.
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
             <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span> Perfil de Usuario</h4>
              <p class="text-right"><strong>(*)Campos requeridos</strong></p>
           </div>
           <div class="modal-body">
             <div role="form">
               <div class="form-group">
                 <label for="login"><span class="glyphicon glyphicon-user"></span> Usuario (*)</label>
                 <div class="validar"><input type="text" class="form-control" id="login" name="login" value="<?php echo $d[0]['Login']; ?>" placeholder="Introduce un nombre de usuario"></div>
                      <input type="hidden" id="login2" name="login2" value="<?php echo $d[0]['Login']; ?>">
                 <label for="nom"><span class="glyphicon glyphicon-user"></span> Nombre (*) y Apellido</label>
                 <div class="validar"><input type="text" class="form-control" id="nom" name="nom" value="<?php echo $d[0]['Nombre']; ?>" placeholder="Introduce nombre y apellido"></div>
                 <label for="dni"><span class="glyphicon glyphicon-book"></span> Dni</label>
                 <div class="validar"><input type="text" class="form-control" id="dni" name="dni" value="<?php echo $d[0]['Dni']?>" placeholder="Introduce el Dni"></div>
                 <div class="form-group">
                   <label for="correo"><span class="glyphicon glyphicon-envelope"></span> Email (*)</label>
                   <div class="validar"><input type="email" class="form-control" id="correo" name="correo" value="<?php echo $d[0]['Email']; ?>" placeholder="Introduce tu correo electrónico"></div>
                   <input type="hidden" id="correo2" name="correo2" value="<?php echo $d[0]['Email']; ?>">
                 </div>
                <div class="form-group">
                 <label for="tel"><span class="glyphicon glyphicon-phone"></span> Telefono</label>
                 <div class="validar"><input type="text" class="form-control" id="tel" name="tel" value="<?php echo $d[0]['Tel']; ?>" placeholder="Telefono"></div>
                 <label for="tel2"><span class=" glyphicon glyphicon-phone-alt"></span> Telefono 2</label>
                 <div class="validar"><input type="text" class="form-control" id="tel2" name="tel2" value="<?php echo $d[0]['Tel2']; ?>" placeholder="Telefono 2"></div>
                </div>
                 <div class="form-group">
                   <label><span class=" glyphicon glyphicon-calendar"></span> Fecha de Nacimiento (dd/mm/aa)</label>
                   <?php echo Conectar::crear_selects_fecha(); ?>
                 </div>
                 <label for="dom"><span class="glyphicon glyphicon-home"></span> Domicilio</label>
                 <input type="text" class="form-control" id="dom" name="dom" placeholder="Domicilio" value="<?php echo $d[0]['Dom']; ?>">
                 <label for="loc"><span class="glyphicon glyphicon-map-marker"></span> Localidad</label>
                 <input type="text" class="form-control" id="loc" name="loc" placeholder="Localidad" value="<?php echo $d[0]['Loc']; ?>">
                 <label for="prov"><span class="glyphicon glyphicon-globe"></span> Provincia</label>
                 <input type="text" class="form-control" id="prov" name="prov" placeholder="Provincia" value="<?php echo $d[0]['Prov']; ?>">
                 <label for="cp"><span class="glyphicon glyphicon-tag"></span> Codigo Postal</label>
                 <div class="validar"><input type="text" class="form-control" id="cp" name="cp" placeholder="Codigo postal" value="<?php echo $d[0]['Cp']; ?>"></div>
                 <div style="margin-top:5px;margin-bottom:5px;">
                     <p><strong>Usuario desde: </strong><?php echo $d[0]['FechaAlta']. " " . $d[0]['HoraAlta']; ?></p>
                     <p><strong>Ultima Modificacion: </strong><?php echo $d[0]['FechaMod']. " " . $d[0]['HoraMod']; ?></p>
                 </section>
               </div>
               <input type="hidden" name="id" value="<?php echo $d[0]['idUsuario']; ?>">
               <input type="hidden" name="keyreg" value="">
               <button type="submit" id="btnRegistrar"  class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Guardar</button>
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
            submitHandler: function(form) { form.submit(); },
            onkeyup: false, //evitar que valide con cada tecla
            rules: {
     					nom: { required: true, minlength: 3, maxlength:120 },
              login: { required: true, minlength: 5, maxlength:30,
                       remote:{ //revisa si ya existe siempre y cuando no sea el ya asignado
                                  param:{
                                    url: 'ajax.php?mode=userCheck',
                                    type: "post",
                                    data: { login: function() { return $('#login').val(); } }
                                  },
                                  depends: function() {
                                    return $("#login").val() !== $("#login2").val();
                                  }
                            }
              },
     					correo: { email: true, required: true,
                        remote:{
                                  param:{
                                    url: 'ajax.php?mode=userCheck',
                                    type: "post",
                                    data: { correo: function() { return $('#correo').val(); } }
                                  },
                                  depends: function() {
                                    return $("#correo").val() !== $("#correo2").val();
                                  }
                                }
                },
                dni: { number: true, minlength:6, maxlength:15 },
                tel: { number: true, minlength:7, maxlength:15 },
                tel2:{ number: true, minlength:7, maxlength:15 },
                cp:  { number: true, minlength:4, maxlength:4  }
            },
     				messages: {
     					nom: "Ingresa un Nombre",
     					login: {
     						required: "Ingresa un Usuario",
     						minlength: "El Usuario debe tener al menos 5 caracteres.",
                remote: "El Usuario ya esta registrado, prueba con otro."
     					},
     					correo: {
                  email:"Ingresa una direccion de email valida",
                  remote: "El Email ya esta registrado, prueba con otro."
              }
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
