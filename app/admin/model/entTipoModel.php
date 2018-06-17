<?php 
class EntidadTipo extends Conectar
{
	private $u;

	public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function crearSelect($sel="")
    {
        return parent::crearSelectTabla( "tbentidad_tipo", "idEntidadTipo", "Nombre", $sel );
    }


    
} 
?>