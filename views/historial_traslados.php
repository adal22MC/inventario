<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

require_once "../models/BodegaModel.php";

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

            <!-- TABLA HISTORIAL TRASLADOS -->
            <div class="container-fluid pt-4">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h2 class="badge badge-primary">Historial Traslados</h2>
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
                                <table id="h_traslados" class="table table-bordered table-striped tablaModulos">
                                    <thead>
                                        <tr>
                                            <th>No Traslado</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Responsable</th>
                                            <th>Destino</th>
                                            <th>Cantidad</th>
                                            <?php 
                                            if($_SESSION['tipo_usuario'] == "Administrador"){
                                                echo "<th>Total</th>";
                                            }
                                            ?>  
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $traslados = BodegaModelo::getHistorialTraslados($_SESSION['id_bodega']);
                                            foreach($traslados as $row){
                                                echo "<tr>
                                                        <td>{$row['id']}</td>
                                                        <td>{$row['fecha']}</td>
                                                        <td>{$row['hora']}</td>
                                                        <td>{$row['resp']}</td>
                                                        <td>{$row['nombre']}</td>
                                                        <td>{$row['cant']}</td>";
                                                
                                                        if($_SESSION['tipo_usuario'] == "Administrador"){
                                                            echo "<td>{$row['total']}</td>";
                                                        }
                                                echo "
                                                        <td>
                                                            <div class='text-center'>
                                                                <div class='btn-group'>
                                                                    <button class='btn  btn-danger btn-sm btnTraslado'>
                                                                        <i class='fas fa-file-pdf'></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>";
                                            }

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
    <script src="dist/js/pages/historial_traslados.js"></script>
</body>

</html>