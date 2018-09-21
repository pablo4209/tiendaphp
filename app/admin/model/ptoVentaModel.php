<?php

class PtoVenta extends Conectar
{
    private $u;

    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }

    public function crearSelect($sel="")
    {
        return parent::crearSelectTabla("tbpto_venta", "idPtoVenta", "idOrden", $sel, "Descripcion", "", " input-medium required", "Selecciona un punto de venta." );
    }


}

?>
