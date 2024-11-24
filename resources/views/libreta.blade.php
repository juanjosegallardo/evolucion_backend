<table border="1">
    <tr>
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
@foreach ($ventas as $venta)
    <tr>
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
    
@endforeach

</table>