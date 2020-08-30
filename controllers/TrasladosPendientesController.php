<?php

require_once "../models/TrasladosPendientesModel.php";
session_start();

/* ==============================================
     RETORNA TODOS LOS TRASLADOS PENDIENTES
     (TOMA EL ID DE LA BODEGA QUE ESTA EN SESSION)
    ================================================= */
if (isset($_POST['getTrasladosPendientes'])) {
    $traslados = TrasladosPendientesModel::getTraslados($_SESSION['id_bodega']);
    echo json_encode($traslados);
}

/*========================================
    RETORNA EL DETALLE DE UN TRASLADO
    (RECIBE ID DEL TRASLADO_PENDIENTE)
==========================================*/
if(isset($_POST['getDetalleTraslado'])){
    $detalle = TrasladosPendientesModel::getDetalleTraslado($_POST['id_traslado']);
    echo json_encode($detalle);
}

if(isset($_POST['editarRecibiTrasladoPendiente'])){
    $respuesta = TrasladosPendientesModel::editRecibiTraslado($_POST['id_traslado'],$_POST['id_m'],$_POST['recibi']);

    echo json_encode(['respuesta'=>$respuesta]);
}

/* ============================================
        CUANDO UNA BODEGA RECHAZA EL TRASLADO
    ===============================================*/
if (isset($_POST['rechazar_traslado'])) {
    $respuesta = TrasladosPendientesModel::rechazarTraslado($_POST['id_traslado']);
    echo json_encode(['respuesta'=>$respuesta]);
}

/* ============================================
    CUANDO UNA BODEGA ACEPTA EL TRASLADO
===============================================*/
if (isset($_POST['aceptar_traslado'])) {
    $respuesta = TrasladosPendientesModel::aceptarTraslado($_POST['id_traslado'],$_POST['observaciones']);
    echo json_encode(['respuesta'=>$respuesta]);
}