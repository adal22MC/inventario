<?php
require_once "conexion.php";

class TrasladoModelo{

    public static function imprimirDatosTraslado($id_traslado){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT  t.fecha, t.hora, u.nombres as resp, u.apellidos, b.nombre as bodega, t.t_materiales as cant
            FROM traslados t, usuarios u, bodegas b
            WHERE t.resp = u.username and t.llego_a = b.id_b and t.id_t = ?");
            $pst->execute([$id_traslado]);

            $traslado = $pst->fetchAll();
            foreach ($traslado as $tras) {
                echo "
                    <tr><td><strong>No Traslado: </strong>".$id_traslado."</td>
                    <td><strong>Realizado por:</strong> " . $tras['resp'] . " " . $tras['apellidos'] . "</td>
                    <td><strong>Traslado:</strong> " . $tras['bodega'] . "</td></tr>
                    <td><strong>Cantidad Total:</strong> " . $tras['cant'] . "</td>
                    <td><strong>Fecha:</strong> " . $tras['fecha'] . "</td>
                    <td><strong>Hora:</strong> " . $tras['hora'] . "</td>";
                    
            }
            $conexion->closeConexion();
            $conn = null;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimiDatosTabla($id_traslado){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT m.id_m as id, m.descr as nomM, dt.cant, dt.p_compra, dt.total 
            FROM traslados t, material_traslado mt, detalle_traslado dt, material m
            WHERE mt.id_t_mt = t.id_t and dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt and t.id_t = ?");
            $pst->execute([$id_traslado]);

            $traslado = $pst->fetchAll();
            foreach($traslado as $tras){
                echo '
                <tr>
                    <th scope="row">'.$tras["id"].'</th>
                    <td align="center">'.$tras["nomM"].'</td>
                    <td align="center">'.$tras["cant"].'</td>
                    <td align="center">'.$tras["p_compra"].'</td>
                    <td align="center">'.$tras["total"].'</td>
                </tr>';
            }
            $conexion->closeConexion();
            $conn = null;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimirDatosSuma($id_traslado){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT SUM(dt.total) as cant
            FROM  material_traslado mt, detalle_traslado dt, material m
            WHERE dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt and mt.id_t_mt = ?");
            $pst->execute([$id_traslado]);

            $Traslado = $pst->fetch();
                echo '
                <td colspan="3"></td>
                <td align="right" >TOTAL: </td>
                <td align="center" class="gray">
                <h3 style="margin: 0px 0px;">'.$Traslado["cant"].'</h3>
                </td>';
            $conexion->closeConexion();
            $conn = null;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function TrasladosId($fehcaI,$fehcaF,$idB){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT id_t AS id FROM traslados WHERE fecha BETWEEN ? and ? and salio_de = ? ORDER BY fecha ASC");
            $pst->execute([$fehcaI,$fehcaF,$idB]);

            $Traslados = $pst->fetchAll();

            $conexion->closeConexion();
            $conn = null;
            
            return $Traslados;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}