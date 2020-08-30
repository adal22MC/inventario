<?php

    require_once "conexion.php";
    require_once "../models/BodegaModel.php";

    /**
     * ESTATUS 1 -> SOLICITUD PENDIENTE
     * ESTATUS 2 -> SOLICITUD ACEPTADA POR LA U. PRINCIPAL
     * ESTATUS 3 -> RECHAZADA 
     * ESTATUS 4 -> COMPLETADA FINALMENTE 
     */

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

                $pst = $conn->prepare("SELECT descr,cant,recibi,id_m FROM detalle_solicitud, material WHERE id_s_ds = ? and id_m = id_m_ds");
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

        /* ======================================================
            SE EJECUTA CUANDO SE ACEPTA UNA SOLICITUD FINALMENTE
         ======================================================== */
         public static function aceptarSolicitud($id_s,$id_b_salio,$observaciones){
            try{
              
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                // Obtenemos el id de la bodega Madre
                $pst = $conn->prepare("SELECT * FROM bodegas WHERE tipo = 1");
                $pst->execute();
                $bodegaMadre = $pst->fetch();
                $id_b_salio = $bodegaMadre['id_b'];

                $pst = $conn->prepare("SELECT * FROM solicitud_p WHERE id_s = ?");
                $pst->execute([$id_s]);

                // Establecemos a que bodega llego
                $solicitud = $pst->fetch();
                $traslado[0]['id_bodega'] = $solicitud['id_b_sp'];

                // Establecemos las observacioens
                $traslado[0]['observaciones'] = $observaciones;

                // Modificamos las observaciones a nivel tabla solicitud_p
                $pst = $conn->prepare("UPDATE solicitud_p set observaciones = ? WHERE id_s = ?");
                $pst->execute([$observaciones,$id_s]);

                $pst = $conn->prepare("SELECT * FROM detalle_solicitud WHERE id_s_ds = ?");
                $pst->execute([$id_s]);

                $detalle = $pst->fetchAll();

                $i = 1;
                foreach($detalle as $d){
                    $traslado[$i]['id'] = $d['id_m_ds'];
                    $traslado[$i]['cantidad'] = $d['recibi'];

                    $i++;
                }

                $res = BodegaModelo::insertarTraslado($traslado, $id_b_salio);
                
                $pst = $conn->prepare("UPDATE solicitud_p set status = 4 WHERE id_s = ?");
                $pst->execute([$id_s]);


                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* ==============================================
          CUANDO LA U. PRINCIPAL ACEPTA LA SOLICITUD
         ================================================= */
        public static function aceptarSolicitudMadre($id_solicitud){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                
                $pst = $conn->prepare("UPDATE solicitud_p set status = 2 WHERE id_s = ?");
                $pst->execute([$id_solicitud]);


                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* ===========================================================
            Metodo que verifica que la cantidad que solicita la unidad 
            operativ hija este disponible en la sucursal Madre 
        =====================================================================*/
        public static function verificarSolicitud($id_s, $id_b){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                // Obtenemos el id de la bodega Madre
                $pst = $conn->prepare("SELECT * FROM bodegas WHERE tipo = 1");
                $pst->execute();
                $bodegaMadre = $pst->fetch();
                $id_b = $bodegaMadre['id_b'];

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

        /* ===========================================================
            RETORNA LAS SOLICITUDES EN ESTATUS 2
         =============================================================*/
         public static function getSolicitudesStatus2(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM solicitud_p WHERE status = 2");
                $pst->execute();
                $solicitudes = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $solicitudes;
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* ====================================================================================
                MODIFICA LA CANTIDAD QUE SE RECIBIO DE UNA SOLICITUD QUE HIZO LA HIJA A LA MADRE
        ======================================================================================*/
        public static function modificarCantidadRecibi($id_s, $id_m, $recibi){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("UPDATE detalle_solicitud set recibi = ? WHERE id_s_ds = ? and id_m_ds = ?");
                $pst->execute([$recibi,$id_s,$id_m]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }