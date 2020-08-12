<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

?>

<!doctype html>
<html lang="es">

<head>
    <?php include("include/cabezera.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <?php include("include/navegacion.php") ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- TABLA HISTORIAL DESPACHOS -->
            <div class="container-fluid pt-4">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h2 class="badge badge-primary">Historial Despachos</h2>
                            </div>
                            <div class="card-header">
                                <label for="card-header">De:</label>
                                <input type="date" name="" id="Date" min="2000-01-01" max="2100-12-31">

                                <label for="card-header"> A:</label>
                                <input type="date" name="" id="Date2" min="2000-01-01" max="2100-12-31">
                                <div class='btn-group'>
                                    <button class='btn btn-danger btn-sm btnfechas'><i class='fas fa-file-pdf'></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="h_despachos" class="table table-bordered table-striped tablaModulos">
                                    <thead>
                                        <tr>
                                            <th>No Orden</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Responsable</th>
                                            <th>Cedula</th>
                                            <th>Telefono</th>
                                            <th>observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        //MaterialModelo::obtenerMateriales($_SESSION['id_bodega']);
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
            <!-- /. TABLA HISTORIAL SOLICITUDES -->

        </div>
        <!-- ends content-wrapper -->

        <?php include("include/footer.php") ?>

    </div>
    <!-- ./wrapper -->

    <?php include("include/scripts.php"); ?>
    <script src="dist/js/pages/historial_despachos.js"></script>
</body>

</html>