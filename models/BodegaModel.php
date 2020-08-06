<?php

    require_once "conexion.php";

    class BodegaModelo {

        private static $INSERT_BODEGA = "INSERT INTO bodegas (correo,tel,nombre,username,pass) values (?, ?, ?, ?, ?)";

        private static $SELECT_ALL = "SELECT id_b,f_creacion,correo,tel,nombre,username,pass FROM bodegas";

        private static $UPDATE = "UPDATE bodegas set nombre=?,correo=?,tel=?,username=?,pass=? WHERE id_b = ?";

        private static $DELETE = "DELETE FROM bodegas WHERE id_b = ?";

        public static function agregarBodeja($bodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$INSERT_BODEGA);

                $pst->execute([$bodega['correo'], $bodega['tel'], $bodega['nombre'], $bodega['usuario'], $bodega['pass']]);

                $conn = null;
                $conexion->closeConexion();

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* Validar si la bodega no tiene inventario */
        public static function eliminarBodega($id){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$DELETE);

                $pst->execute([$id]);

                $conn = null;
                $conexion->closeConexion();

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function editarBodega($bodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$UPDATE);

                $pst->execute([$bodega['nombre'], $bodega['correo'], $bodega['tel'], $bodega['usuario'], $bodega['pass'], $bodega['id']]);

                $conn = null;
                $conexion->closeConexion();

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function obtenerBodegas(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$SELECT_ALL);

                $pst->execute();
                $bodegas = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $bodegas;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* Devuelve todas las bodegas disponibles para el traslado */
        public static function obtenerBodegas_traslados($id_b){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM bodegas where id_b <> ?");

                $pst->execute([$id_b]);
                $bodegas = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $bodegas;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* Metodo que imprime las notificaciones de stock bajo */
        public static function printStockBajoBodega(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT descr FROM material, inventario WHERE s_total <= s_min and id_b_i = ? and id_m_i = id_m");

                $pst->execute([$_SESSION['id_bodega']]);
                $materiales = $pst->fetchAll();

                $ban = 0;
                $total_materiales_bajos = count($materiales);
                foreach($materiales as $material){
                    if($ban == 0){
                        echo '
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-info navbar-badge">'.$total_materiales_bajos.'</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">Notificaciones</span>
                        ';
                    }
                    
                    echo '    
                        <div class="dropdown-divider"></div>
                        <a href="materiales.php" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> '.$material['descr'].'
                            <span class="float-right text-muted text-sm">bajo en stock</span>
                        </a>
                    ';
                    $ban = 1;
                }

                if($ban == 0){
                    echo '
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-info navbar-badge">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">Sin Notificaciones</span>      
                    </div>
                    ';
                }else{
                    echo '</div>';
                }

                $conn = null;
                $conexion->closeConexion();

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function insertarTraslado($traslado, $id_bo_salio){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $ban = self::verificarTraslado($traslado);
                if(!$ban){
                    return "Parece que algunas cantidades a trasladar sobrepasan el stock maximo de la sucursal que los recibira";
                }
                return "OK";

                // Dejamos pendiente esta parte
                $total_materiaes = count($traslado) - 1;

                $pst = $conn->prepare("INSERT INTO traslados (llego_a, salio_de,t_materiales,te_traslado) VALUES (?,?,?,?)");
                

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function verificarTraslado($traslado){
            try{
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                // Id de la bodega a la que se hara el traslado
                $id_b_llega = $traslado[0]['id_bodega'];
                
                for($i = 1; $i<count($traslado); $i++){

                    $pst = $conn->prepare("SELECT s_total, s_max FROM inventario WHERE id_b_i = ? and id_m_i = ?");
                    $pst->execute([$id_b_llega, $traslado[$i]['id']]);
                    $datos = $pst->fetch();

                    $filas = $pst->rowCount();
                    if($filas > 0){
                        if( ($datos['s_total'] + $traslado[$i]['cantidad']) > $datos['s_max'] ){
                            return false;
                        }
                    }
                    
                }

                return true;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }