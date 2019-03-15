<?php

  /**
   * Escribe lo que le pasen a un archivo de logs
   * @param string $cadena texto a escribir en el log
   * @param string $tipo texto que indica el tipo de mensaje. Los valores normales son Info, Error,
   *                                       Warn Debug, Critical
   */
  function write_log( $mensaje , $tipo="" )
  {
  	$arch = fopen( realpath( '.' )."/".APP_PATH. "logs/log_".date("Y-m-d").".log", "a+");

  	fwrite($arch, "[".date("Y-m-d H:i:s.u")." ] ".$_SERVER['REMOTE_ADDR']." ".$mensaje.
                     " [ ".$tipo." ] \n");
  	fclose($arch);
  }


 ?>
