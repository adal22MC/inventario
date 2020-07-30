<?php

    require_once "../models/MaterialModel.php";

    if ( isset($_POST['obtenerMaterialesMadre']) ){

        $materiales = MaterialModelo::obtenerMaterialesMadre();
        echo json_encode($materiales);

    }