<?php
require_once "../models/AdminModel.php";
require_once "../config.php";

if (isset($_POST['obtenerDatosSucursal'])) {

    $data = AdminModelo::obtenerDatosSucursal();
    echo json_encode($data);
}

if (isset($_POST['editDatosMadre'])) {
    if (isset($_FILES['logo'])) {
        //Recogemos el archivo enviado por el formulario
        $archivo = $_FILES['logo']['name'];

        //Si el archivo contiene algo y es diferente de vacio
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['logo']['type'];
            //$tamano = $_FILES['logo']['size'];
            $temp = $_FILES['logo']['tmp_name'];
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!((strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")))) {
                echo json_encode(['respuesta' => 'Error. La extensión o el tamaño de los archivos no es correcta. - Se permiten archivos con extensión jpeg, jpg, y png']);
            } else { 
                copy($temp, IMG.'logo_empresa.jpeg');
                $empresa = array(
                    "nom" => $_POST['nombreS'],
                    "nit" => $_POST['nitS'],
                    "pag" => $_POST['paginaS'],
                    "direc" => $_POST['direccionS'],
                    "coreo" => $_POST['correoS'],
                    "tel" => $_POST['telefonoS'],
                );
                $data = AdminModelo::editarDatosEmpresa($empresa);
                echo json_encode(['respuesta'=>$data]);
            }
        } else {
            $empresa = array(
                "nom" => $_POST['nombreS'],
                "nit" => $_POST['nitS'],
                "pag" => $_POST['paginaS'],
                "direc" => $_POST['direccionS'],
                "coreo" => $_POST['correoS'],
                "tel" => $_POST['telefonoS'],
            );
            $data = AdminModelo::editarDatosEmpresa($empresa);
            echo json_encode(['respuesta'=>$data]);
        }
    }
}
