<?php

    require_once "../models/LoginModel.php";

    if( isset($_POST['ingresar'])){

        if(
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_., ]+$/', $_POST['usuario']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_., ]+$/', $_POST['pass'])
        ){
            $respuesta = LoginModel::validarUsuarioBodega($_POST['usuario'], $_POST['pass']);
            
            echo json_encode(['respuesta'=>$respuesta]);
        }else{
            echo json_encode(['respuesta'=>'Caracteres no admitidos']);
        }
        
    }