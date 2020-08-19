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

                $pst = $conn->prepare("INSERT INTO usuarios VALUES (?,?,?,?,?,?,?,?)");
                $pst->execute([$usuario['username'],$usuario['password'],$usuario['correo'],$usuario['num_iden'],$usuario['nombres'],$usuario['apellidos'],$usuario['id_tu_u'],1]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function editUsuario($usuario){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("UPDATE usuarios set pass = ?, correo = ?, num_iden = ?, nombres = ?, apellidos = ? WHERE username = ?");

                $pst->execute([$usuario['password'],$usuario['correo'],$usuario['num_iden'],$usuario['nombres'],$usuario['apellidos'],$usuario['username']]);

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

                $pst = $conn->prepare("SELECT username,pass,correo,num_iden,nombres,apellidos,id_tu_u,descr,status FROM usuarios, tipo_usuario WHERE id_tu = id_tu_u");
                $pst->execute();
                $usuarios = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $usuarios;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function desactivarUsuario($username){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("UPDATE usuarios set status = 0 WHERE username = ?");
                $pst->execute([$username]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function activarUsuario($username){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("UPDATE usuarios set status = 1 WHERE username = ?");
                $pst->execute([$username]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function getUsuariosMultisucursal(){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT username FROM usuarios, tipo_usuario WHERE id_tu = id_tu_u and descr = 'Almacenista Multisucursal' and status = 1");
                $pst->execute();

                $usuarios = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $usuarios;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function getUsuariosUnidadLibres(){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT username 
                FROM usuarios, tipo_usuario 
                WHERE status = 1 and username NOT IN(
                    SELECT username_bu 
                    FROM bod_usu
                ) and id_tu = id_tu_u and descr = 'Almacenista Por Unidad'");
                $pst->execute();

                $usuarios = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $usuarios;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function getBodegasUsuarioMultisucursal($username){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT id_b_bu, nombre FROM bod_usu,bodegas WHERE username_bu = ? and id_b = id_b_bu");
                $pst->execute([$username]);

                $bodegas = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $bodegas;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function multisucursal($accesos){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("DELETE FROM bod_usu WHERE username_bu = ?");
                $pst->execute([$accesos[0]['username']]);

                if(count($accesos) > 1){
                    for($i=1; $i<count($accesos); $i++){
                        $pst = $conn->prepare("INSERT INTO bod_usu VALUES (?,?)");
                        $pst->execute([$accesos[$i]['id_bodega'],$accesos[0]['username']]);
                    }
                }

                $conexion->closeConexion();
                $conn = null;

                return "OK";

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }