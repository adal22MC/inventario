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
                <a class="btn btn-primary btn-sm ml-4" href="salir.php">Salir del sistema</a>
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

                    <!-- DESPACHOS -->
                    <li class="nav-item has-treeview menu-close">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                DESPACHOS
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="despacho.php" class="nav-link">
                                <i class="fas fa-minus-3x nav-icon"></i>
                                <p>Generar Despacho</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- CATEGORIAS -->
                    <li class="nav-item">
                        <a href="categorias.php" class="nav-link">
                            <i class="nav-icon fas fa-hotel"></i>
                            <p>
                                CATEGORIAS
                            </p>
                        </a>
                    </li>

                    <!-- MATERIALES -->
                    <li class="nav-item">
                        <a href="materiales.php" class="nav-link">
                            <i class="nav-icon fas fa-hotel"></i>
                            <p>
                                MATERIALES
                            </p>
                        </a>
                    </li>

                    <!-- USUAERIOS -->
                    <li class="nav-item">
                        <a href="usuarios.php" class="nav-link">
                            <i class="nav-icon fas fa-hotel"></i>
                            <p>
                                USUARIOS
                            </p>
                        </a>
                    </li>

                </ul>

            </nav>
            <!-- /.menu-opciones -->
        </div>
        <!-- /.sidebar -->
    </aside>