<?php
/*
  se crea un select a partir de una consulta sql

 EJEMPLO: combobox desde tabla en bd
 require_once( MODEL_PATH . "controls/cCombo.php");
 $combo = new cCombo();
 $combo->set( array("sql"=>"SELECT * FROM tbmoneda",
              "desc"=>"Nombre",
              "campo_value" => "idMoneda",
               "idSel" =>2) );

 $cmb = $combo->render();


valores para el array
----------------------------------
sql: (string, requerido) consulta sql
desc: (string, requerido) campo que contiene el texto a mostrar en cada option
desc2: (string) texto a mostrar entre [] en cada option
campo_value: (string, requerido) campo del cual se obtienen los valores para los value del combo
                              ( si no se setea campo_id toma por defecto el valor de campo_value)
idSel: (number) valor a seleccionar
campo_id: (string) campo que le da nombre al control para que js lo identifique, si no se setea se toma el valor de campo_value
txtDefault: (string) text por default cuando no hay items seleccionados, su value = 0
required: (boolean) agrega la clase css required al control
 */
class cCombo extends Conectar
{
    private $sql;
    private $campo_value;
    private $combo_id;
    private $idSel;
    private $descNombre; //nombre de campo para mostrar
    private $descNombre2; //nombre de campo para mostrar entre corchetes
    private $selTxtDefault; //texto cuando no esta seleccionado ningun elemento
    private $cssClass;
    private $tooltip;
    private $cssRequired;

    public function __construct(){
          parent::__construct();
          $this->tooltip ="Debes seleccionar un elemento.";
          $this->cssClass =" input-medium ";
          $this->cssRequired = false;
          $this->sql ="";
          $this->campo_value="";
          $this->combo_id="";
          $this->idSel=0;
          $this->descNombre="";
          $this->descNombre2="";
          $this->selTxtDefault="Selecciona un valor";

    }
    /**
     * esta funcion recibe toda la configuracion en un array
     * @param [array]
     * retorna boolean
     */
    public function set($conf){
        if(is_array($conf)){

            if(isset($conf["sql"])) $this->setSql($conf["sql"]); else return false;
            if(isset($conf["campo_value"])) $this->setcampo_value($conf["campo_value"]); else return false;
            if(isset($conf["combo_id"])) $this->setcombo_id($conf["combo_id"]); else $this->combo_id = $this->campo_value;
            if(isset($conf["desc"])) $this->setdescNombre($conf["desc"]); else return false;
            if(isset($conf["desc2"])) $this->setdescNombre2($conf["desc2"]);
            if(isset($conf["idSel"])) $this->setIdSel($conf["idSel"]);
            if(isset($conf["tooltip"])) $this->setTooltip($conf["tooltip"]);
            if(isset($conf["required"])) $this->setRequired($conf["required"]);
            if(isset($conf["txtDefault"])) $this->setTxtDefault($conf["txtDefault"]);

            return true;
        }
        return false;
    }

    public function setTxtDefault($t){ $this->selTxtDefault = $t; }
    public function setdescNombre($t){ $this->descNombre = $t; }
    public function setdescNombre2($t){ $this->descNombre2 = $t; }
    public function setIdSel($t){ $this->idSel = $t; }
    public function setcampo_value($t){ $this->campo_value = $t; }
    public function setcombo_id($t){ $this->combo_id = $t; }
    public function setSql($txt){ $this->sql = $txt; }
    public function setTooltip($txt){ $this->tooltip = $txt; }
    public function setRequired($val){ $this->cssRequired = $val; }

    public function render(){
        $f=""; //se inicializan para evitar warnings
        if(empty($this->sql) or empty($this->campo_value) or empty($this->descNombre) or empty($this->combo_id))
              return "Error al generar Select ".$this->campo_value ;

        if( DEBUG )write_log("database::crearSelectTabla" , $this->sql);
        $datos = self::getRows($this->sql);

        if($datos)
        {
            $req = ($this->cssRequired)? " required" : "";
            $f.= '<select name="'.$this->combo_id.'" id="'.$this->combo_id.'" min="1" title="'.$this->tooltip.'" class="form-control '.$this->cssClass.$req.'">
                    <option value="0" ';
            if ($this->idSel=="") $f.='selected="selected"';
            $f.= '>'.$this->selTxtDefault.'</option>';
            $cant = sizeof($datos);
            for($i=0;$i<$cant;$i++)
             {
                  $f.= '<option value="'.$datos[$i][$this->campo_value].'" ';
                  if ($datos[$i][$this->campo_value] == $this->idSel) $f.='selected="selected"';
                  $f.= '>'.$datos[$i][$this->descNombre];
                  if(! empty($this->descNombre2)) $f.= ' ['.$datos[$i][$this->descNombre2].'] ';
                  $f.='</option>';
             }
            $f.= '</select>';

            return $f;
        }
        return false;
    }


}
 ?>
