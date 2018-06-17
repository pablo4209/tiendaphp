<?php

require_once( MODEL_PATH . "proModel.php");

$pro=new producto();

//Preparar Limit de registros segun el valor del paginador
$pag = 0;  if(isset($_GET["page"]) and $_GET["page"] != ""){$pag = $_GET["page"];}
$cant = 0; if(isset($_GET["size"]) and $_GET["size"] != ""){$cant = $_GET["size"];}
$limite = " LIMIT ".$pag.", ". $cant;


//padre o hijo
$padre = " WHERE tbpro.idPadre = 0 ";
if(isset($_GET["idPadre"]) and $_GET["idPadre"] != "")
{   
    $padre = " WHERE tbpro.idPadre = " . $_GET['idPadre'] . " "; 
    
}


//texto a buscar
$txtbuscar = "";
if(isset($_GET["txtbuscar"]) and $_GET["txtbuscar"] != "")
{   
    $txtbuscar = " AND ( tbpro.Codigo LIKE '%".$_GET["txtbuscar"]."%' OR 
                         tbpro.Nombre LIKE '%".$_GET["txtbuscar"]."%' ) ";
    
}

//obtener la categoria filtrada
$idcat = "";
$campo_cat="";
if(isset($_GET["idcat"]) and $_GET["idcat"] != "")
{
    $idcat = $_GET["idcat"];
    if($idcat > 0) //cuando es =0 muestra todas
    {       
        $campo_cat .= " AND tbpro_categorias.idCategoria = ".$idcat;
    }
}


//para realizar la ordenacion por coolumna
$campo_orden = " order by tbpro.Nombre ASC";
if(isset($_GET["column"]) and $_GET["column"] != "")
{
    foreach($_GET["column"] as $indice => $valor)
    {
        $columna = $indice;
        $orden = $valor;
    } 
    
    if(is_numeric($columna))
    {    
        switch ($columna)
        {
            case 0:
                $campo_orden = " order by tbpro.idProducto";
                break;
            case 1:
                $campo_orden = " order by tbpro.Codigo";
                break;
            case 2:
                $campo_orden = " order by tbpro.Nombre";
                break;
            case 3:
                $campo_orden = " order by tbpro.idPadre";
                break;
            case 4:
                $campo_orden = " order by tbpro.idTipo";                
			case 5:
                $campo_orden = " order by tbpro.Publicar"; 	
        }
    }    
    if(is_numeric($orden))
    { 
       if($orden) 
           $campo_orden .= " DESC";   
       else
           $campo_orden .= " ASC";
    }
}

//productos habilitados
 //productos habilitados
$habilitado = "AND tbpro.Habilitado = 1";
if( isset($_GET["chkHabilitados"]) and $_GET["chkHabilitados"] =="1" )
{
     $habilitado = "";
}






//Primero la consulta sin limite para obtener la cantidad total de registros
$dtotal = $pro->getProductosAjax( $txtbuscar, "", $campo_cat, $campo_orden, $habilitado, $padre );
$total = sizeof($dtotal);
$pro->LimpiarArray(); //esto se usa porque el array de la clase queda cargado con los valores devueltos por la consulta anterior

//Despues con el limite segun el paginador
$datos=$pro->getProductosAjax( $txtbuscar, $limite, $campo_cat, $campo_orden, $habilitado, $padre );

if($total)
{
    $p = array(
        "total_rows" => $total,
        "headers"    => array("ID", "Codigo", "Nombre", "idPadre", "idTipo", "Publicar", "Editar"),
        "rows"       => $datos
        );

    echo json_encode($p);
}else
{
    echo '{"total_rows":1,
           "headers":["ID","Codigo","Nombre","idPadre","idTipo","Publicar","Editar"],
           "rows":[{"idProducto":"","Codigo":"","Nombre":"...No hay resultados","idPadre":"","idTipo":"","Publicar":""}]}';
}


?>