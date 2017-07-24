<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $_layoutParams['titulo']; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo $_layoutParams['ruta_css']; ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $_layoutParams['ruta_css']; ?>estilos.css" rel="stylesheet">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo $_layoutParams['ruta_js']; ?>jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $_layoutParams['ruta_js']; ?>bootstrap.min.js"></script>
	<?php echo $_layoutParams['incluir']; ?> 
	
    
	<script language="javascript" type="text/javascript" src="<?php echo $_layoutParams['ruta_js']; ?>funciones.js"></script> 
	
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
      <?php require_once('nav.php');?>
    <!-- End Header -->
	<div id="principalContent" class="container" style="min-height:430px;padding-top: 70px;"><!-- principal content -->
	