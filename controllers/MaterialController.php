<?php

    require_once "../models/MaterialModel.php";


    /* =========================================================
        RETORNA LA LISTA DE MATERIALES QUE TIENE LA BODEGA MADRE
     ============================================================ */
    if ( isset($_POST['obtenerMaterialesMadre']) ){

        $materiales = MaterialModelo::obtenerMaterialesMadre();
        echo json_encode($materiales);

    }

    /**
     * RETORNA LA LISTA DE MATERIALES DE UNA BODEGA HIJA
     */
    if ( isset($_POST['getMaterialHijas']) ){
        $materiales = MaterialModelo::obtenerMaterialesHijas(13);
        echo json_encode($materiales);
    }