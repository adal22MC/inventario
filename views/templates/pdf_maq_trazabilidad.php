<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Trazabilidad</title>

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
    <br />
    
  </table>
  <!-- Información del Material-->
  <table width="90%"> 
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
           TrazabilidadModelo::imprimirDatosMaterial($_GET["id_M"],$_GET['idS']); 
        ?> 
    </table>
    <hr>
    <br />
  <?php
    $t = 0; $ct = 0; $ctD = 0; $tT = 0; $ctT = 0;
  foreach ($Id as $item) {

  ?>
    <!-- Entrada de Materiales -->
    <div width="100%" align="right">
      <h3 align="center">Entrada del Material</h3>
      <table width="100%">
        <thead style="background-color: lightgray;">
          <tr>
          <th>Entrada Realizada</th>
          <th>Realizado por</th>
          <th>Fecha</th>
          <th>Cantidad</th>
          <th>P.Compra</th>
          <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
                $total_E = TrazabilidadModelo::imprimirDatosEntrada($item["id"],$item["FechaI"],$item["FechaF"],$item["idS"]);
                $t += $total_E["total"];
                $ct += $total_E["cant"];
          ?>
        </tbody>
        <tfoot>
            <?php
                $currencies['COP'] = array(0, '.', '.');
                $toE = number_format($t, ...$currencies['COP']);
                $canE = number_format($ct, ...$currencies['COP']);
                echo '
                <tr>
                    <td colspan="4"></td>
                    <td align="right" >TOTAL: </td>
                    <td align="center" class="gray"> <h3 style="margin: 0px 0px;">' . $toE . '</h3> </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td align="right" >CANTIDAD TOTAL: </td>
                    <td align="center" class="gray"> <h3 style="margin: 0px 0px;">' . $canE . '</h3> </td>
                </tr>'
            ?>        
        </tfoot>
        
      </table>
    </div>
   <br><br><br><br>
    <!-- Despacho de Materiales -->
    <div width="100%" align="right">
      <h3 align="center">Despachos del Material</h3>
      <table width="100%">
        <thead style="background-color: lightgray;">
          <tr>
          <th>Responsable</th>
          <th>Fecha</th>
          <th>Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <?php
                $total_D = TrazabilidadModelo::imprimirDatosDespacho($item["id"],$item["FechaI"],$item["FechaF"],$item["idS"]);
                $ctD += $total_D["cant"];
          ?>
        </tbody>
        <tfoot>
            <?php
                $currencies['COP'] = array(0, '.', '.');
                $canD = number_format($ctD, ...$currencies['COP']);
                echo '
                <tr>
                    <td colspan="1"></td>
                    <td align="right" >CANTIDAD TOTAL: </td>
                    <td align="center" class="gray"> <h3 style="margin: 0px 0px;">' . $canD . '</h3> </td>
                </tr>'
            ?>        
        </tfoot>
      </table>
    </div>
   <br><br><br><br>
    <!-- Entrada de Materiales -->
    <div width="100%" align="right">
      <h3 align="center">Traslados del Material</h3>
      <table width="100%">
        <thead style="background-color: lightgray;">
          <tr>
          <th>Destino</th>
          <th>Responsable</th>
          <th>Fecha</th>
          <th>Cantidad</th>
          <th>P.Compra</th>
          <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
                $total_T =TrazabilidadModelo::imprimirDatosTraslados($item["id"],$item["FechaI"],$item["FechaF"],$item["idS"]);
                $tT += $total_T["total"];
                $ctT += $total_T["cant"];
          ?>
        </tbody>
        <tfoot>
            <?php
                $currencies['COP'] = array(0, '.', '.');
                $toT = number_format($tT, ...$currencies['COP']);
                $canT = number_format($ctT, ...$currencies['COP']);
                echo '
                <tr>
                    <td colspan="4"></td>
                    <td align="right" >TOTAL: </td>
                    <td align="center" class="gray"> <h3 style="margin: 0px 0px;">' . $toT . '</h3> </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td align="right" >CANTIDAD TOTAL: </td>
                    <td align="center" class="gray"> <h3 style="margin: 0px 0px;">' . $canT . '</h3> </td>
                </tr>'
            ?>        
        </tfoot>
      </table>
    </div>
   <br><br><br><br>
  <?php
  }
    $t += $tT;
    $ct += $ctT + $ctD;
    $currencies['COP'] = array(0, '.', '.');
    $to = number_format($t, ...$currencies['COP']);
    $can = number_format($ct, ...$currencies['COP']);
    echo "<h3 align='center'>TOTAL CANTIDAD = ". $can ."</h3>";
    echo "<h3 align='center'>TOTAL EFECTIVO = ". $to."</h3>";
  ?>
</body>


</html>

