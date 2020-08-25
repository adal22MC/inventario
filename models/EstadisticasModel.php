<?php

    require_once "conexion.php";

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

        public function printTotalBodegas(){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT COUNT(*) AS total FROM bodegas WHERE tipo = 0");
                $pst->execute();
                $total = $pst->fetch();
                echo $total['total'];

                $conexion->closeConexion();
                $conn = null;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function printTotalSolicitudes($id_bodega){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                
                $pst = $conn->prepare("SELECT COUNT(id_s) AS total FROM solicitud_p WHERE id_b_sp = ?");
                $pst->execute([$id_bodega]);
                $total = $pst->fetch();
                echo $total['total'];

                $conexion->closeConexion();
                $conn = null;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function printTotalMaterialesHijas($id_bodega){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                
                $pst = $conn->prepare("SELECT COUNT(*) AS total FROM inventario WHERE id_b_i = ?");
                $pst->execute([$id_bodega]);
                $total = $pst->fetch();
                echo $total['total'];

                $conexion->closeConexion();
                $conn = null;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function printTotalTraslados($id_bodega){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                
                $pst = $conn->prepare("SELECT COUNT(*) AS total FROM traslados WHERE salio_de = ?");
                $pst->execute([$id_bodega]);
                $total = $pst->fetch();
                echo $total['total'];

                $conexion->closeConexion();
                $conn = null;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function printTotalDespachos($id_bodega){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                
                $pst = $conn->prepare("SELECT COUNT(*) AS total FROM orden_trabajo WHERE id_b_ot = ?");
                $pst->execute([$id_bodega]);
                $total = $pst->fetch();
                echo $total['total'];

                $conexion->closeConexion();
                $conn = null;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        /* Retorno el total de solicitudes pendientes que tienes la madre */
        public function printTotalSolicitudes_madre(){
            try{
                $conexion = new Conexion();
                $conn = $conexion->getConexion();
                
                $pst = $conn->prepare("SELECT COUNT(*) AS total FROM solicitud_p WHERE status = 1");
                $pst->execute();
                $total = $pst->fetch();

                $conexion->closeConexion();
                $conn = null;

                return $total['total'];
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }