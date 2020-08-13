<?php

    require_once "../../models/Solicitud_model.php";
    require_once "../../models/DespachoModel.php";
    require_once "../../vendor/autoload.php"; // Requirir DOM PDF
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: ../historial_despachos.php");
    }
   
    $Id;
    if (isset($_GET['id_despacho'])) {
        $van = 0;
        $Id[0] = array("id" => $_GET['id_despacho'],
                    "id_b" => $_SESSION['id_bodega']);
    } else {
        $van = 1;
        $Id = DespachoModelo::DespachoId($_GET['fechaInicial'], $_GET['fechaFinal'], $_SESSION['id_bodega']);
    }

    use Dompdf\Dompdf;

    ob_start();
    include "pdf_maq_despacho.php";
    $html = ob_get_clean();

    $pdf = new Dompdf();
    $pdf->load_html($html);

    $pdf->setPaper("A4");
    $pdf->render();

    $pdf->stream("Reporte Despachos ");
