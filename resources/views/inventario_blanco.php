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

        h1
        {
            font-size: 14px;
        }
        h2
        {
            font-size: 12px;
        }
        th, td{
            text-align: center;
            vertical-align: middle;
            padding: 1px;
        }

        .bueno{
            color:#0b5394;
            font-weight:bold;
        }

        .gris
        {
            background-color: #cccccc;

        }
    
        .blanco
        {
            background-color: #FFFFFF;
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

<h1>{{$almacen->nombre}} {{$fecha}}</h1>
<h2>  {{ $almacen->responsable->nombre ?? '' }}</h2>

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
@php($i=0)

@foreach ($articulos as $articulo)
@php($i++)
<tr class="{{($i%2==0)?'blanco':'gris' }}">

<td class="articulo">
    {{$articulo->articulo->tipoArticulo->nombre}}
</td>

<td>
    @if(isset($inicial[$articulo->articulo_id]))
        <span class="bueno">
            {{$inicial[$articulo->articulo_id]["total_actual"]}}
        </span>
        <span class="defectuoso">
            {{$inicial[$articulo->articulo_id]["total_actual_defectuosos"]}}
        </span>
    @endif

</td>

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

<td>

    @if(isset($final[$articulo->articulo_id]))
        <span class="bueno">
            {{$final[$articulo->articulo_id]["total_actual"]}}
        </span>
        <span class="defectuoso">
            {{$final[$articulo->articulo_id]["total_actual_defectuosos"]}}
        </span>
    @endif
</td>

</tr>
@endforeach

</table>

</body>
</html>
