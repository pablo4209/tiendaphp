<?php
//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	//directorio destino
    if(isset($_POST["destino"]) && $_POST["destino"] != "")
	{
		$destino = $_POST["destino"].'/';
	}else $destino="images/";
	//obtenemos el archivo a subir
    $file = $_FILES['archivo']['name'];
 
    
	//comprobamos si existe un directorio para subir el archivo
    //si no es así, lo creamos
    if(!is_dir($destino)) 
        mkdir($destino, 0777);
	else		
		array_map( "unlink", glob( $destino . '*.*' )); //si ya existia se borra su contenido
     
    //comprobamos si el archivo ha subido
    if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],$destino.$file))
    {
       sleep(3);//retrasamos la petición 3 segundos
       echo $file;//devolvemos el nombre del archivo para pintar la imagen
    }
}else{
    throw new Exception("Error Processing Request", 1);    
}