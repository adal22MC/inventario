<?php

    require_once "conexion.php";

    class BodegaModelo {

        private static $INSERT_BODEGA = "INSERT INTO bodegas (correo,tel,nombre,username,pass) values (?, ?, ?, ?, ?)";

        private static $SELECT_ALL = "SELECT id_b,f_creacion,nombre,correo,tel FROM bodegas";

        private static $UPDATE = "UPDATE bodegas set nombre=?,correo=?,tel=?,username=?,pass=? WHERE id_b = ?";

        private static $DELETE = "DELETE FROM bodegas WHERE id_b = ?";

        public static function agregarMaterial($bodega){
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
    }