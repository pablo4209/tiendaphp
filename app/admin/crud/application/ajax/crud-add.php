<?php
/*
*		-recibe un array que incluye  tabla_bd y campo_id como campos principales
*		el resto son nombres de campo>>valor para armar la consulta mysql y agregar el registro
*
*		- el campo crud-add es de verificacion
*/
if( isset($_POST["crud-add"]) AND $_POST["crud-add"] == 1 ){


	$listados = 0;
	$sql = "INSERT INTO " . $_POST["tabla_bd"] . " ( ";
	$valores = '';
	//hay que armar el listado de campos restringiendo crud-add y tabla_bd que no lo son(son los dos primeros del array), tambien uso campo_id para enviar el nombre del id, para aislarlo de la consulta
	foreach ($_POST as $key => $value)
		if( $key != 'crud-add' AND $key != 'tabla_bd' ) {
			$separador = ( $listados )? ', ' : ' ';
			$sql .= $separador . '`'.$key.'`';
			$valores .=	$separador . ':' . $key ;
			$listados++;
		}

	$sql .= ' ) VALUES ( '.$valores.' )';


	$cls = new Conectar();
	$con = $cls->getConn();
	$prepared = $con->prepare( $sql );


	foreach ($_POST as $key => &$value) //bindParam necesita puntero
		if( $key != 'crud-add' AND $key != 'tabla_bd' )
			$prepared->bindParam( ':'.$key , $value );

echo $sql;
	//$res = $prepared->execute();
/*
	if( $res )
		echo 'Registro agregado con exito';
	else
		echo 'Error al agregar registro!';
*/
}


 ?>
