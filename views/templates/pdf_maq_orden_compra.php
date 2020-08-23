<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Orden Compra</title>

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
    </tr>
  </table>
  <br>
  <!-- Información de la Solicitud -->
  <?php

  foreach ($Id as $item) {

  ?>
    <table width="100%">
    
        <?php
        OrdenCompraModel::imprimiDatosOrden($item["id"]);
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
          <th>C. Recibido</th>
          <th>P. Compra</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        OrdenCompraModel::imprimiDatosTabla($item["id"]);
        ?>
      </tbody>
    
      <tfoot>
        <tr>
          <?php
          OrdenCompraModel::imprimirDatosSuma($item["id"]);
          ?>
        </tr>
      </tfoot>
      
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
          <td align="center"><strong>Visto Bueno</strong> </td>
          <td align="center"><strong>Aprobado</strong> </td>
        </tr>
      </table>
    </footer>
  <?php
  }
  ?>
</body>


</html>

