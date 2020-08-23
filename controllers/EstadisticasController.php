<?php   

    require_once "../models/EstadisticasModel.php";

    class EstadisticasControlles {

        public function printTotalOrdenesCompra(){
            $mdl = new EstadisticasModel();
            $mdl->printTotalOrdenesCompra();
        }

        public function printTotalMateriales(){
            $mdl = new EstadisticasModel();
            $mdl->printTotalMateriales();
        }

        public function printTotalUsuarios(){
            $mdl = new EstadisticasModel();
            $mdl->printTotalUsuarios();
        }

        public function printTotalCategorias(){
            $mdl = new EstadisticasModel();
            $mdl->printTotalCategorias();
        }

    }