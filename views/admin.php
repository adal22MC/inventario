<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
}

require_once "../controllers/EstadisticasController.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('include/cabezera.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed" <?php
                                                        if ($_SESSION['tipo_usuario'] == "Administrador") {
                                                          echo ' onload="obtenerDatosSucursalMadre()"';
                                                        }
                                                        ?>>
  <div class="wrapper">

    <?php include('include/navegacion.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0 text-dark">¡Bievenido al sistema!</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- Small boxes (Stat box) -->
          <div class="row">

            <?php if (
              $_SESSION['tipo_usuario'] == "Administrador" ||
              $_SESSION['tipo_usuario'] == "Almacenista Principal"
            ) { ?>
              <!-- ORDENES DE COMPRA TOTALES -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php $ctr = new EstadisticasControlles();
                        $ctr->printTotalOrdenesCompra();
                        ?></h3>

                    <p>Ordenes de compra</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="orden_compra.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <?php } else { ?>
              <!-- SOLICITUDES TOTALES -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php $ctr = new EstadisticasControlles();
                        $ctr->printTotalSolicitudes();
                        ?></h3>

                    <p>Solicitudes</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-file-alt"></i>
                  </div>
                  <a href="historial_solicitudes.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <?php } ?>
            <!-- ./col -->


            <!-- MATERIALES -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php
                      if (
                        $_SESSION['tipo_usuario'] == "Administrador" ||
                        $_SESSION['tipo_usuario'] == "Almacenista Principal"
                      ) {
                        $ctr->printTotalMateriales();
                      } else {
                        $ctr->printTotalMaterialesHijas();
                      }
                      ?></h3>

                  <p>Materiales</p>
                </div>
                <div class="icon">
                  <i class="fas fa-box"></i>
                </div>
                <a href="materiales.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <?php if (
              $_SESSION['tipo_usuario'] == "Administrador" ||
              $_SESSION['tipo_usuario'] == "Almacenista Principal"
            ) { ?>
              <!-- USUARIOS -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php //$ctr = new EstadisticasControlles();
                        $ctr->printTotalUsuarios();
                        ?></h3>

                    <p>Usuarios</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="usuarios.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <?php } else { ?>
              <!-- TRASLADOS -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php
                        $ctr->printTotalTraslados();
                        ?></h3>

                    <p>Traslados</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-truck"></i>
                  </div>
                  <a href="historial_traslados.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <?php } ?>
            <!-- ./col -->

            <?php if (
              $_SESSION['tipo_usuario'] == "Administrador" ||
              $_SESSION['tipo_usuario'] == "Almacenista Principal"
            ) { ?>
              <!-- CATEGORIAS -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?php //$ctr = new EstadisticasControlles();
                        $ctr->printTotalCategorias();
                        ?></h3>

                    <p>Categorias</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="categorias.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <?php } else { ?>
              <!-- DESPACHOS -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?php
                        $ctr->printTotalDespachos();
                        ?></h3>

                    <p>Despachos</p>
                  </div>
                  <div class="icon">

                    <i class=" fas fa-dolly-flatbed"></i>
                  </div>
                  <a href="historial_despachos.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <?php } ?>
            <!-- ./col -->

          </div>
          <!-- /.row -->
          <?php if ($_SESSION['tipo_usuario'] == "Administrador") { ?>

            <div class="row">
              <div class="col-8">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Información de la Empresa</h3>
                  </div>
                  <!-- /.card-header -->

                  <!-- form start -->
                  <form id="formAddSucursal">
                    <div class="card-body">

                      <div class="row">

                        <div class="col-6">
                          <!-- ENTRADA PARA EL NOMBRE DE LA EMPRESA -->
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nombre de la Empresa</label>
                            <input name="nombreS" type="text" class="form-control" id="nombreS" placeholder="Nombre empresa" required>
                          </div>
                        </div>

                        <div class="col-6">
                          <!-- ENTRADA PARA EL TELEFONO DE LA EMPRESA -->
                          <div class="form-group">
                            <label for="exampleInputEmail1">Telefono</label>
                            <input name="telefonoS" type="text" class="form-control" id="telefonoS" placeholder="Telefono" required>
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-6">
                          <!-- ENTRADA PARA EL NIT DE LA EMPRESA -->
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nit</label>
                            <input name="nitS" type="text" class="form-control" id="nitS" placeholder="Nit" required>
                          </div>
                        </div>

                        <div class="col-6">
                          <!-- ENTRADA PARA LA DIRECCION DE LA EMPRESA -->
                          <div class="form-group">
                            <label for="exampleInputEmail1">Dirección</label>
                            <input name="direccionS" type="text" class="form-control" id="direccionS" placeholder="Dirección" required>
                          </div>
                        </div>
                      </div>

                      <div class="row">

                        <div class="col-6">
                          <!-- ENTRADA PARA EL CORREO DE LA EMPRESA -->
                          <div class="form-group">
                            <label for="exampleInputEmail1">Correo</label>
                            <input name="correoS" type="email" class="form-control" id="correoS" placeholder="Email" required>
                          </div>
                        </div>

                        <div class="col-6">
                          <!-- ENTRADA PARA LA PAGIN WEB DE LA EMPRESA -->
                          <div class="form-group">
                            <label for="exampleInputEmail1">Pagina web</label>
                            <input name="paginaS" type="text" class="form-control" id="paginaS" placeholder="Pagina web" required>
                          </div>
                        </div>
                      </div>


                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary float-right">Modificar</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          <?php } ?>

          <?php if ($_SESSION['tipo_usuario'] == "Almacenista Multisucursal") { ?>
            <div class="row">
              <div class="col-md-5">
                <div class="card">
                  <div class="card-header border-transparent">
                    <h3 class="card-title">Cambiar de sucursal</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->

                  <div class="card-body">
                    <!-- ENTRADA PARA CAMBIAR DE SUCURSAL -->
                    <div class="input-group ">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fab fa-cuttlefish"></i>
                        </span>
                      </div>
                      <select class="form-control" name="sucursalAcceso" id="sucursalesAcceso">
                        <?php
                        // Llenamos el select con las sucursales a las que tiene acceso el usuario
                        for ($i = 0; $i < count($_SESSION['datos_bodegas']); $i++) {
                          if ($_SESSION['datos_bodegas'][$i]['id_bodega'] == $_SESSION['id_bodega']) {
                            echo '
                              <option selected value="' . $_SESSION['datos_bodegas'][$i]['id_bodega'] . '">' . $_SESSION['datos_bodegas'][$i]['nombre_bodega'] . '</option>
                            ';
                          } else {
                            echo '
                              <option value="' . $_SESSION['datos_bodegas'][$i]['id_bodega'] . '">' . $_SESSION['datos_bodegas'][$i]['nombre_bodega'] . '</option>
                            ';
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
            </div>
          <?php } ?>

        </div><!-- /.container-fluid -->

      </section>

      <!-- /.content -->
    </div>


    <?php include("include/footer.php") ?>

  </div>
  <!-- ./wrapper -->

  <?php include('include/scripts.php'); ?>
  <?php if ($_SESSION['tipo_usuario'] == "Almacenista Multisucursal") { ?>
    <script src="dist/js/pages/cambio_sucursal.js"></script>
  <?php } ?>
  <?php if ($_SESSION['tipo_usuario'] == "Administrador") { ?>
    <script src="dist/js/pages/admin.js"></script>
  <?php } ?>

</body>

</html>

<?php
if (isset($_SESSION['notificaciones'])) {
  if (
    $_SESSION['tipo_usuario'] == "Administrador"  ||
    $_SESSION['tipo_usuario'] == "Almacenista Principal"
  ) {

    require_once "../config.php";
    require_once CONTROLLERS . 'EstadisticasController.php';
    $ctrEstadistica = new EstadisticasControlles();
    $total = $ctrEstadistica->printTotalSolicitudes_madre();
    if($total > 0){
      echo "<script>Swal.fire('Tienes {$total} solicitudes');</script>";
    }
  }else{
    require_once "../models/BodegaModel.php";
    $total = BodegaModelo::getStockBajoBodega();
    if($total > 0){
      echo "<script>Swal.fire('Tienes {$total} materiales bajos en stock');</script>";
    }
  }
  unset($_SESSION['notificaciones']);
}
