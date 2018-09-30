<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ordenes</title>

</head>
<body>
  <div>

      <img src="{{ URL::asset('img/Logo-prueba.png') }}" class="img-fluid" style="max-height:160px; margin-bottom:20px;"><br><br>

  </div>
  <table>
    <tr>
      <th>ORDNUMEROPEDIDO</th>
    </tr>

    <tr>
      <td>{{$orden->ordNumeroPedido}}</td>
    </tr>

  </table>
</body>
</html>
