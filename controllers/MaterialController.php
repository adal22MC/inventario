<?php

    require_once "../models/MaterialModel.php";
    session_start();

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
      RETORNA LA LISTA DE MATERIALES DE UNA BODEGA HIJA
     ============================================================ */
    if ( isset($_POST['getMaterialHijas']) ){
        $materiales = MaterialModelo::obtenerMaterialesHijas($_SESSION['id_bodega']);
        echo json_encode($materiales);
    }

    /* ===============================================================
        Retorna id material, nombre, stock, s_max, s_min, categoria
        Unicamente bodegas hijas (Recibe el id de la bodega)
     =================================================================*/
    if( isset($_POST['getMaterialBodegaHija_solicitud'])){
        $materiales = MaterialModelo::obtenerMaterialesHijas_solicitud($_SESSION['id_bodega'], $_POST['id_material']);
        echo json_encode($materiales);
    }

    /* =========================================================
      RETORNA ID DE LA CATEGORIA
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
        ELIMINAR MATERIAL
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

    /* ========================================================
        MODIFICA EL STOCK MINIMO Y MAXIMO DE UN MATERIAL DE LAS
        BODEGAS HIJAS
     ==========================================================*/
     if( isset($_POST['modificarStock'])){
        if(
            preg_match('/^[()\-0-9 ]+$/', $_POST['s_min']) &&
            preg_match('/^[()\-0-9 ]+$/', $_POST['s_max'])
        ){
            $respuesta = MaterialModelo::modificarStock($_POST['s_min'],$_POST['s_max'], $_SESSION['id_bodega'], $_POST['idMaterial']);
            echo json_encode(['respuesta'=>$respuesta]);
        }else{
            echo json_encode(['respuesta'=>'Caracteres no admitidos']);
        }
     }

     /* ================================================================
        GENERA LA SOLICITUD DE MATERIALES QUE HACENS LAS BODEGAS HIJAS
        (RECIBE JSON DE SOLICITUD)
     ====================================================================*/
     if( isset($_POST['generarSolicitud'])){

        $solicitud = $_POST['generarSolicitud'];
        $respuesta = MaterialModelo::insertarSolicitudMaterial($solicitud,$_SESSION['id_bodega']);

        echo json_encode(['respuesta'=>$respuesta]);
    }

    /* =======================================================================
        RETORNA ID MATERIAL, NOMBRE MATERIAL, STOCK, STOCK_MAX ,CATEGORIA
    ========================================================================= */
    if( isset($_POST['getMateriales'])){
        $respuesta = MaterialModelo::getMateriales($_SESSION['id_bodega']);
        echo json_encode($respuesta);
    }

