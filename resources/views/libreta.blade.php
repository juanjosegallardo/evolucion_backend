<html>
    <head>
        <style>
            body, *{

                font-family: Arial, Helvetica, sans-serif;
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        
        <h1>{{$vendedor["nombre"]}}</h1>
        <br>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
        
        
        @php
            $fechaAnterior = null;  // Variable para almacenar la fecha anterior
            $total_precio = 0;
            $total_comision = 0;
            $total_a_pagar =0 ;
            $total_enganche =0;
        @endphp
        @foreach ($ventas as $venta)

            @php
                $fechaVenta = \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y');  // Formato de la fecha
            @endphp
            
            @if ($fechaVenta != $fechaAnterior)
                <!-- Mostrar un encabezado con la fecha solo cuando cambie -->
                <tr>
                    <th colspan="7" class="text-center" style="font-weight: bold;">
                        <h2>Fecha: {{ $fechaVenta }}</h2>
                    </th>
                </tr>
                <tr>
                    <th>
                        Fecha
                    </th>
                    <th>
                        Articulos
                    </th>
                    
                    <th>
                        Precio
                    </th>
                    <th>
                        %
                    </th>
                    <th>
                        Comisión
                    </th>
                    <th>
                        Enganche
                    </th>
                    <th>
                        A Pagar
                    </th>
                </tr>
            
            @endif

            <tr>
                <td>
                    {{$venta["fecha"]}}
                </td>
                <td>
                    @foreach($venta["articulos"] as $articulo)
                        {{$articulo["pivot"]["cantidad"]}} {{$articulo["tipoArticulo"]["nombre"]}} <br>
                    @endforeach
                </td>
                <td align="right">
                    
                    ${{ number_format($venta["total"], 2, '.', ',') }}
                </td>
                <td align="right">
                    ${{$venta["porcentaje"]}}
                </td>
                <td align="right">
                    ${{ number_format($venta["comision"], 2, '.', ',') }}
                </td>
                <td align="right">
                    ${{ number_format($venta["enganche"], 2, '.', ',') }}
                </td>
                <td align="right">
                    ${{ number_format($venta["a_pagar"], 2, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <hr>
                </td>
            </tr>
            
            @php
                $fechaAnterior = $fechaVenta;  // Actualiza la fecha anterior
                $total_comision += $venta["comision"];
                $total_a_pagar += $venta["a_pagar"];
                $total_enganche += $venta["enganche"];
                $total_precio +=  $venta["total"];
            @endphp
        @endforeach
            <tr>
                <td></td>
                <td></td>
                <td  align="right">${{ number_format($total_precio, 2, '.', ',') }}</td>
                <td></td>
                <td align="right">${{ number_format($total_comision, 2, '.', ',') }}</td>
                <td align="right">${{ number_format($total_enganche, 2, '.', ',') }}</td>
                <td align="right">${{ number_format($total_a_pagar, 2, '.', ',') }}</td>
            </tr>
        </table>
    </body>
</html>
