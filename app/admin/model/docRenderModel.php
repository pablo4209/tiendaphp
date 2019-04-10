<?php

require_once( MODEL_PATH . "docTipoModel.php");
require_once( MODEL_PATH . "ptoVentaModel.php");
require_once( MODEL_PATH . "condFiscalModel.php");
require_once( MODEL_PATH . "monModel.php" );
require_once( MODEL_PATH . "depModel.php");
require_once( MODEL_PATH . "listModel.php");
require_once( MODEL_PATH . "docModel.php");
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
    private $clsDoc;


    public function __construct(){
        $this->html  = $this->totales =  $this->js = "";
        $this->clsDoc = new Doc();
        $this->clsDoc->setIdTipoDoc(1);
        $this->clsDoc->setIdPtoVenta(1);
        $this->clsDoc->setIdCondFiscal(1);
        $this->clsDoc->setIdMoneda(1);
        $this->clsDoc->setIdDeposito(1);

        self::setTitulo("Nuevo Documento") ;
        $this->setControles();
    }

    public function setControles(){
      $tipodoc = new DocTipo();
      $this->selTipodoc = $tipodoc->crearSelect($this->clsDoc->getIdTipoDoc()); // creamos un select para elegir el tipo de documento
      $ptovta = new PtoVenta();
      $this->selPtoVenta = $ptovta->crearSelect($this->clsDoc->getIdPtoVenta());
      $condf = new CondFiscal();
      $this->selcondfiscal = $condf->crearSelect($this->clsDoc->getIdCondFiscal());
      $mon= new Moneda();
      $this->selMon = $mon->getSelMonedas($this->clsDoc->getIdMoneda());
      $dep= new Depositos();
      $this->seldep = $dep->crearSelect($this->clsDoc->getIdDeposito());
      $list = new Listas();
      $this->sellista = $list->crearSelect($this->clsDoc->getIdLista());
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
                return $this->clsDoc->getItems()->getTable();
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
                      '</div><!-- end div detalle -->
                      <div class="row text-right"><!-- guardar -->
                            <hr class="divider">
                            <button type="button" class="btn btn-default" id="btnCancelar" name="btnCancelar" >Cancelar</button>
                            <button type="button" class="btn btn-success" id="btnGuardar" name="btnGuardar" >Guardar</button>
                      </div><!-- end guardar -->'
                      ;

        return $this->html;
    }

    public function __wakeup(){
        return array();
    }

    public function __sleep(){
          return array( "titulo", "body","selTipodoc", "selcondfiscal", "selPtoVenta",
                      "totales", "js","selMon","seldep","sellista","clsDoc");
    }

    public function getDoc(){ return $this->clsDoc; }
    public function setDoc($d){ $this->clsDoc = $d; }
    public function setItems($d){ $this->clsDoc->setItems($d); }
    public function getItems(){ return $this->clsDoc->getItems();}
}

 ?>
