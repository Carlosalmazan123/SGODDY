<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas - {{ $periodo ?? '' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        .header { text-align: center; margin-bottom: 10px; }
        .small { font-size: 11px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; vertical-align: top; }
        th { background: #1f2937; color: #fff; font-weight: bold; }
        .right { text-align: right; }
        .nested-table { width: 100%; border-collapse: collapse; }
        .nested-table th, .nested-table td { border: 1px solid #ccc; padding: 4px; font-size: 11px; }
        .summary { margin-top: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Clínica Veterinaria ODY</h2>
        <p class="small">Reporte de Ventas — Período: {{ $periodo }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th># recibo</th>
                <th>Fecha</th>
                <th>Productos o servicios</th>
                <th class="right">Total (Bs.)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $f)
                <tr>
                    <td>{{ $f->id }}</td>
                    <td>{{ $f->fecha }}</td>
                    <td>
                        <table class="nested-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="right">Cant.</th>
                                    <th class="right">Precio</th>
                                    <th class="right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($f->detalles as $d)
                                    <tr>
                                        <td>
                                            {{-- Mostrar nombre de producto o servicio --}}
                                            @if($d->producto_id)
                                                {{ $d->producto->nombre }}
                                            @elseif($d->servicio_id)
                                                {{ $d->servicio->nombre }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="right">{{ $d->cantidad }}</td>
                                        <td class="right">
                                            {{ number_format($d->precio ?? 0, 2) }}
                                        </td>
                                        <td class="right">{{ number_format($d->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td class="right">{{ number_format($f->total, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;">No se encontraron facturas en el período.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Cantidad de facturas:</strong> {{ $cantidadFacturas }}</p>
        <p><strong>Total ventas:</strong> Bs. {{ number_format($totalVentas, 2) }}</p>
    </div>
</body>
</html>
