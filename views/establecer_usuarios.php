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

            <section>
                <div class="container-fluid pt-4">
                    <div class="row">

                        <div class="col-md-5">

                            <!-- ENTRADA PARA SELECCIONAR EL USUARIO -->
                            <div class="input-group pb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fab fa-cuttlefish"></i>
                                    </span>
                                </div>
                                <select class="form-control" name="selectUsuarios" id="selectUsuarios">
                                    <option value="default">Selecciona un usuario</option>
                                </select>
                            </div>

                            <!-- TABLE: BODEGA ACCESO -->
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 id="totalApagar" class="card-title">Bodegas a las que tiene acceso el usuario</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="tablaAcceso" class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Eliminar</th>
                                                    <th>No Bodega</th>
                                                    <th>Nombre</th>
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
                                    <a href="establecer_usuarios.php" class="btn btn-sm btn-danger float-left">Cancelar todo</a>
                                    <button id="addUsuario" class="btn btn-sm btn-info float-right">Procesar</button>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>

                        <div class="col-md-7">
                            <!-- TABLA SUCURSALES -->
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="card-title">Sucursales</h2>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="tablaSucursales" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No Bodega</th>
                                                            <th>F. Creacion</th>
                                                            <th>Correo</th>
                                                            <th>Tel</th>
                                                            <th>Nombre</th>
                                                            <th>Dirección</th>
                                                            <th>Tipo</th>
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
    <script src="dist/js/pages/establecer_usuarios.js"></script>

</body>


</html>