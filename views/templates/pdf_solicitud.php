<?php

session_start();

if (isset($_SESSION['username'])) {
  /*if( isset($_GET['id_solicitud'])){
      //echo "SI existe y es " . $_GET['id_solicitud'];
    }else{
      header("Location: ../historial_solicitudes.php");
    }*/
} else {
  header("Location: ../historial_solicitudes.php");
}

require_once "../../models/Solicitud_model.php";

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Solicitud</title>

  <style type="text/css">
    * {
      font-family: Verdana, Arial, sans-serif;
      font-size: 14px;

    }

    table {
      font-size: x-small;
    }

    tfoot tr td {
      font-weight: bold;
      font-size: x-small;
    }

    .gray {
      background-color: lightgray;
    }

    .success {
      color: green;
    }
  </style>
</head>

<body>
  <!-- Cabecera -->
  <table width="100%">
    <tr>
      <td valign="top"><img src="../dist/img/logotipo.jpg" alt="logo" width="150" /></td>
      <td align="right">
        <?php
        SolicitudModelo::imprimiDatosEmpresa($_SESSION['id_bodega']);
        if (isset($_GET['fechaInicial'])) {
          echo "<pre>
            <b>Inicio: </b> " . $_GET['fechaInicial'] . "   <b>Final: </b>" . $_GET['fechaFinal'] . "
                 </pre>";
        }
        ?>
        
        
      </td>
    </tr>
  </table>

  <!-- Información de la Solicitud -->
  <?php

  $van;
  $Id;
  if (isset($_GET['id_solicitud'])) {
    $van = 0;
    $Id[0] = array("id" => $_GET['id_solicitud']);
  } else {
    $van = 1;
    $Id = SolicitudModelo::SolicitudesId($_GET['fechaInicial'], $_GET['fechaFinal'], $_SESSION['id_bodega']);
  }

  foreach ($Id as $item) {

  ?>
    <table width="100%">
      <tr>
        <?php
        SolicitudModelo::imprimiDatosSolicitud($item["id"]);
        ?>
      </tr>
    </table>
    <hr>
    <br />
    <!-- Resumen de la cotización -->
    <table width="100%">
      <thead style="background-color: lightgray;">
        <tr>
          <th>ID</th>
          <th>Producto</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <?php

        SolicitudModelo::imprimiDatosTabla($item["id"]);

        ?>
      </tbody>
    
      <tfoot>
        <tr>
          <?php

          SolicitudModelo::imprimiDatosSuma($item["id"]);


          ?>
        </tr>
      </tfoot>
      
    </table>
    <br><br><br><br>
  <?php
  }
  ?>
</body>

</html>