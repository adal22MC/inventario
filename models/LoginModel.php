<?php

    require_once "conexion.php";
    session_start();

    class LoginModel {

        private static $SELECT_USER_BODEGA = "SELECT * FROM usuarios WHERE username = ? and pass = ?";

        public static function validarUsuarioBodega($user, $pass){
            try{
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$SELECT_USER_BODEGA);
                
                $pst->execute([$user, $pass]);

                $datosUsuario = $pst->fetch();

                // Si no existe el usuario en la tabla usuarios
                if(!$datosUsuario){
                    return "¡Usuario o contraseña incorrectos!";
                }

                $pst = $conn->prepare("SELECT id_b_bu FROM bod_usu WHERE username_bu = ?");
                $pst->execute([$datosUsuario['username']]);

                // Obtenemos todas las bodegas a las que este usuario tiene acceso
                $bodegas_acceso = $pst->fetchAll();

                // Si no existen bodegas para este usuario
                if(!$bodegas_acceso){
                    return "Este usuario aun no tiene sucursales asignadas!";
                }

                //Obtenemos el tipo de usuario
                $pst = $conn->prepare("SELECT tu.descr FROM usuarios u, tipo_usuario tu WHERE u.id_tu_u = tu.id_tu and u.username = ?");
                $pst->execute([$datosUsuario['username']]);

                $tipoUsuario = $pst->fetch();

                // Verificamos el tipo de usuario
                if($tipoUsuario['descr'] == "Almacenista Por Unidad"){

                    // Por ende solo tiene acceso a una sucursal 

                    // Obtenemos los datos de la sucursal
                    $pst = $conn->prepare("SELECT * FROM bodegas WHERE id_b = ?");
                    $pst->execute([$bodegas_acceso[0]['id_b_bu']]);
                    $datos_bodega = $pst->fetch();
                    
                    // Iniciamos las sesiones
                    $_SESSION['username'] = $datosUsuario['username'];
                    $_SESSION['nombre_usuario'] = $datosUsuario['nombres'];
                    $_SESSION['id_bodega'] = $datos_bodega['id_b'];
                    $_SESSION['nombre_bodega'] = $datos_bodega['nombre'];
                    $_SESSION['tipo_usuario'] = "Almacenista Por Unidad";
                    return "OK";

                }else if($tipoUsuario['descr'] == "Almacenista Principal"){
                    return "Almacenista Principal";
                }else if ($tipoUsuario['descr'] == "Administrador"){
                    return "Administrador";
                }


                





                /*
                session_start();
                $_SESSION['username'] = $datosUsuario['username'];
                $_SESSION['id_bodega'] = $datosUsuario['id_b'];
                $_SESSION['nombre_bodega'] = $datosUsuario['nombre'];
                if ($datosUsuario['tipo'] == 0){
                    $_SESSION['tipo_usuario'] = 'almacenista_unidad'; 
                }else{
                    $_SESSION['tipo_usuario'] = 'administrador';
                }
                */
                return "OK";
                

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function validarUsuarioMultiple(){
        }

    }