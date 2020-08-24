<?php

    require_once "../models/SolicitudesMadreModel.php";
    session_start();

    if (isset($_POST['getDetalleSolicitud'])){
        $detalle = SolicitudesMadreModel::getDetalleSolicitud($_POST['idSolicitud']);
        echo json_encode($detalle);
    }

    /* ===========================================
        CUANDO SE ACEPTA LA SOLICITUD
     ============================================= */
     if( isset($_POST['aceptarSolicitud'])){

        $ban = SolicitudesMadreModel::verificarSolicitud($_POST['idSolicitud'], $_SESSION['id_bodega']);

        if($ban){
            $respuesta = SolicitudesMadreModel::aceptarSolicitud($_POST['idSolicitud'], $_SESSION['id_bodega']);

            echo json_encode(['respuesta'=>$respuesta]);
        }else{
            echo json_encode(['respuesta'=>'Algunos productos no tienen stock sufuciente para satisfacer la solicitud!']);
        }
        
    }

    /* ===========================================
        CUANDO SE RECHAZA LA SOLICITUD
     ============================================= */
     if( isset($_POST['rechazarSolicitud'])){
        $respuesta = SolicitudesMadreModel::rechazarSolicitud($_POST['idSolicitud']);
        
        echo json_encode(['respuesta'=>$respuesta]);
    }