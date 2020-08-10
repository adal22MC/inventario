<?php

    require_once "../../models/Solicitud_model.php";
    require_once "../../vendor/autoload.php";
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: ../historial_solicitudes.php");
    }
   
    $Id;
    if (isset($_GET['id_solicitud'])) {
        $van = 0;
        $Id[0] = array("id" => $_GET['id_solicitud']);
    } else {
        $van = 1;
        $Id = SolicitudModelo::SolicitudesId($_GET['fechaInicial'], $_GET['fechaFinal'], $_SESSION['id_bodega']);
    }

    use Dompdf\Dompdf;

    ob_start();
    include "pdf_maq_solicitud.php";
    $html = ob_get_clean();

    $pdf = new Dompdf();
    $html = 
    $pdf->load_html($html);

    $pdf->setPaper("A4");
    $pdf->render();

    $pdf->stream("Reporte Solicitudes");