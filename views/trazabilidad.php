<?php
session_start();
if (!isset($_SESSION['username'])) {
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

            <section>
                <div class="container-fluid pt-4">
                    <div class="row container-fluid">
                        <div class="col-md-6">
                            <!-- ENTRADA PARA SELECCIONAR EL USUARIO -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fab fa-cuttlefish"></i>
                                    </span>
                                </div>
                                <select class="form-control" name="selectSucursal" id="selectSucursal">
                                    <option value="default">Selecciona una Bodega</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- ENTRADA PARA EL RANGO DE FECHAS -->
                            <div class="input-group pb-3">
                                <label class="mr-2">De:</label>
                                <input type="date" name="" id="Date" min="2000-01-01" max="2100-12-31">

                                <label class="mr-2 ml-3">A:</label>
                                <input type="date" name="" id="Date2" min="2000-01-01" max="2100-12-31">
                            </div>
                        </div>
                    </div>
                    <!-- TABLA SUCURSALES -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="card-title">Materiales</h2>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="tablaMaterialesH" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Material</th>
                                                    <th>Serial</th>
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
            </section>

        </div>
        <!-- ends content-wrapper -->


        <?php include("include/footer.php") ?>

    </div>
    <!-- ./wrapper -->

    <?php include('include/scripts.php'); ?>
    <script src="dist/js/pages/trazabilidad.js"></script>

</body>


</html>