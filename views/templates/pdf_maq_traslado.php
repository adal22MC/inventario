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
        <?php
          SolicitudModelo::imprimirDEmpresa();
        ?> 
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
  <!-- Información del Traslado -->
  <?php

  foreach ($Id as $item) {

  ?>
    <table width="100%">
    
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
            if($_SESSION['tipo_usuario']== "Almacenista Principal" || $_SESSION['tipo_usuario']== "Administrador"){
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
            TrasladoModelo::imprimiDatosTabla($item["id"], $item["user"]);
        ?>
      </tbody>
      <tfoot>
        <tr>
          <?php
            TrasladoModelo::imprimirDatosSuma($item["id"],$item["user"]);
          ?>
        </tr>
      </tfoot>
      
    </table>
    <br><br><br><br>
  <?php
  }
  ?>
</body>


</html>

