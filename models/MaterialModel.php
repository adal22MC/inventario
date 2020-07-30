<?php

    require_once "conexion.php";

    class MaterialModelo {

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
    }