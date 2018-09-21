<?php

/**
 * @author pablo
 * @copyright 2013
 */


class Conectar
{
    protected $dbh;
    protected $p;

    function __construct()
    {       try
            {
                $this->dbh=new PDO('mysql:host=' . DB_HOST .
                                   ';dbname=' . DB_NAME,
                                   DB_USER,
                                   DB_PASS,
                                   array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . DB_CHAR)
								                  );
                if( DEBUG ){
                    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                }else
                    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);


            }
            catch (PDOException $e) {
                write_log( "Error estableciendo conexion: " , $e->getMessage() );
                print '<div class="alert alert-danger" role="alert">Mensaje:  '. $e->getMessage() . '</div>';
                //die();
            }

            $this->p=array();
    }

    protected function ClearArray()
    {
        unset($this->p);
        $this->p=array();
    }

    function __destruct()
    {
        $this->dbh = null;
        $this->p = null;
    }

    public function getConn(){
        return $this->dbh;
    }

    //La funcion devuelve un Array de dos dimensiones, como fetch_assocc, recibe como parametro la consulta select lista para ejecutarse
    protected function getRows($sql)
    {
      try{
          self::ClearArray();
          foreach($this->dbh->query($sql) as $row) //query retorna una fila asociada con los nombres de los campos
          {                                         //retorna false y hay error
              $this->p[]=$row;
          }

          self::debugSQL( $sql );
          return $this->p;

        }catch(PDOException $e) {
                write_log( "database::getRows() :" , $e->getMessage() );
                return null;
                //die();
        }
    }

    protected function debugSQL( $param ){
        $info="";
        $sql="";
        if( DEBUG ){
            if( is_string($param) ){
                $sql = htmlspecialchars( $param );
                $info = '<div class="row"><div class="col-md-10"><div class="alert alert-danger" role="alert">'.$sql.'</div></div></div>';
            }elseif( is_a( $param, 'PDOStatement' ) ){

              ob_start();   //debugDumpParams no retorna nada, sino q visualiza, esta parte captura la visualizacion a un string
              $param->debugDumpParams();
              $r = ob_get_contents();
              ob_end_clean();

              $sql = htmlspecialchars( $r );
              $info = '<div class="row"><div class="col-md-10"><div class="alert alert-danger" role="alert">'.$sql.'</div></div></div>';
            }
            if( $sql != "" && LOG_SQL ) write_log( "Valores DEBUG:  " , $sql );

            if( !empty($_POST) )
                    $info .= '<div class="row"><div class="col-md-10"><div class="alert alert-warning" role="alert">'.var_export( $_POST , true ).'</div></div></div>';

            $_SESSION['infoSQL'] = $info; //se guarda en variable de sesion

        }else if( isset( $_SESSION['infoSQL'] ) )
                    unset( $_SESSION['infoSQL'] );
    }


    public function close(){
      $this->dbh = null;
      $this->p = null;
    }

    protected function getRowsJson($sql)
    {
        self::ClearArray();
        $stmt=$this->dbh->prepare($sql);
            if($stmt->execute(  ) )
            {
                self::debugSQL( $sql );
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) //resultado asociado solo a nombres de campos
                {
                    $this->p[]=$row;
                }
                $stmt->closeCursor();
                return $this->p;
            }else
            {
                return false;
            }

    }


    //devuelve un array de dos dimensiones con una sola fila,
    //recibe la consulta sql con el parametro = ?, id=identificador es un String (acepta varios valores a reemplazar en sql si estan separados por comas)
    // para acceder echo $dato[0]["id"];
    public function getRowId($sql, $id)
    {
        try{

            self::ClearArray();
            $stmt=$this->dbh->prepare($sql);

            if( is_array($id) ){
                $stmt->execute( $id );
            }else {
                $stmt->execute( array($id) );
            }

            self::debugSQL( $stmt );

            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $this->p[]=$row;
            }
            $stmt->closeCursor();
            return $this->p;

        }catch(PDOException $e) {
                write_log( "database::getRowId: " , $e->getMessage() );
                return null;
                //die();
        }
    }



    /*
    *   ejecutar consulta preparada y retorna true o false
    */
    protected function exePrepare($consulta){
        try{
            $r = $consulta->execute();
            self::debugSQL( $consulta ); //esto es un prepare
            $consulta->closeCursor();
            if($r)
                return true;
            else
                return false;
        }catch(PDOException $e) {
                write_log( "Error en exePrepare: " , $e->getMessage() );
                return false;
        }
    }

    //
    //recibe una consulta preparada, la ejecutada y retorna un array assocc con los resultados obtenidos
    //
    protected function exePrepare_FetchAssoc( $consulta ){

      try{
          self::ClearArray();
          if( $consulta->execute() )
            {
                self::debugSQL( $consulta );
                while($row = $consulta->fetch(PDO::FETCH_ASSOC)) //resultado asociado solo a nombres de campos
                {
                    $this->p[]=$row;
                }
                $consulta->closeCursor();
                return $this->p;
            }else
            {
                return false;
            }
        }catch(PDOException $e) {
                write_log( "Error en exePrepare_FetchAssoc: " , $e->getMessage() );
                return false;
        }

    }

	//***********************************************************
	//recibe una cadena que incluye numeros y le incrementa una unidad
	//ej: recibe AAA0000 >>>>> devuelve AAA0001
	public static function sumarUno($cadena, $iniciales="3")
	{
		if($cadena =="") return "";

		if($iniciales =="3")
			$cantIniciales = 3;
		else
			$cantIniciales = strlen($iniciales);

		$strLetra = substr( trim($cadena) , 0, $cantIniciales ); //3 es el numero de letras que tiene el codigo
		$strNumero = substr( trim($cadena) , $cantIniciales, strlen($cadena) - $cantIniciales ); //y en numero el resto
		$i = strlen($strNumero); //Cantidad de digitos
		$strNumero = (int)$strNumero + 1; //sumamos 1
		$strNumero = str_pad ((string)$strNumero, $i, "0",STR_PAD_LEFT); //rellenar hasta la longitud $i con ceros
		return trim($strLetra . $strNumero);
	}

    //*******************************************************************************************************************************************************
    //
    //
 //fecha sql recibe una fecha en formato "dd/mm/aaaa" y lo transforma a formato mysql "#mm/dd/aaaa#"
 public static function fechaMysql($fecha = ""){
    list($dia,$mes,$ano)=explode("/",$fecha);
    if($dia != "" AND $mes != "" AND $ano !="")
        {return "'$ano-$mes-$dia'";     }
    else {
        return "";
    }
 }


//funci�n para la fecha
public static function fecha(){
  	$dia=date("w");
  	$day=date("d");
  	$mes=date("m");
    switch ($dia) {
    	case 0:
       	$dia ="Domingo";
    	break;

      case 1:
      $dia = "Lunes";
    	break;
    	case 2:
      $dia ="Martes";

              break;

      case 3:
      $dia ="Mi�rcoles";

              break;
      case 4:
      	$dia ="Jueves";
        break;
      case 5:
      $dia ="Viernes";
    	break;
      case 6:
      $dia ="S�bado";
    	break;

    }
    switch ($mes){
    	case '01':
    	$mes="Enero";
    	break;
    	case '02':
    	$mes="Febrero";
    	break;
    	case '03':
    	$mes="Marzo";
    	break;
    	case '04':
    	$mes="Abril";
    	break;
    	case '05':
    	$mes="Mayo";
    	break;
    	case '06':
    	$mes="Junio";
    	break;
    	case '07':
    	$mes="Julio";
    	break;
    	case '08':
    	$mes="Agosto";
    	break;
    	case '09':
    	$mes="Septiembre";
    	break;
    	case '10':
    	$mes="Octubre";
    	break;
    	case '11':
    	$mes="Noviembre";
    	break;
    	case '12':
    	$mes="Diciembre";
    	break;
    }
    $fecha="$dia ".$day." de ".$mes." de ".date("Y");
    return $fecha;
}
	public static function valida_correo($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminaci?n del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return true;
    else
       return false;
}
    public static function crear_selects_fecha($dia="",$mes="",$anio="")
    {
        $f="";
		//dias
        $f.= '<select name="dia" class="select input">
                <option value="0" ';
        if ($dia=="") $f.='selected="selected"';
        $f.= '>-</option>';
    	   for($i=1;$i<32;$i++)
    	   {
    		  $f.= '<option value="'.$i.'" ';
              if ($i == $dia) $f.='selected="selected"';
              $f.= '>'.$i.'</option>';

    	   }
        $f.= '</select> / ';

        //meses
        $f.= '<select name="mes" class="select input">
                <option value="0" ';
        if ($mes=="") $f.='selected="selected"';
        $f.= '>-</option>';
    	   for($i=1;$i<13;$i++)
    	   {
    		  $f.= '<option value="'.$i.'" ';
              if ($i == $mes) $f.='selected="selected"';
              $f.= '>'.$i.'</option>';

    	   }
        $f.= '</select> / ';

        //a�os
        $f.= '<select name="anio" class="select input">
                <option value="0" ';
        if ($anio=="") $f.='selected="selected"';
        $f.= '>-</option>';
    	   for($i=date("Y");$i>=1930;$i--)
    	   {
    	       $f.= '<option value="'.$i.'" ';
               if ($i == $anio) $f.='selected="selected"';
               $f.= '>'.$i.'</option>';
    	   }
        $f.= '</select>';

        return $f;
    }

    //Genera un select html con nombre e id, si $sel tiene valor lo selecciona, sino imprime seleccionar opcion con val=0
    /*  id: el select toma el name e id con este valor, el valor del campo id es el value del select
        desc: el campo descripcion de la Tabla
        sel: id seleccionado por defecto
        desc2: valor de un campo que se quiera poner como acotacion (ej: dolar [3.40] )
        where: filtro de la $consulta
        cssClass: tiene las clases de control bootstrap por defecto y lo tilda como requerido para validate, cambiar el valor reemplaza el default

    */
    protected function crearSelectTabla($tabla, $id, $desc, $sel="", $desc2="", $where = "", $cssClass=" input-medium required", $toolTip = "Debes seleccionar un elemento." )
    {
        $f=""; //se inicializan para evitar warnings
		if(empty($tabla) or empty($id) or empty($desc))
        {
            return "Error al generar Select de Tabla ".$tabla ;
        }

        $sql = "Select * From ".$tabla." ".$where;

		    $datos = self::getRows($sql);

        if($datos)
        {
            //dias
            $f.= '<select name="'.$id.'" id="'.$id.'" min="1" title="'.$toolTip.'" class="form-control '.$cssClass.'">
                    <option value="0" ';
            if ($sel=="") $f.='selected="selected"';
            $f.= '>Seleccionar</option>';
		    $cant = sizeof($datos);
			   for($i=0;$i<$cant;$i++)
        	   {
        		  $f.= '<option value="'.$datos[$i][$id].'" ';
                  if ($datos[$i][$id] == $sel) $f.='selected="selected"';
                  $f.= '>'.$datos[$i][$desc];
				  if(! empty($desc2)) $f.= ' ['.$datos[$i][$desc2].'] ';
				  $f.='</option>';

        	   }
            $f.= '</select>';

            return $f;

        }
    }


}

?>
