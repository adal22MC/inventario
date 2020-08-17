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