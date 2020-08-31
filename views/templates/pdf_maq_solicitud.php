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
    .imgE{
      margin-top: 15px;
    }
    .pre{
      font-weight: bold;
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
        <?php
          SolicitudModelo::imprimirDEmpresa();
        ?> 
      <td align="right" WIDTH="100">
        <?php
        SolicitudModelo::imprimiDatosEmpresa($_SESSION['id_bodega']);
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
         if (isset($_GET['fechaInicial'])) {
          echo "
          <tr>
          <td><strong>Inicio:</strong>" . $_GET['fechaInicial'] . "</td>
          <td><strong>Final:</strong>" . $_GET['fechaFinal'] . "</td>
          </tr> ";
        }
        ?>
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
    <br>
    <table width="100%">
      <thead style="background-color: lightgray;">
        <tr>
          <th>Observaciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        SolicitudModelo::imprimirDatosObservacionesS($item["id"]);
        ?>
      </tbody>
    </table>
    <br><br><br><br>
  <?php
  }
  ?>
</body>


</html>

