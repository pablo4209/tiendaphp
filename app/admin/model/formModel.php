<?php 

class Formulario extends Conectar {

	private $u;
	protected $titulo;
	protected $html_post_titulo;
	protected $html_dentro_form;	
	protected $form_nombre ;
	protected $controles ;


	public function __construct()
    {
        parent::__construct();
        $this->u=array();
        $this->titulo = "formulario";        
        $this->form_nombre = "Form";
        $this->controles = array();
        $this->html_pre_form = "";
        $this->html_dentro_form = "";
        $this->html_post_form = "";
    }

    //
    public function setControles( $a ){
    	$this->controles = $a;
    }

    public function setTitulo( $t ){
    	$this->titulo = $t;
    }
    public function setNombre( $t ){
    	$this->form_nombre = $t;
    }
    public function setHtmlPreForm( $t ){
    	$this->html_pre_form = $t;
    }
    public function setHtmlDentroForm( $t ){
    	$this->html_dentro_form = $t;
    }
    public function setHtmlPostForm( $t ){
    	$this->html_post_form = $t;
    }

    public function render(){
    	
    	echo '<div class="modal fade" id="panel_edit" role="dialog"  aria-hidden="true">
	    		<div class="modal-content modal-lg">
		    		<div class="modal-header">	    		
		    			<h4 class="modal-title">'.$this->titulo.'</h4>
		    			<button type="button" class="close" data-dismiss="modal">&times;</button>        		
		    			'.$this->html_pre_form.'
		    		</div>
	    			<div class="modal-body">
	    				<form action="" method="POST" name="'.$this->form_nombre.'" id="'.$this->form_nombre.'">  
			    		'.$this->html_dentro_form.' 
			    		</form>
	    			</div>
	    			<div class="modal-footer">
	    			'.$this->html_post_form.'
	    			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    			</div>
	    		
	    		</div>
    		</div>';

    }

}

 ?>