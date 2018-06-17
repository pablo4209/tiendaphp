$(document).ready(function(){
	
	actualizarCartNav();
	
	
	$(".add-cart").click(function(){		
		addCart($(this).val());
		actualizarCartNav();
	});	

	$("#cartNav").click(function(event){
		event.preventDefault();
		
		$.ajax({
		url : 'ajax.php/?mode=cart',
		method	: 'POST',
		data	: {	cartProductosNav:1 },
		success	: function(data){									
			
			$("#cartProductosNav").html(data);	       			
		
		}
		});
		
	})

	
	function actualizarCartNav(){
						
		$.ajax({
		url : 'ajax.php/?mode=cart',
		method	: 'POST',
		data	: {	cantidadItems:1 },
		success	: function(data){									
			
			$("#cartCantidad").text(" "+data);		        			
		}
		});	
	}

	function addCart(idProducto){			
		var cantidad = $('#cant'+idProducto).val();
		
		$.ajax({
		url : 'ajax.php/?mode=cart',
		method	: 'POST',
		data	: {	addItem:1, idpro: idProducto, cantidad : cantidad },
		success	: function(data){						
			
			$('html, body').animate({ scrollTop: $("#wrapper").offset().top }, 600);					
			
        	$('#_AJAX_CART_').html(data).fadeIn(500).fadeOut(4000);    		
			
		}
		});	

	}
	
});