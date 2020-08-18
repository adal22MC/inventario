<?php

    require_once "../models/OrdenCompraModel.php";
    session_start();

    /* ========================================================
        RECIBE EL JSON DE LA ORDEN DE COMPRA Y LA INSERTA
    =========================================================== */
    if( isset($_POST['generarOrden'])){
        $orden = $_POST['generarOrden'];
        $respuesta = OrdenCompraModel::insertarOrdenCompra($orden, $_SESSION['username']);
        echo json_encode(['respuesta'=>$respuesta]);
    }

     /* =============================================================
        Devuelve el historial de las Ordenes de compra
     ===============================================================*/
     if( isset($_POST['getHistorialOrden']) ){
        $orden =  OrdenCompraModel::getHistorialOrden($_SESSION['username']);
        echo json_encode($orden);
    }