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
                return $ordenes;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function getHistorialOrden(){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT oc.id_oc as id, oc.fecha, oc.hora, u.nombres as nombre, oc.status
                FROM orden_compra oc,usuarios u
                WHERE  oc.resp = u.username ");
                $pst->execute();

                $orden = $pst->fetchAll();


                $conexion->closeConexion();
                $conn = null;

                return $orden;

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

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function imprimiDatosOrden($id_orden){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
    
                $pst = $conn->prepare("SELECT oc.id_oc as id, oc.fecha, oc.hora, u.nombres as nombre, u.apellidos, oc.status
                FROM orden_compra oc,usuarios u
                WHERE  oc.resp = u.username and oc.id_oc = ?");
    
                $pst->execute([$id_orden]);
    
                $orden = $pst->fetchAll();
    
                foreach ($orden as $ord) {
                    echo "
                        <tr><td><strong>No Orden: </strong>".$id_orden."</td>
                        <td><strong>Realizado por:</strong> " . $ord['nombre'] . " " . $ord['apellidos'] . "</td>
                        <td><strong>Fecha:</strong> " . $ord['fecha'] . "</td></tr>
                        <td><strong>Hora:</strong> " . $ord['hora'] . "</td>";
                        if ( $ord['status'] == 1) {
                            echo"<td><strong>Estatus:</strong> Pendiente </td>";
                        } else if($ord['status'] == 2) {
                            echo"<td><strong>Estatus:</strong> Aceptada </td>";
                        }else{
                            echo"<td><strong>Estatus:</strong> Rechazada </td>";
                        }
                        
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function imprimiDatosTabla($id_orden){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT m.id_m as id, m.descr as nomM, doc.cant, doc.recibi, doc.p_compra, doc.te_producto as total
                FROM  detalle_orden_compra doc, material m
                WHERE doc.id_m_do = m.id_m and doc.id_oc_do = ?");
                $pst->execute([$id_orden]);
                $Detalletraslado = $pst->fetchAll();

                    foreach ($Detalletraslado as $Dtras) {
                        echo '
                        <tr>
                            <th scope="row">' . $Dtras["id"] . '</th>
                            <td align="center">' . $Dtras["nomM"] . '</td>
                            <td align="center">' . $Dtras["cant"] . '</td>
                            <td align="center">' . $Dtras["recibi"] . '</td>
                            <td align="center">' . $Dtras["p_compra"] . '</td>
                            <td align="center">' . $Dtras["total"] . '</td>
                        </tr>';
                    }


                $conexion->closeConexion();
                $conn = null;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function imprimirDatosSuma($id_orden){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT SUM(recibi) AS cant, SUM(te_producto) AS total
                FROM detalle_orden_compra
                WHERE id_oc_do = ?");
                $pst->execute([$id_orden]);
                $Orden = $pst->fetch();
               
                    echo '
                    <td colspan="4"></td>
                    <td align="right" >TOTAL MATERIALES: </td>
                    <td align="center" class="gray">
                    <h3 style="margin: 0px 0px;">' . $Orden["cant"] . '</h3>
                    </td>
                    <tr>
                        <td colspan="4"></td>
                        <td align="right" >TOTAL EFECTIVO: </td>
                        <td align="center" class="gray">
                        <h3 style="margin: 0px 0px;">' . $Orden["total"] . '</h3></td>
                    </tr>';
                

                $conexion->closeConexion();
                $conn = null;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function OrdenesCompraId($fehcaI, $fehcaF)
        {
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
    
                $pst = $conn->prepare("SELECT id_oc AS id FROM orden_compra WHERE fecha BETWEEN ? and ?  ORDER BY fecha ASC");
                $pst->execute([ $fehcaI, $fehcaF]);
    
                $orden = $pst->fetchAll();
    
                $conexion->closeConexion();
                $conn = null;
    
                return $orden;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        
        public static function obtenerUltimaOrden()
        {
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
    
                $pst = $conn->prepare("SELECT id_oc as id FROM orden_compra ORDER BY id_oc DESC LIMIT 1");
                $pst->execute();
    
                $orden = $pst->fetch();
    
                $conexion->closeConexion();
                $conn = null;
    
                return $orden;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        
    }