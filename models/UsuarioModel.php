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

        public static function getTiposUsuarios(){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM tipo_usuario");
                $pst->execute();

                $tipos = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $tipos;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function addUsuario($usuario){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("INSERT INTO usuarios VALUES (?,?,?,?,?,?,?)");
                $pst->execute([$usuario['username'],$usuario['password'],$usuario['correo'],$usuario['num_iden'],$usuario['nombres'],$usuario['apellidos'],$usuario['id_tu_u']]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function getUsuarios(){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM usuarios");
                $pst->execute();
                $usuarios = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $usuarios;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }