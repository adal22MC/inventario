<?php

    require_once "../models/BodegaModel.php";

    /* ===========================
        AGREGAR BODEGA
     =============================*/
    if( isset($_POST['agregarBodega']) ){
        
        if(

            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['nomBodega']) &&
            preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}+$/', $_POST['correoBodega']) &&
            preg_match('/^[()\-0-9 ]+$/', $_POST['numBodega']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,_]+$/', $_POST['userBodega']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,_]+$/', $_POST['passBodega'])

        ){

            $bodega = array(
                "nombre" => $_POST['nomBodega'],
                "correo" => $_POST['correoBodega'],
                "tel" => $_POST['numBodega'],
                "usuario" => $_POST['userBodega'],
                "pass" => $_POST['passBodega']
            );

            

            $respuesta = BodegaModelo::agregarMaterial($bodega);
            echo json_encode(['respuesta'=>$respuesta]);

        }else{
            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }
        
    }

    /* ==============================
        EDITAR MATERIAL MATERIAL
     ===============================*/
    if( isset($_POST['editarBodega']) ){
        if(
            preg_match('/^[()\-0-9 ]+$/', $_POST['idBodega']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['nomBodega']) &&
            preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}+$/', $_POST['correoBodega']) &&
            preg_match('/^[()\-0-9 ]+$/', $_POST['numBodega']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,_]+$/', $_POST['userBodega']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,_]+$/', $_POST['passBodega'])

        ){

            $bodega = array(
                "id" => $_POST['idBodega'],
                "nombre" => $_POST['nomBodega'],
                "correo" => $_POST['correoBodega'],
                "tel" => $_POST['numBodega'],
                "usuario" => $_POST['userBodega'],
                "pass" => $_POST['passBodega']
            );

            

            $respuesta = BodegaModelo::editarBodega($bodega);
            echo json_encode(['respuesta'=>$respuesta]);

        }else{
            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }
    }

    /* ================================
        DEVUELVE TODAS LAS BODEGAS
     ==================================*/
     if( isset($_POST['obtenerBodegas']) ){
    
        $data = BodegaModelo::obtenerBodegas();
        echo json_encode($data);

    }

    if( isset($_POST['eliminarBodega']) ){
        if(preg_match('/^[()\-0-9 ]+$/', $_POST['idBodega'])){

            $respuesta = BodegaModelo::eliminarBodega($_POST['idBodega']);
            echo json_encode(['respuesta'=>$respuesta]);
        }else{
            echo json_encode(['respuesta'=>'Error con el ID de la bodega']);
        }
    }

