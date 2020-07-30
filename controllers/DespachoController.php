<?php

    if( isset($_POST['generarDespacho']) ){

        $json = file_get_contents('php://input'); //  Obtenemos el JSON
        $datos = json_decode($json); // Lo decodificamos

        echo json_encode(['respuesta'=>'OK']);

    }else{
        echo json_encode(['respuesta'=>'NO']);
    }