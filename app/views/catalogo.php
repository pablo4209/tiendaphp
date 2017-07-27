<?php
  
if( isset( $_POST['input-search'] ) && $_POST['input-search'] !="" ){
    
    require_once( CONN_MODEL_PATH . "proModel.php");
    $db = new Producto();  
    
    $pro = $db->getProductosBuscar( $_POST['input-search'] );   
    $resultados = count($pro);

}else{

  if( isset($_GET['cat']) && $_GET['cat']!= "" ){
        $idCategoria = $_GET['cat'];
  }else $idCategoria =0;

  require_once( CONN_MODEL_PATH . "proCatModel.php");
  $db = new proCategorias();
    
   $resultados = $db->getProductosCatCount( $idCategoria ); 
   $pro = $db->getProductosCat( $idCategoria , $pagina , PRO_POR_PAGINA );   

}

  $pagina = 0;
  if( isset($_GET['pagina']) ){
    $pagina = $_GET['pagina'];
  }

 $cant_pag = 0;
 if($resultados > PRO_POR_PAGINA){
    $cant_pag = ceil( $resultados / PRO_POR_PAGINA ); 
 }

?>

  <div class="clearfix" style="margin-bottom:20px;"></div>
    
    <div class="container-fluid"><!-- contenedor -->        
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <?php echo getRuta($idCategoria, "catalogo"); ?> 
        </div>
      </div>
      <div class="row"><!-- ROW SIDEBAR -->

            <div class="col-sm-4 col-md-3 col-xs-12 col-lg-3" ><!-- COL SIDEBAR -->
                <?php require_once("sidebar.php"); ?>  
            </div><!-- END COL SIDEBAR -->    
              
            <div class="col-md-9 col-sm-8 col-xs-12">              
                 
                 
              <div id="_AJAX_CART_"></div> 
              <div class="panel panel-default">
                 <div class="panel-body">
                          <?php  
                          if($_POST) echo '<div class="alert alert-warning" role="alert">'.$resultados.'   resultado/s para "'.$_POST['input-search'].'"</div>';
                          if( $resultados ){
                            foreach ($pro as $row){ ?>
                            <div class="col-sm-6 col-md-3 col-xs-12 col-lg-3">
                              
                                    <div class="row marketing">
                                            <a href="<?php echo "?accion=details_item&id=".$row["idProducto"] ?>">
                                                <img src="<?php echo IMG_PROD . pathCategoriaProd($row["idProducto"]) . $row["Imagen"]; ?>" alt="<?php echo $row["Nombre"]; ?>" class="img-responsive img-catalogo" >
                                                <span class="label label-success precio-catalogo">$ <?php echo $row["Precio"]; ?></span>   
                                            </a>                                                    
                                            <div class="caption">
                                              <div class="row">
                                                    <a href="<?php echo "?accion=details_item&id=".$row["idProducto"] ?>">      <strong><?php echo $row["Nombre"]; ?></strong></br><span class="marketing-codigo"><?php echo $row["Codigo"]; ?></span>                                  
                                                    </a>                                         
                                              </div><!-- END ROW -->                                                  
                                              <div class="row">                                                
                                                <div class="col-xs-3 col-md-4 col-md-offset-3">
                                                    <div class="input-group">
                                                      <span class="input-group-btn">
                                                        <input type="text" name="cant<?php echo $row['idProducto']?>" id="cant<?php echo $row['idProducto']?>" class="form-control soloNumeros" value="1" min="1" max="20" alt="Cantidad de unidades" size="2"/>                                             
                                                        <button class="btn btn-primary add-cart" value="<?php echo $row['idProducto']?>"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true" alt="Agregar el producto al carro"></span></button>
                                                      </span>
                                                    </div>
                                                </div>
                                                <!--<div class="col-md-12"><span class="label label-info">Stock</span></div>-->
                                              </div><!-- END ROW -->
                                            </div><!-- END CAPTION -->
                                    </div><!-- END ROW MARKETING -->
                            </div> <!-- END COL -->                           
                          <?php }
                          }else if(!$_POST){ ?> 
                                    <div class="alert alert-warning" role="alert">...Sin resultados</div>
                          <?php }?>
                </div><!-- END PANEL BODY -->
              </div><!-- END PANEL -->
           
            <div class="row">
              <div class="col-md-5 col-xs-12 col-md-offset-3">
                
                 <?php 
                if($cant_pag)
                { 
                ?>
                <nav class="text-center" aria-label="Page navigation">
                  <ul class="pagination">
                    <li>
                      <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <?php for($i=0;$i<$cant_pag;$i++){                        
                        
                        if($i == $pagina){
                          $li = '<li class="active"><a href="#">'; 
                        }else{
                          $li = '<li><a href="'.BASE_URL.'?accion=catalogo&cat='.$idCategoria.'&pagina='.$i .'">';
                        }
                       
                        echo $li . ($i+1) . '</a></li>';;
                    } ?>
                    <li>
                      <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>             
                </nav>     
                <?php
                } ?>
              </div><!-- end col paginador -->
              <div class="col-md-4 col-xs-12">
                <nav class="text-right" style="margin-top: 20px;"><strong>Resultados: </strong> 
                    <?php echo $resultados;
                          echo ($cant_pag)? ', página '.($pagina+1).' de '.$cant_pag : ''; ?></nav>
              </div><!-- end col resultados -->
            </div><!-- end row paginacion -->
            
            </div> <!-- End COL col-md-9 col-sm-8 col-xs-12-->


      </div><!-- END ROW SIDEBAR -->
  </div><!-- end contenedor -->
</div>
<script src="<?php echo JS ?>cart.js"></script>