<?php
/**
 * esta clase se carga con los datos para generar un documento
 * o para recuperar un documento guardado
 * para cargar un nuevo documento puedo pasar un array con los datos obligatorios
 * y con el metodo save() guardo el documento.
 *
 * isSet(): retorna true si los valores obligatorios para guardar un documento estan cargados
 * save(): retorna el idDoc en caso de exito, false si hubo algun error
 * setDoc($array): recibe un array con los datos para cargar la clase, retorna isSet()
 *
 *
 */

require_once( MODEL_PATH . "docItemsModel.php" );

class Doc extends Conectar
{
    private $idDoc;
    private $idOrden;
    private $idTipoDoc;
    private $Fecha;
    private $Hora;
    private $Fechamod;
    private $HoraMod;
    private $idDeposito;
    private $idUsuario;
    private $idEntidad;
    private $idLista;
    private $idEstado;
    private $idCondPago;
    private $CliNom;
    private $CliDom;
    private $CliLoc;
    private $CliCp;
    private $CliProv;
    private $CliCuit;
    private $CliTel;
    private $CliMail;
    private $idCondfiscal;
    private $CostoTotal;
    private $pDescuento;
    private $pRecargo;
    private $TotalIva;
    private $SubTotal;
    private $Total;
    private $idMoneda;
    private $MailNotificaciones;
    private $Observacion;
    private $ObsPrivada;
    private $idPtoVenta;
    private $Unidades;
    private $cantItems;
    private $AfectarVendidas;
    private $AfectarStock;
    private $Entregado;
    private $campos;
    private $tabla;
    private $countAjax;
    private $Items;   //Items es contenedor de clase docItemsModel

    public function __construct()
    {
        parent::__construct();

        $this->campos = " `idDoc`, `idOrden`, `idTipoDoc`, `Fecha`, `Hora`, `Fechamod`, `HoraMod`, `idDeposito`, `idUsuario`, `idEntidad`, `idLista`, `idEstado`, `idCondPago`, `CliNom`, `CliDom`, `CliLoc`, `CliCp`, `CliProv`, `CliCuit`, `CliTel`, `CliMail`, `idCondfiscal`, `CostoTotal`, `pDescuento`, `pRecargo`, `TotalIva`, `SubTotal`, `Total`, `idMoneda`, `MailNotificaciones`, `Observacion`, `ObsPrivada`, `idPtoVenta`, `Unidades`, `Items`, `AfectarVendidas`, `AfectarStock`, `Entregado` " ;
        $this->tabla = " `tbdoc` ";
        $this->countAjax =0;
        $this->resetDoc();
        $this->Items = new docItems();
    }

    /**
     * instancia de clase docItems, contiene el detalle del documento
     * @return [docItems]
     */
    public function getItems(){
         return $this->Items;
    }

    /**
     * recibe un array y carga el documento
     * @param [type] $item retorna el valor de isSet()
     */
    public function set( $doc ){
          if( is_array($doc) ){

            $this->idTipoDoc=(isset($doc["idTipoDoc"]))? $doc["idTipoDoc"] : 1;
            $this->idDeposito=(isset($doc["idDeposito"]))? $doc["idDeposito"] : 1;
            $this->idUsuario=(isset($doc["idUsuario"]))? $doc["idUsuario"] : 0;
            $this->idEntidad=(isset($doc["idEntidad"]))? $doc["idEntidad"] : 0;
            $this->idLista=(isset($doc["idLista"]))? $doc["idLista"] : 1;
            $this->idEstado=(isset($doc["idEstado"]))? $doc["idEstado"] : 1;
            $this->idCondPago=(isset($doc["idCondPago"]))? $doc["idCondPago"] : 1;
            $this->CliNom=(isset($doc["CliNom"]))? $doc["CliNom"] : "";
            $this->CliDom=(isset($doc["CliDom"]))? $doc["CliDom"] : "";
            $this->CliLoc=(isset($doc["CliLoc"]))? $doc["CliLoc"] : "";
            $this->CliCp=(isset($doc["CliCp"]))? $doc["CliCp"] : "";
            $this->CliProv=(isset($doc["CliProv"]))? $doc["CliProv"] : "";
            $this->CliCuit=(isset($doc["CliCuit"]))? $doc["CliCuit"] : "";
            $this->CliTel=(isset($doc["CliTel"]))? $doc["CliTel"] : "";
            $this->CliMail=(isset($doc["CliMail"]))? $doc["CliMail"] : "";
            $this->idCondfiscal=(isset($doc["idCondfiscal"]))? $doc["idCondfiscal"] : 1;
            $this->CostoTotal=(isset($doc["CostoTotal"]))? $doc["CostoTotal"] : 0.00;
            $this->pDescuento=(isset($doc["pDescuento"]))? $doc["pDescuento"] : 0.00;
            $this->pRecargo=(isset($doc["pRecargo"]))? $doc["pRecargo"] : 0.00;
            $this->TotalIva=(isset($doc["TotalIva"]))? $doc["TotalIva"] : 0.00;
            $this->SubTotal=(isset($doc["SubTotal"]))? $doc["SubTotal"] : "";
            $this->Total=(isset($doc["Total"]))? $doc["Total"] : 0.00;
            $this->idMoneda=(isset($doc["idMoneda"]))? $doc["idMoneda"] : 1;
            $this->MailNotificaciones=(isset($doc["MailNotificaciones"]))? $doc["MailNotificaciones"] : "";
            $this->Observacion=(isset($doc["Observacion"]))? $doc["Observacion"] : "";
            $this->ObsPrivada=(isset($doc["ObsPrivada"]))? $doc["ObsPrivada"] : "";
            $this->idPtoVenta=(isset($doc["idPtoVenta"]))? $doc["idPtoVenta"] : 1;
            $this->Unidades=(isset($doc["Unidades"]))? $doc["Unidades"] : "";
            $this->cantItems=(isset($doc["cantItems"]))? $doc["cantItems"] : 0;
            $this->AfectarVendidas=(isset($doc["AfectarVendidas"]))? $doc["AfectarVendidas"] : false;
            $this->AfectarStock=(isset($doc["AfectarStock"]))? $doc["AfectarStock"] : false;
            $this->Entregado=(isset($doc["Entregado"]))? $doc["Entregado"] : false;

            return $this->isSet();
          }

          return false;
    }



    /// Revisa si los campos importante estan cargados
    public function isSet(){
      if( //$this->idDoc > 0 &&
          $this->idDeposito > 0 &&
          $this->idUsuario > 0 &&
          $this->idEntidad > 0 &&
          $this->idLista > 0 &&
          $this->idCondPago > 0 &&
          $this->idMoneda > 0 &&
          $this->idPtoVenta > 0
        )
                          return true;

      return false;
    }

    /**
     * guarda el documento completo en la bd
     * @return [type] el id si es correcto, false si incorrecto
     */
    public function save()
    {

        if( !$this->isSet() ) return false;


        if(!parent::getRowId("SELECT tbpro.Codigo FROM tbpro WHERE Codigo=?",array($_POST["Codigo"]))) //si es codigo ya existe no lo crea
    		{
    			$sql="INSERT INTO tbpro ( `idProducto`, `Codigo`, `Nombre`, `SEO`, `FechaIngreso`, `HoraIngreso`, `idMoneda`, `Costo`, `UnidxDef`,
    				  `MaxDescuento`, `pDescuento`, `Imagen`, `CodBar`, `CodBar2`, `idMarca`, `idPadre`, `idTipo`, `idIva`, `Garantia`, `Descripcion`,
    				  `Nota`, `NotaEmerg`, `Publicar`, `Destacado`, `Marcado`, `Usado`, `Reparable`, `VenderSinStock`, `Promociones`, `Habilitado` )
    				  VALUES ( NULL ,? ,? ,? ,NOW() ,NOW(),? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? )";



    			$stmt=$this->dbh->prepare($sql);
    			$stmt->bindValue(1,$_POST["Codigo"],PDO::PARAM_STR);
    			$stmt->bindValue(2,$_POST["Nombre"],PDO::PARAM_STR);
    			$stmt->bindValue(3,$_POST["SEO"],PDO::PARAM_STR);
    			$stmt->bindValue(4,$_POST["idMoneda"],PDO::PARAM_INT);
    			$stmt->bindValue(5,$_POST["Costo"],PDO::PARAM_INT);
    			$stmt->bindValue(6,$_POST["UnidxDef"],PDO::PARAM_INT);
    			$stmt->bindValue(7,$_POST["MaxDescuento"],PDO::PARAM_INT);
    			$stmt->bindValue(8,$_POST["pDescuento"],PDO::PARAM_INT);
    			$stmt->bindValue(9,$_POST["Imagen"],PDO::PARAM_STR);
    			$stmt->bindValue(10,$_POST["CodBar"],PDO::PARAM_STR);
    			$stmt->bindValue(11,$_POST["CodBar2"],PDO::PARAM_STR);
    			$stmt->bindValue(12,$_POST["idMarca"],PDO::PARAM_INT);
    			$stmt->bindValue(13,$_POST["idPadre"],PDO::PARAM_INT);
    			$stmt->bindValue(14,$_POST["idTipo"],PDO::PARAM_INT);
    			$stmt->bindValue(15,$_POST["idIva"],PDO::PARAM_INT);
    			$stmt->bindValue(16,$_POST["Garantia"],PDO::PARAM_INT);
    			$stmt->bindValue(17,$_POST["Descripcion"],PDO::PARAM_STR);
    			$stmt->bindValue(18,$_POST["Nota"],PDO::PARAM_STR);
    			$stmt->bindValue(19,$NotaEmerg,PDO::PARAM_INT);
    			$stmt->bindValue(20,$Publicar,PDO::PARAM_INT);
    			$stmt->bindValue(21,$Destacado,PDO::PARAM_INT);
    			$stmt->bindValue(22,$Marcado,PDO::PARAM_INT);
    			$stmt->bindValue(23,$Usado,PDO::PARAM_INT);
    			$stmt->bindValue(24,$Reparable,PDO::PARAM_INT);
    			$stmt->bindValue(25,$VenderSinStock,PDO::PARAM_INT);
    			$stmt->bindValue(26,$Promociones,PDO::PARAM_INT);
    			$stmt->bindValue(27,$Habilitado,PDO::PARAM_INT);


    			$res = $stmt->execute();
        }else { header("Location:".BASE_URL."?accion=pro-add&st=4");exit; }   //ya existe

        if($res)
        {
			         return $this->dbh->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
            header("Location:".BASE_URL."?accion=pro-add&st=3");exit;
        }


    }

    //inicializa todos los campos
    public function resetDoc(){
        $this->set(array());
    }




    /*
    esta funcion no deberia estar aca, se debe utilizar en una clase que recupere
    un listado de clases Documentos
     */
    public function getDoc()
    {
        $sql="SELECT  idDoc, idOrden, idTipoDoc, DATE_FORMAT(tbdoc.Fecha,'%d/%m/%Y') as 'Fecha', Hora, idCliente, CliNom, idEstadoPago
              FROM  `tbpro`  order by Nombre asc";
        return parent::getRows($sql);
    }
    public function LimpiarArray()
    {
        parent::ClearArray();
    }

	//recibe parametros para armar una consulta filtrada y retorna listado en json
    public function getDocAjax($filtro="")
    {
        $campos = " tbdoc.idDoc, tbdoc.idOrden, tbdoc_tipo.Nombre, DATE_FORMAT(tbdoc.Fecha,'%d/%m/%Y') as 'Fecha', tbdoc.Hora, tbdoc.idCliente, tbdoc.CliNom, tbdoc_estado.Descripcion ";
        $where = " FROM  `tbdoc`, tbdoc_estado, tbdoc_tipo WHERE tbdoc.idEstadoPago = tbdoc_estado.idEstado AND tbdoc.idTipoDoc = tbdoc_tipo.idTipoDoc " . $filtro;

        $sql = "SELECT count(*) as total ". $where;
        $ret = parent::getRows($sql);
        $this->countAjax  = $ret[0]["total"];
        $sql = "SELECT " . $campos . $where;

        return parent::getRowsJson($sql);
    }

    public function getCountDocAjax()
    {
        return $this->countAjax;
    }

    public function getDocId($id)
    {
        $sql="SELECT  ".$this->campos."	FROM ".$this->tabla." WHERE idDoc=?";

        return parent::getRowId($sql, array($id));
    }

    public function edit()
    {
        if(empty($_POST["Nombre"]) or empty($_POST["Codigo"]) or empty($_POST["idCategoria"]) or empty($_POST["idMoneda"]) or empty($_POST["idIva"]))
        {
            header("Location:".BASE_URL."?accion=pro-edit&st=1");exit;
        }

        $sql="UPDATE tbpro
              SET
              `Codigo`=?, `Nombre`=?, `SEO`=?, `FechaMod`=NOW(), `HoraMod`=NOW(), `idMoneda`=?, `Costo`=?, `UnidxDef`=?, `MaxDescuento`=?, `pDescuento`=?,
			  `Imagen`=?, `CodBar`=?, `CodBar2`=?, `idMarca`=?, `idPadre`=?, `idTipo`=?, `idIva`=?, `Garantia`=?, `Descripcion`=?, `Nota`=?,
			  `NotaEmerg`=?, `Publicar`=?, `Destacado`=?, `Marcado`=?, `Usado`=?, `Reparable`=?, `VenderSinStock`=?, `Promociones`=?, `Habilitado`=?
              WHERE
              `idProducto`=?";

		//los checks no tildados no generan variable post!!
		$NotaEmerg  = (isset($_POST["NotaEmerg"]))? 1:0;
		$Publicar  = (isset($_POST["Publicar"]))? 1:0;
		$Destacado  = (isset($_POST["Destacado"]))? 1:0;
		$Marcado  = (isset($_POST["Marcado"]))? 1:0;
		$Usado  = (isset($_POST["Usado"]))? 1:0;
		$Reparable  = (isset($_POST["Reparable"]))? 1:0;
		$VenderSinStock  = (isset($_POST["VenderSinStock"]))? 1:0;
		$Promociones  = (isset($_POST["Promociones"]))? 1:0;
		$Habilitado = (isset($_POST["Habilitado"]))? 1:0;


        $stmt=$this->dbh->prepare($sql);

		$stmt->bindValue(1,$_POST["Codigo"],PDO::PARAM_STR);
		$stmt->bindValue(2,$_POST["Nombre"],PDO::PARAM_STR);
		$stmt->bindValue(3,$_POST["SEO"],PDO::PARAM_STR);
		$stmt->bindValue(4,$_POST["idMoneda"],PDO::PARAM_INT);
		$stmt->bindValue(5,$_POST["Costo"],PDO::PARAM_INT);
		$stmt->bindValue(6,$_POST["UnidxDef"],PDO::PARAM_INT);
		$stmt->bindValue(7,$_POST["MaxDescuento"],PDO::PARAM_INT);
		$stmt->bindValue(8,$_POST["pDescuento"],PDO::PARAM_INT);
		$stmt->bindValue(9,$_POST["Imagen"],PDO::PARAM_STR);
		$stmt->bindValue(10,$_POST["CodBar"],PDO::PARAM_STR);
		$stmt->bindValue(11,$_POST["CodBar2"],PDO::PARAM_STR);
		$stmt->bindValue(12,$_POST["idMarca"],PDO::PARAM_INT);
		$stmt->bindValue(13,$_POST["idPadre"],PDO::PARAM_INT);
		$stmt->bindValue(14,$_POST["idTipo"],PDO::PARAM_INT);
		$stmt->bindValue(15,$_POST["idIva"],PDO::PARAM_INT);
		$stmt->bindValue(16,$_POST["Garantia"],PDO::PARAM_INT);
		$stmt->bindValue(17,$_POST["Descripcion"],PDO::PARAM_STR);
		$stmt->bindValue(18,$_POST["Nota"],PDO::PARAM_STR);
		$stmt->bindValue(19,$NotaEmerg,PDO::PARAM_INT);
		$stmt->bindValue(20,$Publicar,PDO::PARAM_INT);
		$stmt->bindValue(21,$Destacado,PDO::PARAM_INT);
		$stmt->bindValue(22,$Marcado,PDO::PARAM_INT);
		$stmt->bindValue(23,$Usado,PDO::PARAM_INT);
		$stmt->bindValue(24,$Reparable,PDO::PARAM_INT);
		$stmt->bindValue(25,$VenderSinStock,PDO::PARAM_INT);
		$stmt->bindValue(26,$Promociones,PDO::PARAM_INT);
		$stmt->bindValue(27,$Habilitado,PDO::PARAM_INT);
		$stmt->bindValue(28,$_POST["idProducto"],PDO::PARAM_INT);


        if($stmt->execute())
        {
            return true;
        }else
        {
			return false;
        }

    }

    public function delete()
    {
        //primero es necesario checkear la integridad referencial

            $sql="delete from tbmoneda where idMoneda=?";

    		$stmt=$this->dbh->prepare($sql);

            $id=$_GET["id"];
            $stmt->bindValue(1,$id,PDO::PARAM_INT);


    		if($stmt->execute())
            {
                header("Location: ".BASE_URL."?accion=mon&st=2");
            }else
            {
                header("Location: ".BASE_URL."?accion=mon&st=1");
            }

    }
}

?>
