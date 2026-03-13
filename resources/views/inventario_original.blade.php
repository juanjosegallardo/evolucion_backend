```html
<html>
<head>
    <style>
        body, *{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
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

        .entrada{
            color:black;
            font-weight:bold;
        }
        

        .salida{
            color:red;
            font-weight:bold;
        }

        .articulo{
            text-align:left;
            padding-left:5px;
        }
        .dia
        {
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
    <th width="20%">Articulo</th>
    <th width="5%">Inicial</th>
    @for($i=0 ;$i<7; $i++)

        <td width="5%" > {{$dias [ (($i + $dia_semana + 6 ) % 7) +1 ]}} </td>
    @endfor
    <th width="5%"> Total</th>
    <th width="35%"></th>
</tr>

@php($renglon=0)

@foreach ($articulos as $articulo)
@php($renglon++)
<tr class="{{($renglon%2==0)?'blanco':'gris' }}">

<td class="articulo">
    {{$articulo->articulo->tipoArticulo->nombre}}
</td>
<td >

@if(isset($inventario_inicial[$articulo->articulo_id]))
    <span class="bueno">
        {{$inventario_inicial[$articulo->articulo_id]["total_actual"] }}
    </span>
    <span class="defectuoso">
        {{$inventario_inicial[$articulo->articulo_id]["total_actual_defectuosos"] }}
    </span>
@endif

</td>


@for($i=0;$i<7;$i++)
<td class="dia">
@php(  $d=(($i + $dia_semana ) % 7) )
@if(isset($movimientos[$articulo->articulo_id][$d ]))
    <span class="entrada">
        {{$movimientos[$articulo->articulo_id][$d]["entradas"] + $movimientos[$articulo->articulo_id][$d]["defectuosos_entradas"] }}
    </span>
    <span class="salida">
        {{$movimientos[$articulo->articulo_id][$d]["salidas"] + $movimientos[$articulo->articulo_id][$d]["defectuosos_salidas"]}}
    </span>
@endif
</td>
@endfor

<td>

    
@if(isset($inventario_final[$articulo->articulo_id]))
    <span class="bueno">
        {{$inventario_final[$articulo->articulo_id]["total_actual"] }}
    </span>
    <span class="defectuoso">
        {{$inventario_final[$articulo->articulo_id]["total_actual_defectuosos"] }}
    </span>
@endif

</td>
<td></td>


</tr>
@endforeach

</table>

</body>
</html>
