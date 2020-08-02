<?php

    require_once "../models/MaterialModel.php";

    /* ===========================
        AGREGAR MATERIAL
     ============================= */
     if( isset($_POST['agregarMaterial']) ){
       
        if(

            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['idM']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,_ ]+$/', $_POST['desMaterial']) &&
            preg_match('/^[()\-0-9 ]+$/', $_POST['categoria']) 

        ){
            if($_POST["serialMaterial"] != ""){
                if(!preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,_ ]+$/', $_POST['serialMaterial'])){
                    echo json_encode(['respuesta'=>'Eror en el campo serial']);
                }
            }
            
            $Material = array(
                "id" => $_POST['idM'],
                "descr" => $_POST['desMaterial'],
                "serial" => $_POST['serialMaterial'],
                "id_c" => $_POST['categoria']
            );
         
            $respuesta = MaterialModelo::agregarMaterial($Material);
            echo json_encode(['respuesta'=>$respuesta]);
          //  echo json_encode(['respuesta'=>$_POST['categoria']]);
        }else{
            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }
        
    }
    /* =========================================================
        RETORNA LA LISTA DE MATERIALES QUE TIENE LA BODEGA MADRE
     ============================================================ */
    if ( isset($_POST['obtenerMaterialesMadre']) ){

        $materiales = MaterialModelo::obtenerMaterialesMadre();
        echo json_encode($materiales);

    }
    /* =========================================================
    RETORNA LA LISTA DE MATERIALES QUE TIENE LA BODEGA MADRE CON EL CAMPO SERIAL
     ============================================================ */
     if ( isset($_POST['obtenerMateriales']) ){

        $materiales = MaterialModelo::obtenerMateriales();
        echo json_encode($materiales);

    }
    /* =========================================================
      RETORNA LA LISTA DE MATERIALES DE UNA BODEGA HIJA
     ============================================================ */
    if ( isset($_POST['getMaterialHijas']) ){
        $materiales = MaterialModelo::obtenerMaterialesHijas(13);
        echo json_encode($materiales);
    }
    /* =========================================================
      RETORNA ID DE LA CATEDORIA
     ============================================================ */
     if ( isset($_POST['IdMCategoria']) ){
        if (
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['idM'])
        ){
            $respuesta = MaterialModelo::obtenerIdCategoria($_POST['idM']);
            echo json_encode(['id'=>$respuesta[0]["id"]]);
            
        }else{
            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }

    }
    /* ===========================
        EDITAR MATERIAL
     ============================= */
     if( isset($_POST['editarMaterial']) ){
       
        if(

            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['idMaterial']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['idM']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,_ ]+$/', $_POST['desMaterial']) &&
            preg_match('/^[()\-0-9 ]+$/', $_POST['categoria']) 

        ){
            if($_POST["serialMaterial"] != ""){
                if(!preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,_ ]+$/', $_POST['serialMaterial'])){
                    echo json_encode(['respuesta'=>'Eror en el campo serial']);
                }
            }
            
            $Material = array(
                "id" => $_POST['idMaterial'],
                "idNew" => $_POST['idM'],
                "descr" => $_POST['desMaterial'],
                "serial" => $_POST['serialMaterial'],
                "id_c" => $_POST['categoria']
            );
         
            $respuesta = MaterialModelo::editarMaterial($Material);
            echo json_encode(['respuesta'=>$respuesta]);
        }else{
            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }
        
    }
     /* ===========================
        ELIMINAR CATEGORIA
     =============================*/
     if(isset($_POST['eliminarMaterial'])){
        if(
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['idMaterial'])
        ){
            $respuesta = MaterialModelo::eliminarMaterial($_POST['idMaterial']);
            echo json_encode(['respuesta'=>$respuesta]);
        }else{
            echo json_encode(['respuesta'=>'Error con el ID del material']);
        }
    }

