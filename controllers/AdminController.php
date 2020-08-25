<?php
    require_once "../models/AdminModel.php";

    if(isset($_POST['obtenerDatosSucursal'])){

        $data = AdminModelo::obtenerDatosSucursal();
        echo json_encode($data);
    }

    if(isset($_POST['editDatosMadre'])){
        /*
        if (isset($_POST['logo'])) {
            //Recogemos el archivo enviado por el formulario
            $archivo = $_FILES['file']['name'];
            //Si el archivo contiene algo y es diferente de vacio
            if (isset($archivo) && $archivo != "") {
               //Obtenemos algunos datos necesarios sobre el archivo
               $tipo = $_FILES['file']['type'];
               $tamano = $_FILES['file']['size'];
               $temp = $_FILES['file']['tmp_name'];
               //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
              if (!((strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
                 echo json_encode(['respuesta'=>'Error. La extensión o el tamaño de los archivos no es correcta. - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.']);
              }
              else {
                 //Si la imagen es correcta en tamaño y tipo
                 //Se intenta subir al servidor
                 
                 if (move_uploaded_file($temp, 'images/'.$archivo)) {
                     //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                     chmod('images/'.$archivo, 0777);
                     //Mostramos el mensaje de que se ha subido co éxito
                     echo json_encode(["respuesta"=>"Se ha subido correctamente la imagen."]);
                     //Mostramos la imagen subida
                     //echo '<p><img src="images/'.$archivo.'"></p>';
                 }
                 else {
                    //Si no se ha podido subir la imagen, mostramos un mensaje de error
                    echo json_encode(['respuesta'=>'Ocurrió algún error al subir el fichero. No pudo guardarse.']);
                 }
                 
                echo json_encode(['respuesta'=>'OK']);
               }
            }
         }
         */

         
        /*
         if(

            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['nombreS']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['nitS']) &&
            preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $_POST['paginaS']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_.,# ]+$/', $_POST['direccionS']) &&
            preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $_POST['correoS']) &&
            preg_match('/^[()\-0-9 ]+$/', $_POST['telefonoS']) 

        ){
            */
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
            /*
        }else{
            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }
        */
        
    }