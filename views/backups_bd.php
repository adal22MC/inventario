<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

if(!($_SESSION['tipo_usuario'] == "Administrador")){
    header('Location: login.php');
}

require_once "../controllers/conexionController.php";
$con = new conexionController();
$con->crearBackups();

?>


