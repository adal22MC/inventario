  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>


  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>


  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <?php
  if (isset($_SESSION['username'])) {
    if ($_SESSION['tipo_usuario'] == "Administrador") {
      echo '<script src="dist/js/pages/backups.js"></script>';
    }
  }
  ?>