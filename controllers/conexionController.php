<?php

    require_once "../models/conexion.php";

    class conexionController{
        public function crearBackups(){
            $conexion = new Conexion();
            $conexion->backup_tables();
        }
    }