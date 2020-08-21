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

    if( isset($_POST['editUsuario'])){
        
        $usuario = array(
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "correo" => $_POST['correo'],
            "num_iden" => $_POST['num_iden'],
            "nombres" => $_POST['nombres'],
            "apellidos" => $_POST['apellidos']
        );
        
        $respuesta = UsuarioModel::editUsuario($usuario);
        echo json_encode(['respuesta'=>$respuesta]);
        
    }

    if(isset($_POST['getUsuarios'])){
        $usuarios = UsuarioModel::getUsuarios();
        echo json_encode($usuarios);
    }

    if(isset($_POST['desactivarUsuario'])){
        $respuesta = UsuarioModel::desactivarUsuario($_POST['username']);
        echo json_encode(['respuesta'=>$respuesta]);
    }

    if(isset($_POST['activarUsuario'])){
        $respuesta = UsuarioModel::activarUsuario($_POST['username']);
        echo json_encode(['respuesta'=>$respuesta]);
    }

    if(isset($_POST['getUsuariosMultisucursal'])){
        $usuarios = UsuarioModel::getUsuariosMultisucursal();
        echo json_encode($usuarios);
    }

    /* =======================================================
        DEVUELVE LOS USUARIOS POR UNIDAD QUE ESTAN LIBRES
    ========================================================== */
    if(isset($_POST['getUsuariosUnidadLibres'])){
        $usuarios = UsuarioModel::getUsuariosUnidadLibres();
        echo json_encode($usuarios);
    }

    /* ================================================================================
      DEVUELVE TODAS LAS BODEGAS A LAS QUE TIENE ACCESO UN USUARIO MULTISUCURSAL
     ==================================================================================*/
    if(isset($_POST['getBodegasUsuarioMultisucursal'])){
        $bodegas = UsuarioModel::getBodegasUsuarioMultisucursal($_POST['username']);
        echo json_encode($bodegas);
    }

    /* ================================================================
        ESTABLECER LAS SUCURSALES A LAS QUE TENDRA ACCESO UN USUARIO
        MULTISUCURSAL
     ================================================================== */
     if(isset($_POST['multiusuario'])){
        $accesos = $_POST['multiusuario'];
        $respuesta = UsuarioModel::multisucursal($accesos);
        echo json_encode(['respuesta'=>$respuesta]);
     }

     /*===============================================================
       DEVUELVE LAS SUCURSALES A LAS QUE TIENE ACCESOS UN USUARIO 
       MULTISUCURSAL O POR UNIDAD OPERATIVA
     ================================================================= */
     if(isset($_POST['getSucursalesAcceso'])){
        $bodegas = UsuarioModel::getSucursalesAcceso($_POST['username']);
        echo json_encode([$bodegas]);
     }