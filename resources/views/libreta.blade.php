{{$vendedor["nombre"]}}
<br>
<table border="1" width="100%" cellspacing="0" cellpadding="0">
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

   
@php
    $fechaAnterior = null;  // Variable para almacenar la fecha anterior
@endphp
@foreach ($ventas as $venta)

    @php
        $fechaVenta = \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y');  // Formato de la fecha
    @endphp
    
    @if ($fechaVenta != $fechaAnterior)
        <!-- Mostrar un encabezado con la fecha solo cuando cambie -->
        <tr>
            <th colspan="7" class="text-center" style="font-weight: bold;">
                Fecha: {{ $fechaVenta }}
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
    @php
        $fechaAnterior = $fechaVenta;  // Actualiza la fecha anterior
    @endphp
@endforeach

</table>