<?php

    require_once "conexion.php";

    class OrdenCompraModel {

        public static function insertarOrdenCompra($orden, $resp){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                /**
                 * 1 = pendiente
                 * 2 = aceptada
                 * 3 = rechazada
                 */

                // Insertamos en la tabla orden_compra
                $pst = $conn->prepare("INSERT INTO orden_compra (status, resp) VALUES (1,?)");
                $pst->execute([$resp]);

                // Obtenemos el id que acabamos de insertar
                $pst = $conn->prepare("SELECT MAX(id_oc) as id_oc FROM orden_compra");
                $pst->execute();
                $id_oc = $pst->fetch();

                //Empezamos insertar el detalle
                foreach($orden as $row){
                    $pst = $conn->prepare("INSERT INTO detalle_orden_compra (id_oc_do,cant,recibi,p_compra,te_producto,id_m_do) VALUES (?,?,?,?,?,?)");

                    $te_producto = $row['precio'] * $row['cantidad'];

                    $pst->execute([$id_oc['id_oc'],$row['cantidad'],$row['cantidad'],$row['precio'],$te_producto,$row['id']]);
                }

                $conexion->closeConexion();
                $conn = null;
                
                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function getOrdenes(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM orden_compra");
                $pst->execute();

                $ordenes = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $ordenes;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function getOrdenesPendientes(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM orden_compra WHERE status = 1");
                $pst->execute();

                $ordenes = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $ordenes;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function getOrdenById($id){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM orden_compra WHERE id_oc = ?");
                $pst->execute([$id]);

                $ordenes = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $ordenes;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function getDetalleOrden($id){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT cns,id_oc_do,cant,recibi,p_compra,te_producto, m.descr as material, m.id_m  FROM detalle_orden_compra, material m WHERE m.id_m = id_m_do and id_oc_do = ?");
                $pst->execute([$id]);

                $ordenes = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $ordenes;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function editRecibiDetalleOrden($cns, $recibi){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM detalle_orden_compra WHERE cns = ?");
                $pst->execute([$cns]);
                $detalle = $pst->fetch();

                $te_producto = $detalle['p_compra'] * $recibi;

                $pst = $conn->prepare("UPDATE detalle_orden_compra set recibi = ?, te_producto = ? WHERE  cns = ?");
                $pst->execute([$recibi,$te_producto,$cns]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function rechazarOrden($id_orden){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("UPDATE orden_compra set status = 3 WHERE id_oc = ?");
                $pst->execute([$id_orden]);

                $conexion->closeConexion();
                $conn = null;

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function aceptarOrden($id_orden){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("UPDATE orden_compra set status = 2 WHERE id_oc = ?");
                $pst->execute([$id_orden]);

                $detalle_orden = self::getDetalleOrden($id_orden);
                
                foreach($detalle_orden as $row){

                    $pst = $conn->prepare("SELECT * FROM detalle_inventario WHERE id_b_di = ? and id_m_di = ? and dispo = 1 and p_compra = ?");
                    $pst->execute([$_SESSION['id_bodega'], $row['id_m'],$row['p_compra']]);
                    $invetario = $pst->fetch();
                    
                    if($invetario){
                        $total = $invetario['stock'] + $row['recibi'];
                        $pst = $conn->prepare("UPDATE detalle_inventario set stock = ? WHERE cns = ?");
                        $pst->execute([$total,$invetario['cns']]);
                    }else{
                        $pst = $conn->prepare("INSERT INTO detalle_inventario (dispo, p_compra, stock, id_b_di, id_m_di) VALUES (1,?, ?, ?, ?)");
                        $pst->execute([$row['p_compra'],$row['recibi'],$_SESSION['id_bodega'],$row['id_m']]);
                    }

                    $pst = $conn->prepare("SELECT SUM(stock) as suma FROM detalle_inventario WHERE id_b_di = ? and id_m_di = ?");
                    $pst->execute([$_SESSION['id_bodega'],$row['id_m']]);
                    $suma = $pst->fetch();

                    $pst = $conn->prepare("UPDATE inventario set s_total = ? WHERE id_b_i = ? and id_m_i = ?");
                    $pst->execute([$suma['suma'],$_SESSION['id_bodega'],$row['id_m']]);

                }


                $conexion->closeConexion();
                $conn = null;

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }