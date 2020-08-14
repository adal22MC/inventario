<?php


    $arre[]['id_bodega'] = 213;
    $arre[1]['cant'] = 12;
    $arre[1]['id'] = 001;

    for($i = 1; $i < count($arre); $i++){
        echo $arre[$i]['cant'];
    }


/*
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
    */