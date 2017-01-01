    $(function(){	
        $(document).ready(function(){
                $("#cli_contmasdatos").hide();
                $("#fecha").datepicker({
                          showOn: 'both',
                          buttonImage: 'view/layout/default/img/calendar.png',
                          buttonImageOnly: true,					  
                          changeYear: true,
                          numberOfMonths: 2,
                          maxDate: "today"
                }).datepicker("setDate", new Date());
        });			
        //  $( "#txtNombre" ).change(function(){
        //      processForm($("#frmBuscar"));
         // });   
          
            function processForm( e ){               
                $.post(
                    $("#path_js").val()+'pro-buscar.php',
                    $(this).serialize(),
                    function( data ){
                        //$('#contenedor').html( data );
                        alert(data);
                    }
                )
                .fail(function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                });

                e.preventDefault();
            }
        $( "#txtNombre" ).autocomplete({
            source: $("#path_js").val()+"pro-buscar.php",
            minLength: 2,
            select: function( event, ui ) {
              alert( ui.item ?
                "Selected: " + ui.item.value + " aka " + ui.item.id :
                "Nothing selected, input was " + this.value );
            }
         });
        
        $("#cli_masdatos").click(function() {               
                    $("#cli_contmasdatos").slideToggle();     
                    
        });
        $("#btnAdd").click(function(){
            alert("agregar item");
        });
        $("#btnClr").click(function(){
            $(".ingreso_item").val("");
        });
        $(".del_item").click(function(){
            alert("eliminar item");
        });
        $(".edit_item").click(function(){
            alert("editar item");
        });
        
    }); 