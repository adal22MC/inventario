<?php

    require_once "../models/BodegaModel.php";
    session_start();

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

            

            $respuesta = BodegaModelo::agregarBodeja($bodega);
            echo json_encode(['respuesta'=>$respuesta]);

        }else{
            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }
        
    }

    /* ==============================
        EDITAR BODEGA
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

    /* ========================================================
      DEVUELVE TODAS LAS BODEGAS DISPONIBLES PARA EL TRASALADO
     ===========================================================*/
    if (isset($_POST['obtenerBodegas_traslado'])){
        $data = BodegaModelo::obtenerBodegas_traslados($_SESSION['id_bodega']);
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

    /* ==============================================
        HACE EL TRASLADO DE UNA BODEGA A OTRA
    ================================================= */
    if( isset($_POST['traslado'])){
        $traslado = $_POST['traslado'];

        $respuesta = BodegaModelo::insertarTraslado($traslado, $_SESSION['id_bodega']);

        echo json_encode(['respuesta'=>$respuesta]);
    }

    /* =============================================================
        Devuelve el historial de solicitudes de una bodega 
     ===============================================================*/
    if( isset($_POST['getHistorialSolicitudes']) ){
        $solicitudes =  BodegaModelo::getHistorialSolicitudes($_SESSION['id_bodega']);
        echo json_encode($solicitudes);
    }

    /* =============================================================
        Devuelve el historial de despachos de una bodega 
     ===============================================================*/
     if( isset($_POST['getHistorialDespachos']) ){
        $Despachos =  BodegaModelo::getHistorialDespachos($_SESSION['id_bodega']);
        echo json_encode($Despachos);
    }
     /* =============================================================
        Devuelve el historial de traslados de una bodega 
     ===============================================================*/
     if( isset($_POST['getHistorialTraslados']) ){
         $Traslados = BodegaModelo::getHistorialTraslados($_SESSION['id_bodega']);
         echo json_encode($Traslados);
     }
