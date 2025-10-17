<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo #{{ $factura->id }}</title>
    <style>
        @page {
            size: 80mm auto;
            margin: 5mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            width: 80mm;
            margin: 0;
            padding: 5mm;
            text-align: left;
        }

        .header {
            text-align: center;
            margin-bottom: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 14px;
            color: #2F855A;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        .info-box {
            border: 1px dashed #aaa;
            padding: 5px;
            border-radius: 4px;
            margin-bottom: 6px;
        }

        .section-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 3px;
            color: #2B6CB0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 4px 2px;
            font-size: 10px;
        }

        th {
            background-color: #f0f0f0;
            text-align: left;
        }

        td {
            vertical-align: top;
            text-align: left;
        }

        .total {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
            font-size: 11px;
            border-top: 1px solid #000;
            padding-top: 4px;
        }

        .footer {
            margin-top: 12px;
            text-align: center;
            font-size: 9px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>CLÍNICA VETERINARIA ODY</h1>
        <p>C. Beni cerca al Hospital Eduardo Eguía</p>
        <p>Tupiza - Bolivia | Tel: 65468983</p>
    </div>

    <div class="info-factura info-box">
        <div class="section-title">Datos del recibo</div>
        <p><strong>Recibo Nº:</strong> {{ $factura->id }}</p>
        <p><strong>Fecha:</strong> {{ $factura->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Usuario:</strong> {{ $factura->user->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cant.</th>
                <th>Precio</th>
                <th>Subt.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto?->nombre ?? $detalle->servicio?->nombre ?? 'No encontrado' }}</td>
                    <td>
                        @php
                            $cantidad = $detalle->cantidad ?? 0;
                            $mostrarDecimales = fmod($cantidad, 1) >= 0.01;
                        @endphp

                        @if($detalle->producto && $detalle->producto->check)
                            {{ $mostrarDecimales ? number_format($cantidad, 1) : intval($cantidad) }}
                        @else
                            {{ intval($cantidad) }}
                        @endif
                    </td>
                    <td>{{ number_format($detalle?->precio ?? 0, 2) }}</td>
                    <td>{{ number_format($detalle->subtotal ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay detalles disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Total a pagar: Bs {{ number_format($factura->total, 2) }}
    </div>

    <div class="footer">
        ¡Gracias por confiar en nosotros!<br>
        Atendemos con cariño y profesionalismo.
    </div>

</body>
</html>
