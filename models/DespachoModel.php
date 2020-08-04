<?php

    require_once "conexion.php";

    class DespachoModelo {

        public static function registrarDespacho($despacho, $id_bodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                // Registramos el despacho el tabla orden_trabajo
                $pst = $conn->prepare('INSERT INTO orden_trabajo (n_trabajador,cedula,tel,obser) values (?,?,?,?)');

                $pst->execute([$despacho[0]['nombre'],$despacho[0]['cedula'],$despacho[0]['telefono'],$despacho[0]['obser']]);

                // Ahora obtenemos el id de ese despacho que se acaba de insertar
                $pst = $conn->prepare("SELECT MAX(num_orden) as id FROM orden_trabajo");
                $pst->execute();
                $id_despacho = $pst->fetch();

                self::descontarInventarioHija($despacho,$id_bodega);
                self::insertarDetalleOrden($despacho,$id_despacho['id']);

                $conexion->closeConexion();
                $conn = null;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function descontarInventarioHija($despacho,$id_bodega){
            $conexion = new Conexion();
            $conn = $conexion->getConexion();
            
            for($i = 1; $i< count($despacho); $i++){

                $pst = $conn->prepare("SELECT MIN(cns) as cns, stock, p_compra FROM detalle_inventario WHERE id_b_di = ? and id_m_di = ? and dispo = 1");

                $pst->execute([$id_bodega,$despacho[$i]['id']]);

                $material = $pst->fetch();

                // Cuando el primer cns alcanza para descontar el Stock
                if($material['stock'] >= $despacho[$i]['cantidad']){
                    $stock_sobrante = $material['stock'] - $despacho[$i]['cantidad'];
                    if($stock_sobrante == 0){
                        
                        $pst2 = $conn->prepare("UPDATE detalle_inventario set dispo = 0, stock = 0 WHERE id_b_di = ? and id_m_di = ? and cns = ?");
                        $pst2->execute([$id_bodega,$despacho[$i]['id'],$material['cns']]);

                    }else{
                        $pst2 = $conn->prepare("UPDATE detalle_inventario set dispo = 1, stock = ? WHERE id_b_di = ? and id_m_di = ? and cns = ?");
                        $pst2->execute([$stock_sobrante,$id_bodega,$despacho[$i]['id'],$material['cns']]);
                    }

                }else{

                    $ban = true;
                    $descontar = $despacho[$i]['cantidad'];
                    $cns_detalle = 0;

                    while($ban){

                        $pst = $conn->prepare("SELECT MIN(cns) as cns, stock, p_compra FROM detalle_inventario WHERE id_b_di = ? and id_m_di = ? and dispo = 1");

                        $pst->execute([$id_bodega,$despacho[$i]['id']]);
                        $datos_cns = $pst->fetch();
                        $cns_detalle = $datos_cns['cns'];

                        if($descontar > $datos_cns['stock']){
                            $descontar = $descontar - $material['stock'];

                            $pst2 = $conn->prepare("UPDATE detalle_inventario set dispo = 0, stock = 0 WHERE id_b_di = ? and id_m_di = ? and cns = ?");
                            $pst2->execute([$id_bodega,$despacho[$i]['id'],$cns_detalle]);

                        }else{
                            $stock_sobrante = $datos_cns['stock'] - $descontar;
                            if($stock_sobrante == 0){
                                $pst2 = $conn->prepare("UPDATE detalle_inventario set dispo = 0, stock = 0 WHERE id_b_di = ? and id_m_di = ? and cns = ?");
                                $pst2->execute([$id_bodega,$despacho[$i]['id'],$cns_detalle]);
                            }else{
                                $pst2 = $conn->prepare("UPDATE detalle_inventario set dispo = 1, stock = ? WHERE id_b_di = ? and id_m_di = ? and cns = ?");
                                $pst2->execute([$stock_sobrante,$id_bodega,$despacho[$i]['id'],$cns_detalle]);
                            }
                            $ban = false;
                        } 
                    }
                }

                // Actualizamos el stock disponible en la tabla inventario
                $pst_suma = $conn->prepare("SELECT SUM(stock) as suma FROM detalle_inventario WHERE id_b_di = ? and id_m_di = ?");
                $pst_suma->execute([$id_bodega,$despacho[$i]['id']]);
                $stock = $pst_suma->fetch();

                $pst3 = $conn->prepare("UPDATE inventario set s_total = ? WHERE id_b_i = ? and id_m_i = ?");
                $pst3->execute([$stock['suma'],$id_bodega,$despacho[$i]['id']]);


            }

            $conexion->closeConexion();
            $conn = null;
        } 

        public static function insertarDetalleOrden($despachos, $id_orden){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                for($i=1; $i < count($despachos); $i++){
                    $pst = $conn->prepare("INSERT INTO detalle_orden (cant,num_orden_do,id_m_do) VALUES (?,?,?)");
                    $pst->execute([$despachos[$i]['cantidad'],$id_orden,$despachos[$i]['id']]);
                }

                $conexion->closeConexion();
                $conn = null;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }