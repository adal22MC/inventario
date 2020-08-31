<?php

    require_once "conexion.php";

    class CategoriaModelo {

        private static $INSERT_CATEGORIA = "INSERT INTO categorias (descr) values (?)";

        private static $SELECT_ALL = "SELECT * FROM categorias";

        private static $UPDATE = "UPDATE categorias set descr = ? WHERE id_c = ?";

        private static $DELETE = "DELETE FROM categorias WHERE id_c = ?";

        public static function agregarCategoria($categoria){
            try{
                
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$INSERT_CATEGORIA);
                
                $pst->execute([$categoria]);

                $conn = null;
                $conexion->closeConexion();

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function eliminarCategoria($id){
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

        public static function editarCategoria($categoria){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$UPDATE);

                $pst->execute([$categoria['descr'], $categoria['id']]);

                $conn = null;
                $conexion->closeConexion();

                return "OK";

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public static function obtenerCategorias(){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare(self::$SELECT_ALL);

                $pst ->execute();
                
                $categoria = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $categoria;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function evaluarTM($id){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT id_c_m AS id FROM material WHERE id_c_m = ?");

                $pst->execute([$id]);
                $material = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $material;

            } catch(PDOException $e){
                return $e->getMessage();
            }
        }
        public static function imprimirDatosU($user,$id){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                $pst = $conn->prepare("SELECT descr
                FROM categorias 
                WHERE id_c =?");
                $pst->execute([$id]);

                $categoria = $pst->fetch();
                $pst = $conn->prepare("SELECT nombres, apellidos
                FROM usuarios 
                WHERE username =?");
                $pst->execute([$user]);

                $usuario = $pst->fetchAll();

                foreach($usuario as $u){
                    echo"
                        <td><strong>Realizado por:</strong> " . $u['nombres'] . " " . $u['apellidos'] . "</td>
                        <td><strong>Categoria: </strong>" . $categoria['descr'] . "</td>
                        ";
                }
                $conexion->closeConexion();
                $conn = null;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function getIdMaterialBC($id_bodega,$id_c){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT id_m as id
                FROM material m, inventario i,categorias c
                WHERE i.id_m_i = m.id_m and m.id_c_m = c.id_c and c.id_c = ? and i.id_b_i = ?");
                $pst->execute([$id_c,$id_bodega]);

                $material = $pst->fetchAll();
              
                $conexion->closeConexion();
                $conn = null;

                return $material;

            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function imprimirDatosMaterialesC($id_bodega,$id_c){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT m.id_m as id, m.descr as nombre, c.descr as categoria, i.s_total as stock
                FROM inventario i, material m, categorias c
                WHERE i.id_m_i = m.id_m and m.id_c_m = c.id_c and c.id_c = ? and i.id_b_i = ?");
                $pst->execute([$id_c,$id_bodega]);

                $material = $pst->fetchAll();
                $stock = 0;
                foreach($material  as $ma){
                    $stock += $ma["stock"];
                    echo '
                    <tr>
                        <th scope="row">'.$ma["id"].'</th>
                        <td align="center">'.$ma["nombre"].'</td>
                        <td align="center">'.$ma["categoria"].'</td>
                        <td align="center">'.$ma["stock"].'</td>
                    </tr>';
                }
                $total = array("cant" => $stock);
                $conexion->closeConexion();
                $conn = null;
                return $total;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }