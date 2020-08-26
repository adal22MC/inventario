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

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('include/cabezera.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed" onload="obtenerSelect()">

    <div class="wrapper">

        <?php include('include/navegacion.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <section>
                <div class="container-fluid pt-4">
                    <div class="row">

                        <div class="col-md-5">
                            <!-- TABLE: ORDEN -->
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 id="totalApagar" class="card-title">Lista de Materiales a ordenar</h3>
                                    <div class="card-tools">
                                        <button id="altaMaterial" type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modalAgregarMaterial">
                                        <b>+</b> Material
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="tablaOrden" class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Eliminar</th>
                                                    <th>Material</th>
                                                    <th>Cantidad</th>
                                                    <th>P. Compra</th>
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
                                    <a href="orden_compra.php" class="btn btn-sm btn-danger float-left">Cancelar todo</a>
                                    <button id="procesarVenta" class="btn btn-sm btn-info float-right">Procesar orden</button>
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
                                                            <th>Stock Max</th>
                                                            <th>Categoria</th>
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
                            <!-- /. TABLA PRODUCTOS -->
                        </div>

                    </div>
                </div>
            </section>

            <!--=====================================
            MODAL AGREGAR MATERIAL
            ======================================-->
            <div id="modalAgregarMaterial" class="modal fade" role="dialog">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form id="formAddMaterial">

                            <!--=====================================
                            HEADER DEL MODAL
                            ======================================-->

                            <div class="modal-header">

                                <h5 class="modal-title" id="exampleModalLabel">Crear Material</h5>
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

                                <!-- ENTRADA PARA EL STOCK MAXIMO -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="stock_max" placeholder="Stock maximo" required>
                                </div>

                                <!-- ENTRADA PARA EL STOCK MINIMO -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="stock_min" placeholder="Stock minimo" required>
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

        </div>
        <!-- ends content-wrapper -->


        <?php include("include/footer.php") ?>

    </div>
    <!-- ./wrapper -->

    <?php include('include/scripts.php'); ?>
    <script src="dist/js/pages/orden_compra.js"></script>

</body>


</html>