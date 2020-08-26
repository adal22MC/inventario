<?php
require_once "conexion.php";

class TrazabilidadModelo
{
    public static function getSucursalesHijas(){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT id_b as id, nombre FROM bodegas WHERE tipo = 0");
            $pst->execute();

            $sucursales = $pst->fetchAll();

            $conexion->closeConexion();
            $conn = null;

            return $sucursales;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function getMaterialesSucursal($id){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT m.id_m as id, m.descr as nombre, m.serial
            FROM material m, inventario i
            WHERE  i.id_m_i = m.id_m and i.id_b_i = ?");
            $pst->execute([$id]);

            $sucursales = $pst->fetchAll();

            $conexion->closeConexion();
            $conn = null;

            return $sucursales;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimirDatosMaterial($id,$idS){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT nombre FROM bodegas WHERE id_b = ?");
            $pst->execute([$idS]);
            $Sucursal= $pst->fetch();

            $pst = $conn->prepare("SELECT descr FROM material WHERE id_m = ?");
            $pst->execute([$id]);
            $material= $pst->fetchAll();
            foreach ($material as $Dm) {
                echo "
                    <tr>
                    <td><strong>Codigo: </strong>" . $id. "</td>
                    <td><strong>Material: </strong> " . $Dm['descr'] . "</td>
                    <td><strong>Bodega: </strong>" . $Sucursal['nombre']. "</td>
                    </tr>";
            }
            $conexion->closeConexion();
            $conn = null;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimirDatosEntrada($id,$fechaI,$fechaF,$idS){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT b.nombre as realizado,dt.cant, dt.p_compra, dt.total, u.nombres as resp, t.fecha
            FROM traslados t, material_traslado mt, detalle_traslado dt, material m, usuarios u, bodegas b
            WHERE mt.id_t_mt = t.id_t and dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt and t.resp = u.username  and t.salio_de = b.id_b and t.llego_a = ?  and t.fecha BETWEEN ? and ? and m.id_m = ? ORDER BY t.fecha ASC");
            $pst->execute([$idS,$fechaI,$fechaF,$id]);

            $DetalleM = $pst->fetchAll();
            if($DetalleM != null){
                $curr='COP';
                foreach ($DetalleM as $Dtras) {
                    $currencies['COP'] = array(0, '.', '.');

                    $pre = number_format($Dtras["p_compra"], ...$currencies[$curr]);
                    $to = number_format($Dtras["total"], ...$currencies[$curr]);
                    echo '
                    <tr>
                        <td align="center">' . $Dtras["realizado"] . '</td>
                        <td align="center">' . $Dtras["resp"] . '</td>
                        <td align="center">' . $Dtras["fecha"] . '</td>
                        <td align="center">' . $Dtras["cant"] . '</td>
                        <td align="center">' . $pre. '</td>
                        <td align="center">' . $to. '</td>
                    </tr>';
                }
            }else{
                echo '
                <tr>
                <td align="center"colspan="7">El Material no tiene entradas</td>
                </tr>';
            }
            
            $conexion->closeConexion();
            $conn = null;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimirDatosDespacho($id,$fechaI,$fechaF,$idS){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT  dt.cant as cant, u.nombres as resp, ot.fecha
            FROM orden_trabajo ot, detalle_orden dt, material m, usuarios u, bodegas b
            WHERE m.id_m = dt.id_m_do and dt.num_orden_do = ot.num_orden and ot.resp = u.username and ot.id_b_ot = b.id_b and ot.id_b_ot = ? and ot.fecha BETWEEN ? and ? and m.id_m = ? ORDER BY ot.fecha ASC");
            $pst->execute([$idS,$fechaI,$fechaF,$id]);

            $DetalleD = $pst->fetchAll();
            if($DetalleD != null){
                $curr='COP';
                foreach ($DetalleD as $Ddes) {
                    $currencies['COP'] = array(0, '.', '.');
                    $cant = number_format($Ddes["cant"], ...$currencies[$curr]);
                    echo '
                    <tr>
                        <td align="center">' . $Ddes["resp"] . '</td>
                        <td align="center">' . $Ddes["fecha"] . '</td>
                        <td align="center">' . $cant. '</td>
                        
                    </tr>';
                }
            }else{
                echo '
                <tr>
                <td align="center"colspan="7">El Material no tiene Despachos</td>
                </tr>';
            }
            
            $conexion->closeConexion();
            $conn = null;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimirDatosTraslados($id,$fechaI,$fechaF,$idS){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT dt.cant, dt.p_compra, dt.total, u.nombres as resp, t.fecha, b.nombre as Destino
            FROM traslados t, material_traslado mt, detalle_traslado dt, material m, usuarios u, bodegas b
            WHERE mt.id_t_mt = t.id_t and dt.id_t_dt = mt.id_t_mt and mt.id_m_mt = m.id_m and dt.id_m_dt = mt.id_m_mt and t.resp = u.username  and t.llego_a = b.id_b and t.salio_de = ? and t.fecha BETWEEN ? and ? and m.id_m = ? ORDER BY t.fecha ASC");
            $pst->execute([$idS,$fechaI,$fechaF,$id]);

            $DetalleM = $pst->fetchAll();
            if($DetalleM != null){
                $curr='COP';
                foreach ($DetalleM as $Dtras) {
                    $currencies['COP'] = array(0, '.', '.');

                    $pre = number_format($Dtras["p_compra"], ...$currencies[$curr]);
                    $to = number_format($Dtras["total"], ...$currencies[$curr]);
                    echo '
                    <tr>
                        <td align="center">' . $Dtras["Destino"] . '</td>
                        <td align="center">' . $Dtras["resp"] . '</td>
                        <td align="center">' . $Dtras["fecha"] . '</td>
                        <td align="center">' . $Dtras["cant"] . '</td>
                        <td align="center">' . $pre . '</td>
                        <td align="center">' . $to . '</td>
                    </tr>';
                }
            }else{
                echo '
                <tr>
                <td align="center"colspan="7">El Material no tiene Traslados</td>
                </tr>';
            }
            
            $conexion->closeConexion();
            $conn = null;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}