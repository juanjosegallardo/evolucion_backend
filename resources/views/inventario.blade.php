```html
<html>
<head>
    <style>
        body, *{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        table{
            border-collapse: collapse;
        }

        th, td{
            text-align: center;
            vertical-align: middle;
            padding: 2px;
        }

        .bueno{
            color:#0b5394;
            font-weight:bold;
        }

        .defectuoso{
            color:#38761d;
            font-weight:bold;
        }

        .articulo{
            text-align:left;
            padding-left:5px;
        }
        .dia
        {
            width: 20px;
            white-space: nowrap;
        }

        @page {
            margin: 5mm;
        }
     
    </style>
</head>

<body>

<h1>{{$almacen->nombre}} - {{$almacen->responsable->nombre}}</h1>

<table width="100%" border="1" cellspacing="0" cellpadding="0">

<tr>
    <th rowspan="2">Articulo</th>
    <th rowspan="2">Inicial</th>

    <th colspan="5">Cargas</th>
    <th colspan="5">Ventas</th>
    <th colspan="5">Devoluciones</th>
    <th colspan="5">Traspasos</th>
    <th colspan="5">Ajustes</th>
    <th colspan="5">Reclasificaciones</th>

    <th rowspan="2">Total</th>
</tr>

<tr>
@for($i=0;$i<6;$i++)
    <th>L</th><th>M</th><th>X</th><th>J</th><th>V</th>
@endfor
</tr>

@foreach ($articulos as $articulo)
<tr>

<td class="articulo">
    {{$articulo->articulo->tipoArticulo->nombre}}
</td>

<td></td>

{{-- ================= CARGAS ================= --}}
@for($d=2;$d<=6;$d++)
<td class="dia">
@if(isset($cargas[$articulo->articulo_id][$d]))
    <span class="bueno">
        {{$cargas[$articulo->articulo_id][$d]["cantidad"]}}
    </span>
    <span class="defectuoso">
        {{$cargas[$articulo->articulo_id][$d]["cantidad_defectuosos"]}}
    </span>
@endif
</td>
@endfor

{{-- ================= VENTAS ================= --}}
@for($d=2;$d<=6;$d++)
<td  class="dia">
@if(isset($ventas[$articulo->articulo_id][$d]))
    <span class="bueno">
        {{$ventas[$articulo->articulo_id][$d]["cantidad"]}}
    </span>
    <span class="defectuoso">
        {{$ventas[$articulo->articulo_id][$d]["cantidad_defectuosos"]}}
    </span>
@endif
</td>
@endfor

{{-- ================= DEVOLUCIONES ================= --}}

@for($d=2;$d<=6;$d++)
<td  class="dia">
@if(isset($devoluciones[$articulo->articulo_id][$d]))
    <span class="bueno">
        {{$devoluciones[$articulo->articulo_id][$d]["cantidad"]}}
    </span>
    <span class="defectuoso">
        {{$devoluciones[$articulo->articulo_id][$d]["cantidad_defectuosos"]}}
    </span>
@endif
</td>
@endfor
{{-- ================= TRASPASOS ================= --}}
@for($d=2;$d<=6;$d++)
<td  class="dia">
@if(isset($traspasos[$articulo->articulo_id][$d]))
    <span class="bueno">
        {{$traspasos[$articulo->articulo_id][$d]["cantidad"]}}
    </span>
    <span class="defectuoso">
        {{$traspasos[$articulo->articulo_id][$d]["cantidad_defectuosos"]}}
    </span>
@endif
</td>
@endfor

{{-- ================= AJUSTES ================= --}}
@for($d=2;$d<=6;$d++)
<td  class="dia">
@if(isset($ajustes[$articulo->articulo_id][$d]))
    <span class="bueno">
        {{$ajustes[$articulo->articulo_id][$d]["cantidad"]}}
    </span>
    <span class="defectuoso">
        {{$ajustes[$articulo->articulo_id][$d]["cantidad_defectuosos"]}}
    </span>
@endif
</td>
@endfor

{{-- ================= RECLASIFICACIONES ================= --}}
@for($d=2;$d<=6;$d++)
<td  class="dia">
@if(isset($reclasificaciones[$articulo->articulo_id][$d]))
    <span class="bueno">
        {{$reclasificaciones[$articulo->articulo_id][$d]["cantidad"]}}
    </span>
    <span class="defectuoso">
        {{$reclasificaciones[$articulo->articulo_id][$d]["cantidad_defectuosos"]}}
    </span>
@endif
</td>
@endfor

<td></td>

</tr>
@endforeach

</table>

</body>
</html>
