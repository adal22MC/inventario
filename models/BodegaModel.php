<?php

    require_once "conexion.php";

    class BodegaModelo {

        private static $INSERT_BODEGA = "INSERT INTO bodegas (id_b,correo,tel,nombre,direccion) values (?, ?, ?, ?, ?)";

        private static $SELECT_ALL = "SELECT id_b,f_creacion,correo,tel,nombre,direccion FROM bodegas";

        private static $UPDATE = "UPDATE bodegas set id_b = ?, nombre=?,correo=?,tel=?,direccion=?  WHERE id_b = ?";

        private static $DELETE = "DELETE FROM bodegas WHERE id_b = ? and tipo = 0";

        public static function agregarBodeja($bodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$INSERT_BODEGA);

                $pst->execute([$bodega['id'],$bodega['correo'], $bodega['tel'], $bodega['nombre'],$bodega['direc']]);

                /*
                $pst = $conn->prepare("INSERT INTO bod_usu VALUES (?,?)");
                $pst->execute([$bodega['id'],$bodega['username']]);
                */

                $conn = null;
                $conexion->closeConexion();

                return "OK";

            }catch(PDOException $e){
                return "Error, el codigo de sucursal ya existe!";
            }
        }

        /* Validar si la bodega no tiene inventario */
        public static function eliminarBodega($id){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$DELETE);

                $pst->execute([$id]);

                $filas = $pst->rowCount();

                if($filas > 0){
                    return "OK";
                }

                $conn = null;
                $conexion->closeConexion();

                return "No se ha podido eliminar la bodega";

            }catch(PDOException $e){
                return "No se ha podido eliminar la bodega";
                return $e->getMessage();
            }
        }

        public static function editarBodega($bodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$UPDATE);

                $pst->execute([$bodega['id'],$bodega['nombre'], $bodega['correo'], $bodega['tel'], $bodega['direccion'], $bodega['id_viejo']]);

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

        public static function obtenerBodegasHijas(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM bodegas WHERE tipo = 0");

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

                $pst = $conn->prepare("SELECT * FROM bodegas where id_b <> ? and tipo = 0");

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
                            <b><span class="badge badge-danger navbar-badge">'.$total_materiales_bajos.'</span></b>
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

        /* Devuelve la cantidad de materiales con stock bajo de la bodega que este en sesion */
        public static function getStockBajoBodega(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT descr FROM material, inventario WHERE s_total <= s_min and id_b_i = ? and id_m_i = id_m");

                $pst->execute([$_SESSION['id_bodega']]);
                
                $materiales = $pst->fetchAll();

                $total_materiales_bajos = count($materiales);
                

                $conn = null;
                $conexion->closeConexion();

                return $total_materiales_bajos;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* Guardamos el traslado en la tabla traslados pendientes */
        public static function guardarTraslado($traslado, $id_bo_salio){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("INSERT INTO traslados_pendientes 
                (resp,status,llego_a,salio_de) VALUES (?,1,?,?)");
                $pst->execute([$_SESSION['username'],$traslado[0]['id_bodega'],$id_bo_salio]);

                // Obtenemos el id del traslado que acabamos de insertar
                $pst = $conn->prepare("SELECT MAX(id) as id FROM traslados_pendientes");
                $pst->execute();
                $id = $pst->fetch();

                // Insertamos en el detalle del traslado
                for($i=1; $i<count($traslado); $i++){
                    $pst = $conn->prepare("INSERT INTO detalle_traslado_pendientes 
                    (id_tp_dtp,id_m_dtp,cant,recibi) VALUES (?,?,?,?)");
                    $pst->execute([$id['id'],$traslado[$i]['id'],$traslado[$i]['cantidad'],$traslado[$i]['cantidad']]);
                }

                $conexion->closeConexion();
                $con = null;

                return "OK";

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
                
                // Obtenemos el total de materiales a trasladar
                $total_materiaes = self::getTotalMaterialesTraslado($traslado);

                // Insertamos en la tabla traslado
                $pst = $conn->prepare("INSERT INTO traslados (llego_a, salio_de,t_materiales,te_traslado, resp,observaciones) VALUES (?,?,?,?,?,?)");
                $pst->execute([$traslado[0]['id_bodega'],$id_bo_salio,$total_materiaes,0,$_SESSION['username'],$traslado[0]['observaciones']]);

                // Obtenemos el id del traslado
                $pst = $conn->prepare("SELECT MAX(id_t) as id_t FROM traslados"); 
                $pst->execute();
                $id_t = $pst->fetch();

                // Insertamos el detalle del traslado
                self::insertarDetalleTraslado($traslado,$id_t['id_t'],$id_bo_salio);

                // Obtenemos la suma total en efectivo del traslado
                $pst = $conn->prepare("SELECT SUM(t_material) as total FROM material_traslado WHERE id_t_mt = ?");
                $pst->execute([$id_t['id_t']]);
                $suma = $pst->fetch();

                // Acutalizamos el campo te_traslado de la tabla traslado
                $pst = $conn->prepare("UPDATE traslados set te_traslado = ? WHERE id_t = ?");
                $pst->execute([$suma['total'],$id_t['id_t']]);

                return "OK";
                

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

        public static function getTotalMaterialesTraslado($traslado){
            $total = 0;
            for($i = 1; $i<count($traslado); $i++){
                $total = $total + $traslado[$i]['cantidad'];
            }
            return $total;
        }

        public static function insertarDetalleTraslado($traslado,$id_t,$id_bo_salio){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                for($i=1; $i<count($traslado); $i++){

                    // Insertamos en la tabla material traslado
                    $pst = $conn->prepare("INSERT INTO material_traslado VALUES (?,?,?,?)");
                    $pst->execute([$traslado[$i]['cantidad'],0,$id_t,$traslado[$i]['id']]);

                    //Descontamos del inventario de la bodega que hizo el traslado
                    self::descontarInventarioTraslado($traslado[$i]['id'],$traslado[$i]['cantidad'],$traslado[0]['id_bodega'],$id_t,$id_bo_salio);

                    // Obtenemos la suma total del material en efectivos
                    $pst = $conn->prepare("SELECT SUM(total) as total FROM detalle_traslado WHERE id_t_dt = ? and id_m_dt = ?");
                    $pst->execute([$id_t,$traslado[$i]['id']]);
                    $suma = $pst->fetch();

                    //Actualizamos el campo t_material de la tabla material_traslado
                    $pst = $conn->prepare("UPDATE material_traslado set t_material = ? WHERE id_t_mt = ? and id_m_mt = ?");
                    $pst->execute([$suma['total'],$id_t,$traslado[$i]['id']]);
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function descontarInventarioTraslado($id_m,$cantidad,$id_b_llega,$id_t,$id_b_salio){
            
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $ban = true;
                $restante = $cantidad;

                //Insertamos el material en la tabla inventario con el id de la bodega a la que se traslado
                self::insertarInventarioBodegaRecibeTraslado($id_m,$cantidad,$id_b_llega,$id_b_salio);

                while($ban){

                    // Obtengo el cns min
                    $pst = $conn->prepare("SELECT MIN(cns) as cns, stock, p_compra FROM detalle_inventario WHERE dispo = 1 and id_b_di = ? and id_m_di = ?");
                    $pst->execute([$id_b_salio,$id_m]);
                    $cns = $pst->fetch();

                    if( $cns['stock'] <= $restante ){

                        $pst = $conn->prepare("UPDATE detalle_inventario set stock = 0, dispo = 0 WHERE cns = ?");
                        $pst->execute([$cns['cns']]);
                        $restante = $restante - $cns['stock'];

                        //Insertamos el detalle del traslado
                        $pst = $conn->prepare("INSERT INTO detalle_traslado (total,p_compra,cant,id_t_dt,id_m_dt) VALUES (?,?,?,?,?)");
                        $total = $cns['p_compra'] * $cns['stock']; // Precio compra * cantidad
                        $pst->execute([$total,$cns['p_compra'],$cns['stock'],$id_t,$id_m]);

                        //Insertamos en la tabla detalle inventario
                        self::insertarDetalleInventario($cns['p_compra'],$cns['stock'],$id_b_llega,$id_m);

                    }else{

                        $stock_sobra = $cns['stock'] - $restante;
                        $pst = $conn->prepare("UPDATE detalle_inventario set stock = ? WHERE cns = ?");
                        $pst->execute([$stock_sobra,$cns['cns']]);

                        //Insertamos el detelle del traslado
                        $pst = $conn->prepare("INSERT INTO detalle_traslado (total,p_compra,cant,id_t_dt,id_m_dt) VALUES (?,?,?,?,?)");
                        $total = $cns['p_compra'] * $restante; // Precio compra * cantidad
                        $pst->execute([$total,$cns['p_compra'],$restante,$id_t,$id_m]);

                        //Insertamos en la tabla detalle inventario
                        self::insertarDetalleInventario($cns['p_compra'],$restante,$id_b_llega,$id_m);

                        $restante = 0;
                    }

                    if($restante == 0){
                        $ban = false;
                    }

                }

                $pst = $conn->prepare("SELECT SUM(stock) as total FROM detalle_inventario WHERE id_b_di = ? and id_m_di = ? ");
                $pst->execute([$id_b_salio,$id_m]);
                $total = $pst->fetch();

                // Actualizamos el stock en la tabla inventario
                $pst = $conn->prepare("UPDATE inventario set s_total = ? WHERE id_b_i = ? and id_m_i = ?");
                $pst->execute([$total['total'],$id_b_salio,$id_m]);


            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        // Inserta en la tabla inventario de la bodega que recibe
        public static function insertarInventarioBodegaRecibeTraslado($id_m,$cantidad,$id_b,$id_b_salio){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                /*Verificamos si el material ya esta registrado en el inventario de la bodega
                 que lo recibira */

                $pst = $conn->prepare("SELECT * FROM inventario WHERE id_b_i = ? and id_m_i = ?");
                $pst->execute([$id_b,$id_m]);
                $datos = $pst->fetch(); 
                $filas = $pst->rowCount();


                // Si existe el material
                if($filas > 0){
                    // Sumamos el stock que la bodega ya tiene mas el que se le traslado
                    $stock_nuevo = $datos['s_total'] + $cantidad;

                    $pst = $conn->prepare("UPDATE inventario set s_total = ? WHERE id_b_i = ? and id_m_i = ?");
                    $pst->execute([$stock_nuevo,$id_b,$id_m]);
                }else{

                    //Obtenemos el stock max y min de la bodega que traslado el material
                    $pst = $conn->prepare("SELECT * FROM inventario WHERE id_b_i = ? and id_m_i = ? ");
                    $pst->execute([$id_b_salio,$id_m]);
                    $stock = $pst->fetch();

                    // Insertamos el material en el inventario de la bodega que recibe el traslado
                    $pst = $conn->prepare("INSERT INTO inventario VALUES (?,?,?,?,?)");
                    $pst->execute([$cantidad,$stock['s_min'],$stock['s_max'],$id_b,$id_m]);
                }

                $conexion->closeConexion();
                $conn = null;
                

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function insertarDetalleInventario($p_compra,$stock,$id_b,$id_m){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT * FROM detalle_inventario WHERE id_b_di = ? and id_m_di = ? and p_compra = ?");
                $pst->execute([$id_b,$id_m,$p_compra]);

                $existe = $pst->fetch();
                $filas = $pst->rowCount();

                // Si existe ya el material con ese mismo precio de compra
                if($filas > 0){
                    $total = $existe['stock'] + $stock;
                    $pst = $conn->prepare("UPDATE detalle_inventario set stock = ? WHERE cns = ?");
                    $pst->execute([$total,$existe['cns']]);
                }else{
                    $pst = $conn->prepare("INSERT INTO detalle_inventario (dispo,p_compra,stock,id_b_di,id_m_di) VALUES (?,?,?,?,?)");
                    $pst->execute([1,$p_compra,$stock,$id_b,$id_m]);
                }

                $conexion->closeConexion();
                $conn = null;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        // Devuelve el historial de solicitudes de una bodega 
        public static function getHistorialSolicitudes($id_bodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT sp.id_s as id, sp.fecha as fecha, sp.hora as hora, u.nombres as nombre, sp.status FROM solicitud_p sp, usuarios u WHERE sp.resp = u.username and sp.id_b_sp = ? ");
                $pst->execute([$id_bodega]);

                $solicitudes = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $solicitudes;
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        // Devuelve el historial de Despachos de una bodega 
        public static function getHistorialDespachos($id_bodega){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT num_orden as num,fecha,hora,n_trabajador as nombre,cedula,tel,obser FROM orden_trabajo WHERE id_b_ot = ?");
                $pst->execute([$id_bodega]);

                $Despachos = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $Despachos;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        
        // Devuelve el historial de traslados de una bodega 
        public static function getHistorialTraslados($id_bodega){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT t.id_t as id, t.fecha, t.hora, u.nombres as resp, b.nombre, t.t_materiales as cant, t.te_traslado as total
                FROM traslados t, usuarios u, bodegas b
                WHERE t.resp = u.username and t.llego_a = b.id_b and t.salio_de = ?");
                $pst->execute([$id_bodega]);

                $traslados = $pst->fetchAll();
                $conexion->closeConexion();
                $conn = null;

                return $traslados;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

    }