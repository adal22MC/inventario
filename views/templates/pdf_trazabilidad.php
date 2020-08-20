<?php

    require_once "../../models/SolicitudModel.php";
    require_once "../../models/TrazabilidadModel.php";
    require_once "../../vendor/autoload.php"; // Requirir DOM PDF
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: ../trazabilidad.php");
    }
   
    $Id;
    if (isset($_GET['id_M'])) {
        $Id[0] = array("id" => $_GET['id_M'],
                        "FechaI" => $_GET['fechaInicial'],
                        "FechaF" => $_GET['fechaFinal'],
                        "idS" => $_GET['idS']);
    }

    use Dompdf\Dompdf;

    ob_start();
    include "pdf_maq_trazabilidad.php";
    $html = ob_get_clean();

    $pdf = new Dompdf();
    $pdf->load_html($html);

    $pdf->setPaper("A4");
    $pdf->render();

    $pdf->stream("Reporte Trazabilidad ");
