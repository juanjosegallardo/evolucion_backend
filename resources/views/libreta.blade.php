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
                </th>
                <th>
                    {{$venta["total"]}}
                </th>
                <th>
                    {{$venta["porcentaje"]}}
                </th>
                <th>
                    {{$venta["comision"]}}
                </th>
                <th>
                    {{$venta["enganche"]}}
                </th>
                <th>
                    {{$venta["a_pagar"]}}
                </th>
            </tr>
            <tr>
                <td colspan="7">
                    <hr>
                </td>
            </tr>
            @php
                $fechaAnterior = $fechaVenta;  // Actualiza la fecha anterior
            @endphp
        @endforeach

        </table>
    </body>
</html>
