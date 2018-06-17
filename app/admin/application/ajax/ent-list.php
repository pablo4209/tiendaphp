<?php 
	
	if( isset( $_POST["idEntidadTipo"]) AND $_POST["idEntidadTipo"] > 0 ){
			
			require_once( MODEL_PATH . "entModel.php");
						
			$u = new Entidad();			
			$datos = $u->getRowsTipo( $_POST["idEntidadTipo"] );
			if( sizeof($datos) ){
				
		        for($i=0;$i<sizeof($datos);$i++)
		        {
		        	$ret = '<tr>
						        <td align="center">'. $datos[$i]["idEntidad"] . '</td>
						        <td align="center">'. $datos[$i]["Nombre"] . '</td>
						        <td align="center">'. $datos[$i]["Estado"] . '</td>
		        
		        
						        <td align="center">
						        	<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#panel_edit">Edit</button>
						        	<a href="'. BASE_URL . '?accion=ent-edit&id=' . $datos[$i]["idEntidad"]. '" title="Editar '. $datos[$i]["Nombre"] .'"><img src="'. PATH_IMG . 'b_edit.png" border="0" width="16" height="16"></a></td>  
						        </tr>';
		        }
		        echo $ret;		 
		    }       
			else
				echo "no existen registros";


	}	
	else{
    	throw new Exception("Error Processing Request", 1);    
	}	
	
 ?>