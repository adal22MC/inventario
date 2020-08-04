<?php

    require_once "conexion.php";

    class MaterialModelo {

        private static $INSERT_MATERIAL = "INSERT INTO material  values (?, ?, ?, ?)";

        private static $UPDATE_MATERIAL = "UPDATE material set id_m = ?,descr = ?, serial = ?, id_c_m = ? WHERE id_m = ?";

        private static $DELETE_MATERIAL = "DELETE FROM material WHERE id_m = ?";

        public static function obtenerMaterialesMadre(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT id_m , m.descr as nom, c.descr as des FROM material m, categorias c WHERE c.id_c = m.id_c_m");

                $pst->execute();
                $materiales = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $materiales;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

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
                            <td><div class="text-center"><div class="btn-group"><button class="btn btn-info btn-sm btnEditar"><i class="fas fa-edit"></i></button></div></div></td>
                        </tr>
                    ';

                }

                $conn = null;
                $conexion->closeConexion();

                //return $materiales;

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

                $pst = $conn->prepare(self::$UPDATE_MATERIAL);
                $pst->execute([$material['idNew'],$material['descr'],$material['serial'],$material['id_c'],$material['id']] );

                $conn = null;
                $conexion->closeConexion();

                return "OK";
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
                return "Lo sentimos, parametros no aceptados!";
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
        
    }