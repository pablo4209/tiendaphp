pab<?php

$vista = new View();
/*
require_once( MODEL_PATH . "controls/cTabla.php");

$tabla = new cTabla();

$tabla->setTitle("Tabla de prueba");
$tabla->setStriped(true);
$tabla->setCondensed(false);
$tabla->setBorder(true);
$tabla->setHeader(array("col1","col2","col3","col4"));
$tabla->addRow(array("dato1", "dato2", "dato3", "dato4"));
$tabla->addRow(array("dato1", "dato2", "dato3", "dato4"));
$tabla->addRow(array("dato1", "dato2", "dato3", "dato4"));
$tabla->addRow(array("dato1", "dato2", "dato3", "dato4"));

*/


require_once( MODEL_PATH . "docItemsModel.php" );

$items = new docItems();

//cargar items
//$items->add( array ("idDoc"=>2, "idProducto"=>24, "Codigo"=>"cod001", "Descripcion"=>"producto de prueba 1", "Serie"=>"1234", "Cantidad"=>1, "Precio"=>23.30, "Total"=>23.30, "idDeposito"=>1) );
//$items->add( array ("idDoc"=>2, "idProducto"=>22, "Codigo"=>"cod005", "Descripcion"=>"producto de prueba 2", "Serie"=>"1234", "Cantidad"=>1, "Precio"=>43.30, "Total"=>43.30, "idDeposito"=>2) );


$items->setIdDeposito(1);
//cargar y guardar item
$items->add(array( "Codigo"=>"PS40002", "Serie"=>"12ds", "Cantidad"=>2));
$items->add(array( "Codigo"=>"PS40003", "Serie"=>"145678", "Cantidad"=>1));

$items->setIdDoc(2);


//combobox desde tabla en bd
require_once( MODEL_PATH . "controls/cCombo.php");
$combo = new cCombo();
$combo->set( array("sql"=>"SELECT * FROM tbmoneda",
             "desc"=>"Nombre",
             "campo_value" => "idMoneda",             
              "idSel" =>2) );

$cmb = $combo->render();

$vista->renderHeader("prueba");
echo $cmb;
echo $items->getTable();
//$items->toString();
$vista->renderFooter();


/*
if($items->save())
      echo "</br>los items se guardaron en la base de datos!</br>";
else
      print_r($items->getError());
*/

/*
//eliminar un item del listado, si existe en bd, tambien en bd
echo "</br>ahora se elimina idproducto=21, queda: </br>";
$items->del(21);
$items->toString();
*/


//$dato = array( "idDoc"=>2, "idProducto"=>24, "Codigo"=>"cod001", "Descripcion"=>"yerba mate amigazo", "Serie"=>"1234", "Cantidad"=>1, "Precio"=>23.30, "Total"=>23.30, "idDeposito"=>1 );
//echo "Cargar item: " . ( $item->cargarItemArray($dato) )? "true" : "false";
//echo "Guardar item en baes de datos: " . ( $item->add() )? "true" : "false";
/*echo "Datos obtenidos: </br>";

if( $item->cargarItem(8) ){
    echo "Descripcion:".$item->getDescripcion()."<br/>";
    echo "Codigo: ".$item->getCodigo()."<br/>";
}else {
  echo "no se obtuvieron datos.";
}
*/

//mostrar el contenido del listado
//$items->toString();


 ?>
