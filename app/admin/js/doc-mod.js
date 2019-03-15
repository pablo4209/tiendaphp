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

        $("body").on( "eventoResultado" , function( ev , id , codigo , nombre ){

             agregarItem( id , codigo , nombre );

        });


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
            alert("eliminar item: " + $(this).attr("item") );
        });

        $("body").on( "click" , ".edit_item" , function(){
            alert("editar item: " + $(this).attr("item") );
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
                    url : 'ajax.php/?mode=pro-buscar',
                    method  : 'POST',
                    data    : { buscarCodigo:1 , txtBuscar: $(this).val() , items : $("#txtItems").val()  },
                    success : function(data){
                            //alert(data);
                            $("#t_doc_body").html(data);
                            //document.getElementById("tabla_items").insertRow(-1).innerHTML = data ;
                            //actualizarDatos();
                        }
                    });
            }

        });

        var agregarItem = function( id , codigo , nombre ){


            var nroItem = $("#txtItems").val() + 1 ;
            var fila =  '<tr><td>'+nroItem+'</td><td>'+codigo+'</td><td>1</td><td>'+nombre+'</td><td></td><td></td><td></td>';
            var edicion = ' <td><input id="serie" item="1" name="serie" type="text" title="Ingresar numero de serie" class="input-large" ></td> \
                            <td>    \
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">   \
                                    <button type="button" class="btn btn-danger del_item" item="'+nroItem+'" > \
                                        <span class="glyphicon glyphicon-trash"></span>             \
                                    </button>           \
                                    <button type="button" class="btn btn-success edit_item" item="'+nroItem+'" >      \
                                        <span class="glyphicon glyphicon-edit"></span>          \
                                    </button>           \
                                </div>  \
                            </td>       \
                        </tr> ';

            document.getElementById("tabla_items").insertRow(-1).innerHTML = fila + edicion ;
            actualizarDatos();

        };

        var actualizarDatos = function(){
            $('#txtItems').val( $("#tabla_items tr").length );

            $('#txtUnidades').val( 222 );

        };



    });
