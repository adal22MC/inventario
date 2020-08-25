<?php

    require_once "conexion.php";

    class DespachoModelo {

        public static function registrarDespacho($despacho, $id_bodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                // Registramos el despacho el tabla orden_trabajo
                $pst = $conn->prepare('INSERT INTO orden_trabajo (num_orden,n_trabajador,cedula,tel,obser,id_b_ot,resp) values (?,?,?,?,?,?,?)');

                $pst->execute([$despacho[0]['num_orden'],$despacho[0]['nombre'],$despacho[0]['cedula'],$despacho[0]['telefono'],$despacho[0]['obser'],$_SESSION['id_bodega'], $_SESSION['username']]);

                self::descontarInventarioHija($despacho,$id_bodega);
                self::insertarDetalleOrden($despacho,$despacho[0]['num_orden']);

                $conexion->closeConexion();
                $conn = null;

                $_SESSION['id_despacho_actual'] = $despacho[0]['num_orden'];

                return "OK";

            }catch(PDOException $e){
                return "Numero de orden ya registrado!";
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
        
        public static function imprimirDatosDespacho($id_despacho,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT u.nombres as nombre, u.apellidos, ot.fecha, ot.hora
                FROM orden_trabajo ot, usuarios u
                WHERE ot.resp = u.username AND id_b_ot = ? AND num_orden = ?");
                $pst->execute([$id_b,$id_despacho]);
    
                $Despacho = $pst->fetchAll();
                foreach ($Despacho as $desp) {
                    echo "
                        <tr><td><strong>No Despacho: </strong>".$id_despacho."</td>
                        <td><strong>Realizado por:</strong> " . $desp['nombre'] . " " . $desp['apellidos'] . "</td>               
                        <td><strong>Fecha:</strong> " . $desp['fecha'] . "</td></tr>
                        <td><strong>Hora:</strong> " . $desp['hora'] . "</td>";
                        
                }
                $conexion->closeConexion();
                $conn = null;
    
                return $Despacho;
    
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    
        public static function imprimirDatosTrabajador($id_despacho,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT n_trabajador as nombre, tel,cedula FROM orden_trabajo  WHERE  id_b_ot = ? AND num_orden = ?");
                $pst->execute([$id_b,$id_despacho]);
    
                $Despacho = $pst->fetchAll();
                foreach ($Despacho as $desp) {
                    echo '
                    <tr>
                        <th scope="row">'.$desp["nombre"].'</th>
                        <td align="center">'.$desp["tel"].'</td>
                        <td align="center">'.$desp["cedula"].'</td>
                    </tr>';
                        
                }
                $conexion->closeConexion();
                $conn = null;
    
                return $Despacho;
    
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    
        public static function imprimirDatosTabla($id_despacho,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT m.id_m as id, m.descr as material, do.cant as cant
                FROM orden_trabajo ot, detalle_orden do, material m
                WHERE m.id_m = do.id_m_do and do.num_orden_do = ot.num_orden and ot.id_b_ot = ? and ot.num_orden = ?");
                $pst->execute([$id_b,$id_despacho]);
    
                $Despacho = $pst->fetchAll();
                foreach ($Despacho as $desp) {
                    echo '
                    <tr>
                        <th scope="row">'.$desp["id"].'</th>
                        <td align="center">'.$desp["material"].'</td>
                        <td align="center">'.$desp["cant"].'</td>
                    </tr>';
                        
                }
                $conexion->closeConexion();
                $conn = null;
    
                return $Despacho;
    
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    
        public static function imprimirDatosSuma($id_despacho,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT SUM(do.cant) as cant
                FROM orden_trabajo ot, detalle_orden do, material m
                WHERE m.id_m = do.id_m_do and do.num_orden_do = ot.num_orden and ot.id_b_ot = ? and ot.num_orden = ?");
                $pst->execute([$id_b,$id_despacho]);
    
                $Despacho = $pst->fetchAll();
                foreach ($Despacho as $desp) {
                    echo '
                    <td colspan="1"></td>
                    <td align="right" >TOTAL: </td>
                    <td align="center" class="gray">
                      <h3 style="margin: 0px 0px;">'.$desp["cant"].'</h3>
                    </td>';
                        
                }
                $conexion->closeConexion();
                $conn = null;
    
                return $Despacho;
    
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        
        public static function DespachoId($fehcaI,$fehcaF,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT num_orden AS id, id_b_ot as id_b FROM orden_trabajo WHERE fecha BETWEEN ? AND ? AND id_b_ot = ? ORDER BY fecha ASC");
                $pst->execute([$fehcaI,$fehcaF,$id_b]);
    
                $Despacho = $pst->fetchAll();
    
                $conexion->closeConexion();
                $conn = null;
    
                return $Despacho;
    
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function imprimirDatosObservaciones($id_despacho,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT obser FROM orden_trabajo  WHERE  id_b_ot = ? AND num_orden = ?");
                $pst->execute([$id_b,$id_despacho]);
    
                $Despacho = $pst->fetchAll();
                foreach ($Despacho as $desp) {
                    echo '
                    <tr>
                        <td align="center">'.$desp["obser"].'</td>
                    </tr>';
                        
                }
                $conexion->closeConexion();
                $conn = null;
    
                return $Despacho;
    
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function obtenerUltimoDespacho($id_despacho)
        {
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
    
                $pst = $conn->prepare("SELECT num_orden as id FROM orden_trabajo Where num_orden = ?");
                $pst->execute([$id_despacho]);
    
                $despacho = $pst->fetch();
    
                $conexion->closeConexion();
                $conn = null;
    
                return $despacho;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }