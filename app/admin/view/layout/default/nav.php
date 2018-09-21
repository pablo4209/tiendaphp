<?php
	$selMenu = $_layoutParams['selMenu'];
    //$subMenu = $_GET["accion"];
?>
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" style="border-radius:0px !important; margin-bottom:0px;">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo "?accion=home"; ?>"><?php echo $_layoutParams['titulo']; ?></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-left"><!-- MENU -->
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Documentos <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="<?php echo BASE_URL;?>?accion=doc-add">Nuevo</a></li>
					<li><a href="<?php echo BASE_URL;?>?accion=doc">Listado</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="<?php echo BASE_URL;?>?accion=pag-add">Nuevo Pago</a></li>
					<li><a href="<?php echo BASE_URL;?>?accion=pag">Listado de Pagos</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">Compras</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Productos <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="<?php echo BASE_URL;?>?accion=pro">Listado de Productos</a></li>
					<li><a href="<?php echo BASE_URL;?>?accion=pro-add">Nuevo Producto</a></li>
					<li><a href="#">Listado de Precios</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="<?php echo BASE_URL;?>?accion=cat">Categorias</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="<?php echo BASE_URL;?>?accion=dep">Depositos</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="<?php echo BASE_URL;?>?accion=prov">Proveedores</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="<?php echo BASE_URL;?>?accion=ent">Listado de Entidades</a></li>
					<li><a href="<?php echo BASE_URL;?>?accion=ent-add">Nueva entidad</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="<?php echo BASE_URL;?>?accion=ent-tipos">Tipos de entidades</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configuracion <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="<?php echo BASE_URL;?>?accion=mon">Moneda</a></li>
					<li><a href="#">Another action</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">Separated link</a></li>
				  </ul>
				</li>
			</ul><!-- END MENU -->
            <ul class="nav navbar-nav navbar-right"><!-- MENU USUARIO -->
              <?php if(isset($_SESSION["admin_id"])){?>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span><?php echo " ".$_SESSION["admin_nombre"]." (".$_SESSION["admin_login"].")"; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="?accion=user-edit"><span class="glyphicon glyphicon-user"></span> Mi cuenta</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="?accion=logout"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesion</a></li>
                    </ul>
                  </li>
              <?php }else{?>
                  <li><button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#loginmodal" data-whatever="">Acceder</button></li>
                  <li><a href="<?php echo "index.php?accion=user-add"; ?>"  data-target="#registro">Registrarse</a></li>
              <?php }?>
            </ul><!-- END MENU USUARIO -->
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
