<?php
unset($_SESSION['admin_id'], $_SESSION['admin_login'], $_SESSION['admin_nombre'], $_SESSION['NivelAcceso']);
session_destroy();
header("Location: ?accion=index&st=3");
?>