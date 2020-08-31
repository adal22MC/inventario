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

        .imgE {
            margin-top: 15px;
        }

        .pre {
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
            CategoriaModelo::imprimirDatosU($item["user"],$item["id"]);

            ?>

        </table>
        <hr>
        <br />
        <?php
        if ($_SESSION['tipo_usuario'] == "Administrador"|| $_SESSION['tipo_usuario'] == "Almacenista Principal") {
            $t = 0; $ct = 0;  
            foreach ($material as $m){
        ?>
            <table width="100%">
                <?php
                    $cantidad_T = MaterialModelo::imprimirDatosM($m["id"], $_SESSION["id_bodega"]);
                    $ct += $cantidad_T;
                ?>
            </table>
            <br>
            <table width="100%">
                <thead style="background-color: lightgray;">
                    <tr>

                        <th>Fecha</th>
                        <th>P. Compra</th>
                        <th>Stock</th>
                        <th>Total</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    MaterialModelo::imprimirDetalleMateriales($m["id"], $_SESSION["id_bodega"]);

                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <?php
                            $total_e = MaterialModelo::imprimirDatosSuma($m["id"], $_SESSION["id_bodega"]);
                            $t += $total_e;
                        ?>
                    </tr>
                </tfoot>
            </table>
            <br><br><br><br>
        <?php
            }// fin foreach
            $currencies['COP'] = array(0, '.', '.');
            $to = number_format($t, ...$currencies['COP']);
            $can = number_format($ct, ...$currencies['COP']);
            echo "<h3 align='center'>TOTAL CANTIDAD = ". $can ."</h3>";
            echo "<h3 align='center'>TOTAL EFECTIVO = ". $to."</h3>";
        } else {
        ?>

        <h3 align='center'>Materiales</h3>
  
      <br>
      <table width="100%">
        <thead style="background-color: lightgray;">
          <tr>             
              <th>Codigo</th>
              <th>Material</th>
              <th>Categoria</th>
              <th>Stock</th>
          </tr>
        </thead>
        <tbody>
          <?php
        
              $total_c =CategoriaModelo::imprimirDatosMaterialesC($_SESSION['id_bodega'],$item["id"]);
              $cant += $total_c["cant"];
          ?>
        </tbody>
        <tfoot>
            <?php
             echo '
             <td colspan="2"></td>
             <td align="right" >TOTAL: </td>
             <td align="center" class="gray">
               <h3 style="margin: 0px 0px;">'.$cant.'</h3>
             </td>';
            ?>
        </tfoot>
      </table>
    <?php
        } //fin else
    } //fin for
    ?>
</body>

</html>