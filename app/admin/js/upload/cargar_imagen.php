<?php 
//  el script requiere:
    //carpeta del script
    $path_script = PATH_JS . "upload/";
    //carpeta temporal
    $destino_temp = $path_script . "temp/";
    //carpeta destino de la imagen
    $destino = PATH_IMG . "public/";
    //control destino de la imagen
    $idcontrol = "imgImagen";



?> 
<div class="modal fade" tabindex="-1" id="divCargarImg" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Subir imagen</h3>            
      </div>
      <div class="modal-body">
            <form enctype="multipart/form-data" class="formulario">               
                <input type="hidden" name="destino_temp" id="destino_temp" value="<?php echo $destino_temp;?>" />
                <input type="hidden" name="path" id="path" value="<?php echo $destino;?>" />                
                <table width="100%" class="table">
                    <tr>
                        <td width="5%"></td>
                        <td width="20%">Carpeta destino:</td>
                        <td width="75%"><?php echo $destino;?></td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">1</span></td>
                        <td>Seleccionar Imagen:</td>
                        <td><input name="archivo" class="form-control" type="file" id="imagen" />
                        <div class="showImage img-thumbnail"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">2</span></td>
                        <td>Subir al servidor:</td>
                        <td><input type="button" class="btn btn-success" value="Subir imagen" id="upimg"/></td>
                    </tr>
                </table>       
            </form>    
            <input type="hidden" name="controldestino" id="controldestino" value="<?php echo $idcontrol;?>"/>
            <input type="hidden" name="nombre_img" id="nombre_img"/>            
            <div class="messages"></div>                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" disabled="disabled"  id="aplicar" class="btn btn-primary">Aplicar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript" src="<?php echo $path_script .'cargar_imagen.js';?>"></script>