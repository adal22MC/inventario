<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

if ($_SESSION['tipo_usuario'] == "Administrador" ||
      $_SESSION['tipo_usuario'] == "Almacenista Principal"){
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

            <!-- TABLA SOLICITUDES PENDIENTES -->
            <div class="container-fluid pt-4">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h2 class="badge badge-primary">Solicitudes Pendientes</h2>
                            </div>
                            <div class="card-header">
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fab fa-cuttlefish"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" name="categoria" id="selectSolicitud">
                                        <option value="default" >Seleccione un número de solicitud</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="table_ordenes" class="table table-bordered table-striped tablaModulos">
                                    <thead>
                                        <tr>
                                            <th>No. Material</th>
                                            <th>Material</th>
                                            <th>Solicite</th>
                                            <th>Recibí</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button id="btnAceptar" class="btn btn-primary btn-sm float-right ml-2">Aceptar</button>
                                <button id="btnRechazar" class="btn btn-danger btn-sm float-right">Rechazar</button>
                            </div>
                            <!-- /.card-footer -->
                            
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /. TABLA SOLICITUDES PENDIENTES -->

        </div>
        <!-- ends content-wrapper -->

        <?php include("include/footer.php") ?>

    </div>
    <!-- ./wrapper -->

    <?php include("include/scripts.php"); ?>
    <script src="dist/js/pages/solicitudes_pendientes.js"></script>
</body>

</html>