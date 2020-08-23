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
    $material;
    if (isset($_GET['idMaterial'])){
        $material[0]= array("id" =>$_GET['idMaterial']);
    }else{
        $material = MaterialModelo::getIdMaterialB($_SESSION['id_bodega']);
    }
    use Dompdf\Dompdf;

    ob_start();
    include "pdf_maq_material.php";
    $html = ob_get_clean();

    $pdf = new Dompdf();
    $pdf->load_html($html);

    $pdf->setPaper("A4");
    $pdf->render();
    if ($_GET['materiales']==1){
        $pdf->stream("Reporte Materiales ");
    }else{
        $pdf->stream("Reporte Stock Bajo ");
    }
    
