<?php

    require_once "conexion.php";

    class MaterialModelo {

        private static $INSERT_MATERIAL = "INSERT INTO material  values (?, ?, ?, ?)";

        private static $UPDATE_MATERIAL = "UPDATE material set id_m = ?,descr = ?, serial = ?, id_c_m = ? WHERE id_m = ?";

        private static $DELETE_MATERIAL = "DELETE FROM material WHERE id_m = ?";

        // Imprime directamente
        public static function getMaterialesHija($id_bodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT id_m , m.descr as nom, c.descr as des, i.s_total, i.s_max, i.s_min FROM material m, categorias c, inventario i WHERE c.id_c = m.id_c_m and i.id_m_i = m.id_m and i.id_b_i = ?");

                $pst->execute([$id_bodega]);
                $materiales = $pst->fetchAll();

                foreach($materiales as $material){
                    echo '
                        <tr>
                            <td>'.$material['id_m'].'</td>
                            <td><div class="text-center"><div class="btn-group"><button class="btn btn-info btn-sm btnAgregarASolicitud"><i class="fas fa-reply"></i></button></div></div></td>
                            <td>'.$material['nom'].'</td>';
                    
                    if($material['s_total'] == $material['s_max']){
                       echo '<td class="text-center">
                                <button class="btn btn-sm btn-success btnStock">'.$material['s_total'].'</button>
                            </td>';
                    }else if($material['s_total'] > $material['s_min']){
                        echo '<td class="text-center">
                                <button class="btn btn-sm btn-info btnStock">'.$material['s_total'].'</button>
                            </td>';
                    }else{
                        echo '<td class="text-center">
                                <button value="122" class="btn btn-sm btn-danger btnStock">'.$material['s_total'].'</button>
                            </td>';
                    }

                    echo '
                            <td class="text-center">
                                <button class="btn btn-sm btn-success">'.$material['s_max'].'</button>
                            </td>
                            <td>'.$material['des'].'</td>
                        </tr>
                    ';
                }

                $conn = null;
                $conexion->closeConexion();

                return $materiales;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* Retorna id material, nombre, stock, categoria */
        public static function obtenerMaterialesHijas($idBodegaHja){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT  i.id_m_i as id, m.descr as nombre,i.s_total as stock, c.descr as categoria
                FROM  material m, categorias c, inventario i
                WHERE m.id_c_m = c.id_c and i.id_m_i = m.id_m and i.id_b_i = ?");

                $pst->execute([$idBodegaHja]);
                $materiales = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $materiales;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* =======================================================================
            RETORNA ID MATERIAL, NOMBRE MATERIAL, STOCK, STOCK_MAX ,CATEGORIA
         ========================================================================= */
        public static function getMateriales($idBodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT  i.id_m_i as id, m.descr as nombre,i.s_total as stock, i.s_max, c.descr as categoria,i.s_min
                FROM  material m, categorias c, inventario i
                WHERE m.id_c_m = c.id_c and i.id_m_i = m.id_m and i.id_b_i = ?");

                $pst->execute([$idBodega]);
                $materiales = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $materiales;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* Retorna id material, nombre, stock, s_max, s_min, categoria */
        public static function obtenerMaterialesHijas_solicitud($id_bodega, $id_material){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT id_m , m.descr as nom, c.descr as des, i.s_total, i.s_max, i.s_min FROM material m, categorias c, inventario i WHERE c.id_c = m.id_c_m and i.id_m_i = m.id_m and i.id_b_i = ? and i.id_m_i = ?");

                $pst->execute([$id_bodega, $id_material]);
                $materiales = $pst->fetch();

                $conn = null;
                $conexion->closeConexion();

                return $materiales;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function obtenerMateriales($id_bodega){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT m.serial,i.s_total, i.s_min, i.s_max, m.id_m , m.descr as nom, c.descr as des, serial FROM material m, categorias c, inventario i WHERE c.id_c = m.id_c_m and i.id_m_i = m.id_m and i.id_b_i = ?");

                $pst->execute([$id_bodega]);
                $materiales = $pst->fetchAll();

                foreach($materiales as $material){
                    echo '
                        <tr>
                            <td>'.$material['id_m'].'</td>
                            <td>'.$material['nom'].'</td>
                        ';

                        if($material['s_total'] <= $material['s_min']){
                            echo '<td class="text-center">
                                    <button class="btn btn-sm btn-danger">'.$material['s_total'].'</button>  
                                  </td>';
                        }else if($material['s_total'] == $material['s_max']){
                            echo '<td class="text-center">
                                    <button class="btn btn-sm btn-success">'.$material['s_total'].'</button>  
                                  </td>';
                        }else{
                            echo '<td class="text-center">
                                    <button class="btn btn-sm btn-info">'.$material['s_total'].'</button>  
                                  </td>';
                        }

                    echo '
                            <td>'.$material['s_min'].'</td>
                            <td>'.$material['s_max'].'</td>
                            <td>'.$material['des'].'</td>
                            <td>'.$material['serial'].'</td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group">
                                        <button title="Reporte Individual" class="btn btn-danger btn-sm btnMaterialU"><i class="fas fa-file-pdf"></i></button>
                    ';

                    if($_SESSION['tipo_usuario'] == "Administrador"){
                        echo '
                        
                                        <button class="btn   btn-info btn-sm btnEditar"><i class="fas fa-edit"></i></button>
                                        <button title="Historial de Precios" class="btn btn-danger btn-sm btnMaterialP"><i class="fas fa-tags"></i></button>
                              
                        ';
                    }
                    

                    echo '          </div>
                                </div>
                            </td>
                        </tr>';

                }

                $conn = null;
                $conexion->closeConexion();

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function agregarMaterial($material){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$INSERT_MATERIAL);

                $pst->execute([$material['id'], $material['descr'], $material['serial'], $material['id_c']]);

                
                // Obtnemos todas las bodegas
                $pst = $conn->prepare("SELECT * FROM bodegas");
                $pst->execute();
                $bodegas = $pst->fetchAll();

                foreach($bodegas as $bo){
                    $pst = $conn->prepare("INSERT INTO inventario VALUES (0,?,?,?,?)");
                    $pst->execute([$material['s_min'],$material['s_max'],$bo['id_b'],$material['id']]);
                }

                $conn = null;
                $conexion->closeConexion();

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function obtenerIdCategoria($material){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT id_c_m as id FROM material  WHERE id_m = ?");

                $pst->execute([$material]);
                $materiales = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $materiales;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function editarMaterial($material){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();


                $respuesta = self::modificarStock($material['s_min'],$material['s_max'],$_SESSION['id_bodega'],$material['id']);
                if($respuesta == "OK"){

                    $pst = $conn->prepare("UPDATE inventario set s_max = ?, s_min = ? WHERE id_b_i = ? and id_m_i = ?");
                    $pst->execute([$material['s_max'],$material['s_min'],$_SESSION['id_bodega'],$material['idNew']]);

                    $pst = $conn->prepare(self::$UPDATE_MATERIAL);
                    $pst->execute([$material['idNew'],$material['descr'],$material['serial'],$material['id_c'],$material['id']] );

                    $conn = null;
                    $conexion->closeConexion();

                    return "OK";

                }else{
                    return $respuesta;
                }
            } catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function eliminarMaterial($id){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$DELETE_MATERIAL);

                $pst->execute([$id]);

                $conn = null;
                $conexion->closeConexion();

                return "OK";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        /* ============================================================
            MODIFICA EL STOCK MIN Y MAX DE UNA SUCURSAL EN UN MATERIAL
          ============================================================= */
        public static function modificarStock($s_min, $s_max, $id_b, $id_m){
            try {

                if($s_max > $s_min && $s_max > 0 && $s_min > 0){
                
                    $conexion = new Conexion();
                    $conn = $conexion->getConexion();

                    // Validamos que el stock maximo sea igual o mayor al stock disponible
                    $ban = self::validarParametrosStock($id_m,$id_b,$s_max);
                    
                    if(!$ban){
                        return "El Stock maximo no puede ser menor al Stock";
                    }

                    $pst = $conn->prepare("UPDATE inventario set s_min = ?, s_max = ? WHERE id_b_i = ? and id_m_i = ?");

                    $pst->execute([$s_min,$s_max,$id_b,$id_m]);
                    
                    $conn = null;
                    $conexion->closeConexion();

                    return "OK";
                }
                return "Lo sentimos, parametros de stock no aceptados!";
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function validarParametrosStock($id_m,$id_b,$s_max){
            try {
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT s_total FROM inventario WHERE id_b_i = ? and id_m_i = ?");

                $pst->execute([$id_b,$id_m]);

                $datos = $pst->fetch();
                
                if(! ($s_max >= $datos['s_total']) ){
                    return false;
                }

                $conn = null;
                $conexion->closeConexion();

                return true;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function insertarSolicitudMaterial($solicitud, $id_b){
            try{

                /**
                 * Estatus
                 * 1 -> pendiente
                 * 2 -> ya aceptada
                 */

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                // Insertamos en la tabla solicitud_p
                $pst = $conn->prepare("INSERT INTO solicitud_p (resp,status,id_b_sp) VALUES (?,?,?)");
                $pst->execute([$_SESSION['username'],1,$id_b]);

                // Obtenemos el id de la soliciitud que acabamos de insertar
                $pst = $conn->prepare("SELECT MAX(id_s) as id_s FROM solicitud_p");
                $pst->execute();
                $id_s = $pst->fetch();
                
                self::insertarDetalleSolicitud($solicitud, $id_s['id_s']);

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function insertarDetalleSolicitud($solicitud, $id_s){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                foreach($solicitud as $item){
                    $pst = $conn->prepare("INSERT INTO detalle_solicitud (id_s_ds,id_m_ds,cant) VALUES (?,?,?)");
                    $pst->execute([$id_s,$item['id_material'],$item['cantidad']]);
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
         /* ============================================================
            REPORTE DE STOCK BAJO DE MATERIAL DE UNA SUCURSAL 
          ============================================================= */
        public static function imprimirDatosUsuario($user){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT nombres, apellidos
                FROM usuarios 
                WHERE username =?");
                $pst->execute([$user]);

                $usuario = $pst->fetchAll();

                foreach($usuario as $u){
                    echo"
                        <td><strong>Realizado por:</strong> " . $u['nombres'] . " " . $u['apellidos'] . "</td>
                        ";
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function imprimiDatosTabla($id_bodega){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT m.id_m as id, m.descr as nombre, c.descr as categoria, i.s_total as stock,  i.s_min as mini
                FROM inventario i, material m, categorias c
                WHERE i.id_m_i = m.id_m and m.id_c_m = c.id_c  and i.s_total <= i.s_min and i.id_b_i = ?");
                $pst->execute([$id_bodega]);

                $material = $pst->fetchAll();

                foreach($material  as $ma){
                    echo '
                    <tr>
                        <th scope="row">'.$ma["id"].'</th>
                        <td align="center">'.$ma["nombre"].'</td>
                        <td align="center">'.$ma["categoria"].'</td>
                        <td align="center">'.$ma["mini"].'</td>
                        <td align="center">'.$ma["stock"].'</td>
                    </tr>';
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function imprimirDatosMateriales($id_bodega){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT m.id_m as id, m.descr as nombre, c.descr as categoria, i.s_total as stock
                FROM inventario i, material m, categorias c
                WHERE i.id_m_i = m.id_m and m.id_c_m = c.id_c and i.id_b_i = ?");
                $pst->execute([$id_bodega]);

                $material = $pst->fetchAll();

                foreach($material  as $ma){
                    echo '
                    <tr>
                        <th scope="row">'.$ma["id"].'</th>
                        <td align="center">'.$ma["nombre"].'</td>
                        <td align="center">'.$ma["categoria"].'</td>
                        <td align="center">'.$ma["stock"].'</td>
                    </tr>';
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function getIdMaterialB($id_bodega){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT id_m as id
                FROM material m, inventario i
                WHERE i.id_m_i = m.id_m and i.id_b_i = ?");
                $pst->execute([$id_bodega]);

                $material = $pst->fetchAll();
              
                $conexion->closeConexion();
                $conn = null;

                return $material;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function imprimirDatosM($id_m,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT m.descr, i.s_total
                FROM material m, inventario i
                WHERE i.id_m_i = m.id_m and i.id_b_i = ? and m.id_m = ?");
                $pst->execute([$id_b, $id_m]);

                $material = $pst->fetchAll();

                foreach($material as $m){
                    echo"
                        <td><strong>Codigo:</strong> " . $id_m . " </td>
                        <td><strong>Material:</strong> " . $m['descr'] . " </td>
                        <td><strong>Stock:</strong> " . $m['s_total'] . " </td>
                        ";
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function imprimirDetalleMateriales($id_m,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT di.fecha, di.stock, di.p_compra, di.stock * di.p_compra AS total
                FROM inventario i, detalle_inventario di
                WHERE di.id_b_di = i.id_b_i and di.id_m_di = i.id_m_i and di.dispo = 1 and i.id_b_i = ? and i.id_m_i = ?");
                $pst->execute([$id_b,$id_m]);

                $material = $pst->fetchAll();
                $curr='COP';
                foreach($material  as $ma){
                    $currencies['COP'] = array(0, '.', '.');

                    $pre = number_format($ma["p_compra"], ...$currencies[$curr]);
                    $to = number_format($ma["total"], ...$currencies[$curr]);
                    echo '
                    <tr>
                        <td align="center">'.$ma["fecha"].'</td>
                        <td align="center">'.$pre.'</td>
                        <td align="center">'.$ma["stock"].'</td>
                        <td align="center">'.$to.'</td>
                    </tr>';
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function imprimirDatosSuma($id_m,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT SUM(stock * p_compra) AS total
                FROM detalle_inventario di
                WHERE id_b_di = ? and id_m_di = ?");
                $pst->execute([$id_b,$id_m]);
    
                $material = $pst->fetchAll();
                $curr='COP';
                foreach ($material as $ma) {
                    $currencies['COP'] = array(0, '.', '.');
                    $to = number_format($ma["total"], ...$currencies[$curr]);
                    echo '
                    <td colspan="2"></td>
                    <td align="right" >TOTAL: </td>
                    <td align="center" class="gray">
                      <h3 style="margin: 0px 0px;">'.$to.'</h3>
                    </td>';
                        
                }
                $conexion->closeConexion();
                $conn = null;
    
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function getSucursales(){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT id_b AS id, nombre FROM bodegas WHERE tipo = 0");
                $pst->execute();
                $sucursal = $pst->fetchAll();

                $conexion->closeConexion();
                $conn = null;

                return $sucursal;
            } catch (PDOException $e) {
               return $e->getMessage();
            }
        }
        public static function imprimirDatosSucursal($id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT nombre
                FROM bodegas 
                WHERE id_b =?");
                $pst->execute([$id_b]);

                $sucursal = $pst->fetchAll();

                foreach($sucursal as $su){
                    echo"
                        <td><strong>Sucursal:</strong> " . $su['nombre'] . "</td>
                        ";
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function imprimirHistorialMaterial($id_m,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT di.fecha, di.p_compra
                FROM inventario i, detalle_inventario di
                WHERE di.id_b_di = i.id_b_i and di.id_m_di = i.id_m_i and i.id_b_i = ? and i.id_m_i = ?");
                $pst->execute([$id_b,$id_m]);

                $material = $pst->fetchAll();

                foreach($material  as $ma){
                    echo '
                    <tr>
                        <td align="center">'.$ma["fecha"].'</td>
                        <td align="center">'.$ma["p_compra"].'</td>
                    </tr>';
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function imprimirDatosMH($id_m,$id_b){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT m.descr
                FROM material m, inventario i
                WHERE i.id_m_i = m.id_m and i.id_b_i = ? and m.id_m = ?");
                $pst->execute([$id_b, $id_m]);

                $material = $pst->fetchAll();

                foreach($material as $m){
                    echo"
                        <td><strong>Codigo:</strong> " . $id_m . " </td>
                        <td><strong>Material:</strong> " . $m['descr'] . " </td>
                        ";
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }