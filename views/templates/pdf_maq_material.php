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
  $cant = 0;
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
        $t=0; $ct=0;
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
              $cantidad_T = MaterialModelo::imprimirDatosM($m["id"], $item["id"]);
              $ct += $cantidad_T;
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
                $total_e = MaterialModelo::imprimirDatosSuma($m["id"], $item["id"]);
                $t += $total_e;
                ?>
              </tr>
            </tfoot>
          </table>
          <br><br><br><br>
        <?php
          }
        } if(empty($_GET['idMaterial'])){
            $currencies['COP'] = array(0, '.', '.');
            $to = number_format($t, ...$currencies['COP']);
            $can = number_format($ct, ...$currencies['COP']);
            echo "<h3 align='center'>TOTAL CANTIDAD = ". $can ."</h3>";
            echo "<h3 align='center'>TOTAL EFECTIVO = ". $to ."</h3>";
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
            if(isset($_GET["idMaterial"])){
              MaterialModelo::imprimirDatosMaterial($item["id"],$_GET["idMaterial"]);
            }else{
              $total_C =MaterialModelo::imprimirDatosMateriales($item["id"]);
              $cant = $total_C["cant"];
            }
           
          } else {
            MaterialModelo::imprimiDatosTabla($item["id"]);
          }

          ?>
        </tbody>
        <tfoot>
          <?php
            if ($_GET['materiales'] == 1){
              if(empty($_GET["idMaterial"])){
                echo '
                    <td colspan="2"></td>
                    <td align="right" >TOTAL: </td>
                    <td align="center" class="gray">
                      <h3 style="margin: 0px 0px;">'.$cant.'</h3>
                    </td>';
              }
            }
          ?>
        </tfoot>
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