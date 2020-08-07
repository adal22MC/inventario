<?php
  session_start();
  if (!isset($_SESSION['username']) ){
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

            <!-- TABLA HISTORIAL SOLICITUDES -->
            <div class="container-fluid pt-4">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h2 class="badge badge-primary">Historial Solicitudes</h2>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="h_solicitudes" class="table table-bordered table-striped tablaModulos">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Responsable</th>
                                            <th>Estatus</th>
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
    <script src="dist/js/pages/historial_solicitudes.js"></script>
</body>

</html>