<?php

  session_start();

  if( isset($_SESSION['username'])){
    if( isset($_GET['id_solicitud'])){
      echo "SI existe y es " . $_GET['id_solicitud'];
    }else{
      header("Location: ../historial_solicitudes.php");
    }
  }else{
    header("Location: ../historial_solicitudes.php");
  }
  
  require_once "../../models/Solicitud_model.php";

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Solicitud</title>

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
      <td valign="top"><img src="" alt="logo" width="150" /></td>
      <td align="right">
        <?php
          SolicitudModelo::imprimiDatosEmpresa($_GET['id_solicitud']);
        ?>
      </td>
    </tr>
  </table>

  <!-- Información de la empresa -->
  <table width="100%">
    <tr>
      <td><strong>Procesado por:</strong> Bodega Los Pinos</td>
      <td><strong>Solicitado por:</strong> Bodega Hija</td>
      <td><strong>Fecha:</strong> 04/12/20</td>
      <td><strong>Hora:</strong> 08:14</td>
    </tr>
  </table>
  <hr>
  <br />
  <!-- Información del trabajador -->
   <!--
  <div width="50%" align="right">
    <h3 align="center">Despacho realizado por:</h3>
    <table width="60%">
      <thead style="background-color: lightgray;">
        <tr>
          <th>Nombre</th>
          <th>Telefono</th>
          <th>Cedula</th>
          <th>Observaciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th align="center">Adalberto Moreno Cardenas</th>
          <td align="center">9262033312</td>
          <td align="center">33psWaosm2</td>
          <td align="center">Todo llego correctamente prueba.</td>
        </tr>
      </tbody>
    </table>
  </div> -->
  <br /> <br /> <br />
  <!-- Resumen de la cotización -->
  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Cantidad</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td align="center">PVC</td>
        <td align="center">22</td>

      </tr>
      <tr>
        <th scope="row">2</th>
        <td align="center">Tubos H2</td>
        <td align="center">40</td>

      </tr>
      <tr>
        <th scope="row">3</th>
        <td align="center">Laminas</td>
        <td align="center">12</td>

      </tr>
      <tr>
        <th scope="row">4</th>
        <td align="center">Cinta</td>
        <td align="center">20</td>

      </tr>
    </tbody>
    <tfoot>
      
      <tr>
        <td colspan="1"></td>
        <td align="right">Total: </td>
        <td align="center" class="gray">
          <h3 style="margin: 0px 0px;">94</h3>
        </td>
      </tr>
      <!--
      <tr>
        <td colspan="5" align="right">IVA INCLUIDO</td>
      </tr> -->
    </tfoot>
  </table>
</body>

</html>