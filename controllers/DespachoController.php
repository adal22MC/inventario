<?php

    
    if( isset($_POST['generarDespacho']) ){

        $datos = $_POST['generarDespacho'];
        echo json_encode(['respuesta'=>$datos[1]['cantidad']]);

    }else{
        echo json_encode(['respuesta'=>'NO']);
    }