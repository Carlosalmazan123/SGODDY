<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico</title>
    <style>
        @page {
            margin: 120px 50px 100px 50px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            background-color: #f9f9f9;
        }

        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 80px;
            text-align: center;
            padding-top: 10px;
            border-bottom: 2px solid #3498db;
        }

        header h1 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
        }

        footer {
            position: fixed;
            bottom: -80px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 11px;
            color: #777;
            border-top: 1px solid #ccc;
        }

        .section-title {
            background-color: #3498db;
            color: #fff;
            padding: 6px 10px;
            font-weight: bold;
            margin-top: 25px;
            border-radius: 5px;
        }

        p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background-color: #fff;
        }

        th {
            background-color: #2980b9;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #ccc;
        }

        td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .info-table td {
            background-color: #ecf0f1;
        }

        .content {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Historial Clínico</h1>
    </header>

    <footer>
        Clínica Veterinaria ODDY - Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </footer>

    <div class="content">
        <div class="section-title">Información del Paciente</div>
        <p><strong>Nombre:</strong> {{ $paciente->nombre }}</p>
        <p><strong>Especie:</strong> {{ $paciente->especie }}</p>
        <p><strong>Raza:</strong> {{ $paciente->raza ?? 'No especificada' }}</p>
        <p><strong>Edad:</strong> {{ $paciente->edad }} años</p>
        <p><strong>Peso:</strong> {{ $paciente->peso }} kg</p>
        <p><strong>Color:</strong> {{ $paciente->color }}</p>
        <p><strong>Sexo:</strong> {{ $paciente->sexo }}</p>

        <div class="section-title">Información del Propietario</div>
        <p><strong>Nombre:</strong> {{ $paciente->relPropietario->nombre }} {{ $paciente->relPropietario->apellido }}</p>
        <p><strong>Teléfono:</strong> {{ $paciente->relPropietario->telefono }}</p>
        <p><strong>Dirección:</strong> {{ $paciente->relPropietario->direccion }}</p>

        <div class="section-title">Datos Clínicos</div>
        <table class="info-table">
            <tr>
                <th>Signos Clínicos</th>
                <td>{{ is_array($historial->anamnesis) ? implode(', ', $historial->anamnesis) : $historial->anamnesis }}</td>
            </tr>
            <tr>
                <th>Diagnóstico</th>
                <td>{{ is_array($historial->diagnostico) ? implode(', ', $historial->diagnostico) : $historial->diagnostico }}</td>
            </tr>
            <tr>
                <th>Examen</th>
                <td>{{ is_array($historial->examen) ? implode(', ', $historial->examen) : $historial->examen }}</td>
            </tr>
        </table>

        @if(is_array($historial->fecha) && is_array($historial->tratamiento) && is_array($historial->observaciones))
            <div class="section-title">Tratamientos Realizados</div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tratamiento</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historial->fecha as $i => $fecha)
                        <tr>
                            <td>{{ $fecha }}</td>
                            <td>{{ $historial->tratamiento[$i] ?? '-' }}</td>
                            <td>{{ $historial->observaciones[$i] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay historial clínico detallado disponible.</p>
        @endif
    </div>
</body>
</html>
