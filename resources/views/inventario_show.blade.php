<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, p { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #1f2937; color: white; }
        .total-table { margin-top: 40px; }
    </style>
</head>
<body>
    <h1>Reporte de Inventario</h1>

    @if(isset($fecha))
        <p>Fecha seleccionada: {{ $fecha }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Tipo Movimiento</th>
                <th>Descripción</th>
                <th>Fecha Movimiento</th>
                <th>Stock Movido</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventario as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->producto->nombre ?? 'N/A' }}</td>
                <td>{{ ucfirst($item->tipo_movimiento)  }}</td>
                <td>{{ $item->descripcion ?? "***************************"}}</td>
                <td>{{ \Carbon\Carbon::parse($item->fecha_movimiento)->format('d/m/Y H:i') }}</td>
                <td>{{ number_format($item->stock) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 🔹 Resumen de stock actual por producto --}}
    <h2>Resumen de Stock Actual</h2>
    <table class="total-table" >
        <thead>
            <tr>
                <th>Producto</th>
                <th>Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Agrupar los productos del inventario listado en el reporte
                $productos = $inventario->pluck('producto')->unique('id');
            @endphp
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->nombre ?? 'N/A' }}</td>
                <td>{{ number_format($producto->stock_actual) ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
