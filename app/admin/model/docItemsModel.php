<?php
require_once( MODEL_PATH . "docItemModel.php" );
require_once( MODEL_PATH . "controls/cTabla.php" );
/**
 * declara una coleccion de docItemModel
 * ------------------------------------------------------
 * setIdDoc(id); setea el id de documento, asi los items pueden ser guardados
 * count()
 * add(): recibe un array asociativo y agrega un elemento al listado de tipo docItem
 * del(idproducto): borra el elemento del listado y de la bd si corresponde
 * getItem(idproducto): retorna una instancia de la clase docItem correspondiente
 * save(): guarda todos los items cargados para el documento idDoc, revisa si idDoc esta seteado
 * getTable(): retorna el html con la tabla de items en html
 */
class docItems
{
    private $idDoc;
    private $idLista;
    private $idDeposito;
    private $listado;
    private $error;
    private $tabla;

    public function __construct(){
        $this->listado = array();
        $this->error = array();
        $this->idDoc = 0;
        $this->idDeposito = 1;
        $this->idLista = 1;
        $this->tabla = new cTabla();
    }
    /*
    public function __wakeup(){
        return array();
    }

    public function __sleep(){
          return array("idDoc", "idLista", "idDeposito", "listado", "error", "tabla" );
    }*/

    /**
     * setea el idDoc para que los items puedan ser guardados para
     * ese documento
     * @param [numero] $id [idDocumento valido(no chequea)]
     */
    public function setIdDoc($id){
      if(is_numeric($id))
            return $this->idDoc = $id;
      return false;
    }

    /**
     * retorna cantidad de items en la coleccion
     * @return [integer]
     */
    public function count(){ return sizeof($this->listado); }

    /**
     * agregar item a la coleccion, solo si esta correcto
     * @param [array] $item [array (elementos minimos validos:iddoc, idproducto, cantidad, descripcion, iddeposito) ]
     * @return [boolean]
     */
    public function add($item){

          if(!isset($item["idLista"])) $item["idLista"] = $this->idLista;
          if(!isset($item["idDeposito"])) $item["idDeposito"] = $this->idDeposito;

          $elemento = new docItem($item);
          if($elemento->isSet()){

            $this->listado[] = $elemento;
            return true;
          }
          return false;
    }

    /**
     * guarda todos los items en la bd, revisa si idDoc esta seteado
     * @return [boolean] [si retorna false, se puede verificar el array error para saber que elemento fallo]
     */
    public function save(){
          if( $this->idDoc > 0 ){
                foreach ($this->listado as $value)
                        $value->setIdDoc($this->idDoc);
          }else{
            $this->error[] = "ERROR, IDDOC NO SETEADO";
            return false; //sino esta seteado retorna error
          }
          $ret = true;
          foreach ($this->listado as $key => $value) {
              if($value->add())
                    $this->error[$key] = "OK";
              else{
                  $ret = false;
                  $this->error[$key] = "ERROR, idDoc:".$value->getIdDoc()." | Cod:".$value->getCodigo()." no se guardo en la bd.";
              }
          }
          return $ret;
    }

    /**
     * [del borra el item segun idProducto, si está guardado lo borra de la bd]
     * @param  [numero] $idproducto [ borra item, si corresponde tambien de la base de datos]
     * @return [boolean]
     */
    public function del($idproducto){
          foreach ($this->listado as $key => $item)
            if($item->getIdProducto() == $idproducto){
                $item->del();
                unset($this->listado[$key]);
            }
          return false;
    }
    /**
     * muestra el contenido del item
     * @return [string] [description]
     */
    public function toString(){
          foreach ($this->listado as $key => $value) {
                 echo '</br>'.$value->toString();
          }
    }
    public function getTBody(){
          $this->setTable();
          return $this->tabla->renderBody();
    }

    public function getTable(){
          $this->setTable();
          return $this->tabla->render();
    }

    public function setTable(){

      $this->tabla->setTitle("");
      $this->tabla->setStriped(true);
      $this->tabla->setCondensed(true);
      $this->tabla->setBorder(true);
      $this->tabla->setIdBody("t_doc_body");
      $this->tabla->setIdTabla("t_doc");
      $this->tabla->setHeader(array('<div class="form-group">
                                <label for="txtCodigo">Codigo</label>
                                <input type="text" placeholder="Codigo o barcode" value="" name="txtCodigo" id="txtCodigo" class="input-small ingreso_item form-control" >
                              </div>',
                              '<div class="form-group">
                                <label for="txtNombre">Descripcion</label>
                                <input type="text" placeholder="descripcion o buscar (F9)" value="" name="txtNombre" id="txtNombre" class="input-large form-control  ingreso_item" autocomplete="off">
                               </div>',
                               '<div class="form-group">
                                 <label for="txtCantidad">Cantidad</label>
                                 <input type="text" placeholder="Cantidad" value="1" name="txtCantidad" id="txtCantidad" class="input-small form-control ingreso_item" >
                                </div>',
                                '<div class="form-group">
                                  <label for="txtPrecio">Precio</label>
                                  <input type="text" placeholder="Precio" value="0.00" name="txtPrecio" id="txtPrecio" class="input-small form-control ingreso_item" >
                                 </div>',
                                 '<div class="form-group">
                                   <label for="txtTotal">Total</label>
                                   <input type="text" placeholder="Total" value="0.00" name="txtTotal" id="txtTotal" class="input-small form-control ingreso_item" >
                                  </div>',
                                 "ACCION"));

      foreach ($this->listado as $d) //coleccion de objetos docItemModel
            $this->tabla->addRow(array($d->getCodigo(), $d->getDescripcion(), $d->getCantidad(), $d->getPrecio(), $d->getTotal(),
            '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                <button type="button" class="btn btn-danger del_item" item="'.$d->getIdProducto().'" >
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
                <button type="button" class="btn btn-success edit_item" item="'.$d->getIdProducto().'" >
                    <span class="glyphicon glyphicon-edit"></span>
                </button>
            </div>'
            ));

    }

    /**
     * [getItem retorna un objeto de la clase docItem]
     * @param  [type] $idproducto [description]
     * @return [class docITem]             [false si no existe]
     */
    public function getItem($idproducto){
          foreach ($this->listado as $item) {
            if( $item->getIdProducto() == $idProducto )
                      return  $item;
          }
          return false;
    }

    /**
     * retorna referencia al array error
     */
    public function getError(){
        return $this->error;
    }

    public function getListado(){
        return $this->listado;
    }

    public function getIdDeposito(){return $this->idDeposito;}
    public function getIdLista(){return $this->idLista;}

    public function setIdDeposito($d){$this->idDeposito = $d;}
    public function setIdLista($d){$this->idLista=$d;}

}
?>
