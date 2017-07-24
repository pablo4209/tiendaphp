<?php
if(isset($_GET['id']) && $_GET['id']!= ""){
      $id = $_GET['id'];
      require_once( CONN_MODEL_PATH . "proModel.php");

		$db = new Producto();
		$pro = $db->getProductoId($id);
		$idCategoria = catProd($id,1)[0]['idCategoria']; //obtengo la categoria principal asociada, la funcion retorna array

		if(!sizeof($pro))
		{	?>
				<div class="content content-dialog">
				  <div class="row" >
				    <div class="col-md-6 .col-md-offset-3 centrar-bloque">
				      <div class="alert alert-danger" role="alert">
				          <strong>No se encontro item. <a href="javascript:history.back(-1);" title="Ir la página anterior">Volver</a></strong> 
				      </div>
				    </div>
				  </div>
				</div>
<?php 	exit;
		}		
}
?>
	<!-- Page Content -->
	<div class="clearfix" style="margin-bottom:20px;"></div>	
	<div class="container" id="wrapper">
		<div class="row">
			<?php echo getRuta($idCategoria, "catalogo"); ?> 
		</div>
		<div class="row">			
			<div class="col-md-12 col-sm-12 col-xs-12 centrar-bloque">
					<div class="row">		
					  <div class="col-md-2 col-sm-2 col-xs-12"></div>
					  <div class="col-md-3 col-sm-3 col-xs-12">					  	
					  	<img src="<?php echo IMG_PROD . pathCategoriaProd($pro[0]["idProducto"]) . $pro[0]["Imagen"]; ?>" alt="<?php echo $pro[0]["Nombre"]; ?>" class="img-thumbnail" style="width:100%;">
					  </div>				  
					  <div class="col-md-5 col-sm-5 col-xs-12">					
						<div id="_AJAX_CART_"></div>
					  	<div class="panel panel-default">
							  <div class="panel-heading">
							    <h2 class="panel-title"><strong><?php echo $pro[0]['Nombre'];?></strong></h2>
							  </div>
							  <div class="panel-body">
							    <div class="width100"><h3><small>Precio: </small>$ 35</h3></div>
							    <div style="width: 50%;">								  
				                    <input type="text" name="cant<?php echo $pro[0]['idProducto']?>" id="cant<?php echo $pro[0]['idProducto']?>" class="cantidad soloNumeros" value="1" alt="Cantidad de unidades" size="1" >
			                    </div>
			                   </div>			                    
		                  		<div class="panel-footer">
		                  			<button class="btn btn-primary add-cart" style="text-transform: capitalize;" role="button" alt="Comprar" value="<?php echo $pro[0]['idProducto']?>"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Comprar</button>  
		                  		</div>
							  
						</div>				
											
					  </div>
					  <div class="col-md-2 col-sm-2 col-xs-12"></div>							
				  	</div>				
					
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-12"></div>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<p><?php echo $pro[0]["Descripcion"]; ?></p>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12"></div>
					</div>					
										
				</div>
			</div>
		</div>	
	<!-- End Page Content -->
<script>
    $(".cantidad").TouchSpin({
      verticalbuttons: true,
      min: 1,
	  max: 100,
	  decimals:0,
	  prefix: "Cantidad",
      verticalupclass: 'glyphicon glyphicon-plus',
      verticaldownclass: 'glyphicon glyphicon-minus'
    });
</script>
<script src="<?php echo JS ?>cart.js"></script>