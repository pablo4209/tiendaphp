<?php

require_once( MODEL_PATH . "docTipoModel.php");
require_once( MODEL_PATH . "ptoVentaModel.php");
require_once( MODEL_PATH . "condFiscalModel.php");
require_once( MODEL_PATH . "monModel.php" );
require_once( MODEL_PATH . "depModel.php");
require_once( MODEL_PATH . "listModel.php");
require_once( MODEL_PATH . "docItemsModel.php");
require_once( MODEL_PATH . "controls/cTabla.php");

class DocRender
{
    private $titulo;
    private $body;
    private $selTipodoc;
    private $selcondfiscal;
    private $selPtoVenta;
    private $totales;
    private $js;
    private $selMon;
    private $seldep;
    private $sellista;
    private $items;


    public function __construct(){
        $this->html  = $this->totales =  $this->js = "";

        self::setTitulo("Nuevo Documento") ;
        $tipodoc = new DocTipo();
        $this->selTipodoc = $tipodoc->crearSelect(1); // creamos un select para elegir el tipo de documento
        $ptovta = new PtoVenta();
        $this->selPtoVenta = $ptovta->crearSelect(1);
        $condf = new CondFiscal();
        $this->selcondfiscal = $condf->crearSelect(1);
        $mon= new Moneda();
        $this->selMon = $mon->getSelMonedas(1);
        $dep= new Depositos();
        $this->seldep = $dep->crearSelect(1);
        $list = new Listas();
        $this->sellista = $list->crearSelect(1);
        $this->items = new docItems();
    }

    public function setTitulo( $t ){ $this->titulo = '<h2>'.$t.'</h2>'; }
    public function setTipo( $t ){ $this->idTipo = $t; }

    public function setCabecera(){
              return '<div class="form-inline" id="panel_tipo">
                          <label for="selTipodoc">Tipo</label>
                          '.$this->selTipodoc.'

                          <input id="letra" name="letra" type="text" disabled="disabled" value="" class="input" size="2" >
                          '.$this->selPtoVenta.'
                          <input id="idDoc" name="idDoc" type="text" disabled="disabled" value="" class="input" size="8" >
                      </div>';
    }

    public function setPanelFecha(){
        return '<div style="float:left;width:30%;min-height: 120px;" class="form-horizontal"><!-- div fecha -->

                  <div class="form-group">
                      <label for="fecha" class="col-sm-2 control-label">Fecha</label>
                      <div class="col-sm-10"><div class="validar">
                                                  <input id="fecha" name="fecha" type="text" title="Fecha es requerida (dd/mm/aaaa)." class="input-small form-control required date" >
                                              </div>
                      </div>

                      <label for="selMon" class="col-sm-2 control-label">Moneda</label>
                      <div class="col-sm-10">'.$this->selMon.'</div>

                      <label for="seldep" class="col-sm-2 control-label">Deposito</label>
                      <div class="col-sm-10">'.$this->seldep.'</div>

                      <label for="sellista" class="col-sm-2 control-label">Lista</label>
                      <div class="col-sm-10">'.$this->sellista.'</div>
                  </div>

              </div><!-- end div fecha columana2-->';

    }

    public function setCliente(){
        return '
                  <div style="float:left;width:70%;min-height: 120px;"><!-- div cliente -->

                      <div class="form-group" id="panel_cli">
                          <div class="form-group">
                              <label for="cliNom" class="col-sm-2 control-label">Cliente</label>
                              <div class="col-sm-10">
                                  <input id="cliNom" name="cliNom" type="text" title="razon social de cliente" class="input-medium form-control" ><a class="btn btn-info" role="button" href="#" id="cli_masdatos">...mas datos</a>
                                  <input id="idCliente" name="idCliente" type="hidden" >
                              </div>
                          </div>

                          <div id="cli_contmasdatos" style="background-color: rgb(39, 201, 172);border: 1px solid;" class="form-horizontal" >
                              <div class="form-group">
                                  <label for="cliDom" class="col-sm-2 control-label">Domicilio</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="cliDom" name="cliDom" placeholder="Domicilio fiscal">
                                  </div>

                                  <label for="cliLoc" class="col-sm-2 control-label">Localidad</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control input-medium" id="cliLoc" name="cliLoc" placeholder="Localidad">
                                  </div>

                                  <label for="cliLoc" class="col-sm-2 control-label">Localidad</label>
                                  <div class="col-sm-10"><input id="cliLoc" name="cliLoc" type="text" title="Localidad" class="input-medium form-control" ></div>

                                  <label for="cliCp" class="col-sm-2 control-label">Codigo postal</label>
                                  <div class="col-sm-10"><input id="cliCp" name="cliCp" type="text" title="Codigo Postal" class="input-small form-control" ></div>

                                  <label for="cliProv" class="col-sm-2 control-label">Provincia</label>
                                  <div class="col-sm-10"><input id="cliProv" name="cliProv" type="text" title="Provincia" class="input-small form-control" ></div>
                                  <label for="cliTel" class="col-sm-2 control-label">Telefono</label>
                                  <div class="col-sm-10"><input id="cliTel" name="cliTel" type="text" title="Telefono" class="input-medium form-control" ></div>

                                  <label for="cliMail" class="col-sm-2 control-label">Email</label>
                                  <div class="col-sm-10"><input id="cliMail" name="cliMail" type="Email" title="Email" class="input-medium form-control" ></div>

                              </div>
                          </div>

                          <label for="cliCuit" class="col-sm-2 control-label">Cuit</label>
                          <div class="col-sm-10"><input id="cliCuit" name="cliCuit" type="text" title="Cuit" class="input-small form-control" ></div>

                          <label for="selcondfiscal" class="col-sm-2 control-label">Condicion fiscal</label>
                          <div class="col-sm-10">'.$this->selcondfiscal.'</div>
                      </div>

                  </div><!-- end div cliente -->
        ';

    }

    public function setTabla(){
        $htmlAnt = '<div id="panel_tabla"><!-- DIV TABLA -->
                    <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="10%">Codigo</th>
                                                <th width="6%">Cantidad</th>
                                                <th width="40%">Descripcion</th>
                                                <th width="8%">Descuento</th>
                                                <th width="8%">Precio</th>
                                                <th width="8%">Total</th>
                                                <th width="5%">Serie</th>
                                                <th width="10%">Accion</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th><input type="text" placeholder="Codigo o barcode" value="" name="txtCodigo" id="txtCodigo" class="input-small ingreso_item form-control" ></th>
                                                <th><input type="text" placeholder="Cantidad" value="1" name="txtCantidad" id="txtCantidad" class="input-small form-control ingreso_item" ></th>
                                                <th width="30%">
                                                    <input type="text" placeholder="descripcion o buscar (F9)" value="" name="txtNombre" id="txtNombre" class="input-large form-control  ingreso_item" autocomplete="off">
                                                </th>
                                                <th><input type="text" placeholder="Descuento" value="0.00" name="txtDescuento" id="txtDescuento" class="input-small form-control ingreso_item" ></th>
                                                <th><input type="text" placeholder="Precio" value="0.00" name="txtPrecio" id="txtPrecio" class="input-small form-control ingreso_item" ></th>
                                                <th><input type="text" placeholder="Total" value="0.00" name="txtTotal" id="txtTotal" class="input-small form-control ingreso_item" ></th>
                                                <th><input type="text" placeholder="Serie" value="" name="txtSerie" id="txtSerie" class="input-medium form-control ingreso_item"></th>
                                                <th>
                                                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                                        <button type="button" class="btn btn-success" name="btnadd" id="btnadd">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-danger" name="btndel" id="btndel">
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        </button>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabla_items">

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Items:</td>
                                                <td><input type="text" title="cantidad de items" value="0" name="txtItems" id="txtItems" class="input" size="2" disabled="disabled"></td>
                                                <td>Unidades:<input type="text" title="cantidad de unidades" value="0" name="txtUnidades" id="txtUnidades" class="input" size="2" disabled="disabled"></td>
                                                <td></td>
                                                <td>Subtotal</td>
                                                <td><input type="text" title="cantidad de unidades" value="0.00" name="txtSubTotal" id="txtSubTotal" class="input full"  disabled="disabled"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td>Saldo</td>
                                                <td><input type="text" title="cantidad de unidades" value="0.00" name="txtSaldo" id="txtSaldo" class="input-extralarge"  disabled="disabled"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td>Total</td>
                                                <td>0</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                        <input type="hidden" name="base_path" id="base_path" value="<?php echo BASE_URL;?>" >
                        <input type="hidden" name="path_js" id="path_js" value="<?php echo PATH_JS;?>" >
                        <div id="_AJAX_PROD_"></div>
                    </div>
                </div><!-- END DIV TABLA -->';
                //return $htmlAnt;

                $this->items->setIdDeposito(1);

                //$this->items->add(array( "Codigo"=>"PS40002", "Serie"=>"12ds", "Cantidad"=>2));
                //$this->items->add(array( "Codigo"=>"PS40003", "Serie"=>"145678", "Cantidad"=>1));

                $this->items->setIdDoc(2);

                return $this->items->getTable();

    }

    public function render_add(){

        $this->html = '<div class="row">' . $this->titulo . '</div>'.
                      '<hr>'.
                      '<div class="row"  id="panel_control"><!-- div panel cliente-fecha -->'.
                          self::setCabecera().
                          self::setCliente().
                          self::setPanelFecha().
                      '</div><!-- end div panel cliente-fecha-->'.
                      '<div class="row"><!-- div detalle -->'.
                          self::setTabla().
                          $this->totales.
                      '</div><!-- end div detalle -->'
                      ;

        return $this->html;
    }

    public function setItems($d){ $this->items = $d;}
    public function getItems(){ return $this->items;}
}

 ?>
