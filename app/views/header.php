<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo APP_TITLE; ?></title>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo CSS ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo CSS ?>fuentes.css" rel="stylesheet">
    <link href="<?php echo CSS ?>estilos.css" rel="stylesheet">    
    <link href="<?php echo CSS ?>menu.css" rel="stylesheet">    
    <link rel="stylesheet" href="<?php echo COMPOSER ?>components/font-awesome/css/font-awesome.min.css">
    <link href="<?php echo JS ?>touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo JS ?>jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo JS ?>bootstrap.min.js"></script>
    
    <script src="<?php echo JS ?>validate/jquery.validate.min.js"></script>
    <script src="<?php echo JS ?>validate/localization/messages_es_AR.min.js"></script>
    <script src="<?php echo JS ?>touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="<?php echo JS ?>generales.js"></script>
    <script src="<?php echo JS ?>menu.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
    .marketing{
      text-align: center;
      margin-bottom: 20px;
    }
    .divider{
      margin: 80px 0;
    }
    hr{
      border: solid 1px #eee;
    }
    .thumbnail img{
      width: 100%;
    }
    </style>
  </head>
  <body>
    <!-- Header -->
      <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" style="border-radius:0px !important; margin-bottom:0px;">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo "?accion=home"; ?>"><?php echo APP_TITLE; ?></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <form class="navbar-form navbar-left " role="search">
      			  <div class="form-group">
      			    <input type="text" class="form-control" placeholder="Search">
      			  </div>
      			  <button type="submit" class="btn btn-default">
                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
              </button>
      			</form>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="index.php?accion=cart" id="cartNav" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button" ><span class="glyphicon glyphicon-shopping-cart"></span><span class="badge" id="cartCantidad">0</span></a>
                    <div class="dropdown-menu" style="width:450px;">
                      <div class="panel panel-success">
                        <div class="panel-heading">
                          <div class="row">
                            <div class="col-md-1">#</div>                            
                            <div class="col-md-7">Producto</div>
                            <div class="col-md-1">Cant</div>
                            <div class="col-md-3">Precio</div>
                          </div>
                        </div>
                        <div class="panel-body fixed-panel">
                          <div id="cartProductosNav"></div>
                        </div>
                      </div>                     
                    </div>

                </li>
                <li class="dropdown">                
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo (sesionIniciada())? $_SESSION["user_login"]: "Invitado"; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">                      
                      <?php if(sesionIniciada()){?>
                        <li><a href="?accion=cart"><span class="glyphicon glyphicon-shopping-cart"> Carro</a></li>
                        <li><a href="?accion=user-edit"><span class="glyphicon glyphicon-cog"></span> Mi cuenta</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="?accion=logout"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesion</a></li>
                      <?php }else{?>
                        <li><a href="#loginmodal" data-toggle="modal"><span class="glyphicon glyphicon-log-in"></span> Acceder</a></li>                   
                        <li role="separator" class="divider"></li>
                        <li><a href="index.php?accion=user-add"><span class="glyphicon glyphicon-plus"></span> Registrarse</a></li>
                      <?php }?>
                    </ul>
                </li>              
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    <!-- End Header -->
    <div class="clearfix content-margen"></div>
    <div class="container-fluid" style="min-height: 600px;"><!-- MAIN CONTAINER -->