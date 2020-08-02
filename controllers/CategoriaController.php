<?php

    require_once "../models/CategoriaModel.php";

    /* ===========================
        AGREGAR CATEGORIA
     =============================*/
     if( isset($_POST['agregarCategoria']) ){

        if(
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['desCategoria'])
        ){

            $respuesta = CategoriaModelo::agregarCategoria($_POST['desCategoria']);
            echo json_encode(['respuesta'=>$respuesta]);

        }else{

            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }
     }

     /* ===========================
        EDITAR CATEGORIA
     =============================*/
     if(isset($_POST['editarCategoria'])){

        if(
            preg_match('/^[()\-0-9 ]+$/', $_POST['idCategoria']) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_ ]+$/', $_POST['desCategoria'])
        ){
            $categoria = array(
                "id" => $_POST['idCategoria'],
                "descr" => $_POST['desCategoria']
            );

            $respuesta = CategoriaModelo::editarCategoria($categoria);
            echo json_encode(['respuesta'=>$respuesta]);

        }else{

            echo json_encode(['respuesta'=>'Error en caracteres.']);
        }
    }

    /* ===========================
        DEVUELVE TODAS LAS CATEGORIAS
     =============================*/
     if(isset($_POST['obtenerCategorias'])){

        $data = CategoriaModelo::obtenerCategorias();
        echo json_encode($data);
    }

    /* ===========================
        ELIMINAR CATEGORIA
     =============================*/
     if(isset($_POST['eliminarCategoria'])){
        if(
            preg_match('/^[()\-0-9 ]+$/', $_POST['idCategoria'])
        ){
            $respuesta = CategoriaModelo::eliminarCategoria($_POST['idCategoria']);
            echo json_encode(['respuesta'=>$respuesta]);
        }else{
            echo json_encode(['respuesta'=>'Error con el ID de la categoria']);
        }
    }
