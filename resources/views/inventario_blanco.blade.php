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
            <td colspan="12" class="titulo" >NOMBRE: </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="12" class="titulo">    FECHA: {{ $fecha_inicio->format('d-m-Y') }} -
            {{ $fecha_fin->format('d-m-Y') }}
            </td>
            <td></td>
        </tr>




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
</thead>

@foreach ($articulos as $articulo)
@php($renglon++)
<tr class="{{($renglon%2==0)?'blanco':'blanco' }}">
        
    <td align="center">{{$renglon}}</td>
    <td class="articulo">
        {{$articulo->tipoArticulo->nombre}}
    </td>
    <td >
    

    </td>
    <td>

    </td>

    


    @for($i=0;$i<7;$i++)
    <td class="dia">
    @php(  $d=(($i + $dia_semana ) % 7) )

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
    <td></td>
    <td></td>
</tr>
</table>

</body>
</html>
