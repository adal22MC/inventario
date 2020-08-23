<?php

    require "conexion.php";

    class EstadisticasModel {

        public function printTotalOrdenesCompra(){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT COUNT(*) AS total FROM orden_compra");
                $pst->execute();
                $total = $pst->fetch();
                echo $total['total'];

                $conexion->closeConexion();
                $conn = null;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function printTotalMateriales(){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT COUNT(*) AS total FROM material");
                $pst->execute();
                $total = $pst->fetch();
                echo $total['total'];

                $conexion->closeConexion();
                $conn = null;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function printTotalUsuarios(){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT COUNT(*) AS total FROM usuarios");
                $pst->execute();
                $total = $pst->fetch();
                echo $total['total'];

                $conexion->closeConexion();
                $conn = null;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function printTotalCategorias(){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT COUNT(*) AS total FROM categorias");
                $pst->execute();
                $total = $pst->fetch();
                echo $total['total'];

                $conexion->closeConexion();
                $conn = null;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }