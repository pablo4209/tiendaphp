<?php

/*
 * consultas de productos con ajax
 */



if( isset( $_POST["buscarProd"] ) && $_POST["buscarProd"] == 1 )
{
	require_once(APP_PATH . 'config.php');
	require_once( MODEL_PATH . "proModel.php");


	$pro=new Producto();
	$datos=$pro->getProductosBuscar( $_POST["txtBuscar"] );

	if( is_array($datos) )
	{
				$result = count($datos);
				if( $result )
				{
			        for( $i=0; $i<$result; $i++ )
			        {

			            $clase = ( $i == 0 )? 'class="selected"' : '';
			            $txt .= '<tr ' . $clase . '>
			                        <td align="center" class="colCodigo">' .$datos[$i]["Codigo"].'
			                        <input class="buscarID" type="hidden" value="'.$datos[$i]["idProducto"].'" </td>
			                        <td   align="left" class="colNombre">'.$datos[$i]["Nombre"].'</td>
			                        <td align="center" class="colPrecio">'.$datos[$i]["Precio"].'</td>
			                    </tr>';
			        }
			        echo $txt;
				} //hay resultados?
	} //es array?
}

if( isset( $_POST["buscarCodigo"] ) && $_POST["buscarCodigo"] == 1 ){

    require_once(APP_PATH . 'config.php');
    require_once( MODEL_PATH . "proModel.php");


    $pro=new Producto();
    $datos=$pro->getProductosCodigo( $_POST["txtBuscar"] );

		if( is_array($datos) )
		{
		    $result = count($datos);
		    if( $result )
		    {

		        $item = $_POST["items"] + 1 ; //$_POST["items"] + 1 ;
		        $fila =  '<tr>
		                        <td>' . $item . '</td>
		                        <td>' .$datos[0]["Codigo"]. '</td>
		                        <td>1</td>
		                        <td>' .$datos[0]["Nombre"]. '</td>
		                        <td></td>
		                        <td></td>
		                        <td></td>
		                        <td><input id="serie" item="1" name="serie" type="text" title="Ingresar numero de serie" class="input-large" >
		                        </td>
		                        <td>
		                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
		                                    <button type="button" class="btn btn-danger del_item" item="'.$item.'" >
		                                        <span class="glyphicon glyphicon-trash"></span>
		                                    </button>
		                                    <button type="button" class="btn btn-success edit_item" item="'.$item.'" >
		                                        <span class="glyphicon glyphicon-edit"></span>
		                                    </button>
		                                </div>
		                        </td>
		                </tr> ';
		        echo $fila;

		    } //hay resultados?
		}//es array?

}

?>
