<?php

require_once( MODEL_PATH . "docRenderModel.php");

$render = new DocRender();
$html = $render->render_add();


$vista = new View();
$vista->incluir( INC_CONTENT_CSS .
								 '<link href="css/tabla_selec.css" rel="stylesheet" type="text/css" />' .
								 INC_JQUERYUI .
								 INC_VALIDATE . INC_VALIDATE_REGLAS .
								 '<script type="text/javascript" src="' . PATH_JS . 'doc-mod.js" language="javascript"></script>'
							 );
$vista->renderHeader("doc");
//require_once( VIEW_PATH . 'doc-add.phtml' );
echo $html;
require_once( VIEW_PATH . 'buscar-prod.php' );

$vista->renderFooter();

?>
