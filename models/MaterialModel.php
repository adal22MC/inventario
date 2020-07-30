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
    }