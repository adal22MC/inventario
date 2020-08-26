<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Material</title>

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
  <!-- Información de los Materiales -->
  <?php

  foreach ($Id as $item) {

  ?>
    <table width="100%">

      <?php
      MaterialModelo::imprimirDatosUsuario( $item["user"]);
      if(isset($_GET['idS'])){
        MaterialModelo::imprimirDatosSucursal($item["id"]);
      }
      ?>

    </table>
    <hr>
    <br />
    <?php
    if ($_SESSION['tipo_usuario'] == "Administrador" || $_SESSION['tipo_usuario'] == "Almacenista Principal") {
    ?>
      <?php
      if ($_GET['materiales'] == 1) {
        foreach ($material as $m) {
          if(isset($_GET['HMaterial'])){         
      ?>
        <table width="100%">
            <?php
            MaterialModelo::imprimirDatosMH($m["id"], $item["id"]);
            ?>
          </table>
          <br>
          <table width="100%">
            <thead style="background-color: lightgray;">
              <tr>
                <?php
                echo "
                <th>Fecha</th>
                <th>P.Compra</th>";
                ?>
              </tr>
            </thead>
            <tbody>
              <?php
              MaterialModelo::imprimirHistorialMaterial($m["id"], $item["id"]);
              ?>
            </tbody>
            
          </table>
          <br><br><br><br>
        <?php
        }else{
        ?>
          <table width="100%">
            <?php
            MaterialModelo::imprimirDatosM($m["id"], $item["id"]);
            ?>
          </table>
          <br>
          <table width="100%">
            <thead style="background-color: lightgray;">
              <tr>
                <?php
                echo "
                <th>Fecha</th>
                <th>P. Compra</th>
                <th>Stock</th>
                <th>Total</th>";

                ?>
              </tr>
            </thead>
            <tbody>
              <?php
              MaterialModelo::imprimirDetalleMateriales($m["id"], $item["id"]);

              ?>
            </tbody>
            <tfoot>
              <tr>
                <?php
                MaterialModelo::imprimirDatosSuma($m["id"], $item["id"]);
                ?>
              </tr>
            </tfoot>
          </table>
          <br><br><br><br>
        <?php
          }
        }
      } else {
        ?>
        <h3 align='center'>Materiales con Stock Bajo</h3>
        <br>
        <table width="100%">
          <thead style="background-color: lightgray;">
            <tr>
              <th>Codigo</th>
              <th>Material</th>
              <th>Categoria</th>
              <th>Stock Min</th>
              <th>Stock</th>
            </tr>
          </thead>
          <tbody>
            <?php
            MaterialModelo::imprimiDatosTabla($item["id"]);
            ?>
          </tbody>

        </table>
      <?php
      } ?>
    <?php
    } else {
    ?>
      <!-- Resumen de la cotización -->
      <?php
      if ($_GET['materiales'] == 1) {
        echo "<h3 align='center'>Materiales</h3>";
      } else {
        echo "<h3 align='center'>Materiales con Stock Bajo</h3>";
      }
      ?>
      <br>
      <table width="100%">
        <thead style="background-color: lightgray;">
          <tr>
            <?php
            if ($_GET['materiales'] == 1) {

              echo "
              <th>Codigo</th>
              <th>Material</th>
              <th>Categoria</th>
              <th>Stock</th>";
            } else {
              echo "
            <th>Codigo</th>
            <th>Material</th>
            <th>Categoria</th>
            <th>Stock Min</th>
            <th>Stock</th>";
            }
            ?>

          </tr>
        </thead>
        <tbody>
          <?php
          if ($_GET['materiales'] == 1) {
            MaterialModelo::imprimirDatosMateriales($item["id"]);
          } else {
            MaterialModelo::imprimiDatosTabla($item["id"]);
          }

          ?>
        </tbody>

      </table>
    <?php
    } //fin else
    ?>
    <br><br><br><br>
  <?php
  }
  ?>
</body>

</html>