<?php

    require_once "conexion.php";

    class LoginModel {

        private static $SELECT_USER_BODEGA = "SELECT * FROM bodegas WHERE username = ? and pass = ?";

        public static function validarUsuarioBodega($user, $pass){
            try{
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$SELECT_USER_BODEGA);
                
                $pst->execute([$user, $pass]);

                $datosUsuario = $pst->fetch();

                // Si no existe el usuario en las bodegas
                if(!$datosUsuario){
                    return "Usuario y contraseña incorrectos!";
                }

                session_start();
                $_SESSION['username'] = $datosUsuario['username'];
                if ($datosUsuario['tipo'] == 0){
                    $_SESSION['tipo_usuario'] = 'administrador'; 
                }else{
                    $_SESSION['tipo_usuario'] = 'almacenista_unidad';
                }

                return "OK";
                

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function validarUsuarioMultiple(){
        }

    }