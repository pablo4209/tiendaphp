<?php

class DocTipo extends Conectar 
{
    private $u;
    
    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }
    
    public function crearSelect($sel="")
    {
        return parent::crearSelectTabla("tbdoc_tipo", "idTipoDoc", "Nombre", $sel, "", " WHERE Activo = 1");       
    }
	//crea checks de todos los tipos de documento, segun 
	//activo=0 >> deshabilitados
	//activo=1 >> habilitados
	//activo=2 >> todos
	//$seleccionar=0 todos sin tildar, =1 todos tildados , =2 tildar tipos activos
	//(seleccionar deberia ser un array con la lista de id a seleccionar, si viene vacio se seleccionan todos los activos)
	public function crearChecks($activo, $seleccionar=1){
		if($activo="") return "";
		$sql = "SELECT  `idTipoDoc` ,  `Nombre` ,  `Letra` ,`Activo` FROM  `tbdoc_tipo` ";
		
		switch ($activo) {
			//case 0://	$where = " WHERE Activo=0 ";break;				
			case 1:$where = " WHERE Activo=1 ";break;					
			default: $where = "";//para el case 2 no se hace nada
		}
		$where .= " ORDER BY `idTipoDoc` ASC";
		$codigo="";
		$tipos = parent::getRows($sql.$where);
		if(sizeof($tipos)){			
			foreach($tipos as $x){			
				switch ($seleccionar) {
					case 1: $tildado = "checked";break;					
					case 2: $tildado = ($x["Activo"])? "checked":""; break;					
					default: $tildado ="";
				}				
				$codigo .= '<input type="checkbox" name="TipoDoc[]" id="idTipoDoc'.$x["idTipoDoc"].'" value="'.$x["idTipoDoc"].'" '.$tildado.' >'.$x["Nombre"]." [".$x["Letra"]."]</br>";
			}
			return $codigo;
		}else
			return $sql.$where;
		
		
	}
	
}

?>