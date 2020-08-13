<?php

    require_once "conexion.php";
    session_start();

    class UsuarioModel {

        public static function cambiarSucursal($id_sucursal){
            for($i = 0; $i<count($_SESSION['datos_bodegas']); $i++){
                if($_SESSION['datos_bodegas'][$i]['id_bodega'] == $id_sucursal){
                    $_SESSION['id_bodega'] = $_SESSION['datos_bodegas'][$i]['id_bodega'];
                    $_SESSION['nombre_bodega'] = $_SESSION['datos_bodegas'][$i]['nombre_bodega'];
                    return "OK";
                }
            }

            return "Lo sentimos no tienes acceso";
        }
    }