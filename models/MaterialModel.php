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

        public static function obtenerMateriales(){
            try{

                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT id_m , m.descr as nom, c.descr as des, serial FROM material m, categorias c WHERE c.id_c = m.id_c_m");

                $pst->execute();
                $materiales = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $materiales;

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
        
    }