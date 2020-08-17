<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Despacho</title>

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

    .hr {
      width: 75%;
    }

    footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 80px;
      color: black;
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
      </td>
    </tr>
  </table>
  <br>
  <?php

  foreach ($Id as $item) {

  ?>
    <!-- Información del Despacho  -->
    <table width="100%">

      <?php
      DespachoModelo::imprimirDatosDespacho($item["id"], $item["id_b"]);
      ?>

    </table>
    <hr>
    <!-- Información del trabajador -->
    <div width="100%" align="right">
      <h3 align="center">Datos del Trabajador:</h3>
      <table width="100%">
        <thead style="background-color: lightgray;">
          <tr>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Cedula</th>
          </tr>
        </thead>
        <tbody>
          <?php
          DespachoModelo::imprimirDatosTrabajador($item["id"], $item["id_b"]);
          ?>
        </tbody>
      </table>
    </div>
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
        DespachoModelo::imprimirDatosTabla($item["id"], $item["id_b"]);
        ?>
      </tbody>
      <tfoot>

        <tr>
          <?php
          DespachoModelo::imprimirDatosSuma($item["id"], $item["id_b"]);
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
        DespachoModelo::imprimirDatosObservaciones($item["id"], $item["id_b"]);
        ?>
      </tbody>
    </table>
    <br><br><br><br>
  <?php
  }
  ?>
  <?php
  if (empty($_GET['fechaInicial'])) {
  ?>
    <footer>
      <table width="100%">
        <tr>
          <td>
            <hr class="hr">
          </td>
          <td>
            <hr class="hr">
          </td>
        </tr>
        <tr>
          <td align="center"><strong>Entregado por</strong> </td>
          <td align="center"><strong>Recibido por</strong> </td>
        </tr>
      </table>
    </footer>
  <?php
  }
  ?>
</body>

</html>