<?php
require_once "conexion.php";

class TrasladoModelo
{

    public static function imprimirDatosTraslado($id_traslado){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT  t.fecha, t.hora, u.nombres as resp, u.apellidos, b.nombre as bodega
            FROM traslados t, usuarios u, bodegas b
            WHERE t.resp = u.username and t.llego_a = b.id_b and t.id_t = ?");
            $pst->execute([$id_traslado]);

            $traslado = $pst->fetchAll();
            foreach ($traslado as $tras) {
                echo "
                    <tr><td><strong>No Traslado: </strong>" . $id_traslado . "</td>
                    <td><strong>Realizado por:</strong> " . $tras['resp'] . " " . $tras['apellidos'] . "</td>
                    <td><strong>Destino:</strong> " . $tras['bodega'] . "</td></tr>
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

            $pst = $conn->prepare("SELECT m.id_m as id, m.descr as nomM, mt.cant
            FROM traslados t, material_traslado mt,  material m
            WHERE mt.id_t_mt = t.id_t and mt.id_m_mt = m.id_m and t.id_t = ?");
            $pst->execute([$id_traslado]);
            $traslado = $pst->fetchAll();
            
                foreach ($traslado as $tras) {
                    echo '
                    <tr>
                        <th scope="row">' . $tras["id"] . '</th>
                        <td align="center">' . $tras["nomM"] . '</td>
                        <td align="center">' . $tras["cant"] . '</td>
                    </tr>';
                }          

            $conexion->closeConexion();
            $conn = null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimirDatosSuma($id_traslado)
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT SUM(mt.cant) as cant
            FROM  material_traslado mt
            WHERE  mt.id_t_mt = ?");
            $pst->execute([$id_traslado]);
            $Traslado = $pst->fetch();
         
                echo '
                <tr>
                    <td colspan="1"></td>
                    <td align="right" >TOTAL: </td>
                    <td align="center" class="gray">
                    <h3 style="margin: 0px 0px;">' . $Traslado["cant"] . '</h3>
                    </td>
                </tr>';
            

            $conexion->closeConexion();
            $conn = null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function TrasladosId($fehcaI, $fehcaF, $idB)
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT id_t AS id, resp AS user FROM traslados WHERE  fecha BETWEEN ? and ? and salio_de = ? ORDER BY fecha ASC");
            $pst->execute([ $fehcaI, $fehcaF, $idB]);

            $Traslados = $pst->fetchAll();

            $conexion->closeConexion();
            $conn = null;

            return $Traslados;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimiDatosTablaDetalle($id_traslado)
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT m.id_m as id, m.descr as nomM, dt.cant, dt.p_compra, dt.total, t.t_materiales as canTo
            FROM traslados t, material_traslado mt, detalle_traslado dt, material m
            WHERE mt.id_t_mt = t.id_t and dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt  and t.id_t = ?");
            $pst->execute([$id_traslado]);
            $Detalletraslado = $pst->fetchAll();
            $curr='COP';
                foreach ($Detalletraslado as $Dtras) {
                    $currencies['COP'] = array(0, '.', '.');

                    $pre = number_format($Dtras["p_compra"], ...$currencies[$curr]);
                    $to = number_format($Dtras["total"], ...$currencies[$curr]);
                    echo '
                    <tr>
                        <th scope="row">' . $Dtras["id"] . '</th>
                        <td align="center">' . $Dtras["nomM"] . '</td>
                        <td align="center">' . $Dtras["cant"] . '</td>
                        <td align="center">' . $pre . '</td>
                        <td align="center">' . $to. '</td>
                    </tr>';
                }
           

            $conexion->closeConexion();
            $conn = null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimirDatosSumaDetalle($id_traslado)
    {
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT SUM(dt.total) as cant
            FROM  material_traslado mt, detalle_traslado dt, material m
            WHERE dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt and mt.id_t_mt = ?");
            $pst->execute([$id_traslado]);
            $DetalleTraslado = $pst->fetch();

            $pst = $conn->prepare("SELECT SUM(mt.cant) as cant
            FROM  material_traslado mt
            WHERE  mt.id_t_mt = ?");
            $pst->execute([$id_traslado]);
            $Traslado = $pst->fetch();

            $curr='COP';
            $currencies['COP'] = array(0, '.', '.');

                    $pre = number_format($DetalleTraslado["cant"], ...$currencies[$curr]);
                    $to = number_format($Traslado["cant"], ...$currencies[$curr]);
                echo '
                <tr>
                    <td colspan="3"></td>
                    <td align="right" >TOTAL: </td>
                    <td align="center" class="gray"> <h3 style="margin: 0px 0px;">' . $pre . '</h3> </td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td align="right" >CANTIDAD TOTAL: </td>
                    <td align="center" class="gray"> <h3 style="margin: 0px 0px;">' . $to . '</h3> </td>
                </tr>';

            $conexion->closeConexion();
            $conn = null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
