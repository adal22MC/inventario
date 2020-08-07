<?php

    require_once "conexion.php";

    class SolicitudModelo {

        public static function imprimiDatosEmpresa($id_solicitud){
            echo "<h3>Los Pinos</h3>
                    <pre>
                    Pedro Ignacio
                    Joystick
                    XX101010101
                    5512 3465 78
                    FAX
                </pre>";
        }
    }