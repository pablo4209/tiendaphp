<?php
session_start();

//define('BASE_URL', 'http://admin.pablo-intranet.com.ar/'); //ruta base para todo lo que no sea include/require
define('BASE_URL', 'http://localhost/ecom2017/app/admin/'); //ruta base para todo lo que no sea include/require
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_LAYOUT', 'default');
define('PATH_PUBLIC_RELAT', 'public/'); // ruta donde se guardan las carpetas para imagenes del contenido por ejemplo
define('PATH_LAYOUT', BASE_URL . 'view/layout/' . DEFAULT_LAYOUT . '/');
define('PATH_LAYOUT_RELAT', 'view/layout/' . DEFAULT_LAYOUT . '/');
define('DIR_IMG', 'img/');
define('DIR_JS',  'js/');
define('DIR_CSS', 'css/');
define('PATH_IMG', PATH_LAYOUT . DIR_IMG);  // ubicadas en view/layout...
define('PATH_JS',  PATH_LAYOUT . DIR_JS);
define('PATH_CSS', PATH_LAYOUT . DIR_CSS);



define( 'VIEW_PATH', ROOT . 'view' . DS);
define('MODEL_PATH', ROOT . 'model' . DS);
define('CONTR_PATH', ROOT . 'controller' . DS);

define('APP_NAME', '.::Service Intranet::.');
define('APP_SLOGAN', 'desarrollado con php y mvc...');
define('APP_COMPANY', 'www.pablo-intranet.com.ar');

//includes de librerias
define('INC_CONTENT_CSS', '<link href="' . PATH_CSS . 'estilosclases.css" rel="stylesheet" type="text/css" />');

define('INC_PRO_JS', '<script type="text/javascript" src="' . PATH_JS . 'pro_js.js" language="javascript"></script>');
define('INC_JQUERY', '<script type="text/javascript" src="' . PATH_JS . 'jquery.js" language="javascript"></script>');
//tema tronastic: <link type="text/css" href="' . PATH_JS . 'jqueryui/trontastic/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
define('INC_JQUERYUI', '<link type="text/css" href="' . PATH_JS . 'jqueryui/redmond/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />
						<script type="text/javascript" src="' . PATH_JS . 'jqueryui/jquery-ui-1.9.2.custom.min.js" language="javascript"></script>
						<script type="text/javascript" src="' . PATH_JS . 'jqueryui/jquery.ui.datepicker-es.js" language="javascript"></script>');
define('INC_VALIDITY', '<link href="' . PATH_JS . 'validity/jquery.validity.css" rel="stylesheet" type="text/css" />
                        <script type="text/javascript" src="' . PATH_JS . 'validity/jquery.validity.min.js" language="javascript"></script>');
define('INC_TABLESORTER', '<link href="' . PATH_JS . 'tablesorter/css/theme.blue.css" rel="stylesheet" type="text/css" />
                           <script type="text/javascript" src="' . PATH_JS . 'tablesorter/jquery.tablesorter.min.js" language="javascript"></script>
                           <script type="text/javascript" src="' . PATH_JS . 'tablesorter/jquery.tablesorter.widgets.min.js" language="javascript"></script>');

define('INC_TABLESORTER_PARSER_IN_SELECT', '<script type="text/javascript" src="' . PATH_JS . 'tablesorter/parsers/parser-input-select.js" language="javascript"></script>');

define('INC_TABLESORTER_PAGER', '<link href="' . PATH_JS . 'tablesorter/addons/pager/jquery.tablesorter.pager.css" rel="stylesheet" type="text/css" />
                                 <script type="text/javascript" src="' . PATH_JS . 'tablesorter/addons/pager/jquery.tablesorter.pager.min.js" language="javascript"></script>');

define('INC_TABLESORTER_GROUPING', '<script type="text/javascript" src="' . PATH_JS . 'tablesorter/widgets/widget-grouping.js" language="javascript"></script>');


// remoto para digitalstoremerlo.com.ar
//define('DB_NAME', 'pablo_ds');
//define('DB_USER', 'pablo_admin31');
//define('DB_PASS', 'H=#47P92^)lw');
//define('DB_CHAR', 'utf8');


?>
