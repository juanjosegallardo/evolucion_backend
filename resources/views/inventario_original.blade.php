```html
<html>
<head>

    <style>
        body, *{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
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
        th{
            text-align: center;
            vertical-align: middle;
            padding: 1px;
            font-weight: bold;
        }
        .titulo{
            font-size: 12px;
            font-weight: bold;
        }

        .bueno{
            color:#0b5394;
            font-weight:bold;
        }

        .gris
        {
            background-color: #cccccc;

        }

        tr
        {
            text-align: left!important;
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

<h1></h1>
 
@php($i=1)
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <td colspan="12" class="titulo" >NOMBRE: {{ $almacen->responsable->nombre ?? '' }} {{$almacen->nombre}} </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="12" class="titulo">    FECHA: {{ $fecha_inicio->format('d-m-Y') }} -
            {{ $fecha_fin->format('d-m-Y') }}
            </td>
            <td></td>
        </tr>
    </thead>



<tr>
    <th width="5%"></th>
    <th width="20%">Articulo</th>
    <th width="4%">INI</th>|
    <th width="4%">DF</th>
    @for($i=0 ;$i<7; $i++)

        <th width="4%" > {{$dias [ (($i + $dia_semana + 6 ) % 7) +1 ]}} </th>
    @endfor
    <th width="4%"> Total</th>
    <th width="35%"></th>
</tr>

@php($renglon=0)
@php($suma_inicial=0)
@php($suma_inicial_defectuosos=0)

@foreach ($articulos as $articulo)
@php($renglon++)
<tr class="{{($renglon%2==0)?'blanco':'blanco' }}">
        
    <td align="center">{{$renglon}}</td>
    <td class="articulo">
        {{$articulo->tipoArticulo->nombre}}
    </td>
    <td >

        @if(isset($inventario_inicial[$articulo->id])&& $inventario_inicial[$articulo->id]["total_actual"] > 0)
            <span class="bueno">
                {{$inventario_inicial[$articulo->id]["total_actual"] }}
                @php($suma_inicial += $inventario_inicial[$articulo->id]["total_actual"])
            </span>
        @endif
    

    </td>
    <td>
        @if(isset($inventario_inicial[$articulo->id])&& $inventario_inicial[$articulo->id]["total_actual_defectuosos"] > 0)
            <span class="defectuoso">
                {{$inventario_inicial[$articulo->id]["total_actual_defectuosos"] }}
                @php($suma_inicial_defectuosos += $inventario_inicial[$articulo->id]["total_actual_defectuosos"])
            </span>
        @endif
    </td>

    


    @for($i=0;$i<7;$i++)
    <td class="dia">
    @php(  $d=(($i + $dia_semana ) % 7) )
    @if(isset($movimientos[$articulo->id][$d ]))
        <span class="entrada">
            {{$movimientos[$articulo->id][$d]["entradas"] + $movimientos[$articulo->id][$d]["defectuosos_entradas"] }}
        </span>
        <span class="salida">
            {{$movimientos[$articulo->id][$d]["salidas"] + $movimientos[$articulo->id][$d]["defectuosos_salidas"]}}
        </span>
    @endif
    </td>
    @endfor

    <td>

        

    </td>
    <td>
        
    </td>

</tr>

@endforeach
<tr>
    <td align="center">{{$renglon}}</td>
    <td>Total</td>
    <td>{{$suma_inicial}}</td>
    <td>{{$suma_inicial_defectuosos}}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
</table>

</body>
</html>
