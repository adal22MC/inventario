<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('include/cabezera.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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

            <!-- VENTAS TOTALES -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3></h3>

                  <p>Ventas</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="historial_ventas.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <!-- PRODUCTOS -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3></h3>

                  <p>Productos</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <!-- CLIENTES -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3></h3>

                  <p>Clientes Registrados</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <!-- CATEGORIAS -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3></h3>

                  <p>Categorias</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

          </div>
          <!-- /.row -->

          <?php if($_SESSION['tipo_usuario'] != "Almacenista Por Unidad"){?>
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
                        for($i = 0; $i<count($_SESSION['datos_bodegas']); $i++){
                          if($_SESSION['datos_bodegas'][$i]['id_bodega'] == $_SESSION['id_bodega']){
                            echo '
                              <option selected value="'.$_SESSION['datos_bodegas'][$i]['id_bodega'].'">'.$_SESSION['datos_bodegas'][$i]['nombre_bodega'].'</option>
                            ';
                          }else{
                            echo '
                              <option value="'.$_SESSION['datos_bodegas'][$i]['id_bodega'].'">'.$_SESSION['datos_bodegas'][$i]['nombre_bodega'].'</option>
                            ';
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer clearfix">
                  <button id="cambiarSucursal" class="btn btn-sm btn-info float-right">Cambiar</button>
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <?php }?>

        </div><!-- /.container-fluid -->

      </section>

      <!-- /.content -->
    </div>


    <?php include("include/footer.php") ?>

  </div>
  <!-- ./wrapper -->

  <?php include('include/scripts.php'); ?>
  <?php if($_SESSION['tipo_usuario'] != "Almacenista Por Unidad"){?>
  <script src="dist/js/pages/cambio_sucursal.js"></script>
  <?php }?>

</body>

</html>