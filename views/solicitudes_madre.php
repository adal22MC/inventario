<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

if (
    $_SESSION['tipo_usuario'] != "Administrador" &&
    $_SESSION['tipo_usuario'] != "Almacenista Principal"
) {
    header('Location: login.php');
}

require_once "../models/SolicitudesMadreModel.php";

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
                        <div class="col-md-12">
                            <!-- TABLA MATERIALES -->
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="card-title">Lista de solicitudes</h2>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="tablaSolicitud" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No Solicitud</th>
                                                            <th>Bodega</th>
                                                            <th>Fecha</th>
                                                            <th>Hora</th>
                                                            <th>Responsable</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                            SolicitudesMadreModel::printSolicitudes();
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
                            <!-- /. TABLA MATERIALES -->
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- ends content-wrapper -->

        <!--=====================================
        MODAL VER DETALLE SOLICITUD
        ======================================-->

        <!-- Modal -->
        <div class="modal fade" id="modalVerDetalleSolicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div style="width: 560px;" class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-md-12">
                                <!-- TABLA DETALLE -->
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">

                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="card-title">Detalle de la solicitud</h2>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="detalle_solicitud" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Material</th>
                                                                <th>Cantidad</th>
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
                                <!-- /. TABLA DETALLE -->
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include("include/footer.php") ?>

    </div>
    <!-- ./wrapper -->

    <?php include('include/scripts.php'); ?>
    <script src="dist/js/pages/solicitudes_madre.js"></script>

</body>


</html>