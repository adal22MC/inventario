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

                        <div class="col-md-12">
                            <!-- TABLA MATERIALES -->
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <button id="btnAddUsuario" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalAgregarUsuario">
                                                    Agregar Usuario
                                                </button>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="tablaUsuarios" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Username</th>
                                                            <th>Password</th>
                                                            <th>Correo</th>
                                                            <th>No Identificación</th>
                                                            <th>Nombres</th>
                                                            <th>Apellidos</th>
                                                            <th>Id_tu</th>
                                                            <th>Tipo Usuario</th>
                                                            <th>Status</th>
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
                MODAL AGREGAR USUARIO 
            ======================================-->

            <div id="modalAgregarUsuario" class="modal fade" role="dialog">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form id="formAddUusario">

                            <!--=====================================
                            HEADER DEL MODAL
                            ======================================-->

                            <div class="modal-header">

                                <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeEsquina">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>

                            <!--=====================================
                            CUERPO DEL MODAL
                            ====================================== -->

                            <div class="modal-body">

                                <!-- ENTRADA PARA EL USERNAME -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                </div>

                                <!-- ENTRADA PARA LA PASS -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                </div>

                                <!-- ENTRADA PARA EL CORREO -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo" required>
                                </div>

                                <!-- ENTRADA PARA EL NUMERO DE IDENTIFICACION -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="num_iden" name="num_iden" placeholder="Número de identificación" required>
                                </div>

                                <!-- ENTRADA PARA EL NOMBRE -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombre" required>
                                </div>

                                <!-- ENTRADA PARA LOS APELLIDOS -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                                </div>

                                <!-- ENTRADA PARA EL TIPO DE USUARIO -->
                                <div class="input-group pt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fab fa-cuttlefish"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" name="tipoUsuario" id="tipoUsuario">

                                    <option value="default">Selecciona un tipo de usuario</option>

                                    </select>
                                </div>



                            </div>


                            <!--=====================================
                                PIE DEL MODAL
                            ======================================-->

                            <div class="modal-footer">
                                <button id="closeAdd" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">
                                    Crear Usuario
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
    <script src="dist/js/pages/usuarios.js"></script>

</body>


</html>