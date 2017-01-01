<?php  
	
	require_once(  CONN_MODEL_PATH . "proModel.php" );

$cat= new Producto();

$datos = $cat->getProductos(" ORDER BY tbpro.Vendidas DESC" , " Limit 2 ");

print_r($datos);



?>