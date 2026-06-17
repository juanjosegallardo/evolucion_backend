<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Artículos</title>

    <style>
        @page {
            margin: 35px;
        }

        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
        }

        .header p {
            margin: 5px 0 0;
            color: #777;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #2c3e50;
            color: white;
        }

        th {
            padding: 10px 8px;
            font-size: 12px;
            text-align: left;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #dcdcdc;
        }

        tbody tr:nth-child(even) {
            background: #f7f7f7;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: -15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #888;
        }

        .fecha {
            margin-bottom: 15px;
            text-align: right;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>CATÁLOGO DE ARTÍCULOS</h1>
    <p>Lista de precios</p>
</div>

<div class="fecha">
    Generado: {{ now()->format('d/m/Y H:i') }}
</div>

<table>
    <thead>
        <tr>
            <th width="60%">Artículo</th>
            <th width="20%" class="text-right">Contado</th>
            <th width="20%" class="text-right">Crédito</th>
        </tr>
    </thead>

    <tbody>
        @foreach($articulos as $articulo)
            <tr>
                <td>{{ $articulo->tipoArticulo->nombre }}</td>
                <td class="text-right">
                    ${{ number_format($articulo->tipoArticulo->precio_contado, 2) }}
                </td>
                <td class="text-right">
                    ${{ number_format($articulo->tipoArticulo->precio_credito, 2) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Lista de artículos y precios
</div>

</body>
</html>