<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Traslado</title>

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
  <!-- Información del Traslado -->
  <?php
  $t=0; $ct=0;
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
            TrasladoModelo::imprimirDatosTraslado($item["id"]);
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
          <?php
            if( $_SESSION['tipo_usuario']== "Administrador"){
          ?>
          <th>P.Compra</th>
          <th>Total</th>
          <?php
            }
          ?> 
        </tr>
      </thead>
      <tbody>
        <?php
          if( $_SESSION['tipo_usuario']== "Administrador"){
            TrasladoModelo::imprimiDatosTablaDetalle($item["id"]);
          }else{
            TrasladoModelo::imprimiDatosTabla($item["id"]);
          }
            
        ?>
      </tbody>
      <tfoot>
          <?php
            if( $_SESSION['tipo_usuario']== "Administrador"){
              $total_t = TrasladoModelo::imprimirDatosSumaDetalle($item["id"]);
              $t += $total_t["total"];
              $ct += $total_t["cant"];
            }else{
              TrasladoModelo::imprimirDatosSuma($item["id"]);
            }           
          ?>
       
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
        TrasladoModelo::imprimirDatosObservacionesT($item["id"]);
        ?>
      </tbody>
    </table>
    <br><br><br><br>
  <?php
  }
  if($_SESSION['tipo_usuario']== "Administrador"){
    if(isset($_GET['fechaInicial'])){
      $currencies['COP'] = array(0, '.', '.');
      $to = number_format($t, ...$currencies['COP']);
      $can = number_format($ct, ...$currencies['COP']);
      echo "<h3 align='center'>TOTAL CANTIDAD = ". $can ."</h3>";
      echo "<h3 align='center'>TOTAL EFECTIVO = ". $to ."</h3>";
    }
  }
  
  ?>
</body>


</html>

