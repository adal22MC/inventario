<?php

    require_once "conexion.php";
    require_once "../models/BodegaModel.php";

    class SolicitudesMadreModel {

        /* Imprime directamente las solicitudes que hacen las bodegas
           hijas a la bodega Madre */
        public static function printSolicitudes(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                // 1 = pendiente
                $pst = $conn->prepare("SELECT id_s, nombre, fecha, hora, nombres, apellidos FROM solicitud_p, bodegas, usuarios WHERE solicitud_p.status = 1 and id_b = id_b_sp and username = resp");
                $pst->execute();

                $datosSolicitudes = $pst->fetchAll();
                foreach($datosSolicitudes as $row){
                    echo '
                        <tr>
                            <td>'.$row['id_s'].'</td>
                            <td>'.$row['nombre'].'</td>
                            <td>'.$row['fecha'].'</td>
                            <td>'.$row['hora'].'</td>
                            <td>'.$row['nombres'].'</td>
                            <td class="text-center">
                                <button id="'.$row['id_s'].'" class="btn btn-sm btn-primary btnVerDetalle">Más</button>
                                <button id="'.$row['id_s'].'" class="btn btn-sm btn-success btnAceptar">Aceptar</button>
                                <button id="'.$row['id_s'].'" class="btn btn-sm btn-danger btnRechazar">Rechazar</button>
                            </td>
                        </tr>
                    ';
                }

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* ==============================================
            Retorna el detalle de una solicitud en json 
         ================================================ */
        public static function getDetalleSolicitud($id){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT descr, cant FROM detalle_solicitud, material WHERE id_s_ds = ? and id_m = id_m_ds");
                $pst->execute([$id]);

                $detalle = $pst->fetchAll();
                
                return $detalle;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* ==================================
            CUANDO SE RECHAZA UNA SOLICITUD
         ====================================*/
         public static function rechazarSolicitud($id_s){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                
                $pst = $conn->prepare("UPDATE solicitud_p set status = 3 WHERE id_s = ?");
                $pst->execute([$id_s]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* ===========================================
            SE EJECUTA CUANDO SE ACEPTA UNA SOLICITUD
         =============================================*/
         public static function aceptarSolicitud($id_s, $id_b_salio){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM solicitud_p WHERE id_s = ?");
                $pst->execute([$id_s]);

                // Establecemos a que bodega llego
                $solicitud = $pst->fetch();
                $traslado[0]['id_bodega'] = $solicitud['id_b_sp'];

                $pst = $conn->prepare("SELECT * FROM detalle_solicitud WHERE id_s_ds = ?");
                $pst->execute([$id_s]);

                $detalle = $pst->fetchAll();

                $i = 1;
                foreach($detalle as $d){
                    $traslado[$i]['id'] = $d['id_m_ds'];
                    $traslado[$i]['cantidad'] = $d['cant'];

                    $i++;
                }

                $res = BodegaModelo::insertarTraslado($traslado, $id_b_salio);
                
                $pst = $conn->prepare("UPDATE solicitud_p set status = 2 WHERE id_s = ?");
                $pst->execute([$id_s]);


                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* Metodo que verifica que la cantidad que solicita la unidad operativ hija este disponible en la
           sucursal Madre */
        public static function verificarSolicitud($id_s, $id_b){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM solicitud_p WHERE id_s = ?");
                $pst->execute([$id_s]);

                $pst = $conn->prepare("SELECT * FROM detalle_solicitud WHERE id_s_ds = ?");
                $pst->execute([$id_s]);

                $detalle = $pst->fetchAll();

                $ban = true;
                foreach($detalle as $d){
                    $pst = $conn->prepare("SELECT * FROM inventario WHERE id_b_i = ? and id_m_i = ?");
                    $pst->execute([$id_b,$d['id_m_ds']]);
                    $stocK = $pst->fetch();
                    if($stocK['s_total'] < $d['cant']){
                        $ban = false;
                        break;
                    }
                }

                return $ban;
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }