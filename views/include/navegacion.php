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
            <li class="nav-item">
                <a class="btn btn-info btn-sm ml-4" href="salir.php">Salir del sistema</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="admin.php" class="brand-link">
            <img src="dist/img/avatar5.png" alt="Inventario Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light"><b>Inventario</b></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            
            <!-- Menu opciones -->
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <!-- BODEGAS -->
                    <li class="nav-item">
                        <a href="bodegas.php" class="nav-link">
                            <i class="nav-icon fas fa-hotel"></i>
                            <p>
                                BODEGAS
                            </p>
                        </a>
                    </li>

                    <!-- SOLICITUDES -->
                    <li class="nav-item">
                        <a href="solicitudes_p.php" class="nav-link">
                            <i class="nav-icon fas fa-id-badge"></i>
                            <p>
                                SOLICITUDES
                            </p>
                        </a>
                    </li>

                    <!-- CATEGORIAS -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fab fa-cuttlefish"></i>
                            <p>
                                CATEGORIAS
                            </p>
                        </a>
                    </li>

                    <!-- PRODUCTOS -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fab fa-product-hunt"></i>
                            <p>
                                PRODUCTOS
                            </p>
                        </a>
                    </li>

                     <!-- TRASLADOS -->
                    <li class="nav-item has-treeview menu-close">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                TRASLADOS
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="fas fa-minus-3x nav-icon"></i>
                                <p>Vender Productos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="fas fa-minus-3x nav-icon"></i>
                                <p>Historial de ventas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="fas fa-minus-3x nav-icon"></i>
                                <p>Historial de cierres</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- CIERRE DE DIA -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                CIERRE DE DIA
                            </p>
                        </a>
                    </li>

                </ul>

            </nav>
            <!-- /.menu-opciones -->
        </div>
        <!-- /.sidebar -->
    </aside>