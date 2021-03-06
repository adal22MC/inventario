   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">
       <!-- Left navbar links -->
       <ul class="navbar-nav">
           <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
           </li>
       </ul>

       <!-- Right navbar links -->
       <ul class="navbar-nav ml-auto">

           <!-- Notifications Dropdown Menu -->
           <li class="nav-item dropdown">
               <?php
                require_once "../models/BodegaModel.php";
                BodegaModelo::printStockBajoBodega();
                ?>
           </li>
           <li class="nav-item">
               <a class="btn btn-primary btn-sm ml-4 mt-1" href="salir.php">Salir</a>
           </li>
       </ul>
   </nav>
   <!-- /.navbar -->

   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
       <!-- Brand Logo -->
       <a href="admin.php" class="brand-link">
           <img src="dist/img/logo_unidades1.jpeg" alt="Inventario Logo" class="brand-image img-circle elevation-3">
           <span class="brand-text font-weight-light text-center">
               <b>
                   <?php
                    echo $_SESSION['nombre_bodega'];
                    ?>
               </b>
           </span>
       </a>

       <!-- Sidebar -->
       <div class="sidebar">

           <!-- Informacion del usuario -->
           <div class="user-panel mt-3 pb-3 mb-3 d-flex">
               <div class="image">
                   <img src="dist/img/usuario.jpeg" class="img-circle elevation-2" alt="User Image">
               </div>
               <div class="info">
                   <a href="#" class="d-block"><?php echo $_SESSION['nombre_usuario']; ?></a>
               </div>
           </div>

           <!-- Menu opciones -->
           <nav class="mt-2">

               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                   <?php if ($_SESSION['tipo_usuario'] == "Administrador") { ?>
                       <!-- BODEGAS -->
                       <li class="nav-item">
                           <a href="bodegas.php" class="nav-link">
                               <i class="nav-icon fas fa-hotel"></i>
                               <p>
                                   BODEGAS
                               </p>
                           </a>
                       </li>
                   <?php } ?>


                   <?php if (
                        $_SESSION['tipo_usuario'] == "Almacenista Por Unidad" ||
                        $_SESSION['tipo_usuario'] == "Almacenista Multisucursal"
                    ) { ?>
                       <!-- SOLICITUDES -->
                       <li class="nav-item has-treeview menu-close">
                           <a href="#" class="nav-link">
                               <i class="nav-icon fas fa-shipping-fast"></i>
                               <p>
                                   SOLICITUDES
                                   <i class="right fas fa-angle-left"></i>
                               </p>
                           </a>
                           <ul class="nav nav-treeview">
                               <li class="nav-item">
                                   <a href="solicitudes_p.php" class="nav-link">
                                       <i class="fas fa-minus-3x nav-icon"></i>
                                       <p>Realizar solicitud</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="solicitudes_pendientes.php" class="nav-link">
                                       <i class="fas fa-minus-3x nav-icon"></i>
                                       <p>Solicitudes Pendientes</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="historial_solicitudes.php" class="nav-link">
                                       <i class="fas fa-minus-3x nav-icon"></i>
                                       <p>Historial de Solicitudes</p>
                                   </a>
                               </li>
                           </ul>
                       </li>
                      
                   <?php } ?>


                   <!-- DESPACHOS -->
                   <li class="nav-item has-treeview menu-close">
                       <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-dolly-flatbed"></i>
                           <p>
                               DESPACHOS
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="despacho.php" class="nav-link">
                                   <i class="fas fa-minus-3x nav-icon"></i>
                                   <p>Realizar Despacho</p>
                               </a>
                           </li>
                           <li class="nav-item">
                               <a href="historial_despachos.php" class="nav-link">
                                   <i class="fas fa-minus-3x nav-icon"></i>
                                   <p>Historial de despachos</p>
                               </a>
                           </li>
                       </ul>
                   </li>


                   <?php if (
                        $_SESSION['tipo_usuario'] == "Administrador" ||
                        $_SESSION['tipo_usuario'] == "Almacenista Principal"
                    ) { ?>
                       <!-- CATEGORIAS -->
                       <li class="nav-item">
                           <a href="categorias.php" class="nav-link">
                               <i class="nav-icon fab fa-cuttlefish"></i>
                               <p>
                                   CATEGORIAS
                               </p>
                           </a>
                       </li>
                   <?php } ?>

                   <!-- MATERIALES -->
                   <li class="nav-item">
                       <a href="materiales.php" class="nav-link">
                           <i class="nav-icon fas fa-box"></i>
                           <p>
                               MATERIALES
                           </p>
                       </a>
                   </li>

                   <!-- TRASLADOS -->
                   <li class="nav-item">
                       <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-truck"></i>
                           <p>
                               TRASLADOS
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="traslados.php" class="nav-link">
                                   <i class="fas fa-minus-3x nav-icon"></i>
                                   <p>Realizar Traslado</p>
                               </a>
                           </li>
                           <li class="nav-item">
                                   <a href="traslados_pendientes.php" class="nav-link">
                                       <i class="fas fa-minus-3x nav-icon"></i>
                                       <p>Traslados Pendientes</p>
                                   </a>
                               </li>
                           <li class="nav-item">
                               <a href="historial_traslados.php" class="nav-link">
                                   <i class="fas fa-minus-3x nav-icon"></i>
                                   <p>Historial de traslados</p>
                               </a>
                           </li>
                       </ul>
                   </li>


                   <?php if ($_SESSION['tipo_usuario'] == "Administrador") { ?>
                       <li class="nav-item">
                           <a href="#" class="nav-link">
                               <i class="nav-icon fas fa-users"></i>
                               <p>
                                   USUARIOS
                                   <i class="right fas fa-angle-left"></i>
                               </p>
                           </a>
                           <ul class="nav nav-treeview">
                               <li class="nav-item">
                                   <a href="usuarios.php" class="nav-link">
                                       <i class="fas fa-minus-3x nav-icon"></i>
                                       <p>Administrar Usuarios</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="establecer_usuarios.php" class="nav-link">
                                       <i class="fas fa-minus-3x nav-icon"></i>
                                       <p>Establecer usuarios</p>
                                   </a>
                               </li>
                           </ul>
                       </li>
                   <?php } ?>

                   <!-- SOLICITUDES -->
                   <?php if (
                        $_SESSION['tipo_usuario'] == "Administrador" ||
                        $_SESSION['tipo_usuario'] == "Almacenista Principal"
                    ) { ?>
                       <li class="nav-item">
                           <a href="solicitudes_madre.php" class="nav-link">
                               <span class='badge badge-danger navbar-badge'>
                                   <?php
                                    require_once "../config.php";
                                    require_once CONTROLLERS . 'EstadisticasController.php';
                                    $ctrEstadistica = new EstadisticasControlles();
                                    $total = $ctrEstadistica->printTotalSolicitudes_madre();
                                    echo "<b>{$total}</b>";
                                    ?></span>
                               <i class="nav-icon fas fa-file-alt"></i>
                               <p>
                                   SOLICITUDES
                               </p>

                           </a>
                       </li>

                   <?php } ?>


                   <!-- ORDEN DE COMPRA -->
                   <?php if (
                        $_SESSION['tipo_usuario'] == "Administrador" ||
                        $_SESSION['tipo_usuario'] == "Almacenista Principal"
                    ) {
                    ?>
                       <li class="nav-item">
                           <a href="#" class="nav-link">
                               <i class="nav-icon fas fa-shipping-fast"></i>
                               <p>
                                   ORDEN DE COMPRA
                                   <i class="right fas fa-angle-left"></i>
                               </p>
                           </a>
                           <ul class="nav nav-treeview">
                               <li class="nav-item">
                                   <a href="orden_compra.php" class="nav-link">
                                       <i class="fas fa-minus-3x nav-icon"></i>
                                       <p>Realizar orden</p>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="ver_orden.php" class="nav-link">
                                       <i class="fas fa-minus-3x nav-icon"></i>
                                       <p>Ver ordenes</p>
                                   </a>
                               </li>
                               <li class="nav-item">

                                   <a href="historial_orden_compra.php" class="nav-link">
                                       <i class="fas fa-minus-3x nav-icon"></i>
                                       <p>Historial de ordenes</p>
                                   </a>
                               </li>
                           </ul>
                       </li>

                   <?php } ?>

                   <?php if (
                        $_SESSION['tipo_usuario'] == "Administrador" ||
                        $_SESSION['tipo_usuario'] == "Almacenista Principal"
                    ) {
                    ?>
                       <!-- TRAZABILIDAD -->
                       <li class="nav-item">
                           <a href="trazabilidad.php" class="nav-link">
                               <i class="nav-icon fas fa-chart-line"></i>
                               <p>
                                   TRAZABILIDAD
                               </p>
                           </a>
                       </li>
                   <?php } ?>

                   <?php if ($_SESSION['tipo_usuario'] == "Administrador") {
                    ?>
                       <!-- MODIFICAR STOCK MIN Y MAX DE BODEGAS HIJAS -->
                       <li class="nav-item">
                           <a href="config_stock_hijas.php" class="nav-link">
                               <i class="nav-icon fas fa-tools"></i>
                               <p>
                                   STOCK MAX Y MIN UND
                               </p>
                           </a>
                           <a id="enlace"></a>
                       </li>
                   <?php } ?>

                   <?php if ($_SESSION['tipo_usuario'] == "Administrador") {
                    ?>
                       <!-- BACKUPS BD -->
                       <li class="nav-item">
                           <a id="backups" href="#" class="nav-link">
                               <i class="nav-icon fas fa-database"></i>
                               <p>
                                   BACKUPS BD
                               </p>
                           </a>
                           <a id="enlace"></a>
                       </li>
                   <?php } ?>

               </ul>

           </nav>
           <!-- /.menu-opciones -->
       </div>
       <!-- /.sidebar -->
   </aside>