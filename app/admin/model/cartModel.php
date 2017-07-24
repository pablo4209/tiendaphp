<?php

/*
+   maneja dos tablas, tbcart y tbcart_items
+   getCart():      lista los cart creados, filtro: seteados $_POST['desde'], $_POST['hasta']
+   getItems():
+
*/

class Cart extends Conectar
{

	const CART_TODOS = 100;
    const CART_ABIERTO = 0;
    const CART_CERRADO = 1;
	private $u;    
    
	public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    //lista todos los items tbcart creados
    public function getCart(){
        $sql="SELECT `idCart` , `idUsuario` , `Fecha` , `Hora` , `Fechamod` , `Horamod` , `ip` , `idEstado` , `idEstadoPago` , `idMoneda` , `CostoTotal` , `pDescuento` , `TotalIva` , `SubTotal`
                FROM `tbcart` ORDER BY `Fecha` DESC LIMIT 0, 30;";
        return parent::getRows($sql);
    }

    //
    //recibe idcart y retorna array con todos los items asociados
    public function getItems($idCart=0){
        
        $sql="call  getCartItems(?)"; // se llama al procedimiento almacenado
        
        $consulta =$this->dbh->prepare($sql);

        $consulta->bindValue(1,$idCart,PDO::PARAM_INT);       
        
        
        return parent::exePrepare_FetchAssoc($consulta); //resultado asociado solo a nombres de campos

    }

    //recibe idUser y retorna array con todos los items asociados
    public function getItemsUser($idUsuario=0, $idEstado = self::CART_ABIERTO){
        
        $cart = self::getCartIdUser($idUsuario, $idEstado);
        if(sizeof($cart)){
            $idCart = $cart[0]['idCart'];
            return self::getItems($idCart);
        }else
            return '';      

    }

    //recibe idUser y retorna el total del carro abierto
    public function getCartTotalUser($idUsuario=0){
        
        $cart = self::getCartIdUser($idUsuario, self::CART_ABIERTO);
        if(sizeof($cart)){
            $idCart = $cart[0]['idCart'];
            $items=self::getItems($idCart);
            if(sizeof($items)){
                $total = 0;
                foreach ($items as $row) {
                    $total = $total + ($row['Cantidad']*$row['Total']);
                }
                return $total;
            }else
                return 0;
        }else
            return 0;      

    }


    //
    // retorna la cantidad de items si existe carro abierto, recibiendo idUsuario
    //
    public function getCantidadItems($idUsuario){

        $cart = self::getCartIdUser($idUsuario, self::CART_ABIERTO );
        if(sizeof($cart)){
            $id= $cart[0]['idCart'];
            $items = self::getItems($id);            
            
            return sizeof($items);            
        }else
            return 0;        
    }

    //lista los carros de $idUsuario, si $abierto=0 retorna un array con el registro del carro abierto
    // idEstado = 100 (o sin parametro)todos
    // idEstado = 0 carro abierto
    // idEstado = 1 carro cerrado
    public function getCartIdUser($idUsuario=0, $idEstado = self::CART_ABIERTO){
              
        $sql = "SELECT  `idCart`, 
                        `idUsuario`, 
                        `Fecha`, 
                        `Hora`, 
                        `Fechamod`, 
                        `Horamod`, 
                        `ip`, 
                        `idEstado` ,
                        `idEstadoPago` , 
                        `idMoneda` , 
                        `CostoTotal` , 
                        `pDescuento` , 
                        `TotalIva` , 
                        `SubTotal`
                FROM `tbcart`
                WHERE `idUsuario`=? ";

        
        switch ($idEstado) {
            case self::CART_ABIERTO:
                $sql .= " AND idEstado=0 LIMIT 1;"; 
                break;
            case self::CART_CERRADO:
                $sql .= " AND idEstado=1 LIMIT 1; ";
                break;                        
        }

        return parent::getRowId($sql, array($idUsuario));

    }

    //  recibe idcart, idproducto
    // retorna item segun su id con sus join correspondientes
    //
    public function getItemId($idCart, $idProducto){
         $sql="call  getCartItem(?, ?)"; //getCartItem(idCart, idProducto) se llama al procedimiento almacenado
        
        $consulta =$this->dbh->prepare($sql);

        $consulta->bindValue(1,$idCart,PDO::PARAM_INT);              
        $consulta->bindValue(2,$idProducto,PDO::PARAM_INT);                      

        return parent::exePrepare_FetchAssoc($consulta); //resultado asociado solo a nombres de campos
        
    }

    //
    // recibe $idUsuario, crea un carro para ese usario el cual queda abierto >>> idEstado = 0
    // retorna su id si se crea con exito
    public function addCart($idUsuario=0){
        
        $sql = "
            INSERT INTO `tbcart` (`idCart`, `idUsuario`, `Fecha`, `Hora`, `Fechamod`, `Horamod`,
                `ip`, `idEstado`, `idEstadoPago`, `idMoneda`, `CostoTotal`, `pDescuento`, `TotalIva`, `SubTotal` )
                VALUES ( NULL , ?, NOW(), NOW(), NULL , NULL , ? , '0', '0', '1', '0.000', '0.000', '0.000', '0.000'
                )";
        
        $ip = getUserIp();

        $consulta =$this->dbh->prepare($sql);

        $consulta->bindValue(1,$idUsuario,PDO::PARAM_INT);
        $consulta->bindValue(2,$ip,PDO::PARAM_STR);
        

        $res = $consulta->execute();

        if($res)
        {
            return $this->dbh->lastInsertId();
        }else{
            print_r($stmt->errorInfo());            
            return 0;
        }

    }


    //
    //AGREGA ITEM AL CARRO DE COMPRAS, SI NO EXISTE CARRO SE CREA
    //
    public function addProducto($idUsuario=0, $idProducto=0, $cantidad=1){                 


        if( $idProducto ){
            $sql = "call getProducto(?,?,?)"; //getPrducto(idproducto, idlista, iddeposito)
            $consulta = $this->dbh->prepare($sql);
            $consulta->bindValue(1,$idProducto,PDO::PARAM_INT);
            $consulta->bindValue(2,1,PDO::PARAM_INT); //idLista
            $consulta->bindValue(3,1,PDO::PARAM_INT); //idDeposito
            
            $pro = parent::exePrepare_FetchAssoc($consulta); //obtenemos array con todos los datos de producto            
            if( !sizeof($pro) )       
                return 0;            
        }else            
            return 0;

        $cart = self::getCartIdUser($idUsuario, self::CART_ABIERTO);        
        $cant_ant = 0;     

        if( sizeof($cart) ){ // existe carro abierto para este cliente?
           $idCart = $cart[0]['idCart'];  //si, se agrega ahi             
           $pro_cart = self::getItemId($idCart, $idProducto);

           if( sizeof($pro_cart) ){ //existe este producto en el carro?            
                $cant_ant = $pro_cart[0]['Cantidad']; //si, se guarda cantidad
                $idItem = $pro_cart[0]['idItem']; // se guarda idItem para editar en vez de agregar
                return self::editItem($idItem, $cantidad + $cant_ant);
           }
        } else {           
            $idCart = self::addCart($idUsuario); //echo "no existe, se debe crear";
        }        

        if($idCart){ //revisa si se retorno un idCart valido
             return self::addItem($idCart, $pro, $cantidad);  
        }else
            return 0;       

    }

    // 
    //
    public function addItem($idCart=0, $pro, $cantidad=1){
         $sql = "
                INSERT INTO `tbcart_detalle` ( `idItem`, `idCart`, `idProducto`, `Cantidad`, `Serie`, `Costo`,
                `pDescuento`, `Total`, `pIva`, `idDeposito`)
                VALUES ( NULL , ?, ?, ?, '', ?, ?, ?, ?, 1); ";            


            $consulta=$this->dbh->prepare($sql);

            $consulta->bindValue(1,$idCart,PDO::PARAM_INT);
            $consulta->bindValue(2,$pro[0]['idProducto'],PDO::PARAM_INT);
            $consulta->bindValue(3,$cantidad,PDO::PARAM_INT);            
            $consulta->bindValue(4,$pro[0]['Costo'],PDO::PARAM_INT);
            $consulta->bindValue(5,$pro[0]['pDescuento'],PDO::PARAM_INT);
            $consulta->bindValue(6,$pro[0]['Precio'],PDO::PARAM_INT);
            $consulta->bindValue(7,$pro[0]['pIva'],PDO::PARAM_INT);            

            $res = $consulta->execute();

            if($res)
            {
                return $this->dbh->lastInsertId();
            }else{
                print_r($consulta->errorInfo());            
                return 0;
            }         

    }

    public function editItem($idItem=0, $cantidad=1){        
        
        $sql = "UPDATE `tbcart_detalle` SET `Cantidad` = ? WHERE `tbcart_detalle`.`idItem` =?;";


        $consulta=$this->dbh->prepare($sql);

        $consulta->bindValue(1,$cantidad, PDO::PARAM_INT);
        $consulta->bindValue(2,$idItem, PDO::PARAM_INT);

        return parent::exePrepare($consulta);
    }


    public function deleteItem($idItem=0)
    {
        
            $sql="DELETE FROM tbcart WHERE idItem=?";

            $stmt=$this->dbh->prepare($sql);
            
            $stmt->bindValue(1,$idItem,PDO::PARAM_INT);

            return parent::exePrepare($stmt);            

    }

    /*
    *   BORRA ITEM DE TABLA PERTENECIENTE A idCart, idProducto
    *
    */
    public function deleteItemIDCart($idCart=0, $idProducto=0)
    {
        
            $sql="DELETE FROM tbcart_detalle WHERE idCart = ? AND idProducto = ? ;";

            $stmt=$this->dbh->prepare($sql);
            
            $stmt->bindValue(1,$idCart,PDO::PARAM_INT);
            $stmt->bindValue(2,$idProducto,PDO::PARAM_INT);


            return parent::exePrepare($stmt);            

    }


    public function LimpiarArray()
    {
        parent::ClearArray();
    }

    function __destruct()
    {
        $this->u = null;        
    }
}

?>