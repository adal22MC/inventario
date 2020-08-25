<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

if (!($_SESSION['tipo_usuario'] == "Administrador")) {
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('include/cabezera.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <?php include('include/navegacion.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- TABLA MATERIALES BODEGAS HIJAS -->
            <div class="container-fluid pt-4">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <!-- ENTRADA PARA LA BODEGA -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-hotel"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" id="selectBodega">
                                        <option value="default">Selecciona una bodega</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="bodega" class="table table-bordered table-striped tablaModulos">
                                    <thead>
                                        <tr>
                                            <th>No. Material</th>
                                            <th>Descripción</th>
                                            <th>Categoria</th>
                                            <th>Stock</th>
                                            <th>Stock Max</th>
                                            <th>Stock Min</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
            <!-- /. TABLA BODEGA -->

        </div>
        <!-- ends content-wrapper -->

        <!--=====================================
        MODAL EDITAR BODEGA 
        ======================================-->

        <div id="modalEditarMaterial" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form id="formEdit">

                        <!--=====================================
                        HEADER DEL MODAL
                        ======================================-->

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">Editar Material</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeEsquina">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ====================================== -->

                        <div class="modal-body">

                            <!-- ENTRADA PARA EL STOCK MAXIMO -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" id="s_max" name="s_max" placeholder="Stock Maximo" required>
                            </div>

                            <!-- ENTRADA PARA EL STOCK MINIMO -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" id="s_min" name="s_min" placeholder="Stock Maximo" required>
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

    <?php include('include/scripts.php'); ?>
    <script src="dist/js/pages/config_stock_hijas.js"></script>

</body>


</html>