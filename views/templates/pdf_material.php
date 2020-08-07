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
      <td valign="top"><img src="" alt="logo" width="150" /></td>
      <td align="right">
        <h3>Los Pinos</h3>
        <pre>
          Jhon Doe CEO
          Joystick
          XX101010101
          5512 3465 78
          FAX
        </pre>
      </td>
    </tr>
  </table>

  <!-- Información de la empresa -->
  <table width="100%">
    <tr>
      <td><strong>DE:</strong> 21/07/20</td>
      <td><strong>A:</strong> 04/08/20</td>
      <td><strong>Fecha:</strong> 05/08/20</td>
      <td><strong>Hora:</strong> 08:14</td>
    </tr>
  </table>
  <hr>
  <br />
  <!-- Información del trabajador -->
  <div width="50%" align="right">
    <h3 align="center">Almacenista:</h3>
    <table width="50%">
      <thead style="background-color: lightgray;">
        <tr>
          <th>Nombre</th>
          <th>Cedula</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th align="center">Adalberto Moreno Cardenas</th>
          <td align="center">33psWao2</td>
        </tr>
      </tbody>
    </table>
  </div>
  <br /> <br /> <br />
  <!-- Resumen de la cotización -->
  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Categoria</th>
        <th>Serial</th>
        <th>Stock</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">001</th>
        <td align="center">PVC</td>
        <td align="center">Tuberia</td>
        <td align="center">2001</td>
        <td align="center">22</td>

      </tr>
      <tr>
        <th scope="row">002</th>
        <td align="center">Tubos H2</td>
        <td align="center">Tuberia</td>
        <td align="center">2002</td>
        <td align="center">40</td>

      </tr>
      <tr>
        <th scope="row">003</th>
        <td align="center">Laminas</td>       
        <td align="center">Metal</td>
        <td align="center">2003</td>
        <td align="center">12</td>

      </tr>
      <tr>
        <th scope="row">004</th>
        <td align="center">Cinta</td>     
        <td align="center">Aislante</td>
        <td align="center">2001</td>
        <td align="center">20</td>

      </tr>
    </tbody>
    <tfoot>
      
      <tr>
        <td colspan="3"></td>
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