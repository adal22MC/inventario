<?php

    require_once "../models/SolicitudesMadreModel.php";
    session_start();

    if (isset($_POST['getDetalleSolicitud'])){
        $detalle = SolicitudesMadreModel::getDetalleSolicitud($_POST['idSolicitud']);
        echo json_encode($detalle);
    }

    /* ===========================================
        CUANDO SE ACEPTA LA SOLICITUD FINALMENTE
     ============================================= */
     if( isset($_POST['aceptarSolicitud_hija'])){

        $ban = SolicitudesMadreModel::verificarSolicitud($_POST['idSolicitud'], $_SESSION['id_bodega']);

        if($ban){
            $respuesta = SolicitudesMadreModel::aceptarSolicitud($_POST['idSolicitud'], $_SESSION['id_bodega']);

            echo json_encode(['respuesta'=>$respuesta]);
        }else{
            echo json_encode(['respuesta'=>'Algunos productos no tienen stock sufuciente para satisfacer la solicitud!']);
        }
        
    }

    /* =================================================
        CUANDO ACEPTA LA SOLICITUD LA UNIDAD MADRE
    ====================================================*/
    if(isset($_POST['aceptarSolicitud'])){
        $ban = SolicitudesMadreModel::verificarSolicitud($_POST['idSolicitud'], $_SESSION['id_bodega']);

        if($ban){
            $respuesta = SolicitudesMadreModel::aceptarSolicitudMadre($_POST['idSolicitud']);

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

    /* ===========================================================
        RETORNA LOS ID DE LAS SOLICITUDES QUE ESTAN EN ESTATUS 2
    ==============================================================*/
    if(isset($_POST['getSolicitudesAceptadas'])){
        $solicitudes = SolicitudesMadreModel::getSolicitudesStatus2();
        echo json_encode($solicitudes);
    }

    /* ====================================================================================
        MODIFICA LA CANTIDAD QUE SE RECIBIO DE UNA SOLICITUD QUE HIZO LA HIJA A LA MADRE
     ======================================================================================*/
     if(isset($_POST['editRecibiDetalleSolicitud'])){
         $respuesta = SolicitudesMadreModel::modificarCantidadRecibi($_POST['id_s'],$_POST['id_m'], $_POST['recibi']);
         echo json_encode(['respuesta'=>$respuesta]);
     }