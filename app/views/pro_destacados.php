<?php 
//Destacados
require_once( CONN_MODEL_PATH . "proModel.php");
$db = new Producto();
$pro = $db->getProductos(" WHERE Publicar = 1 AND Habilitado = 1 AND Destacado = 1 ORDER BY tbpro.Vendidas DESC" , " Limit 4 ");

?>
<div class="panel panel-default">
        <div class="panel-body">
            <?php 
                          if(sizeof($pro)){
                            foreach ($pro as $row){ ?>
                            <div class="col-sm-6 col-md-3 col-xs-12 col-lg-4">
                              
                                    <div class="row marketing">
                                            <a href="<?php echo "?accion=details_item&id=".$row["idProducto"] ?>">
                                                <img src="<?php echo IMG_PROD . pathCategoriaProd($row["idProducto"]) . $row["Imagen"]; ?>" alt="<?php echo $row["Nombre"]; ?>" class="img-responsive img-catalogo" >
                                            </a>                                                    
                                            <div class="caption">
                                              <a href="<?php echo "?accion=details_item&id=".$row["idProducto"] ?>">      <h5><?php echo $row["Nombre"]; ?></h5>
                                                    <p>Cod:<?php echo '('.$row["Codigo"].')'; ?></p>
                                              </a>
                                              <p>
                                                <input type="text" name="cant<?php echo $row['idProducto']?>" id="cant<?php echo $row['idProducto']?>" class="form-control soloNumeros input-small " value="1" alt="Cantidad de unidades" size="1"/>
                                                <button class="btn btn-primary add-cart" value="<?php echo $row['idProducto']?>"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true" alt="Agregar el producto al carro"></span></button>                                               
                                              </p>
                                            </div>
                                    </div>
                            </div>                            
                          <?php }
                          }else { ?> 
                                    <div class="alert alert-warning" role="alert">...Sin resultados.</div>

                          <?php }?>     

        </div> <!-- End Product Thumbnail -->   
       
</div>

