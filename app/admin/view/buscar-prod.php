<div class="modal fade" id="dialogoProd" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">

                 <div id="_AJAX_DIALOGPROD_"></div>

                   <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 style="color:red;"><span class="glyphicon glyphicon-search"></span> Busqueda de Productos</h4>
                   </div>
                   <div class="modal-body">
                        <div role="form">
                              <div class="input-group">
                                <span class="input-group-addon">Busqueda</span>
                                <input type="text" class="form-control" aria-label="ingresa el texto a buscar" value="" id="txtbuscar" name="txtbuscar" autocomplete="off" >
                                <span class="input-group-btn">
                                  <button class="btn btn-success" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                              </div>

                              <table id="tabla_prod" class="tablesorter">
                                  <thead>
                                    <tr style="font-weight: bold;">
                                        <th align="center">Codigo</th>
                                        <th align="center">Nobre</th>
                                        <th align="center">Precio</th>
                                    </tr>
                                  </thead>
                                  <tbody id="tabla_prod_body">

                                  </tbody>
                              </table>

                              <div class="form-horizontal">
                                  <label for="" class="col-sm-2 control-label">Resultados</label>
                                  <div class="col-sm-10"><input type="text" disabled="true" class="form-control input-small" id="resultados" value="0" ></div>
                              </div>

                        </div>
                   </div>
                   <div class="modal-footer">
                     <input type="text"  name="resValor" id="resValor" value="" >
                     <input type="text"  name="resCodigo" id="resCodigo" value="" >
                     <input type="text" name="resNombre" id="resNombre" value="">
                     <button type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                     <button type="button" class="btn btn-success btn-default pull-right" id="btn-aceptar" ><span class="glyphicon glyphicon-plus"></span> Aceptar</button>
                   </div>
               </div>
           </div>
</div>
<script>
    $(function(){
        $(document).ready(function(){

              $("#tabla_prod").tablesorter({
                        theme : 'blue',
                        widgets: ["zebra"],
                        headers : { 6 : { sorter: false } }
              });
        });

        $("body").delegate("#tabla_prod", "click", function(){

            /*
                      if ( $('.focus-highlight').length ) {
                          $('.focus-highlight').find('td, th')
                            .attr('tabindex', '1')
                            // add touch device support
                            .on('touchstart', function() {
                              $(this).focus();
                          });
                      }*/

        });

        $("body").delegate("#txtbuscar", "keyup", function(e){
            var keyCode = e.keyCode || e.which;
            e.preventDefault();

            var selec = $('#tabla_prod_body').find('.selected');

            //alert(keyCode);

            switch(keyCode) {
                case 37:
                    //alert('izquierda');
                    break;
                case 38:
                    //alert('arriba');
                    selecFila( selec.prev() );
                    break;
                case 39:
                    //alert('derecha');
                    break;
                case 40:
                    selecFila( selec.next() );
                    break;
                case 120: //F9:buscar
                    //alert('abajo');
                    break;
                case 13: //F9:buscar
                    aceptarFila();
                    break;
                default:
                    buscarAjax( $('#txtbuscar').val() );
            }



           //selecFila( $(this).next('tr') );

        });

        $("body").delegate("#tabla_prod_body tr", "click", function(){

           selecFila( $(this) );

        });

        $("body").delegate("#tabla_prod_body tr", "dblclick", function(){

            selecFila( $(this) );
            aceptarFila();

        });

        $("body").delegate("#btn-aceptar", "click", function(){

            aceptarFila();

        });

        $('body').on( "actFila" , function(){

            if( $('#tabla_prod_body').find('tr').length ){
                selecFila( $('#tabla_prod_body').find('.selected') );
            }else{
               $("#resValor").attr( "value"  , "" );
               $("#resCodigo").attr( "value" , "" );
               $("#resNombre").attr( "value" , "" );
            }

        });



    });

    var aceptarFila = function aceptarFila( )
        {
            $('#btn-aceptar').trigger( "eventoResultado" , [ $("#resValor").val() , $("#resCodigo").val() , $("#resNombre").val() ] );
            $('#dialogoProd').modal('hide');
        }

    var selecFila = function selecFila( a )
    {

      if( a.is('tr') ){

          $('#tabla_prod_body').find('tr').removeClass('selected');
          a.addClass('selected');
          $("#resValor").attr( "value"  , a.find(".buscarID").val() );
          $("#resCodigo").attr( "value" , a.find(".colCodigo").text().trim() );
          $("#resNombre").attr( "value" , a.find(".colNombre").text().trim() );
      }

      $('#txtbuscar').focus();

    }


    //recibe el texto a buscar
    var dialogoBuscar = function dialogoBuscar( a ){

        $('#dialogoProd').modal('show');
        $("#txtbuscar").val( a );

        //hay que esperar que finalice la transicion para darle el foco sino no lo toma
        $('#dialogoProd').on('shown.bs.modal', function() {
            buscarAjax( $('#txtbuscar').val() );
            $('#txtbuscar').focus().select();
        });
    }



    var buscarAjax = function buscarAjax( texto ){

      $('#tabla_prod_body').html('');
      if( texto != '' ){

            $.ajax({
                        url : 'ajax.php/?mode=pro-buscar',
                        method  : 'POST',
                        data    : { buscarProd:1, txtBuscar: texto },
                        success : function(data){

                                $("#tabla_prod_body").html(data);
                                $('#resultados').val( $("#tabla_prod_body tr").length );
                                $('#tabla_prod_body').trigger("actFila");

                            }
            });

      }

    }
</script>
