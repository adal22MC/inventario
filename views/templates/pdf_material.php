<?php

    require_once "../../models/SolicitudModel.php";
    require_once "../../models/MaterialModel.php";
    require_once "../../vendor/autoload.php"; // Requirir DOM PDF
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: ../materiales.php");
    }
   
    $Id;
    $Id[0] = array(
        "id" => $_SESSION['id_bodega'],
        "user"=>$_SESSION['username']
    );
    
    use Dompdf\Dompdf;

    ob_start();
    include "pdf_maq_material.php";
    $html = ob_get_clean();

    $pdf = new Dompdf();
    $pdf->load_html($html);

    $pdf->setPaper("A4");
    $pdf->render();
    if (isset($_GET['materiales'])){
        $pdf->stream("Reporte Materiales ");
    }else{
        $pdf->stream("Reporte Stock Bajo ");
    }
    
