<?php
    require_once "../models/AdminModel.php";

    if(isset($_POST['obtenerDatosSucursal'])){

        $data = AdminModelo::obtenerDatosSucursal();
        echo json_encode($data);
    }

    if(isset($_POST['editDatosMadre'])){
        if(

            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['nombreS']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['nitS']) &&
            preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $_POST['paginaS']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_., ]+$/', $_POST['direccionS']) &&
            preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $_POST['correoS']) &&
            preg_match('/^[()\-0-9 ]+$/', $_POST['telefonoS']) 

        ){
            $empresa = array(
                "nom" => $_POST['nombreS'],
                "nit" => $_POST['nitS'],
                "pag" => $_POST['paginaS'],
                "direc" => $_POST['direccionS'],
                "coreo" => $_POST['correoS'],
                "tel" => $_POST['telefonoS'],
            );
            $data = AdminModelo::editarDatosEmpresa($empresa);
            echo json_encode(['respuesta'=>$data]);
        }else{
            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }
        
    }