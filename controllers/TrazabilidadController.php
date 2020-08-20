<?php

    require_once "../models/TrazabilidadModel.php";
    session_start();

     /* =============================================================
        Devuelve todas las Sucursales hijas
     ===============================================================*/
     if( isset($_POST['getSucursalesHijas']) ){
        $sucursales =  TrazabilidadModelo::getSucursalesHijas();
        echo json_encode($sucursales);

    }
     /* =============================================================
        Devuelve los materiales de una sucursal hija
     ===============================================================*/
     if( isset($_POST['getMaterialesSucursal']) ){
        $Materiales =  TrazabilidadModelo::getMaterialesSucursal($_POST["id"]);
        echo json_encode($Materiales);

    }