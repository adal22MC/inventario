<?php

    require_once "conexion.php";

    class AdminModelo{

        public static function obtenerDatosSucursal(){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("SELECT nombre, correo, tel, direccion, nit, pagina FROM empresa where id = 1");

                $pst ->execute();
                
                $datosS = $pst->fetchAll();

                $conn = null;
                $conexion->closeConexion();

                return $datosS;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        public static function editarDatosEmpresa($empresa){
            try {
                $conexion = new Conexion();
                $conn = $conexion->getConexion();

                $pst = $conn->prepare("UPDATE empresa set nombre = ?,correo = ?, tel = ?, direccion = ?, nit = ?, pagina = ? where id = 1");
                $pst->execute([$empresa['nom'],$empresa['coreo'],$empresa['tel'],$empresa['direc'],$empresa['nit'],$empresa['pag']] );              

                $conn = null;
                $conexion->closeConexion();

                return "OK";
            } catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }