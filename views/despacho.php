<?php
  session_start();
  if (!isset($_SESSION['username']) ){
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

                            <!-- TABLE: DESPACHOS -->
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 id="totalApagar" class="card-title">Lista de materiales a despachar</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="tablaDespachos" class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Eliminar</th>
                                                    <th>Material</th>
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
                                    <a href="despacho.php" class="btn btn-sm btn-danger float-left">Cancelar todo</a>
                                    <button id="procesarVenta" class="btn btn-sm btn-info float-right">Procesar despacho</button>
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


            <!--=====================================
            MODAL PROCESAR DESPACHO 
            ======================================-->

            <div id="modalProcesarDespacho" class="modal fade" role="dialog">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form id="formDatosDespacho">

                            <!--=====================================
                            HEADER DEL MODAL
                            ======================================-->

                            <div class="modal-header">

                                <h5 class="modal-title" id="exampleModalLabel">Procesando Despacho</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeEsquina">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>

                            <!--=====================================
                            CUERPO DEL MODAL
                            ====================================== -->

                            <div class="modal-body">

                                <!-- ENTRADA PARA EL NOMBRE DEL TRABAJADOR -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="num_orden" placeholder="Número de orden" required>
                                </div>

                                <!-- ENTRADA PARA EL NOMBRE DEL TRABAJADOR -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="nomTrabajador" name="nomTrabajador" placeholder="Nombre trabajador" required>
                                </div>

                                <!-- ENTRADA PARA EL TELEFONO DEL TRABAJADOR -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
                                </div>

                                <!-- ENTRADA PARA EL NUMERO DE CEDULA -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula" required>
                                </div>

                                <!-- ENTRADA PARA LAS OBSERVACIONES -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <textarea class="form-control" id="observaciones" name="observaciones"  cols="30" rows="5" placeholder="Observaciones" required></textarea>
                                </div>


                            </div>


                            <!--=====================================
                                PIE DEL MODAL
                            ======================================-->

                            <div class="modal-footer">
                                <button id="closeAdd" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">
                                    Procesar despacho
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
    <script src="dist/js/pages/despacho.js"></script>

</body>


</html>