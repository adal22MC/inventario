<?php
  session_start();
  if (!isset($_SESSION['username']) ){
      header('Location: login.php');
  }

  require_once "../models/MaterialModel.php";

?>

<!doctype html>
<html lang="es">

<head>
    <?php include("include/cabezera.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed" 
<?php 
    if($_SESSION['tipo_usuario'] == "administrador"){
        echo 'onload="obtenerSelect()';
    } 
?>">

    <div class="wrapper">

        <?php include("include/navegacion.php") ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- TABLA MATERIAL -->
            <div class="container-fluid pt-4">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <?php
                                    if($_SESSION['tipo_usuario'] == "administrador"){
                                ?>
                                <button id="altaMaterial" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAgregarMaterial">
                                    Agregar Nuevo Material
                                </button>
                                <?php
                                    }
                                ?>
                                

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="material" class="table table-bordered table-striped tablaModulos">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Descripción</th>
                                            <th>Stock</th>
                                            <th>Stock min</th>
                                            <th>Stock max</th>
                                            <th>Categoria</th>
                                            <th>Serial</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            MaterialModelo::obtenerMateriales($_SESSION['id_bodega']);
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /. TABLA MATERIAL -->

        </div>
        <!-- ends content-wrapper -->

        <!--=====================================
        MODAL AGREGAR MATERIAL (ADMINISTRADOR)
        ======================================-->

        <div id="modalAgregarMaterial" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form id="formAddMaterial">

                        <!--=====================================
                        HEADER DEL MODAL
                        ======================================-->

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">Alta Material</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ====================================== -->

                        <div class="modal-body">

                            <!-- ENTRADA PARA EL ID DE LA MATERIAL -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="idM" placeholder="ID Material" required>
                            </div>

                            <!-- ENTRADA PARA LA DESCRIPCION DEL  MATERIAL -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="desMaterial" placeholder="Descripción" required>
                            </div>

                            <!-- ENTRADA PARA EL TIPO DE CATEGORIA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fab fa-cuttlefish"></i>
                                    </span>
                                </div>
                                <select class="form-control" name="categoria" id="selectCategoria">
                                    <option value="show" selected="selected">Seleccione una categoria</option>

                                </select>
                            </div>

                            <!-- ENTRADA PARA EL SERIAL DE MATERIAL -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="serialMaterial" placeholder="Serial (Opcional)">
                            </div>


                        </div>


                        <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                        <div class="modal-footer">
                            <button id="closeAdd" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                Guardar Material
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--=====================================
        MODAL EDITAR MATERIAL (ADMINISTRADOR)
        ======================================-->

        <div id="modalEditarMaterial" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form id="formEditMaterial">

                        <!--=====================================
                        HEADER DEL MODAL
                        ======================================-->

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">Editar Material</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ====================================== -->

                        <div class="modal-body">

                            <!-- ENTRADA PARA EL ID DE LA MATERIAL -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="idM" id ="idM" placeholder="ID Material" required>
                            </div>

                            <!-- ENTRADA PARA LA DESCRIPCION DEL MATERIAL -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="desMaterial" name="desMaterial" placeholder="Descripción" required>
                            </div>

                            <!-- ENTRADA PARA EL TIPO DE CATEGORIA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fab fa-cuttlefish"></i>
                                    </span>
                                </div>
                                <select class="form-control" name="categoria" id="selectEditCategoria">

                                </select>
                            </div>
                            
                            <!-- ENTRADA PARA DEL SERIAL DE MATERIAL -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="SerialMaterial" name="serialMaterial" placeholder="Serial (Opcional)">
                            </div>
                        </div>


                        <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                        <div class="modal-footer">
                            <button id="closeEdit" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--=====================================
        MODAL EDITAR MATERIAL (UNIDAD)
        ======================================-->

        <div id="modalEditMaterialUnidad" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form id="formEditMaterialUnidad">

                        <!--=====================================
                        HEADER DEL MODAL
                        ======================================-->

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">Editar Material</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ====================================== -->

                        <div class="modal-body">

                            <!-- ENTRADA PARA EL STOCK MIN -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="s_min" name="s_min" required>
                                <small class="form-text text-muted btn-block">Stock minimo</small>
                            </div>

                            <!-- ENTRADA PARA EL STOCK MAX -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="s_max" name="s_max" required>
                                <small class="form-text text-muted btn-block">Stock maximo</small>
                            </div>

                        </div>


                        <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                        <div class="modal-footer">
                            <button id="closeEdit" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>





        <?php include("include/footer.php") ?>

    </div>
    <!-- ./wrapper -->

    <?php include("include/scripts.php"); 
        if($_SESSION['tipo_usuario'] == "administrador"){
            echo '<script src="dist/js/pages/material.js"></script>';
        }else{
            echo '<script src="dist/js/pages/material_unidad.js"></script>';
        }
    ?>

</body>

</html>