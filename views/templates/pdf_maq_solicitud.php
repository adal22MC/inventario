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
            <b>Inicio: </b> " . $_GET['fechaInicial'] . "   <b>Final: </b>" . $_GET['fechaFinal'] . "</pre>";
        }
        ?>  
      </td>
    </tr>
  </table>
  <br>
  <!-- Información de la Solicitud -->
  <?php

  foreach ($Id as $item) {

  ?>
    <table width="100%">
    
        <?php
        SolicitudModelo::imprimiDatosSolicitud($item["id"]);
        ?>
     
    </table>
    <hr>
    <br />
    <!-- Resumen de la cotización -->
    <table width="100%">
      <thead style="background-color: lightgray;">
        <tr>
          <th>Codigo</th>
          <th>Material</th>
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

