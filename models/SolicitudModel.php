<?php

require_once "conexion.php";

class SolicitudModelo
{

    public static function imprimiDatosEmpresa($id_solicitud){

        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT  nombre, correo, tel, direccion FROM  bodegas WHERE id_b = ?");
            $pst->execute([$id_solicitud]);

            $bo = $pst->fetchAll();
            foreach ($bo as $bodega) {
                echo "<h3>" . $bodega['nombre'] . "</h3>
                        <pre>
                        No Bodega: " .$id_solicitud. "
                        " . $bodega['direccion'] . " 
                        " . $bodega['tel'] . "
                        " . $bodega['correo'] . "
                        </pre>";
            }
            $conexion->closeConexion();
            $conn = null;

            return $bo;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function imprimiDatosSolicitud($id_solicitud){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT u.nombres as nombre, u.apellidos as apellido, sp.status as status, sp.fecha as fecha, sp.hora as hora FROM solicitud_p  sp, usuarios u WHERE sp.resp = u.username and sp.id_s = ?");

            $pst->execute([$id_solicitud]);

            $solicitud = $pst->fetchAll();

            foreach ($solicitud as $soli) {
                echo "
                    <tr><td><strong>No Solicitud: </strong>".$id_solicitud."</td>
                    <td><strong>Realizado por:</strong> " . $soli['nombre'] . " " . $soli['apellido'] . "</td>
                    <td><strong>Fecha:</strong> " . $soli['fecha'] . "</td></tr>
                    <td><strong>Hora:</strong> " . $soli['hora'] . "</td>";
                    if ( $soli['status'] == 1) {
                        echo"<td><strong>Estatus:</strong> Pendiente </td>";
                    } else if($soli['status'] == 2) {
                        echo"<td><strong>Estatus:</strong> Aceptada </td>";
                    }else{
                        echo"<td><strong>Estatus:</strong> Rechazada </td>";
                    }
                    
            }
            $conexion->closeConexion();
            $conn = null;

            return $solicitud;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
     public static function imprimiDatosTabla($id_solicitud){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT m.id_m as id, m.descr as material, ds.cant as cant FROM solicitud_p  sp, detalle_solicitud ds, material m WHERE m.id_m = ds.id_m_ds and sp.id_s = ds.id_s_ds and sp.id_s = ?");
                $pst->execute([$id_solicitud]);

                $materiales = $pst->fetchAll();
                foreach($materiales as $material){
                    echo '
                    <tr>
                        <th scope="row">'.$material["id"].'</th>
                        <td align="center">'.$material["material"].'</td>
                        <td align="center">'.$material["cant"].'</td>
                    </tr>';
                }
                $conexion->closeConexion();
                $conn = null;

                return $materiales;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
    }
    public static function imprimiDatosSuma($id_solicitud){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT SUM(ds.cant) as cant FROM solicitud_p  sp, detalle_solicitud ds, material m WHERE m.id_m = ds.id_m_ds and sp.id_s = ds.id_s_ds and sp.id_s = ?");
            $pst->execute([$id_solicitud]);

            $material = $pst->fetch();
                echo '
                <td colspan="1"></td>
                <td align="right" >TOTAL: </td>
                <td align="center" class="gray">
                  <h3 style="margin: 0px 0px;">'.$material["cant"].'</h3>
                </td>';
            
            $conexion->closeConexion();
            $conn = null;

            return $material;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function SolicitudesId($fehcaI,$fehcaF,$idB){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT id_s AS id FROM solicitud_p WHERE fecha BETWEEN ? AND ?  AND id_b_sp = ? ORDER BY fecha ASC");
            $pst->execute([$fehcaI,$fehcaF,$idB]);
            $ID = $pst->fetchAll();

            $conexion->closeConexion();
            $conn = null;

            return $ID;

        } catch (PDOException $e) {           
            return $e->getMessage();
        }
    }
    public static function imprimirDEmpresa(){
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            $pst = $conn->prepare("SELECT nombre, correo, tel, direccion, nit, pagina,url FROM empresa where id = 1");

            $pst ->execute();
            
            $datosS = $pst->fetchAll();
            foreach ($datosS as $datos) {
                echo ' 
                <td valign="top" align="left" > 
                    <img src="../dist/img/logo_empresa.jpeg" alt="logo" width="150" align="center"/>           
                </td>
                <td valign="top" align="center" WIDTH="100"> 
                     
                    <p style="font-size: 12px" >                  
                <pre><p style="font-size: 14px" class="pre" >'. $datos["nombre"] . '</p>
NIT: '. $datos["nit"] . '
'. $datos["tel"] . '
'. $datos["direccion"] . '
'. $datos["correo"] . '
'. $datos["pagina"] . '</pre>
                    </p>
                </td> ';
            }
            $conn = null;
            $conexion->closeConexion();

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
