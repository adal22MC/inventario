<?php

    require_once "../models/DespachoModel.php";

    /* ===========================================
        CUANDO UNA BODEGA HIJA GENERA UN DESPACHO
     ============================================= */    
    if( isset($_POST['generarDespacho']) ){

        $datos = $_POST['generarDespacho'];

        DespachoModelo::registrarDespacho($datos);

        echo json_encode(['respuesta'=>'OK']);

    }else{
        echo json_encode(['respuesta'=>'NO']);
    }
