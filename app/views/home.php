<?php
  require_once(  CONN_MODEL_PATH . "proModel.php" );

$pro= new Producto();

$pro_top = $pro->getProductos(" WHERE Publicar = 1 AND Habilitado = 1 ORDER BY tbpro.Vendidas DESC" , " Limit 10 ");

$pro_dest = $pro->getProductos(" WHERE Publicar = 1 AND Habilitado = 1 AND Destacado = 1 ORDER BY tbpro.Vendidas DESC" , " Limit 10 ");

?>
<!-- Slide Show -->
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>

        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img class="img-responsive center-block" src="http://lorempixel.com/1280/315/" alt="img1">
            <div class="carousel-caption">
              <h3>Title Here 1</h3>
              <p>span span span span span span span span span</p>
            </div>
          </div>
          <div class="item">
            <img class="img-responsive center-block" src="http://lorempixel.com/1280/315/sports/" alt="img2">
            <div class="carousel-caption">
              <h3>Title Here 2</h3>
              <p>span span span span span span span span span</p>
            </div>
          </div>

        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    <div class="clearfix" style="margin-bottom:20px;"></div>

    <div class="container">
    <!-- End Slide Show -->
      <div class="row marketing">
          <?php foreach ($pro_dest as $row){ ?>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <img src="<?php echo IMG ?>thumb155.png" alt="marketing01" class="img-thumbnail">
              <h5><?php echo $row["Nombre"]; ?></h5>
              <p>span span span span span span span span span span span span span span span span</p>
              <a href="#" class="btn btn-default">Details...</a>
            </div>
          <?php }?>
      </div>
    <!-- Marketing -->
    <hr class="divider">
    <!-- Product Thumbnail -->
      <div class="row">
      <?php foreach ($pro_top as $row){ ?>
        <div class="col-sm-6 col-md-3 col-xs-12 col-lg-2">
          <div class="thumbnail">
            <img src="<?php echo IMG ?>thumb155.png" alt="thumb01" >
            <div class="caption">
              <h5><?php echo $row["Nombre"]; ?></h5>
              <p>Cod:<?php echo $row["Codigo"]; ?></p>
              <p><a href="#" class="btn btn-primary" role="button">Comprar</a> <a href="<?php echo "?accion=details_item"?>" class="btn btn-default" role="button">..ver</a></p>
            </div>
          </div>
        </div>
      <?php }?>

      </div>
    <!-- End Product Thumbnail -->
