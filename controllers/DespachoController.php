<?php

    require_once "../models/DespachoModel.php";
    session_start();

    /* ===========================================
        CUANDO UNA BODEGA HIJA GENERA UN DESPACHO
     ============================================= */    
    if( isset($_POST['generarDespacho']) ){

        $datos = $_POST['generarDespacho'];

        DespachoModelo::registrarDespacho($datos, $_SESSION['id_bodega']);

        echo json_encode(['respuesta'=>'OK']);

    }
