<?php

/**
 * @author pablo
 * @copyright 2013
 */

class View
{
    private $title;
    private $incluir;
    
    public function __construct()
    {
        $this->title = APP_NAME;
        $this->incluir = "";
    }
    
    public function titulo($ti="")
    {
        if($ti != "") $this->title = $ti;
    }
    
    public function incluir($in="")
    {
        $this->incluir = $in;
    }
    
    //
    public function renderHeader($menu = "")
    {
                
        $_layoutParams = array(
            'titulo' => $this->title,
            'incluir' => $this->incluir,
            'ruta_css' => PATH_CSS,
            'ruta_img' => PATH_IMG,
            'ruta_js' => PATH_JS,          
            'selMenu' => $menu 
        );
        
        $rutaHeader = VIEW_PATH . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
        
        if(is_readable($rutaHeader)){
            include_once($rutaHeader);             
        } 
        else {
            throw new Exception('Error de vista, Header.');
        }
    }
    
    public function renderFooter()
    {          
        
        $rutaFooter = VIEW_PATH . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        
        if(is_readable($rutaFooter)){            
            include_once($rutaFooter);
        } 
        else {
            throw new Exception('Error de vista, Footer.');
        }
    }
    
    
}

?>