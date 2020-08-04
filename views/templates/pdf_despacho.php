<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cotización</title>

  <style type="text/css">
    * {
      font-family: Verdana, Arial, sans-serif;
    }
    table{
      font-size: x-small;
    }
    tfoot tr td{
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
      <td valign="top"><img src="" alt="logo" width="150"/></td>
      <td align="right">
        <h3>COTIZADOR</h3>
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
      <td><strong>De:</strong> Jhon Doe - Joystick</td>
      <td><strong>Para:</strong>Pedro Ignacio</td>
    </tr>
  </table>

  <br/>

  <!-- Resumen de la cotización -->
  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>#</th>
        <th>Descripción</th>
        <th>Precio unitario</th>
        <th>Cantidad</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Concepto</td>
          <td align="right">$100</td>
          <td align="center">50</td>
          <td align="right">$5000</td>
        </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3"></td>
        <td align="right">Subtotal $</td>
        <td align="right">500</td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td align="right">Impuestos $</td>
        <td align="right">100</td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td align="right">Envío $</td>
        <td align="right">150</td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td align="right">Total $</td>
        <td align="right" class="gray"><h3 style="margin: 0px 0px;">5000</h3></td>
      </tr>
      <tr>
        <td colspan="5" align="right">IVA INCLUIDO</td>
      </tr>
    </tfoot>
  </table>
</body>
</html>