<?php

    session_start();

    
    $_SESSION['id_bodegas'][] = [
        "id_bodega" => 1,
        "nombre" => "Nombre de la bodega 1"
    ];

    $_SESSION['id_bodegas'][] = [
        "id_bodega" => 2,
        "nombre" => "Nombre de la bodega 2"
    ];


    
    for($i = 0; $i<count($_SESSION['id_bodegas']); $i++){
        echo $_SESSION['id_bodegas'][$i]['nombre'] . '<br>';
    }
    

    session_destroy();