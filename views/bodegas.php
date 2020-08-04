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

            <!-- TABLA BODEGA -->
            <div class="container-fluid pt-4">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <button id="altaBodega" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAgregarBodega">
                                    Agregar Nueva Bodega
                                </button>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="bodega" class="table table-bordered table-striped tablaModulos">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>F. Creacion</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th>Username</th>
                                            <th>Contraseña</th>
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
        MODAL AGREGAR BODEGA 
        ======================================-->

        <div id="modalAgregarBodega" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form id="formAddBodega">

                        <!--=====================================
                        HEADER DEL MODAL
                        ======================================-->

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">Alta Bodega</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeEsquina">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ====================================== -->

                        <div class="modal-body">


                            <!-- ENTRADA PARA LA NOMBRE DE LA BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="nomBodega" placeholder="Nombre" required>
                            </div>

                            <!-- ENTRADA PARA EL CORREO DE LA BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" name="correoBodega" placeholder="Correo" required>
                            </div>

                            <!-- ENTRADA PARA EL NUMERO DE LA BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" name="numBodega" placeholder="Numero de Telefono" required>
                            </div>

                            <!-- ENTRADA PARA EL USERNAME DE BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="userBodega" placeholder="Username" required>
                            </div>

                            <!-- ENTRADA PARA EL PASSWORD DE BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" name="passBodega" placeholder="Contraseña" required>
                            </div>
                            

                        </div>


                        <!--=====================================
                        PIE DEL MODAL
                    ======================================-->

                        <div class="modal-footer">
                            <button id="closeAdd" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                Guardar Bodega
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--=====================================
        MODAL EDITAR BODEGA 
        ======================================-->

        <div id="modalEditarBodega" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form id="formEditBodega">

                        <!--=====================================
                        HEADER DEL MODAL
                        ======================================-->

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">Editar Bodega</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeEsquina">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ====================================== -->

                        <div class="modal-body">


                            <!-- ENTRADA PARA LA NOMBRE DE LA BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="nomBodega" name="nomBodega" placeholder="Nombre" required>
                            </div>

                            <!-- ENTRADA PARA EL CORREO DE LA BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" id="correoBodega" name="correoBodega" placeholder="Correo" required>
                            </div>

                            <!-- ENTRADA PARA EL NUMERO DE TELEFONO LA BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" id="numBodega" name="numBodega" placeholder="Numero de Telefono" required>
                            </div>

                            <!-- ENTRADA PARA EL USERNAME DE BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="userBodega" name="userBodega" placeholder="Username" required>
                            </div>

                            <!-- ENTRADA PARA EL PASSWORD DE BODEGA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="passBodega" name="passBodega" placeholder="Contraseña" required>
                            </div>
                            

                        </div>


                        <!--=====================================
                        PIE DEL MODAL
                    ======================================-->

                        <div class="modal-footer">
                            <button id="closeEdit" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                Guardar Bodega
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
    <script src="dist/js/pages/bodega.js"></script>

</body>


</html>