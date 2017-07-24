<?php


//AGREGAR ITEMS
if(isset($_POST['addItem']) && isset($_POST['idpro']) && $_POST['idpro'] != ''){

	$idProducto = $_POST['idpro'];
	$idUsuario = $_SESSION["user_id"];
	$cantidad = $_POST['cantidad'];

	require_once(CONN_MODEL_PATH . "cartModel.php");
	$cart = new Cart();
	
	if( $cart->addProducto($idUsuario, $idProducto, $cantidad) ){	//ya esta en el carro de compras el producto
		echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Producto Agregado con Exito.</strong>
              </div>';		//si
	}else{  
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error, No se agrego producto al cart.</strong>
              </div>';			//no, se agrega
	
	}
	
}


//CONSULTAR CANTIDAD DE ITEMS DEL CARRO
if(isset($_POST['cantidadItems']) && $_POST['cantidadItems'] == 1){

	if(isset($_SESSION["user_id"])){
		require_once(CONN_MODEL_PATH . "cartModel.php");
		$cart = new Cart();
		
		echo $cart->getCantidadItems($_SESSION["user_id"]);	//ya esta en el carro de compras el producto	
		
	}else{
		echo 0;
	}
	
}

//
// RETORNA LOS ITEMS DEL CART para el panel del NAV
if(isset($_POST['cartProductosNav']) && $_POST['cartProductosNav'] == 1){
	
	if(isset($_SESSION["user_id"])){
		require_once(CONN_MODEL_PATH . "cartModel.php");
		$con = new Cart();
		
		$items = $con->getItemsUser($_SESSION["user_id"]);
		if(sizeof($items)){
			$nro = 1;
			foreach ($items as $row) {
				
				echo '<div class="row">
                        <div class="col-md-1">'.$nro.'</div>
                        <div class="col-md-2"><img class="img-responsive" src="'. IMG_PROD . pathCategoriaProd($row["idProducto"]) . $row["Imagen"].'"></div>
                        <div class="col-md-5"><small>'.$row["Nombre"].'</small></div>
                        <div class="col-md-1 text-left">'.$row["Cantidad"].'</div>
                        <div class="col-md-3 text-right">'.$row["Total"].'</div>
                      </div><hr>
				';	
				$nro++;
			}
			echo '<div class="panel-footer">
					<div class="col-md-6 text-left"><a class="btn btn-success" href="?accion=cart"><span class="glyphicon glyphicon-shopping-cart"> Modificar</a></div>
					<div class="col-md-6 text-right">Total: <strong>$'.$con->getCartTotalUser($_SESSION["user_id"]).'</strong></div>
					 
				  </div>';
		}else
			echo '..Sin Items';		
	}else{
		echo '..No hay sesion iniciada';
	}
}

//
// elimina item dell carro, recibe idProducto
//
if(isset($_POST['remove']) && $_POST['remove'] == 1){
				
		$idProducto = $_POST['id'];
		require_once(CONN_MODEL_PATH . "cartModel.php");
		$db = new Cart();
		$cart = $db->getCartIdUser($_SESSION['user_id']); //cart abierto
		if(sizeof($cart)){
			$idCart = $cart[0]['idCart'];
			
			$db->deleteItemIDCart($idCart, $idProducto);

			echo '
				<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>El Item fue eliminado con exito...!</strong>
				</div>
			';
		}else{
			echo '
				<div class="alert alert-info alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>La operacion no finalizo correctamente...!</strong>
				</div>
			';
		}


}

//
// edita item dell carro, recibe idItem, cantidad
//
if(isset($_POST['editItem']) && $_POST['editItem'] == 1){
				
		$idItem = $_POST['id'];
		$cantidad = $_POST['cant'];

		require_once(CONN_MODEL_PATH . "cartModel.php");
		$db = new Cart();
		
		if( $db->editItem($idItem, $cantidad) ){			

			echo '
				<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>El Item fue editado con exito...!</strong>
				</div>
			';
		}else{
			echo '
				<div class="alert alert-info alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>La operacion no finalizo correctamente...!</strong>
				</div>
			';
		}


}

//
// RETORNA LOS ITEMS DEL CART para el panel del CART
if(isset($_POST['cartProductos']) && $_POST['cartProductos'] == 1){
	
	if(isset($_SESSION["user_id"])){
		require_once(CONN_MODEL_PATH . "cartModel.php");
		$con = new Cart();
		
		$str = '<div class="panel-heading">
							<div class="panel-title">								
								<div class="row">
									<div class="col-md-1 col-sm-2 col-xs-12 text-left">Nro</div>
									<div class="col-md-5 col-sm-3 col-xs-12 text-left">Producto</div>					
									<div class="col-md-6">
										<div class="col-md-3 col-xs-3">Cantidad</div>
										<div class="col-md-3 col-xs-3"></div>
										<div class="col-md-3 col-xs-3">Precio unitario</div>
										<div class="col-md-3 col-xs-3">Total</div>
									</div>									
								</div>
							</div>
			  		</div>
					<div class="panel-body" >';

		$items = $con->getItemsUser($_SESSION["user_id"]);
		if(sizeof($items)){
			$nro = 1;		
			

				foreach ($items as $row) 
				{						
					$str .='<div class="row">
								<div class="col-md-1 col-sm-2 col-xs-12 text-left">
									'.$nro.'#
								</div>
								<div class="col-md-1 col-sm-3 col-xs-12">								
									<img src="'. IMG_PROD . pathCategoriaProd($row["idProducto"]) . $row["Imagen"] . '" alt="'. $row["Nombre"] . '" class="img-responsive img-catalogo" >
								</div>
								<div class="col-md-4 col-xs-12">
									<a href="?accion=details_item&id='.$row["idProducto"].'"><h4><strong>'.$row['Nombre'].'</strong></h4></a>
									<h4><small>(Cod:'.$row['Codigo'].')</small></h4>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="col-md-3 col-xs-3">										 				
										 	<input type="text" class="soloNumeros form-control input-small text-right cantidad" id="cantidad-'.$row["idProducto"].'" idp="'.$row["idProducto"].'" idItem="'.$row["idItem"].'" value="'. $row['Cantidad'] .'">
									</div>
									<div class="col-md-3 col-xs-3">
										<button class="btn btn-danger btn-sm remove" idp="'.$row["idProducto"].'" idItem="'.$row["idItem"].'" id="remove-'.$row["idProducto"].'"><span class="glyphicon glyphicon-trash"></span></button>
									</div>	
									<div class="col-md-3 col-xs-3">
											<input type="text" id="precio-'.$row["idProducto"].'" value="'.$row['Total'] .'" class="form-control input-medium text-right precio" disabled>
									</div>																
									<div class="col-md-3 col-xs-3">
											<input type="text" id="total-'.$row["idProducto"].'" value="'. ($row['Total']*$row['Cantidad']) .'" class="form-control input-medium text-right total" disabled>										
									</div>								
								</div>
							</div><!-- ROW ITEM -->
							<hr>';
				$nro++;
				} 
				
				$str .= '
						<div class="row">							
								<div class="col-md-9"></div>	
								<div class="col-md-3 col-xs-12 text-right">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Total $</span>
										<input type="text" id="totalCart" class="form-control input-medium text-right" value="'.$con->getCartTotalUser($_SESSION["user_id"]).'" disabled>
									</div>
								</div>
						</div>
					  	</div><!-- PANEL BODY -->
					  
						<div class="panel-footer">
							<div class="row">								
								<div class="col-md-9 col-xs-12"><a class="btn btn-warning" title="Refrescar carro" id="cartRefresh"><span class="glyphicon glyphicon-refresh"></span></a></div>
								<div class="col-md-3 col-xs-12 text-right">							
									<a href="?accion=checkout" id="checkout" class="btn btn-success btn-lg btn-block">Checkout</a>
								</div>
							</div>
						</div>';
			  	
				
		}else{ 
				$str .= '	<div class="row">
								<div class="col-md-12 col-xs-12">
									<h5><strong>No hay elementos agregados.</strong></h5>
								</div>	
							</div>
						</div><!-- PANEL BODY -->';						

		} 				
		echo $str;
					
	}else{
		echo '..No hay sesion iniciada';
	}



}
?>