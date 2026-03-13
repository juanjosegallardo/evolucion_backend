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
    <th>Articulo</th>
    <th>Inicial</th>
    <th>M</th>
    <th>M</th>
    <th>J</th>
    <th>V</th>
    <th>S</th>
    <th>D</th>
    <th>L</th>
    <th>Total</th>
</tr>

@php($i=0)

@foreach ($articulos as $articulo)
@php($i++)
<tr class="{{($i%2==0)?'blanco':'gris' }}">

<td class="articulo">
    {{$articulo->articulo->tipoArticulo->nombre}}
</td>
<td></td>


@for($d=1;$d<=7;$d++)
<td class="dia">
@if(isset($movimientos[$articulo->articulo_id][$d]))
    <span class="entrada">
        {{$movimientos[$articulo->articulo_id][$d]["entradas"]}}
    </span>
    <span class="salida">
        {{$movimientos[$articulo->articulo_id][$d]["salidas"]}}
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
