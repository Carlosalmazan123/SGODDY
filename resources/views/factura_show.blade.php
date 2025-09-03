<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $factura->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 30px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2F855A;
        }

        .info-clinica, .info-factura, .info-cliente {
            margin-bottom: 20px;
        }

        .info-box {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 6px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #2B6CB0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #EDF2F7;
            text-align: left;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 16px;
            color: #1A202C;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

    </style>
</head>
<body>

    <div class="header">
        <h1>CLÍNICA VETERINARIA ODDY</h1>
        <p>Av. Tupiza Nº 123, Tupiza - Bolivia | Tel: 71234567</p>
        <p>Email: contacto@veterinariaoddy.bo</p>
    </div>

    <div class="info-factura info-box">
        <div class="section-title">Datos de la Factura</div>
        <p><strong>Factura Nº:</strong> {{ $factura->id }}</p>
        <p><strong>Fecha de emisión:</strong> {{ $factura->created_at->format('d/m/Y H:i') }}</p>
     
    </div>

    <div class="info-cliente info-box">
        <div class="section-title">Datos del Cliente</div>
        <p><strong>Nombre del propietario:</strong> {{ $factura->paciente->propietario->nombre ?? 'No disponible' }}</p>
        <p><strong>Mascota:</strong> {{ $factura->paciente->nombre }}</p>
        <p><strong>Raza:</strong> {{ $factura->paciente->raza ?? 'N/D' }}</p>
    </div>

   <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
         <tbody>
        @forelse($detalles as $detalle)
            @php
                $producto = \App\Models\Producto::find($detalle->producto_id);
            @endphp
            <tr>
                <td>{{ $producto?->nombre ?? 'Producto no encontrado' }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>{{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-red-500">No hay productos registrados en esta factura.</td>
            </tr>
        @endforelse
    </tbody>
    </table>

    <div class="total">
        <strong>Total a pagar: Bs {{ number_format($factura->total, 2) }}</strong>
    </div>

    <div class="footer">
        Gracias por confiar en nosotros. ¡Atendemos con cariño y profesionalismo!
    </div>

</body>
</html>
