<?php

require_once "conexion.php";
session_start();

class LoginModel
{

    private static $SELECT_USER_BODEGA = "SELECT * FROM usuarios WHERE username = ? and pass = ?";

    public static function validarUsuarioBodega($user, $pass)
    {
        try {

            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare(self::$SELECT_USER_BODEGA);

            $pst->execute([$user, $pass]);

            $datosUsuario = $pst->fetch();

            // Si no existe el usuario en la tabla usuarios
            if (!$datosUsuario) {
                return "¡Usuario o contraseña incorrectos!";
            }

            if ($datosUsuario['status'] == 0) {
                return "El usuario esta desactivado";
            }

            // Obtenemos todas las bodegas a las que este usuario tiene acceso
            $pst = $conn->prepare("SELECT id_b_bu FROM bod_usu WHERE username_bu = ?");
            $pst->execute([$datosUsuario['username']]);
            $bodegas_acceso = $pst->fetchAll();

            //Obtenemos el tipo de usuario
            $pst = $conn->prepare("SELECT tu.descr FROM usuarios u, tipo_usuario tu WHERE u.id_tu_u = tu.id_tu and u.username = ?");
            $pst->execute([$datosUsuario['username']]);

            $tipoUsuario = $pst->fetch();

            if ($tipoUsuario['descr'] == "Almacenista Por Unidad") {

                // Si no existen bodegas para este usuario
                if (!$bodegas_acceso) {
                    return "Este usuario aun no tiene sucursales asignadas!";
                }
            }

            // Variable para las notificaciones de stock y solicitudes
            $_SESSION['notificaciones'] = 1;

            // Verificamos el tipo de usuario
            if ($tipoUsuario['descr'] == "Almacenista Por Unidad") {
                // Iniciamos las sesiones
                $_SESSION['username'] = $datosUsuario['username'];
                $_SESSION['nombre_usuario'] = $datosUsuario['nombres'];
                $_SESSION['tipo_usuario'] = "Almacenista Por Unidad";

                //Iniciamos una sesion con todas las sucursales a las que tiene acceso
                foreach($bodegas_acceso as $bodega){

                    // Obtenemos los datos de la sucursal
                    $pst = $conn->prepare("SELECT * FROM bodegas WHERE id_b = ?");
                    $pst->execute([$bodega['id_b_bu']]);
                    $datos_bodega = $pst->fetch();

                    $_SESSION['datos_bodegas'][] = [
                        'id_bodega' => $datos_bodega['id_b'],
                        'nombre_bodega' => $datos_bodega['nombre']
                    ];
                }

                $_SESSION['id_bodega'] = $_SESSION['datos_bodegas'][0]['id_bodega'];
                $_SESSION['nombre_bodega'] = $_SESSION['datos_bodegas'][0]['nombre_bodega'];
                
            }else if ($tipoUsuario['descr'] == "Almacenista Principal") {

                // Consultamos los datos de la bodega madre
                $pst = $conn->prepare("SELECT * FROM bodegas WHERE tipo = 1");
                $pst->execute();
                $datos_bodega = $pst->fetch();

                if (!$datos_bodega) {
                    return "La sucursal principal aun no esta creada";
                }

                // Iniciamos las sesiones
                $_SESSION['username'] = $datosUsuario['username'];
                $_SESSION['nombre_usuario'] = $datosUsuario['nombres'];
                $_SESSION['tipo_usuario'] = "Almacenista Principal";
                $_SESSION['id_bodega'] = $datos_bodega['id_b'];
                $_SESSION['nombre_bodega'] = $datos_bodega['nombre'];

            } else if ($tipoUsuario['descr'] == "Administrador") {
                // Consultamos los datos de la bodega madre
                $pst = $conn->prepare("SELECT * FROM bodegas WHERE tipo = 1");
                $pst->execute();
                $datos_bodega = $pst->fetch();

                if (!$datos_bodega) {
                    return "La sucursal principal aun no esta creada";
                }

                // Iniciamos las sesiones
                $_SESSION['username'] = $datosUsuario['username'];
                $_SESSION['nombre_usuario'] = $datosUsuario['nombres'];
                $_SESSION['tipo_usuario'] = "Administrador";
                $_SESSION['id_bodega'] = $datos_bodega['id_b'];
                $_SESSION['nombre_bodega'] = $datos_bodega['nombre'];
            }
            return "OK";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
