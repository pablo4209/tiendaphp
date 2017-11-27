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

	}
}
?>