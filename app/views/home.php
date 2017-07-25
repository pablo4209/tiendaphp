<div class="container-fluid" id="wrapper">
    

    <div class="clearfix" style="margin-bottom:20px;"></div>
    <div class="container-fluid"><!-- contenedor -->        
      
        <div id="row_contenido" class="row"><!-- ROW CONTENIDO -->

              <div class="col-sm-4 col-md-3 col-xs-12 col-lg-3" style="padding-bottom: 100%;margin-bottom: -100%;" ><!-- COL SIDEBAR -->
                  <?php require_once("sidebar.php"); ?>  
              </div><!-- END COL SIDEBAR -->    
        
                            
              <?php //require_once("slide.php"); ?>
              
              
              <div class="col-md-9 col-sm-8 col-xs-12" style="float:right;"> <!-- CONTENIDO -->
                   
                <div id="_AJAX_CART_"></div>                 
                <?php include( "pro_destacados.php"); ?>            

              </div><!-- END CONTENIDO -->

        </div><!-- END ROW CONTENIDO -->

      </div><!-- end contenedor -->
  </div>
   <script src="<?php echo JS ?>cart.js"></script>