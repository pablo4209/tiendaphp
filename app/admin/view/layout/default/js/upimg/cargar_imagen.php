<?php

$dir_script = 'upimg/';

if(isset($_GET["path"]) && $_GET["path"] != ""){
	$basepath = $_GET["path"];
}

if(isset($_GET["d"]) && $_GET["d"] != ""){
	$dir = $_GET["d"];
}else $dir="tmp";


if(isset($_GET["ctrl"]) && $_GET["ctrl"] != ""){
	$ctrl = $_GET["ctrl"];
}else $ctrl="nameimg";
?>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="<?php echo $basepath;?>jquery.js"></script>
    <script type="text/javascript" src="<?php echo $basepath . $dir_script;?>cargar_imagen.js"></script>
 
<style type="text/css">
    .messages{
        float: left;
        font-family: sans-serif;
        display: none;
    }
    .info{
        padding: 10px;
        border-radius: 10px;
        background: orange;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .success{
        padding: 10px;
        border-radius: 10px;
        background: green;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .error{
        padding: 10px;
        border-radius: 10px;
        background: red;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
</style>
</head>
<body>	
	<br />
	<span class='info'>Seleccionar imagen de 155x200 pixeles preferentemente</span><br />
    <!--el enctype debe soportar subida de archivos con multipart/form-data-->
    <form enctype="multipart/form-data" class="formulario">
		<input type="hidden" name="destino" id="destino" value="<?php echo $dir;?>" /><br />
		<input type="hidden" name="path" id="path" value="<?php echo $basepath.$dir_script;?>" /><br />
        <table width="100%">
			<tr>
				<td width="5%"></td>
				<td width="20%">Carpeta destino:</td>
				<td width="75%"><?php echo $dir;?></td>
			</tr>
			<tr>
				<td>1</td>
				<td>Seleccionar Imagen:</td>
				<td><input name="archivo" type="file" id="imagen" /></td>
			</tr>
			<tr>
				<td>2</td>
				<td>Subir al servidor:</td>
				<td><input type="button" value="Subir imagen" id="upimg"/></td>
			</tr>
		</table>       
    </form>	
    <!--div para visualizar mensajes-->
    <div class="messages"></div><br /><br />
	<div style="width:200px;height:30px;">
		<input type="hidden" name="controldestino" id="controldestino" value="<?php echo $ctrl;?>"/>
		<input type="hidden" name="nombreimg" id="nombreimg"/>
		<input type="button" value="Cancelar" id="cancelar"/>
		<input type="button" value="Aplicar" disabled="disabled"  id="aplicar"/>
	</div><br /><br />
    <!--div para visualizar en el caso de imagen-->
    <div class="showImage"></div>	
</body>
</html>