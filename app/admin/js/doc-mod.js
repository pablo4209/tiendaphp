    $(function(){
        $(document).ready(function(){
                visualizar_paneles();

                $("#fecha").datepicker({
                          showOn: 'both',
                          buttonImage: 'view/layout/default/img/calendar.png',
                          buttonImageOnly: true,
                          changeYear: true,
                          numberOfMonths: 2,
                          maxDate: "today"
                }).datepicker("setDate", new Date());
        });

        $("body").on( "change" , "#idTipoDoc" , function(){

               visualizar_paneles();

        });


        var visualizar_paneles = function (){

            $("#cli_contmasdatos").hide();
            switch( $("#idTipoDoc").val() ) {
                    case '0':
                        $("#panel_cli").hide();
                        $("#panel_control").hide();
                        $("#panel_tabla").hide();
                        break;
                    case '1':
                    case '2':
                    case '3':
                    case '4':
                        $("#panel_cli").show();
                        $("#panel_control").show();
                        $("#panel_tabla").show();
                        $("#panel_cli").show();
                        break;
                    case '5':
                    case '6':
                        $("#cli_contmasdatos").show();
                        $("#panel_control").show();
                        $("#panel_tabla").show();
                        $("#panel_cli").hide();
            }
        }



        $( "#txtNombre" ).keyup( function(e){
            var keyCode = e.keyCode || e.which;
            e.preventDefault();

            if( keyCode == 13 || keyCode == 120 ){
                dialogoBuscar( $(this).val() );
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

        $("body").on( "click" , ".del_item" , function(){
            $.ajax({
            url : 'ajax.php/?mode=doc-action',
            method  : 'POST',
            data    : { eliminarItem:1 , idProducto: $(this).attr("idprod")   },
            success : function(data){
                    //alert(data);
                    $("#t_doc_body").html(data);
                    actualizarTotales();
                }
            });
        });

        $("body").on( "click" , ".edit_item" , function(){
            alert("editar item: " + $(this).attr("idprod") );
        });

        $("body").on( "change" , "#idLista" , function(){
            alert("cambiar a lista: " + $(this).val() );
        });

        $("body").on( "change" , "#idDeposito" , function(){
            alert("cambiar a deposito: " + $(this).val() );
        });

        $("body").on( "click" , "#btnGuardar" , function(){
            alert("Guardar documento" );
        });

        $("body").on( "click" , "#btnCancelar" , function(){
            alert("cancelar documento" );
        });


        $("body").delegate("#txtCodigo", "keyup", function(e){
            var keyCode = e.keyCode || e.which;
            e.preventDefault();

            if( keyCode == 120 ){  //F9 : buscar

                dialogoBuscar( $(this).val() );
            }


            if( keyCode == 13 ) //ENTER
            {

                    $.ajax({
                    url : 'ajax.php/?mode=doc-action',
                    method  : 'POST',
                    data    : { buscarCodigo:1 , txtBuscar: $(this).val() , txtCantidad : $("#txtCantidad").val()  },
                    success : function(data){
                            //alert(data);
                            $("#t_doc_body").html(data);
                            actualizarTotales();
                            //document.getElementById("tabla_items").insertRow(-1).innerHTML = data ;

                        }
                    });
            }

        });


        var actualizarTotales = function(){
            $('#txtItems').val( $("#t_doc_body tr").length );
              var i = 0, unidades = 0;
              $(".clsY4").each(function(){
                   i = i + parseFloat( $(this).text() ) ;
              });
              $(".clsY2").each(function(){
                   unidades = unidades + parseInt( $(this).text() ) ;
              });
              $("#txtUnidades").val(unidades);
              $("#txtSubTotal").val(parseFloat(i).toFixed(3));
        };



    });
