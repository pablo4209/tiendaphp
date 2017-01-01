<?php
session_destroy();
header("Location: " . BASE_URL . "?accion=index&st=3");
?>