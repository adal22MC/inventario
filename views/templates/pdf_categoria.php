<?php

    require_once "../../models/SolicitudModel.php";
    require_once "../../models/CategoriaModel.php";
    require_once "../../models/MaterialModel.php";
    require_once "../../vendor/autoload.php"; // Requirir DOM PDF
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: ../materiales.php");
    }
   
    $Id;
    if(isset($_GET['id_c'])){
        $Id[0] = array(
            "id" => $_GET['id_c'],
            "user"=>$_SESSION['username']
        );
    }
    $material = CategoriaModelo::getIdMaterialBC($_SESSION['id_bodega'],$_GET['id_c']);

    use Dompdf\Dompdf;

    ob_start();
    include "pdf_maq_categoria.php";
    $html = ob_get_clean();

    $pdf = new Dompdf();
    $pdf->load_html($html);

    $pdf->setPaper("A4");
    $pdf->render();
   
    $pdf->stream("Reporte Material Categoria");
    
