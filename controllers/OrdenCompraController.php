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

    /* =================================================================
        RETORNA TODAS LAS ORDENES DE COMPRA SIN IMPORTAR EL STATUS
    ==================================================================== */
    if( isset($_POST['getOrdenes'])){
        $ordenes = OrdenCompraModel::getOrdenes();
        echo json_encode($ordenes);
    }

    /* =============================================
      RETORNA UNA ORDEN DE COMPRA POR SU ID SIN
      IMPORTAR EL ESTATUS
     ===============================================*/
    if(isset($_POST['getOrdenById'])){
        $ordenes = OrdenCompraModel::getOrdenById($_POST['getOrdenById']);
        echo json_encode($ordenes);
    }

    /* =============================================
      RETORNA TODAAS LA ORDENES DE COMPRA CON STATUS 
      PENDIENTE
     ===============================================*/
    if(isset($_POST['getOrdenesPendientes'])){
        $ordenes = OrdenCompraModel::getOrdenesPendientes();
        echo json_encode($ordenes);
    }

    /* =============================================
      RETORNA EL DETALLE DE UNA ORDEN DE COMPRA
      (RECIBE EL ID DE LA ORDEN DE COMPRA)
     ===============================================*/
     if(isset($_POST['getDetalleOrden'])){
        $ordenes = OrdenCompraModel::getDetalleOrden($_POST['id_orden']);
        echo json_encode($ordenes);
    }

    /* =============================================================
       EDITA LA CANTIDAD QUE RECIBIO EN LA ORDEN DE COMPRA DETALLE
    =================================================================*/
    if(isset($_POST['editRecibiDetalleOrden'])){
        $respuesta = OrdenCompraModel::editRecibiDetalleOrden($_POST['cns'], $_POST['recibi']);
        echo json_encode(['respuesta'=>$respuesta]);
    }

    /* =======================================================
      RECHAZA UNA ORDEN DE COMPRA (CAMBIA EL ESTATUS A 3)
     =========================================================*/
    if(isset($_POST['rechazarOrden'])){
        $respuesta = OrdenCompraModel::rechazarOrden($_POST['id_orden']);
        echo json_encode(['respuesta'=>$respuesta]);
    }


    /* ==========================================================
        ACEPTA UNA ORDEN DE COMPRA (CAMBIA  EL ESTATUS A 2);
     ============================================================*/
    if(isset($_POST['aceptarOrden'])){
        $respuesta = OrdenCompraModel::aceptarOrden($_POST['id_orden']);
        echo json_encode(['respuesta'=>$respuesta]);
    }