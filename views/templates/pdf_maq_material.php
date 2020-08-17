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
      MaterialModelo::imprimirDatosUsuario($item["id"], $item["user"]);
      ?>

    </table>
    <hr>
    <br />
    <!-- Resumen de la cotización -->
    <?php 
      if (isset($_GET['materiales'])){
        echo"<h3 align='center'>Productos</h3>";
      }else{
        echo"<h3 align='center'>Productos con Stock Bajo</h3>";
      }
    ?>
    <br>
    <table width="100%">
      <thead style="background-color: lightgray;">
        <tr>
          <?php
          if (isset($_GET['materiales'])){
            echo"
              <th>Codigo</th>
              <th>Material</th>
              <th>Categoria</th>
              <th>Stock</th>";
          }else{
            echo"
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
          if (isset($_GET['materiales'])){
            MaterialModelo::imprimirDatosMateriales($item["id"]);
          }else{
            MaterialModelo::imprimiDatosTabla($item["id"]);
          }
        
        ?>
      </tbody>

      <tfoot>
       
      </tfoot>

    </table>
    <br><br><br><br>
  <?php
  }
  ?>
</body>

</html>