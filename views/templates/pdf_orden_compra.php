<?php

    require_once "../../models/SolicitudModel.php";
    require_once "../../models/OrdenCompraModel.php";
    require_once "../../vendor/autoload.php"; // Requirir DOM PDF
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: ../historial_despachos.php");
    }
   
    $Id;
    if (isset($_GET['id_orden'])) {
        $Id[0] = array("id" => $_GET['id_orden']);
    } else {
        $Id = OrdenCompraModel::OrdenesCompraId($_GET['fechaInicial'], $_GET['fechaFinal'],$_SESSION['username']);
    }

    use Dompdf\Dompdf;

    ob_start();
    include "pdf_maq_orden_compra.php";
    $html = ob_get_clean();

    $pdf = new Dompdf();
    $pdf->load_html($html);

    $pdf->setPaper("A4");
    $pdf->render();

    $pdf->stream("Reporte Orden Compra");
