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
              TrasladoModelo::imprimirDatosSumaDetalle($item["id"]);
            }else{
              TrasladoModelo::imprimirDatosSuma($item["id"]);
            }           
          ?>
       
      </tfoot>
      
    </table>
    <br><br><br><br>
  <?php
  }
  ?>
</body>


</html>

