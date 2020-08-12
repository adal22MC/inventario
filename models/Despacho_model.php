<?php
require_once "conexion.php";

class DespachoModel
{
    public static function imprimirDatosDespacho($id_despacho,$id_b){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();
            $pst = $conn->prepare("SELECT fecha, hora FROM orden_trabajo  WHERE  id_b_ot = ? AND num_orden = ?");
            $pst->execute([$id_b,$id_despacho]);

            $Despacho = $pst->fetchAll();
            foreach ($Despacho as $desp) {
                echo "
                    <tr><td><strong>No Despacho: </strong>".$id_despacho."</td>               
                    <td><strong>Fecha:</strong> " . $desp['fecha'] . "</td>
                    <td><strong>Hora:</strong> " . $desp['hora'] . "</td></tr>";
                    
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
            $pst = $conn->prepare("SELECT n_trabajador as nombre, tel,cedula, obser FROM orden_trabajo  WHERE  id_b_ot = ? AND num_orden = ?");
            $pst->execute([$id_b,$id_despacho]);

            $Despacho = $pst->fetchAll();
            foreach ($Despacho as $desp) {
                echo '
                <tr>
                    <th scope="row">'.$desp["nombre"].'</th>
                    <td align="center">'.$desp["tel"].'</td>
                    <td align="center">'.$desp["cedula"].'</td>
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
}