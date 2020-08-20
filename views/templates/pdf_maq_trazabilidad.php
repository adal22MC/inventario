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
  <!-- Información del Material-->
  <table width="90%">     
        <?php
           TrazabilidadModelo::imprimirDatosMaterial($_GET["id_M"],$_GET['idS']); 
        ?> 
    </table>
    <hr>
    <br />
  <?php
    
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
                TrazabilidadModelo::imprimirDatosEntrada($item["id"],$item["FechaI"],$item["FechaF"],$item["idS"]);
          ?>
        </tbody>
        
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
                TrazabilidadModelo::imprimirDatosDespacho($item["id"],$item["FechaI"],$item["FechaF"],$item["idS"]);
          ?>
        </tbody>
        
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
                TrazabilidadModelo::imprimirDatosTraslados($item["id"],$item["FechaI"],$item["FechaF"],$item["idS"]);
          ?>
        </tbody>
        
      </table>
    </div>
   <br><br><br><br>
  <?php
  }
  ?>
</body>


</html>

