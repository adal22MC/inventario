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
    }