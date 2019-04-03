<?php
/*
 Como uso la clase?

 $tabla = new cTabla();

 $tabla->setTitle("Tabla de prueba");
 $tabla->setStriped(true);
 $tabla->setCondensed(false);
 $tabla->setBorder(true);
 $tabla->setHeader(array("col1","col2","col3","col4"));
 $tabla->addRow(array("dato1", "dato2", "dato3", "dato4"));
 $tabla->addRow(array("dato1", "dato2", "dato3", "dato4"));
 $tabla->addRow(array("dato1", "dato2", "dato3", "dato4"));
 $tabla->addRow(array("dato1", "dato2", "dato3", "dato4"));

 echo $tabla->render();

 */
class cTabla
{
    private $cols;
    private $rows;
    private $titulo;
    private $cebra;
    private $bordes;
    private $condensada;
    private $hover;
    private $idBody;
    private $idTabla;
    private $footer;

    public function __construct(){
        $this->cols = array();
        $this->rows = array();
        $this->titulo = "";
        $this->cebra = false;
        $this->bordes = false;
        $this->condensada = false;
        $this->hover = true;
        $this->idBody = "";
        $this->idTabla ="";
        $this->footer="";
    }


    /**
     * configura el header de la tabla, cuenta los elementos y carga la variable cols
     * @param  [array] $elementos [un array de strings que contiene]
     * @return [type]            [description]
     */
    public function setHeader($elementos){
        if(is_array($elementos)){
            $this->cols = $elementos;
            return true;
        }
        return false;
    }

    /**
     * recibe un array de valores para ser agregados como fila
     * @param [type] $row [description]
     */
    public function addRow($row){
        if(is_array($row))
            if(sizeof($row) == $this->countCols()){ //misma cantidad de columnas
                  $this->rows[] = $row;
            }
    }

    /**
     * dibuja la tabla
     * @return [string] [html con la tabla dentro de un div]
     */
    public function render(){
          $html = 'ERROR AL RENDERIZAR TABLA, DATOS INVALIDOS';

          if( $this->countCols() > 0 ){
              $html = '<div class="container">
                        <h2>'.$this->titulo.'</h2>
                        <div class="table-responsive" '.$this->getIdTabla().'>
                            <table class="table '.$this->getTableProp().'">
                                <thead>
                                  <tr>
                                    ';
                                    foreach ($this->cols as $value) {
                                        if( is_array($value) ){
                                            $width = (isset($value["width"]))? ' width="'.$value["width"].'%"': "";
                                            $tit = (isset($value["titulo"]))? $value["titulo"] : "";
                                            $html .= '
                                                    <th'.$width.'>'.$tit.'</th>';
                                        }else{
                                            $html .= '
                                                    <th>'.$value.'</th>';
                                        }
                                    }
              $html .='
                                    </tr>
                                  </thead>';
              $html .= '      <tbody '.$this->getIdBody().'>
                                    ';
                                  $html .= $this->renderBody();

              $html .= '      </tbody>
                              <tfoot>
                                  '.$this->footer.'
                              </tfoot>
                            </table>
                          </div><!-- FIN DE TABLA -->
                        </div><!-- END CONTAINER -->';
          }

          return $html;
    }

    /**
     * solo retorna el contenido del body de la tabla, util para ajax
     *
     * @return [string] html con el codigo del body
     */
    public function renderBody(){
      $html = 'ERROR AL RENDERIZAR TABLA, DATOS INVALIDOS';

          if( $this->countCols() > 0 ){
                $html = "";
                foreach ($this->rows as $x => $row) {
                      $html .= '<tr>';
                            foreach ($row as $col => $value)
                                  $html .='<td class="clsY'.$col.' clsXY'.$x.$col.' clsX'.$x.'">'.$value.'</td>';
                      $html .= '</tr>
                            ';
                }
          }

          return $html;
    }

    /**
     * carga html para el tfoot de la tabla
     *
     */
    public function setFooter($html){
            $this->footer = $html;
    }

    private function getTableProp(){
          $p = ($this->cebra)? " table-striped" : "";
          $p .= ($this->bordes)? " table-bordered": "";
          $p .= ($this->condensada)? " table-condensed" : "";
          $p .= ($this->hover)? " table-hover": "";
          return $p;
    }

    public function setStriped($value){ $this->cebra = $value; }
    public function setBorder($value){ $this->bordes = $value; }
    public function setCondensed($value){ $this->condensada = $value; }
    public function setHover($value){ $this->hover = $value; }
    public function setTitle($str){ $this->titulo = $str; }
    public function countRows(){ return sizeof($this->rows); }
    public function countCols(){ return sizeof($this->cols); }
    public function setIdTabla($d){ $this->idTabla = $d; }
    private function getIdTabla(){ return ($this->idTabla !="")? ' id="'.$this->idTabla.'"' : "" ;}
    public function setIdBody($d){ $this->idBody = $d; }
    private function getIdBody(){ return ($this->idBody !="")? ' id="'.$this->idBody.'"' : "" ;}
}
 ?>
