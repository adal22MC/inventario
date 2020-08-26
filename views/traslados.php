<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

require_once "../models/MaterialModel.php";

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

            <section>
                <div class="container-fluid pt-4">
                    <div class="row">

                        <div class="col-md-5">

                            <!-- TABLE: TRASLADO -->
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 id="totalApagar" class="card-title">Lista de productos a trasladar</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="tablaSolicitud" class="table m-0 listaSolicitud">
                                            <thead>
                                                <tr>
                                                    <th>Eliminar</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer clearfix">
                                    <a href="solicitudes_p.php" class="btn btn-sm btn-danger float-left">Cancelar todo</a>
                                    <button id="procesarVenta" class="btn btn-sm btn-info float-right">Procesar traslado</button>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->

                        </div>


                        <div class="col-md-7">
                            <!-- TABLA MATERIALES -->
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <div class="input-group pt-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fab fa-cuttlefish"></i>
                                                        </span>
                                                    </div>
                                                    <select class="form-control" id="selectSucursales">
                                                        <option value="default" selected>Seleccione una Bodega</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="card-title">Lista de todos los Materiales</h2>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="tablaMateriales" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>ID Material</th>
                                                            <th>Nombre</th>
                                                            <th>Stock</th>
                                                            <th>Categoria</th>
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
                            <!-- /. TABLA PRODUCTOS -->
                        </div>

                    </div>
                </div>
            </section>

        </div>
        <!-- ends content-wrapper -->

        <?php include("include/footer.php") ?>

    </div>
    <!-- ./wrapper -->

    <?php include('include/scripts.php'); ?>
    <script src="dist/js/pages/traslados.js"></script>

</body>


</html>