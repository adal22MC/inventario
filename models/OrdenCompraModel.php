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
    }