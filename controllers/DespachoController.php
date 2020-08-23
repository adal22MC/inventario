<?php

    require_once "../models/DespachoModel.php";
    session_start();

    /* ===========================================
        CUANDO UNA BODEGA HIJA GENERA UN DESPACHO
     ============================================= */    
    if( isset($_POST['generarDespacho']) ){

        $datos = $_POST['generarDespacho'];

        $respuesta = DespachoModelo::registrarDespacho($datos, $_SESSION['id_bodega']);

        echo json_encode(['respuesta'=>$respuesta]);

    }
    if( isset($_POST['obtenerUltimoDespacho']) ){
        $orden =  DespachoModelo::obtenerUltimoDespacho();
        echo json_encode($orden);

    }
