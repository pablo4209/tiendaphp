	
	$(function(){		
		$(document).ready(function(){
			//$('html, body').animate({scrollTop: $("#login").position().top}, 1000);
			if($("#idProducto").length){
				CalcularPrecios($("#Costo"));
				funcCategorias("cargarCat");
			}
			

		});
		

		
		$("body").delegate("#txtpadre", "keyup", function(e){
	            var keyCode = e.keyCode || e.which; 	            
	            event.preventDefault();
	            
	            if( keyCode == 120 || keyCode == 13 ){  //F9 o ENTER : buscar	                
	                dialogoBuscar( $(this).val() );
	            } 
        });
			
		$("body").on( "eventoResultado" , function( ev , id , nombre ){ 
				
				$("#txtpadre").attr( "value" , nombre );
				$("#idPadre").attr( "value" , id ); 
 
		});

		$("body").delegate("#buscarSub", "click", function(e){	            
	            
	                dialogoBuscar( $("#txtpadre").val() );	             
        });

        $("body").delegate("#chkSub", "click", function(e){	            
	       
	       	if( $(this).is( ":checked" ) ){
	       		//habilitar controles
	       		$(".ctrlNoSubPro,#idCategoria").attr("disabled" , "true" );
	       		$(".ctrlSubPro").removeAttr("disabled");
	       	    $("#form").validate({ rules: { idCategoria : { required : false }  } });
	       		
	       	}else{
	       		//deshabilitar controles de subproducto
	       		$(".ctrlNoSubPro,#idCategoria").removeAttr("disabled");	    
	       		$(".ctrlSubPro").attr("disabled" , "true" );   		
	       		$("#form").validate({ rules: { idCategoria : { required : true } } });
	       	}

	        //dialogoBuscar( $(this).val() );	             
        });
		
		$("#cargando").hide();
		$("#aceptado").hide();
		//boton submit
		$('#BtnGuardar').button();		
		$('#imgGuardar').click(function(){
			$('#form').submit();
		});
		$('#imgEliminar').click(function(){
			alert("Eliminar?");
		});
		$('#imgRecargar').click(function(){
			 location.reload();
		});
		
		$("#buscarCodigo").click(function(){					
				var formData = new FormData();	
				formData.append("func", "cod");
				formData.append("idcat", $("#idCategoria").val());
				formData.append("mpath", $("#modelpath").val());
				formData.append("apppath", $("#apppath").val());
				$.ajax({
					url: $('#pathjs').val()+'pro_ajax.php',  
					type: 'POST',										
					data: formData,					
					cache: false,
					contentType: false,
					processData: false,
					//mientras enviamos el archivo
					beforeSend: function(){
												
					},
					//una vez finalizado correctamente
					success: function(data){												
						$("#Codigo").val(data);						
						$("#cargando").hide();						
						if($("#Codigo").val()){ $("#aceptado").show(); }else $("#aceptado").hide();
					},
					//si ha ocurrido un error
					error: function(){
						$("#cargando").hide();
						$("#aceptado").hide();
					}
				});			
		});
		
		var moverCargando = function(a)
		{			
			//a.insertAfter( $("#cargando") );			
			$("#cargando").show();
		}
		var buscarImagen = function()
		{
			$('#divCargarImg').modal('show');						
		}		
		
		$('#imgImagen').click(function(){
			buscarImagen();
		});
		$('#clrImagen').click(function(){
			if($('#Imagen').val() != "")
			{
				if(confirm("Borrar la imagen"))
				{					
					$('#Imagen').val("");						
					$("#imgImagen").attr("src",$('#pathimg').val()+'255x320.png');
				}
			}
				
		});
		
		//datepicker
		$('#FechaIngreso').datepicker({
			inline: true,
			changeMonth: true, 
			changeYear: true,
			dateFormat: 'dd/mm/yy'
		});
		$('#FechaMod').datepicker({
			inline: true,
			changeMonth: true, 
			changeYear: true,
			dateFormat: 'dd/mm/yy' });
			
		$('#FechaUltVenta').datepicker({
			inline: true,
			changeMonth: true, 
			changeYear: true,
			dateFormat: 'dd/mm/yy' });
			
		//evitar que se envie el form con enter
		$("input[type=text]").keypress( function(e){ if(e.which == 13){ return false; } }); 
		$("#form1").keypress( function(e){ if(e.which == 13){ return false; } });		
			//if(e.which == 13){ return false; }
			
		$("#idMoneda").change(function(){ CalcularPrecios ($(this)); });	
		$("#idIva").change(function(){ CalcularPrecios ($(this)); });	
		$("#Costo").keyup(function(){ CalcularPrecios($(this)); });
		$(".txtMargen").keyup(function(){ CalcularPrecios($(this)); });
		$(".txtPrecio").keyup(function(){ CalcularPrecios($(this)); });
		$(".txtPrecioFinal").keyup(function(){ CalcularPrecios($(this)); });
		
		var strValorMoneda = function(cadena){
			if(cadena != ""){
				var ini = cadena.indexOf("(");				
				var fin = cadena.indexOf(")");
				cadena = cadena.slice(ini+1, fin); //recorta				
				return parseFloat(cadena);
			}else return 1;						
		}
		
		var CalcularPrecios = function(a) 
		{			
			//obtiene el el valor del cambio a partir de la leyenda del select
			var cambio = strValorMoneda($("#idMoneda option:selected").html());
			var alicuota = strValorMoneda($("#idIva option:selected").html());			
			var costo = parseFloat($("#Costo").val())*parseFloat(cambio);				
			var costofinal = ((costo / 100) * alicuota) + costo;
			$('input[class=txtCosto]').each( function(){																				
				var idcosto = $(this).closest('tr').find('input[class=txtCosto]').attr("id");										
				var idmargen = $(this).closest('tr').find('input[class=txtMargen]').attr("id");						
				var idprecio = $(this).closest('tr').find('input[class=txtPrecio]').attr("id");							
				var idpreciofinal = $(this).closest('tr').find('input[class=txtPrecioFinal]').attr("id");							

				if(isNaN(costofinal)){
					costo = 0;
					$("#"+idprecio).val(0.000);							
				}else{		
					var margen;			 
					var precio;
					switch (a.attr("id")) {							
						case idprecio:						
							precio = parseFloat($("#"+idprecio).val());
							//Margen = ((Precio - Costo) * 100) / Costo
							margen = (precio - costo)*100 / costo ;
							$("#"+idmargen).val(margen.toFixed(3));
							break;	
						case idpreciofinal:
							var preciofinal = parseFloat($("#"+idpreciofinal).val()) ;
							margen = (preciofinal - costofinal)*100 / costofinal ;
							$("#"+idmargen).val(margen.toFixed(3));												
						case idmargen: //igual que PrecioCompra														
						default:
							//PrecioCompra
							margen = parseFloat($("#"+idmargen).val());					
							precio = ((costo / 100) * margen) + costo;					
							$("#"+idprecio).val(precio.toFixed(3));
							break;
					}													
					$("#"+idcosto).val(costofinal.toFixed(3));
					var preciofinal = ((precio / 100) * alicuota) + precio;
					if(a.attr("id")!=idpreciofinal) $("#"+idpreciofinal).val(preciofinal.toFixed(3));
				}
			});					
		}	
		
		//asociar mas categorias a producto
				
		$("#idCategoria").change(function(){  			
			var idcat = $(this).val(); 						
			if(!$("#idProducto").length){			
				if($('#tablacat >tbody >tr').length > 0)
				   {
						alert("Al cambiar la categoria principal es necesario eliminar todas las categorias secundarias seleccionadas");					
						$('#tablacat >tbody >tr').remove();					
				   }
		   }
			$("#idCategoria2 option").each(function(){	// hide para la categoria principal seleccionada, show al resto	    			   
			   if($(this).attr('value') == idcat && idcat!=0){
					$(this).attr("disabled","true");
			   }else $(this).removeAttr("disabled");			   
			});			
			$("#buscarCodigo").click();
		});	
		
		$("#addCategoria").on( "click", function() {
			if($("#idCategoria2").val() !=0)
			{
				if($("#idCategoria").val() !=0)
				{					
					if($("#idProducto").length){
						funcCategorias("addCat", $("#idCategoria2").val()); 
					}else{
						var strFila = '<tr><td>'+ $("#idCategoria2 option:selected").text() +
								  '<input type="hidden" value="'+ $.trim($("#idCategoria2").val()) +'" name="otrasCat[]" id="otrasCat'+$("#idCategoria2").val()+'" class="clsFilas"/></td>'+
								  '<td><input type="button" value="-" id="delCat'+$("#idCategoria2").val()+'" title="Eliminar" class="clsEliminarFila"/></td></tr>';
						$('#tablacat').find('tbody').append(strFila); //agregamos la nueva fila a la tabla				
					}										
					$("#idCategoria2 option:selected").attr("disabled","true"); //para que no se pueda volver a 
					$("#idCategoria2").val(0);
				}else 	
					alert( "Debes seleccionar una categoria principal antes de agregar otras secundarias!!!" );						
			}
			
		});		
		
		$(document).on('click','.clsEliminarFila',function(){
			if(confirm("Eliminar?"))
			{			
				var objFila = $(this).closest('tr');
				var idcat = objFila.find(".clsFilas").val();
				if($("#idProducto").length) //si idproducto esta seteado quiere decir que estamos editando
				{
					funcCategorias("delCat", idcat);
				}else
				{								
					objFila.remove();
				}
				$("#idCategoria2 option").each(function(){
						if($(this).val()==idcat){ $(this).removeAttr("disabled");}					
				});
			}
		});
		
		var funcCategorias = function(func, id) 
		{				
				id = (typeof id == 'undefined') ? false : id;				
		
				$('#tablacat >tbody >tr').remove();	 //borrar todas las filas				
				var formData = new FormData();	
				formData.append("func", func);
				if(id){					
					formData.append("idCategoria", id);
				}
				formData.append("idProducto", $("#idProducto").val());
				formData.append("mpath", $("#modelpath").val());
				formData.append("apppath", $("#apppath").val());
				$.ajax({
					url: 'ajax.php/?mode=pro-cat',  
					type: 'POST',										
					data: formData,					
					cache: false,
					contentType: false,
					processData: false,
					//mientras enviamos el archivo
					beforeSend: function(){
						$("#cargando").show();						
					},
					//una vez finalizado correctamente
					success: function(data){																		
						$('#tablacat').find('tbody').append(data);					
						$("#cargando").hide();												
					},
					//si ha ocurrido un error
					error: function(){
						$("#cargando").hide();						
					}
				});	
		}
		
	});