<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo $_layoutParams['ruta_img']; ?>chart_16.png">

<title><?php echo $_layoutParams['titulo']; ?></title>

<!-- MASTER STYLESHEET-->
<link href="<?php echo $_layoutParams['ruta_css']; ?>styles.css" rel="stylesheet" type="text/css" />
<?php echo $_layoutParams['incluir']; ?>  
<script language="javascript" type="text/javascript" src="<?php echo $_layoutParams['ruta_js']; ?>funciones.js"></script> 
    
<!--[if IE 6]>
<script src="<?php echo $_layoutParams['ruta_js']; ?>pngfix.js"></script>
<script>
    DD_belatedPNG.fix('.png_bg');
</script>        
<![endif]-->


</head>

<body onload="muestraReloj();">


<!--  START HEADER -->
<div id="header">

	<!--  START HEAD_WRAP -->
  <?php require_once( VIEW_PATH . "header.phtml");?>
  <!--  END HEAD_WRAP -->
   
</div><!--  end div #header -->
<!--  END HEADER -->

	
    
    <!--  START CONTENT WRAPPER -->
    <div id="content_wrapper">
      <!--  START PRIMARY CONTENT -->
      <div id="primary_content">