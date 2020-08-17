<?php

    require_once "../../models/SolicitudModel.php";
    require_once "../../models/TrasladoModel.php";
    require_once "../../vendor/autoload.php"; // Requirir DOM PDF
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: ../historial_traslados.php");
    }
   
    $Id;
    if (isset($_GET['id_traslado'])) {
        $van = 0;
        $Id[0] = array("id" => $_GET['id_traslado'],
                        "user" => $_SESSION['username']);
    } else {
        $van = 1;
        $Id = TrasladoModelo::TrasladosId($_GET['fechaInicial'], $_GET['fechaFinal'], $_SESSION['id_bodega'],$_SESSION['username']);
    }

    use Dompdf\Dompdf;

    ob_start();
    include "pdf_maq_traslado.php";
    $html = ob_get_clean();

    $pdf = new Dompdf();
    $pdf->load_html($html);

    $pdf->setPaper("A4");
    $pdf->render();

    $pdf->stream("Reporte Traslados ");
