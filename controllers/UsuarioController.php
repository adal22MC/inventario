<?php

    require_once "../models/UsuarioModel.php";

    if( isset($_POST['cambiarSucursal']) ){
        $respuesta = UsuarioModel::cambiarSucursal($_POST['id_sucursal']);
        echo json_encode(['respuesta'=>$respuesta]);
    }

    if( isset($_POST['getTiposUsuarios'])){
        $tipos = UsuarioModel::getTiposUsuarios();
        echo json_encode($tipos);
    }

    if( isset($_POST['addUsuario'])){
        $usuario = array(
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "correo" => $_POST['correo'],
            "num_iden" => $_POST['num_iden'],
            "nombres" => $_POST['nombres'],
            "apellidos" => $_POST['apellidos'],
            "id_tu_u" => $_POST['tipoUsuario']
        );

        $respuesta = UsuarioModel::addUsuario($usuario);

        echo json_encode(['respuesta'=>$respuesta]);
    }

    if(isset($_POST['getUsuarios'])){
        $usuarios = UsuarioModel::getUsuarios();
        echo json_encode($usuarios);
    }