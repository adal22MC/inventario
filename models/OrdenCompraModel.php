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
        public static function getHistorialOrden($resp){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT oc.id_oc as id, oc.fecha, oc.hora, u.nombres as nombre, oc.status
                FROM orden_compra oc,usuarios u
                WHERE  oc.resp = u.username and oc.resp = ?");
                $pst->execute([$resp]);

                $orden = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $orden;

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
        public static function imprimiDatosTabla($id_orden, $user){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT  tu.descr as tipoU
                FROM usuarios u, tipo_usuario tu
                WHERE u.id_tu_u = tu.id_tu and u.username  = ?");
                $pst->execute([$user]);
                $tipo = $pst->fetch();

                $pst = $conn->prepare("SELECT m.id_m as id, m.descr as nomM, doc.cant, doc.recibi, doc.p_compra, doc.te_producto as total
                FROM  detalle_orden_compra doc, material m
                WHERE doc.id_m_do = m.id_m and doc.id_oc_do = ?");
                $pst->execute([$id_orden]);
                $Detalletraslado = $pst->fetchAll();

                if ($tipo["tipoU"] == "Almacenista Principal" || $tipo["tipoU"] == "Administrador") {
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
                } 

                $conexion->closeConexion();
                $conn = null;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function imprimirDatosSuma($id_orden, $user){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT SUM(recibi) AS cant, SUM(te_producto) AS total
                FROM detalle_orden_compra
                WHERE id_oc_do = ?");
                $pst->execute([$id_orden]);
                $Orden = $pst->fetch();

                $pst = $conn->prepare("SELECT  tu.descr as tipoU
                FROM usuarios u, tipo_usuario tu
                WHERE u.id_tu_u = tu.id_tu and u.username  = ?");
                $pst->execute([$user]);
                $tipo = $pst->fetch();


                if ($tipo["tipoU"] == "Almacenista Principal" || $tipo["tipoU"] == "Administrador") {
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
                }

                $conexion->closeConexion();
                $conn = null;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function OrdenesCompraId($fehcaI, $fehcaF, $user)
        {
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
    
                $pst = $conn->prepare("SELECT id_oc AS id,resp AS user FROM orden_compra WHERE resp = ? and fecha BETWEEN ? and ?  ORDER BY fecha ASC");
                $pst->execute([$user, $fehcaI, $fehcaF]);
    
                $orden = $pst->fetchAll();
    
                $conexion->closeConexion();
                $conn = null;
    
                return $orden;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }