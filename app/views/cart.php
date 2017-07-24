	<!-- Content -->
	<div class="clearfix" style="margin-bottom:20px;"></div>
	<div class="container">
		<div class="row">
			<h3><span class="glyphicon glyphicon-shopping-cart"></span> Productos en el carro</h3>
			<div class="col-md-12 col-xs-12">
				<div id="_AJAX_CART_"></div>
				<div class="panel panel-info" id="cartProductos">						  						  
				  
				</div><!-- PANEL -->
				<a href="?accion=catalogo" class="btn btn-primary"><span class="glyphicon glyphicon-share-alt"></span> Continuar comprando</a>	
			</div>
		</div>
	</div>
	<!-- End Content -->
	<script type="text/javascript">
		$(document).ready(function(){
			
			getProductos();

			

			$("body").delegate("#cartRefresh","click", function(){
				getProductos();
			})

			$("body").delegate(".remove","click", function(){				
				var idProducto = $(this).attr("idp");
				
				$.ajax({
					url	:  'ajax.php/?mode=cart',
					method	: 'POST',
					data	: {remove:1, id: idProducto},
					success	: function(data){
						$('#_AJAX_CART_').html(data).fadeIn(500).fadeOut(4000);
						getProductos();	
						actualizarCartNav();
					}
				});
			})

			var timer=0;
			// en este evento se actualiza la fila y se pone la funcion con ajax a la espera de 1.5 segundos de
			// pulsada la ultima tecla para actualizar el registro
			$("body").delegate(".cantidad", "keyup paste", function(){
				
				var idp = $(this).attr("idp");
				calcularPrecio(idp);
				clearTimeout(timer);
				timer = setTimeout( function() { modificarCantidad( idp ) } , 1500 );
			});						
			
			function modificarCantidad(idProducto){
				var cantidad = $("#cantidad-"+idProducto).val();
				var idItem = $("#cantidad-"+idProducto).attr("idItem");
				
				$.ajax({
					url	:  'ajax.php/?mode=cart',
					method	: 'POST',
					data	: {editItem:1, id: idItem, cant: cantidad },
					success	: function(data){
						$('#_AJAX_CART_').html(data).fadeIn(500).fadeOut(4000);
						getProductos();	
						actualizarCartNav();
					}, 
					complete : function(){ habilitarBotones(); },
					beforeSend : function(){ deshabilitarBotones(); }
				});
			}


			function calcularPrecio(id){
				//actualizar precio*cantidad de la fila
				$("#total-"+id).val( parseFloat($("#cantidad-"+id).val() * $("#precio-"+id).val(), 2) );
				
				//actualizar el total del cart
				var total=0; 
				$(".total").each(function(index, value){
					total = parseFloat(total) + parseFloat($(this).val());					
				});
				$("#totalCart").val( parseFloat(total, 2) );
			}

			function getProductos(){
				$.ajax({
					url	:  'ajax.php/?mode=cart',
					method	: 'POST',
					data	: {	cartProductos:1 },
					success	: function(data){	
						
						$("#cartProductos").html(data);	       	

					}
				});
			}
		});
	</script>
	<script src="<?php echo JS ?>cart.js"></script>