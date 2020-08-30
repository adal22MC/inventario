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
  $t = 0; $ct = 0;
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
            $total_e = OrdenCompraModel::imprimirDatosSuma($item["id"]);
            $t += $total_e["total"];
            $ct += $total_e["cant"];
          ?>
        </tr>
      </tfoot>
      
    </table>
    <br><br><br><br>
  <?php
  }
    if(empty($_GET['id_orden'])){
      $currencies['COP'] = array(0, '.', '.');
      $to = number_format($t, ...$currencies['COP']);
      $can = number_format($ct, ...$currencies['COP']);
      echo "<h3 align='center'>TOTAL CANTIDAD = ". $can ."</h3>";
      echo "<h3 align='center'>TOTAL EFECTIVO = ". $to."</h3>";
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

