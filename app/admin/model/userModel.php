<?php
class  User extends Conectar
{

    private $u;

    public function __construct()
    {
        parent::__construct();
        $this->u=array();
    }



    public function logueo()
    {
        $sql="select idUsuario, Login, NivelAcceso, Estado from tbusuarios
            where
            Login= ?
            and
            Pass= ?;";

        $pass=self::Encrypt($_POST["pass"]);
        $stmt=$this->dbh->prepare($sql);

        if($stmt->execute(array($_POST["login"],$pass)))
        {
            if($stmt->rowCount())
            {
               if($reg = $stmt->fetch())
                {
                    if($reg["Estado"]==1)
                    {
                        $_SESSION["user_id"]=$reg["idUsuario"];
                        $_SESSION["user_login"]=$reg["Login"];
                        $_SESSION["NivelAcceso"]=$reg["NivelAcceso"];
                        header("Location: ".BASE_URL."?accion=home");
                    }
                    else
                    {
                        header("Location: ".BASE_URL."?accion=index&st=4");exit;
                    }
                }
            }else
            {
                header("Location: ".BASE_URL."?accion=index&st=1");exit;
            }
            $this->dbh=null;
        }

    }
    //Busca usuario segun login o email y retorna un array
    //recibe estas variables form = 'user=' + user + '&pass=' + pass + '&sesion=' + sesion;
    public function loginweb(){ //para el frontend
        try{
            if( !empty($_POST['user']) AND !empty($_POST['pass']) ){

                        $sql="select idUsuario, Nombre, Login, Email, NivelAcceso, Estado from tbusuarios
                        where
                        (login= ? OR email= ?)
                        AND
                        Pass= ? LIMIT 1;";

                        $pass=self::Encrypt($_POST["pass"]);

                        $stmt=$this->dbh->prepare($sql);

                        $stmt->execute(array($_POST["user"], $_POST["user"],$pass));

                         if($reg = $stmt->fetch()) //hay resultado?
                          {
                              return  $reg;

                          } else return null;

            }else{
                throw new Exception('Error: Datos Vacios.');
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function close(){
        parent::__destruct();

    }
    private function Encrypt($string) {
      $long = strlen($string);
      $str = '';
      for($x = 0; $x < $long; $x++) {
        $str .= ($x % 2) != 0 ? md5($string[$x]) : $x;
      }
      return md5($str);
    }

    public function existeUsuario($login="", $email="")
    {
        $sql="select idUsuario, Nombre, Login, Email, NivelAcceso, Estado from tbusuarios
        where
        login= ? OR email= ? LIMIT 1;";

        $stmt=$this->dbh->prepare($sql);
        $stmt->execute(array($login, $email));

        if($reg = $stmt->fetch()) //hay resultado?
         {
             return  $reg;

         } else return null;

    }


    public function registrar(){

    }

    public function recuperar(){


    }

    public function get_usuarios()
    {
        $sql="select idUsuario, Nombre, Login, Email, Pass, Estado from tbusuarios order by Nombre asc;";
        return parent::getRows($sql);
    }

    public function get_usuarios_por_id($id)
    {
        $sql="select idUsuario, Nombre, Login, Email, Pass, NivelAcceso, Dom, Loc, Cp, Prov, Dni, Tel, Tel2,
              FechaNacimiento, Sexo, FechaAlta, HoraAlta, FechaMod, HoraMod, Estado, Observaciones,
              AvisoEmergente from tbusuarios where idUsuario=? LIMIT 1";

        return parent::getRowId($sql, $id);
    }




    public function add()
    {
        //print_r($_POST);exit;

        if(empty($_POST["nom"]) or empty($_POST["correo"]) or empty($_POST["login"]) or empty($_POST["pass"])
            or  Conectar::valida_correo($_POST["correo"])==false)
        {
            header("Location:".BASE_URL."index.php?accion=user-add&st=1");exit;
        }

        $sql="INSERT INTO tbusuarios ( idUsuario , Nombre , Login ,
            Email , Pass , NivelAcceso , Dom , Loc , Cp , Prov ,
            Dni , Tel , Tel2 , FechaNacimiento , Sexo , FechaAlta ,
            HoraAlta , FechaMod , HoraMod , Estado , Observaciones , AvisoEmergente, KeyReg )
            VALUES (
            NULL ,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ? , ? , NOW( ) , NOW( ) , NULL , NULL ,  ?, ?, ?, ? )";

        //concatenar la fecha en formato mysql
        $f = $_POST['anio']."-".$_POST['mes']."-".$_POST['dia'];
        $pass=self::Encrypt($_POST["pass"]);
        $estado=(isset($_POST["estado"]))? $_POST["estado"]:0;
        $nivel = (isset($_POST["NivelAcceso"]))? $_POST["NivelAcceso"]:0;
        $keyreg = (isset($_POST["keyreg"]))? $_POST["keyreg"]:"";

        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1,$_POST["nom"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["login"],PDO::PARAM_STR);
        $stmt->bindValue(3,$_POST["correo"],PDO::PARAM_STR);
        $stmt->bindValue(4,$pass,PDO::PARAM_STR);
        $stmt->bindValue(5,$nivel,PDO::PARAM_INT);
        $stmt->bindValue(6,$_POST["dom"],PDO::PARAM_STR);
        $stmt->bindValue(7,$_POST["loc"],PDO::PARAM_STR);
        $stmt->bindValue(8,$_POST["cp"],PDO::PARAM_STR);
        $stmt->bindValue(9,$_POST["prov"],PDO::PARAM_STR);
        $stmt->bindValue(10,$_POST["dni"],PDO::PARAM_STR);
        $stmt->bindValue(11,$_POST["tel"],PDO::PARAM_STR);
        $stmt->bindValue(12,$_POST["tel2"],PDO::PARAM_STR);
        $stmt->bindValue(13,$f,PDO::PARAM_STR);
        $stmt->bindValue(14,$_POST["sexo"],PDO::PARAM_STR);
        $stmt->bindValue(15,$estado,PDO::PARAM_INT);
        $stmt->bindValue(16,$_POST["observaciones"],PDO::PARAM_STR);
        $stmt->bindValue(17,$_POST["avisoemergente"],PDO::PARAM_STR);
        $stmt->bindValue(18,$keyreg,PDO::PARAM_STR);

        $res = $stmt->execute();

        if($res)
        {
            header("Location:".BASE_URL."index.php?accion=user-add&st=2&id=".$this->dbh->lastInsertId());exit;
        }else{
            //print_r($stmt->errorInfo());
            header("Location:".BASE_URL."index.php?accion=user-add&st=3");exit;
        }
        $this->dbh=null;

    }


    public function edit()
    {
        if(empty($_POST["nom"]) or empty($_POST["correo"]) or empty($_POST["login"]) or empty($_POST["pass"]) or Conectar::valida_correo($_POST["correo"])==false)
        {
            header("Location:".BASE_URL."index.php?accion=user-edit&id=".$_POST["id"]."&st=1");exit;
        }

        $sql="update tbusuarios
              set
              Nombre=?, Login=?, Email=?, Pass=?, NivelAcceso=?, Dom=?, Loc=?, Cp=?, Prov=?, Dni=?, Tel=?, Tel2=?,
              FechaNacimiento=?, Sexo=?, FechaMod=NOW(), HoraMod=NOW(), Estado=?, Observaciones=?,
              AvisoEmergente=?
              where
              idUsuario=?";

        //concatenar la fecha en formato mysql
        $f = $_POST['anio']."-".$_POST['mes']."-".$_POST['dia'];
        $pass=self::Encrypt($_POST["pass"]);
        $estado=(isset($_POST["estado"]))? $_POST["estado"]:0;
        $nivel = (isset($_POST["NivelAcceso"]))? $_POST["NivelAcceso"]:0;

        $stmt=$this->dbh->prepare($sql);

        $stmt->bindValue(1,$_POST["nom"],PDO::PARAM_STR);
        $stmt->bindValue(2,$_POST["login"],PDO::PARAM_STR);
        $stmt->bindValue(3,$_POST["correo"],PDO::PARAM_STR);
        $stmt->bindValue(4,$_POST["pass"],PDO::PARAM_STR);
        $stmt->bindValue(5,$nivel,PDO::PARAM_INT);
        $stmt->bindValue(6,$_POST["dom"],PDO::PARAM_STR);
        $stmt->bindValue(7,$_POST["loc"],PDO::PARAM_STR);
        $stmt->bindValue(8,$_POST["cp"],PDO::PARAM_STR);
        $stmt->bindValue(9,$_POST["prov"],PDO::PARAM_STR);
        $stmt->bindValue(10,$_POST["dni"],PDO::PARAM_STR);
        $stmt->bindValue(11,$_POST["tel"],PDO::PARAM_STR);
        $stmt->bindValue(12,$_POST["tel2"],PDO::PARAM_STR);
        $stmt->bindValue(13,$f,PDO::PARAM_STR);
        $stmt->bindValue(14,$_POST["sexo"],PDO::PARAM_STR);
        $stmt->bindValue(15,$estado,PDO::PARAM_INT);
        $stmt->bindValue(16,$_POST["observaciones"],PDO::PARAM_STR);
        $stmt->bindValue(17,$_POST["avisoemergente"],PDO::PARAM_STR);
        $stmt->bindValue(18,$_POST["id"],PDO::PARAM_INT);

        if($stmt->execute())
        {
            header("Location:".BASE_URL."?accion=user-edit&id=".$_POST["id"]."&st=2");
        }else
        {
           header("Location:".BASE_URL."?accion=user-edit&id=".$_POST["id"]."&st=3");
        }

        $this->dbh=null;
    }

    public function delete()
    {
        //primero es necesario checkear la integridad referencial


            $sql="delete from tbusuarios where idUsuario=?";

    		$stmt=$this->dbh->prepare($sql);

            $id=$_GET["id"];
            $stmt->bindValue(1,$id,PDO::PARAM_INT);


    		if($stmt->execute())
            {
                header("Location: ".BASE_URL."?accion=user&st=2");
            }else
            {
                header("Location: ".BASE_URL."?accion=user&st=1");
            }
            $this->dbh=null;
    }
}
?>
