<?php

    require_once "../models/UsuarioModel.php";

    if( isset($_POST['cambiarSucursal']) ){
        $respuesta = UsuarioModel::cambiarSucursal($_POST['id_sucursal']);
        echo json_encode(['respuesta'=>$respuesta]);
    }