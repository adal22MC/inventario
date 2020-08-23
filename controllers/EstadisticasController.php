<?php   

    require_once "../models/EstadisticasModel.php";
    //session_start();

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

        public function printTotalSolicitudes(){
            $mdl = new EstadisticasModel();
            $mdl->printTotalSolicitudes($_SESSION['id_bodega']);
        }

        public function printTotalMaterialesHijas(){
            $mdl = new EstadisticasModel();
            $mdl->printTotalMaterialesHijas($_SESSION['id_bodega']);
        }

        public function printTotalTraslados(){
            $mdl = new EstadisticasModel();
            $mdl->printTotalTraslados($_SESSION['id_bodega']);
        }

        public function printTotalDespachos(){
            $mdl = new EstadisticasModel();
            $mdl->printTotalDespachos($_SESSION['id_bodega']);
        }

    }