<?php

class iva extends Conectar
{
    private $u;
    
    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }
    
    public function crearSelect($sel="")
    {
        return parent::crearSelectTabla("tbpro_iva", "idIva", "Nombre", $sel, "Porcentaje");       
    }
    
}
?>