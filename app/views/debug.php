<?php 

if(isset($_GET['id'])){
	$id = $_GET['id'];
	echo '<div class="clearfix"></div>
			<div class="container">
				<div class="row">
						<h4><strong>El Hash es: '.Encrypt($id).'</strong></h4>
				</div>
			</div>
		';
}else{

	echo 'No se encuentra ID.';
}

?>