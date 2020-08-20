<?php

    require_once "../models/conexion.php";
    session_start();

    if(isset($_POST['backups'])){
        if($_SESSION['tipo_usuario'] == "Administrador"){
            $conexion = new Conexion();
            $backups = $conexion->backup_tables();
            echo json_encode($backups);
        }else{
            echo json_encode(['respuesta'=>$backups]);
        }
    }

    if(isset($_POST['backups_remove'])){
        $conexion = new Conexion();
        $r = $conexion->backup_remove($_POST['ruta']);
        echo json_encode(['respuesta'=>$r]);
    }