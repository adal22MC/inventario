<?php

    require_once "conexion.php";
    require_once "../models/BodegaModel.php";

    class TrasladosPendientesModel {

        public static function getTraslados($id_bodega){
            
            try{
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM traslados_pendientes WHERE status = 1 and llego_a = ?");
                $pst->execute([$id_bodega]);

                $traslados = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $traslados;
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
            
        }

        public static function getDetalleTraslado($id_traslado){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT id_m,cant,recibi,descr FROM detalle_traslado_pendientes, material WHERE id_m_dtp = id_m and id_tp_dtp = ?");
                $pst->execute([$id_traslado]);

                $traslados = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $traslados;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function editRecibiTraslado($id_traslado,$id_m,$recibi){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("UPDATE detalle_traslado_pendientes set recibi = ? WHERE 
                id_tp_dtp = ? and id_m_dtp = ?");
                $pst->execute([$recibi,$id_traslado,$id_m]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function rechazarTraslado($id_traslado){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("UPDATE traslados_pendientes set status = 3 WHERE id = ?");
                $pst->execute([$id_traslado]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function aceptarTraslado($id_traslado,$observaciones){
            try{

                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM traslados_pendientes WHERE id = ?");
                $pst->execute([$id_traslado]);

                // Obtnemos la informacion del traslado 
                $infoTraslado = $pst->fetch();

                // Establecemos a que bodega llego
                $traslado[0]['id_bodega'] = $infoTraslado['llego_a'];

                // Establecemos las observaciones
                $traslado[0]['observaciones'] = $observaciones;  

                // Obtenemos el detalle del traslado
                $pst = $conn->prepare("SELECT id_m,cant,recibi,descr FROM detalle_traslado_pendientes, material WHERE id_m_dtp = id_m and id_tp_dtp = ?");
                $pst->execute([$id_traslado]);

                $detalle_traslado = $pst->fetchAll();
                
                $i = 1;
                foreach($detalle_traslado as $d){
                    $traslado[$i]['id'] = $d['id_m'];
                    $traslado[$i]['cantidad'] = $d['recibi'];

                    $i++;
                }
                
                BodegaModelo::insertarTraslado($traslado, $infoTraslado['salio_de']);

                $pst = $conn->prepare("UPDATE traslados_pendientes set status = 4 WHERE id = ?");
                $pst->execute([$id_traslado]);

                $conexion->closeConexion();
                $conn = null;
                
                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }
