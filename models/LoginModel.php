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
                    $pst = $conn->prepare("SELECT * FROM usuarios WHERE username=? and pass = ?");
                    $pst->execute([$user,$pass]);
                    $datosUsuario = $pst->fetch();
                    // Si tampoco existe en la tabla usuarios
                    if(!$datosUsuario){
                        return "¡Usuario o contraseña incorrectos!";
                    }
                    // Si existe en la tabla usuario;

                }

                session_start();
                $_SESSION['username'] = $datosUsuario['username'];
                $_SESSION['id_bodega'] = $datosUsuario['id_b'];
                $_SESSION['nombre_bodega'] = $datosUsuario['nombre'];
                if ($datosUsuario['tipo'] == 0){
                    $_SESSION['tipo_usuario'] = 'almacenista_unidad'; 
                }else{
                    $_SESSION['tipo_usuario'] = 'administrador';
                }

                return "OK";
                

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function validarUsuarioMultiple(){
        }

    }