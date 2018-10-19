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

		public function getId( $id )
    {
        $sql="SELECT idEntidadTipo, Nombre, asoc_contacto, asoc_nivel, asoc_fiscal, asoc_marcas
							FROM  `tbentidad_tipo`
							WHERE idEntidadTipo = ? ";

        return parent::getRowId( $sql , $id );
    }

}
?>
