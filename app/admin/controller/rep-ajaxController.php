<?php

require_once(APP_PATH . 'config.php');
require_once( MODEL_PATH . "repModel.php");


////Preparar Limit de registros segun el valor del paginador
$pag = 0;  if(isset($_GET["page"]) and $_GET["page"] != ""){$pag = $_GET["page"];}
$cant = 0; if(isset($_GET["size"]) and $_GET["size"] != ""){$cant = $_GET["size"];}
$limite = " LIMIT ".$pag.", ". $cant;


$between = "";
if(isset($_GET["txtDesde"]) and $_GET["txtDesde"] != "" AND isset($_GET["txtHasta"]) and $_GET["txtHasta"] != ""){
    $between = " AND tbdoc.fecha BETWEEN " . conectar::fechaMysql($_GET["txtDesde"]) . " AND " . conectar::fechaMysql($_GET["txtHasta"]) . " "; //formato mysql aaaa-mm-dd
}

//LA VARIABLE tipodoc es un array enviado por get  con los idtipodoc a mostrar
$tipodoc="";
    if(isset($_GET["TipoDoc"]))
    {			
            $tipodoc.=" AND (";
            $primeravez=true;
            foreach ($_GET['TipoDoc'] as $id){                             
                   if(!$primeravez)$tipodoc.=" OR "; else $primeravez=false;
                   $tipodoc .= " tbdoc.idTipoDoc = " . $id;
            }
            $tipodoc.=") ";
    }
//para realizar la ordenacion por coolumna
$campo_orden = " ORDER BY tbdoc.Fecha DESC, tbdoc.Hora DESC ";
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
                $campo_orden = " ORDER BY tbdoc.idDoc ";
                break;
            case 1:
                $campo_orden = " ORDER BY tbdoc.idOrden ";
                break;
            case 2:
                $campo_orden = " ORDER BY tbdoc.idTipoDoc ";
                break;
            case 3:
                $campo_orden = " ORDER BY tbdoc.Fecha ";
                break;
            case 5:
                $campo_orden = " ORDER BY tbdoc.idCliente ";                
            case 6:
                $campo_orden = " ORDER BY tbdoc.cliNom "; 	
            case 7:
                $campo_orden = " ORDER BY tbdoc.idEstadoPago "; 
        }
    }    
     if(is_numeric($orden))
     { 
         if ($orden) {
            $campo_orden .= " DESC ";
        } else {
            $campo_orden .= " ASC ";
        }
    }
}

$cd = new Documentos();

$datos=$cd->getDocAjax($between . $tipodoc . $campo_orden . $limite);
$total=$cd->getCountDocAjax();


if($total)
{
	$p = array(
        "total_rows" => $total,
        "headers"    => array("id", "Orden", "Tipo", "Fecha", "Hora", "idCliente", "Cliente", "EstadoPago","Editar"),
        "rows"       => $datos
        );

    echo json_encode($p);
}else
{			//`idDoc` ,  `idOrden` ,  `idTipoDoc` ,  `Fecha`, Hora, idCliente, CliNom, idEstadoPago
    echo  '{"total_rows":1,
     "headers":["id","Orden","Tipo","Fecha","Hora", "idCliente","Cliente","EstadoPago", "Editar"],
     "rows":[{"id":"","Orden":"","Tipo":"..Sin Resultados","Fecha":"","Hora":"","idCliente":"","Cliente":"","EstadoPago":""}]}';          
}


?>