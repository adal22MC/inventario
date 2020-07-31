<!doctype html>
<html lang="en">

<head>
    <?php include("include/cabezera.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <?php include("include/navegacion.php") ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- TABLA CATEGORIA -->
            <div class="container-fluid pt-4">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <button id="altaCategoria" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAgregarCategoria">
                                    Agregar Nueva Categoria
                                </button>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="categoria" class="table table-bordered table-striped tablaModulos">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Descripción</th>
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
            <!-- /. TABLA CATEGORIA -->

        </div>
        <!-- ends content-wrapper -->

        <!--=====================================
        MODAL AGREGAR CATEGORIA 
        ======================================-->

        <div id="modalAgregarCategoria" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form id="formAddCategoria">

                        <!--=====================================
                        HEADER DEL MODAL
                        ======================================-->

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">Alta Categoria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ====================================== -->

                        <div class="modal-body">


                            <!-- ENTRADA PARA LA DESCRIPCION DE LA CATEGORIA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="desCategoria" placeholder="Descripción" required>
                            </div>

                        </div>


                        <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                        <div class="modal-footer">
                            <button id="closeAdd" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                Guardar Categoria
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--=====================================
        MODAL EDITAR CATEGORIA 
        ======================================-->

        <div id="modalEditarCategoria" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form id="formEditCategoria">

                        <!--=====================================
                        HEADER DEL MODAL
                        ======================================-->

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ====================================== -->

                        <div class="modal-body">

                            <!-- ENTRADA PARA LA DESCRIPCION DE LA CATEGORIA -->
                            <div class="input-group pt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control"  id ="desCategoria" name="desCategoria" placeholder="Descripción" required>
                            </div>

                        </div>


                        <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                        <div class="modal-footer">
                            <button id="closeEdit" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>       

        <?php include("include/footer.php") ?>

    </div>
    <!-- ./wrapper -->

    <?php include("include/scripts.php"); ?>
    <script src="dist/js/pages/categoria.js"></script>

</body>

</html>