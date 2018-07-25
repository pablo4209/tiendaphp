<?php
/*

__construct( $tabla , $campos , $edit_id = 0 )
                |       |           |_____ si es mayor a cero la clase utiliza el valor como id para
                |       |                    recuperar en la bd los valores de los campos
                |       |_________________ es un array que contiene todos los datos de los campos con los
                |                            que se construye el form, mismo array que crudmodel
                |_________________________ nombre de la tabla en la bd


- a cada input editable se le agrega la clase "campo_editable" para seleccionar facilmente estos campos y manipularlos


*/
class Formulario extends Conectar {

	private $u;
	protected $titulo;
	protected $html_post_titulo;
	protected $html_dentro_form;
	protected $form_nombre;
	protected $controles ;
  protected $panel_nombre;
  protected $campos_array;
  protected $campos_sql;
  protected $tabla;
  protected $edit_id;  //se carga en contruct con el id del registro a recuperar, por defecto = 0, cuando no se va a recuperar ningun registro

    const C_NOMBRE_CAMPO = 0;   //nombre verdadero que figura en la tabla de la bd
    const C_TIPO_CAMPO = 1; //usando la clase tipoDato, para saber de que tipo es
    const C_ALIAS = 2;      //nombre para mostrar en listado o label de los input
    const C_LISTAR = 3;     //mostrarlo en el listado
    const C_EDITAR = 4;     //el campo es editable
    const C_REQUERIDO = 5;  //validacion
    const C_TYPE = 6;   //campo de texto, para la validacion (ej: "email")
    const C_MIN = 7;    //minlenght del input (ej: 2)
    const C_MAX = 8;    //maxlenght del imput
    const C_PLACE = 9;  //placeholder del input
    const C_CLASS = 10;  //agregar alguna clase extra, para validar puede ser util

	public function __construct( $tabla , $campos , $edit_id = 0 )
    {
        parent::__construct();
        $this->u=array();
        $this->titulo = "Formulario CRUD";
        $this->form_nombre = "form_crud";
        $this->controles = "";
        $this->html_pre_form = "";
        $this->html_dentro_form = "";
        $this->html_post_form = "";
        $this->panel_nombre = "panel_crud";
        $this->campos_array = $campos;
        $this->tabla = $tabla;
        $this->edit_id = $edit_id;
        self::listar_campos_sql();
        self::listar_controles();

    }

    public function listar_valores(){
        if( $this->edit_id ){ //si es >0 hay que recuperar los calores para cada campo
            $sql = "SELECT * FROM " . $this->tabla . " WHERE " . $this->campos_array[0][self::C_NOMBRE_CAMPO] . "=?";

            $con = new Conectar();
            $dato = $con->getRowId( $sql , $this->edit_id );
            return json_encode( $dato );
        }else
            return "";

    }


    // FALTA REVISAR SI SE TRATA DE UNA EDICION LA CARGA DEL VALUE,
		// ya que solo dibuja los controles, la carga de datos se realiza con fnAjaxCompletarFormulario
    private function listar_controles(){

        if( $this->edit_id ){ //si es >0 hay que recuperar los valores para cada campo
            $sql = "SELECT * FROM " . $this->tabla . " WHERE " . $this->campos_array[0][self::C_NOMBRE_CAMPO] . "=?";
            $con = new Conectar();
            $dato = $con->getRowId( $sql , $this->edit_id );
				}

        $this->controles = '<input id="tabla_bd" name="tabla_bd" type="hidden" class="form-control" value="'.$this->tabla.'" >';
        $cant = count( $this->campos_array );
        $autofoco = '';
        foreach ( $this->campos_array as $id => $row )
                    if( $id >= 0 ){  //mostrar en listado?
                        $type = $row[self::C_TYPE];
                        $disabled = ( $row[self::C_EDITAR] && $id != 0 )? '' : ' disabled'; //nunca editar id
                        $cls_editable = '';
												if($row[self::C_TIPO_CAMPO] == tipoDato::T_HIDDEN ){
														$type = "hidden"; //no importa lo que tenga C_TYPE
														$cls_editable = '';
												}
												$requerido = ( $row[self::C_REQUERIDO] )? ' required':'' ;
                        $asterisco = ( $row[self::C_REQUERIDO] )? ' (*)' : '';
                        $minlength = ( $row[self::C_MIN] !='' )? ' minlength="'.$row[self::C_MIN].'"' : '';
                        $maxlength = ( $row[self::C_MAX] !='' )? ' maxlength="'.$row[self::C_MAX].'"' : '';
                        $extraclass = ( $row[self::C_CLASS] !='' )? ' '.$row[self::C_CLASS] : '';
                        $place = ( $row[self::C_PLACE] != '' )? 'placeholder="'.$row[self::C_PLACE].'"' : '';
                        $valor = ( isset($dato[0][$row[self::C_NOMBRE_CAMPO]]) )? ' value="' . $dato[0][$row[self::C_NOMBRE_CAMPO]] . '" ' : ' value="nunca entar" ';

												//en esta parte hay que determinar que tipo de control renderizar
												switch ($row[self::C_TIPO_CAMPO]) {
													case tipoDato::T_INT:
													case tipoDato::T_STR:
																$control = '<div class="form-group validar">
				                                                <label for="'.$row[self::C_NOMBRE_CAMPO].'" >'
				                                                             .$row[self::C_ALIAS].$asterisco.'</label>
				                                                <input id="'.$row[self::C_NOMBRE_CAMPO]
				                                                 .'" name="'.$row[self::C_NOMBRE_CAMPO] . '"'
				                                                 . $minlength
				                                                 . $maxlength
				                                                 .' type="'.$type.'" class="form-control input-medium '
				                                                 .$cls_editable
				                                                 .$extraclass
				                                                 .$requerido.'" '
				                                                 .$place
				                                                 . $valor
				                                                 . $disabled
				                                                 .' >
				                                            </div>';      //' .($row[self::C_REQUERIDO])? required':'' . '
																break;
													case tipoDato::T_HIDDEN:
																$control = '<input type="hidden" id="'.$row[self::C_NOMBRE_CAMPO]
																						.'" name="'.$row[self::C_NOMBRE_CAMPO] . '" '
																						.$valor.'>';
																break;
													case tipoDato::T_CHECK:
																$check = "";$valor = ' value="0" ';

																$control = '<div class="form-group validar">
																							<div class="checkbox">
																							  <label>
																									<input type="checkbox"
																									id="'.$row[self::C_NOMBRE_CAMPO]
																									.'" name="'.$row[self::C_NOMBRE_CAMPO] . '" '. $check . $valor . $disabled .' >'
																									.$row[self::C_ALIAS].'
																								</label>
																							</div>
																						</div>
																						';
																break;
													default:
																$control = "";
																break;
												}
												$this->controles .= $control;

                    }// end if( id>=0)

    }

    private function listar_campos_sql(){

        $cant = count($this->campos_array);
        $listados =0 ;
        for( $i=0 ; $i<$cant ; $i++ )
            if( $this->campos_array[$i][self::C_LISTAR] ){
                $separador = ( $i!=$cant-1 AND $listados )? ", " : " ";
                $this->campos_sql .= $separador . $this->campos_array[$i][self::C_NOMBRE_CAMPO] ;
                $listados++;
            }

    }

    public function setControles( $t ){
    	$this->controles = $t;
    }

    public function setTitulo( $t ){
    	$this->titulo = $t;
    }
    public function setNombrePanel( $t ){ //tambien es el id
        $this->panel_nombre = $t;
    }
    public function setNombreForm( $t ){
    	$this->form_nombre = $t;
    }
    public function setHtmlPreForm( $t ){
    	$this->html_pre_form = $t;
    }
    public function setHtmlDentroForm( $html ){
    	$this->html_dentro_form =  $html ;
    }
    public function setHtmlPostForm( $t ){
    	$this->html_post_form = $t;
    }


    public function renderModal(){
        return '<div class="modal fade" id="'.$this->panel_nombre.'" role="dialog" tabindex="-1"  aria-hidden="true"><!-- PANEL MODAL -->
                  <div class="modal-dialog modal-lg" role="document"><!-- modal-dialog -->
                    <form action="" method="POST" name="'.$this->form_nombre.'" id="'.$this->form_nombre.'">
                        <div class="modal-content">
                                <div class="modal-header"><!-- PANEL HEADER -->
                                    <h4 class="modal-title" id="panel_titulo">'.$this->titulo.'</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    '.$this->html_pre_form.'
                                </div><!-- END PANEL HEADER -->
                                <div class="modal-body"><!-- PANEL BODY -->
                                    ' .$this->controles
                                     .$this->html_dentro_form
                                    .'
                                </div><!-- END PANEL BODY -->
                                <div class="modal-footer"><!-- PANEL FOOTER -->
                                    '.$this->html_post_form.'
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="hidden" id="modal_mode" name="modal_mode" value="add" />
                                    <input type="button" class="btn btn-success pull-right" name="guardar" id="guardar" value="Guardar" title="Guardar cambios" />
                                </div><!-- END PANEL FOOTER -->
                        </div><!-- modal-content -->
                    </form>
                  </div><!-- END modal-dialog -->
                </div><!-- END PANEL MODAL -->';
    }


}

 ?>
