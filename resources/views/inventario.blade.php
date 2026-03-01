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
        <h1>{{$almacen->nombre}} - {{$almacen->responsable->nombre}}</h1>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
                <th rowspan="2">
                    Articulo
                </th>
                <th rowspan="2">
                    Inicial
                </th>
                <th colspan="5">
                    Cargas
                </th>
                <th colspan="5">
                    Ventas
                </th>
                <th colspan="5">
                    Devoluciones
                </th>
                <th colspan="5">
                    Traspasos
                </th>
                <th colspan="5">
                    Ajustes
                </th>
                <th colspan="5">
                    Reclasificaciones
                </th>
                <th rowspan="2">
                    Total
                </th>
            </tr>
            <tr>
                <th>L</th>
                <th>M</th>
                <th>X</th>
                <th>J</th>
                <th>V</th>
                <th>L</th>
                <th>M</th>
                <th>X</th>
                <th>J</th>
                <th>V</th>
                <th>L</th>
                <th>M</th>
                <th>X</th>
                <th>J</th>
                <th>V</th>
                <th>L</th>
                <th>M</th>
                <th>X</th>
                <th>J</th>
                <th>V</th>
                <th>L</th>
                <th>M</th>
                <th>X</th>
                <th>J</th>
                <th>V</th>
                <th>L</th>
                <th>M</th>
                <th>X</th>
                <th>J</th>
                <th>V</th>
            </tr>
            @foreach ($articulos as $articulo)
            <tr>
                <td>
                     {{$articulo->articulo->tipoArticulo->nombre}}
                </td>
                <td>
                  
                </td>
                <!-- Cargas -->
                <td>
                    {{$cargas[$articulo->articulo_id]["2"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$cargas[$articulo->articulo_id]["2"]["cantidad_defectuosos"] ?? ""}}
                </td>

                <td>
                    {{$cargas[$articulo->articulo_id]["3"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$cargas[$articulo->articulo_id]["3"]["cantidad_defectuosos"] ?? ""}}
                </td>

                <td>
                    {{$cargas[$articulo->articulo_id]["4"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$cargas[$articulo->articulo_id]["4"]["cantidad_defectuosos"] ?? ""}}
                </td>

                <td>
                    {{$cargas[$articulo->articulo_id]["5"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$cargas[$articulo->articulo_id]["5"]["cantidad_defectuosos"] ?? ""}}
                </td>

                <td>
                    {{$cargas[$articulo->articulo_id]["6"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$cargas[$articulo->articulo_id]["6"]["cantidad_defectuosos"] ?? ""}}
                </td>
                <!-- Ventas -->

                 <td>
                    {{$ventas[$articulo->articulo_id]["2"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$ventas[$articulo->articulo_id]["2"]["cantidad_defectuosos"] ?? ""}}
                </td>

                <td>
                    {{$ventas[$articulo->articulo_id]["3"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$ventas[$articulo->articulo_id]["3"]["cantidad_defectuosos"] ?? ""}}
                </td>

                <td>
                    {{$ventas[$articulo->articulo_id]["4"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$ventas[$articulo->articulo_id]["4"]["cantidad_defectuosos"] ?? ""}}
                </td>

                <td>
                    {{$ventas[$articulo->articulo_id]["5"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$ventas[$articulo->articulo_id]["5"]["cantidad_defectuosos"] ?? ""}}
                </td>

                <td>
                    {{$ventas[$articulo->articulo_id]["6"]["cantidad"] ?? ""}}
                    &nbsp;
                    {{$ventas[$articulo->articulo_id]["6"]["cantidad_defectuosos"] ?? ""}}
                </td>
                <td colspan="20">

                </td>
                <td>

                </td>
            </tr>
            @endforeach
            
         
            



        </table>
    </body>
</html>
