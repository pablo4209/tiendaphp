<?php

class ProductoTipo extends Conectar 
{
    private $u;
    
    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }
    
    public function crearSelect($sel="")
    {
        return parent::crearSelectTabla("tbpro_tipo", "idTipo", "Descripcion", $sel);       
    }
}

?>