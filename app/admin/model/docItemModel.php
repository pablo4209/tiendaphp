<?php
//// Item para documento
////  - el constructor debe recibir un parametro
////              array: llama a setItemArray( $item ), elementos minimos validos: iddoc, idproducto, cantidad, descripcion, iddeposito
////              numero: llama a getItem( $id );
////              null: crea un item inicializado vacio
////  - isSet() verfica que los campos importantes esten cargados (iddoc, idproducto, cantidad, descripcion, iddeposito)
////  - save() crea un nuevo item si permite isSet(),
////              si SUMAR=true (por defecto=true) verifica que ya existe edita la Cantidad y actualiza los totales
////              si SUMAR=false no realiza accion
////  - edit() edita el item cargado ID, segun isSet(). solo reemplaza valores existentes por los nuevos
////  - getItem(ID) recupera el item ID, se utiliza en items guardados para cargar documentos existentes
////
require_once( MODEL_PATH . "proModel.php");
class docItem extends Conectar
{
    private $id;
    private $idDoc;
    private $idProducto;
    private $Codigo;  //string
    private $Descripcion; //string
    private $Serie; //string
    private $Cantidad;
    private $Precio;
    private $pDescuento;
    private $Total;
    private $pIva;
    private $costo;
    private $idDeposito;
    private $Promociones; // numerico que apunta la promocion que afecta el item
    private $idCategoria; // si =0 >>no asignada

    private $SUMAR; //propiedad para unificar items repetidos, por defecto true

    public function __construct( $item ){
          parent::__construct();
          $this->SUMAR = true;
          if( is_array($item) )
                $this->setItemArray($item);
          elseif( is_numeric($item))
                getItem($item);
          else
              $this->resetItem();
    }


    /**
     * __sleep() y
     * @return array [description]
     */
    public function __sleep(){
        return array("id", "idProducto", "idDoc", "Codigo", "Descripcion",
                  "Serie", "Cantidad", "Precio", "pDescuento", "Total", "pIva", "costo",
                 "idDeposito", "Promociones", "idCategoria", "SUMAR" );
    }
    public function __wakeup(){ return array(); }

    public function resetItem(){
        $this->id=0;
        $this->idDoc=0;
        $this->idProducto=0;
        $this->Codigo="";
        $this->Descripcion="";
        $this->Serie="";
        $this->Cantidad=1;
        $this->Precio=0.0;
        $this->pDescuento=0.0;
        $this->Total=0.0;
        $this->pIva=0.0;
        $this->costo=0.0;
        $this->idDeposito=0;
        $this->Promociones=0;
        $this->idCategoria=0;
    }

    public function save(){
        if( $this->idDoc > 0 && $this->isSet() && $this->id == 0 && !$this->buscar() ){ //revisa q este completo y que no exista para este documento

            $sql="INSERT INTO `tbdoc_detalle`(
                    `idDoc`, `idProducto`, `Codigo`, `Descripcion`, `Serie`, `Cantidad`, `pDescuento`,
                    `Precio` ,`Total`,`pIva` ,`Costo` ,`idDeposito` ,`Promociones`, `idCategoria` )
                    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

            $stmt= $this->dbh->prepare($sql);

            $stmt->bindValue(  1,  $this->idDoc       ,PDO::PARAM_INT );
            $stmt->bindValue(  2,  $this->idProducto  ,PDO::PARAM_INT );
            $stmt->bindValue(  3,  $this->Codigo      ,PDO::PARAM_STR );
            $stmt->bindValue(  4,  $this->Descripcion ,PDO::PARAM_STR );
            $stmt->bindValue(  5,  $this->Serie       ,PDO::PARAM_STR );
            $stmt->bindValue(  6,  $this->Cantidad    ,PDO::PARAM_INT );
            $stmt->bindValue(  7,  $this->pDescuento  ,PDO::PARAM_STR );
            $stmt->bindValue(  8,  $this->Precio      ,PDO::PARAM_STR );
            $stmt->bindValue(  9,  $this->Total       ,PDO::PARAM_STR );
            $stmt->bindValue( 10,  $this->pIva        ,PDO::PARAM_STR );
            $stmt->bindValue( 11,  $this->Costo       ,PDO::PARAM_STR );
            $stmt->bindValue( 12,  $this->idDeposito  ,PDO::PARAM_INT );
            $stmt->bindValue( 13,  $this->Promociones ,PDO::PARAM_INT );
            $stmt->bindValue( 14,  $this->idCategoria ,PDO::PARAM_INT );

            return $stmt->execute();
        }
        return false;
    }

    /**
     * edita el item cargado reemplazando todos los valores.
     * Tiene una segunda funcion donde
     * actualiza la cantidad sumando el nuevo valor al ya existente y reemplazando totales
     * @return [type] [description]
     */
    public function edit(){
        if( $this->isSet() && $this->id > 0 ){
            $sql="UPDATE `tbdoc_detalle` SET `idDoc`=?, `idProducto`=?, `Codigo`=?, `Descripcion`=?, `Serie`=?, `Cantidad`=?, `pDescuento`=?,
                    `Precio`=? ,`Total`=? ,`pIva`=? ,`Costo`=? ,`idDeposito`=? ,`Promociones`=? , `idCategoria`=? WHERE `id`=? ";

            $stmt=$$this->dbh->prepare($sql);

            $stmt->bindValue(  1,  $this->idDoc       ,PDO::PARAM_INT );
            $stmt->bindValue(  2,  $this->idProducto  ,PDO::PARAM_INT );
            $stmt->bindValue(  3,  $this->Codigo      ,PDO::PARAM_STR );
            $stmt->bindValue(  4,  $this->Descripcion ,PDO::PARAM_STR );
            $stmt->bindValue(  5,  $this->Serie       ,PDO::PARAM_STR );
            $stmt->bindValue(  6,  $this->Cantidad    ,PDO::PARAM_INT );
            $stmt->bindValue(  7,  $this->pDescuento  ,PDO::PARAM_STR );
            $stmt->bindValue(  8,  $this->Precio      ,PDO::PARAM_STR );
            $stmt->bindValue(  9,  $this->Total       ,PDO::PARAM_STR );
            $stmt->bindValue( 10,  $this->pIva        ,PDO::PARAM_STR );
            $stmt->bindValue( 11,  $this->Costo       ,PDO::PARAM_STR );
            $stmt->bindValue( 12,  $this->idDeposito  ,PDO::PARAM_INT );
            $stmt->bindValue( 13,  $this->Promociones ,PDO::PARAM_INT );
            $stmt->bindValue( 14,  $this->idCategoria ,PDO::PARAM_INT );
            $stmt->bindValue( 15,  $this->id          ,PDO::PARAM_INT );

            return $stmt->execute();
        }
        return false;
    }

    /**
     * [toString description]
     * @return [string] [description]
     */
    public function toString(){
        if( $this->isSet() )
                return $this->idProducto . "  "
                      . $this->Descripcion . "  "
                      . $this->Cantidad . "  "
                      . $this->Total ;
    }

    /**
     *
     * @return [type] [description]
     */
    public function del(){
        if( $this->isSet() && $this->id > 0 ){
            $sql="DELETE * FROM tbdoc_detalle WHERE id=?";
            $stmt=$$this->dbh->prepare($sql);
            $stmt->bindValue( 1,  $this->id          ,PDO::PARAM_INT );
            return $stmt->execute();
        }
        return false;
    }

    /**
     * CUANDO NO SE SABE EL ID DEL ITEM
     * busca si el item cargado ya existe para este documento
     * segun idDoc, idProducto, idDeposito, si existe carga su id
     *
     * @return [numero]     [retorna el id del producto existente]
     */
    public function buscar(){
        if( is_numeric($this->idProducto) && is_numeric($this->idDoc) && is_numeric($this->idDeposito)  ){
          $sql="SELECT * FROM tbdoc_detalle WHERE idDoc=? AND idProducto=? AND idDeposito=?";

          $item = parent::getRowId($sql, array($this->idDoc, $this->idProducto, $this->idDeposito));
          if( is_array($item) && isset($item[0]["id"]))
                    return $this->id = $item[0]["id"];
        }
        return false;
    }
    /**
    *  Para items existentes en la bd, recibe
    *     id:(numero) del item y lo carga en la clase desde la base de datos
    *     retorna boolean
    */
    public function getItem( $id ){
      if( is_numeric($id) ){
        $sql="SELECT * FROM tbdoc_detalle WHERE id=?";

        $item = parent::getRowId($sql, array($id));
        if( is_array($item) )
            return $item[0] ;
      }
      return false;
    }

    public function getProd( $p ){
        if( is_array( $p ) ){
            if( ( isset($p["idProducto"]) || isset($p["Codigo"]) ) &&
                  isset($p["idDeposito"])
            ){
              $sql="SELECT * FROM tbdoc_detalle WHERE idDoc=? AND idProducto=? AND idDeposito=?";

              $item = parent::getRowId($sql, array($this->idDoc, $this->idProducto, $this->idDeposito));
              if( is_array($item) && isset($item[0]["id"]))
                        return $this->id = $item[0]["id"];

            }
        }
        return false;
    }

    /**
     * recibe un array y carga el item completo
     * @param [type] $item [description]
     */
    public function setItemArray( $item ){
          if( is_array($item) ){

            $this->Codigo=(isset($item["Codigo"]))? $item["Codigo"] : "";
            $this->idDoc=(isset($item["idDoc"]))? $item["idDoc"] : 0;
            $this->id=(isset($item["id"]))? $item["id"] : 0;
            $this->Cantidad=(isset($item["Cantidad"]))? $item["Cantidad"] : 1;
            $this->pDescuento=(isset($item["pDescuento"]))? $item["pDescuento"] : 0.0;
            $this->pIva=(isset($item["pIva"]))? $item["pIva"] : 0.0;
            $this->Serie=(isset($item["Serie"]))? $item["Serie"] : "";
            $this->idDeposito=(isset($item["idDeposito"]))? $item["idDeposito"] : 0;

            if( !isset($item["Descripcion"]) ||
                !isset($item["Precio"]) ||
                !isset($item["Total"]) ||
                !isset($item["Costo"]) ||
                !isset($item["idCategoria"])
              ){ //si los datos principales no estan seteados, que busque el producto y lo cargue solo
                    if($this->Codigo!=""){
                          $idlista = (isset($item["idLista"]))? $item["idLista"]:1;
                          $pro = new Producto();
                          $res = $pro->getProductosCodigo($this->Codigo, $idlista);
                          //print_r($res);
                          if( isset($res[0]["Nombre"]) ){
                              $this->idProducto=(isset($res[0]["idProducto"]))? $res[0]["idProducto"] : 0;
                              $this->Descripcion=(isset($res[0]["Nombre"]))? $res[0]["Nombre"] : "";
                              $this->Precio=(isset($res[0]["Precio"]))? $res[0]["Precio"] : 0.0;
                              $this->Costo=(isset($res[0]["Costo"]))? $res[0]["Costo"] : 0.0;
                              $this->Promociones=(isset($res[0]["Promociones"]))? $res[0]["Promociones"] : 0;
                              $this->idCategoria=(isset($res[0]["idCategoria"]))? $res[0]["idCategoria"] : 0;
                          }
                    }
              }else{
                              $this->idProducto=(isset($item["idProducto"]))? $item["idProducto"] : 0;
                              $this->Descripcion=(isset($item["Descripcion"]))? $item["Descripcion"] : "";
                              $this->Precio=(isset($item["Precio"]))? $item["Precio"] : 0.0;
                              $this->Costo=(isset($item["Costo"]))? $item["Costo"] : 0.0;
                              $this->Promociones=(isset($item["Promociones"]))? $item["Promociones"] : 0;
                              $this->idCategoria=(isset($item["idCategoria"]))? $item["idCategoria"] : 0;
              }


            $this->Total=(isset($item["Total"]))? $item["Total"] : $this->Precio*$this->Cantidad;

            return $this->isSet();
          }
          else if( is_numeric($id) ){
                return true;
          }

          return true;
    }
    /// Revisa si los campos importante estan cargados
    public function isSet(){
      if( //$this->idDoc > 0 &&
          $this->idProducto > 0 &&
          //$this->Descripcion != "" &&
          $this->Cantidad > 0 &&
          $this->idDeposito > 0 )
                          return true;

      return false;
    }

    public function getId(){ return $this->id; }
    public function getIdDoc(){ return $this->idDoc; }
    public function getIdProducto(){ return $this->idProducto; }
    public function getCodigo(){ return $this->Codigo; }
    public function getDescripcion(){ return $this->Descripcion; }
    public function getSerie(){ return $this->Serie; }
    public function getCantidad(){ return $this->Cantidad; }
    public function getPrecio(){ return $this->Precio; }
    public function getpDescuento(){ return $this->pDescuento; }
    public function getTotal(){ return $this->Total; }
    public function getpIva(){ return $this->pIva; }
    public function getCosto(){ return $this->costo; }
    public function getidDeposito(){ return $this->idDeposito; }
    public function getPromociones(){ return $this->Promociones; }
    public function getidCategoria(){ return $this->idCategoria; }
    public function getSUMAR(){ return $this->SUMAR; }

    //public function setId($d){ $this->id=$d; }
    public function setIdDoc($d){ $this->idDoc=$d; }
    public function setIdProducto($d){ $this->idProducto=$d; }
    public function setCodigo($d){ $this->Codigo=$d; }
    public function setDescripcion($d){ $this->Descripcion=$d; }
    public function setSerie($d){ $this->Serie=$d; }
    public function setCantidad($d){ $this->Cantidad=$d; }
    public function setPrecio($d){ $this->Precio=$d; }
    public function setpDescuento($d){ $this->pDescuento=$d; }
    public function setTotal($d){ $this->Total=$d; }
    public function setpIva($d){ $this->pIva=$d; }
    public function setCosto($d){ $this->costo=$d; }
    public function setidDeposito($d){ $this->idDeposito=$d; }
    public function setPromociones($d){ $this->Promociones=$d; }
    public function setidCategoria($d){ $this->idCategoria=$d; }
    public function setSUMAR($valor){ $this->SUMAR = $valor; }
}
?>
