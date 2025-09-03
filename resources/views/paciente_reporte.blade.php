<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Pacientes</title>
    <style>
        @page {
            margin: 100px 50px 80px 50px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 60px;
            text-align: center;
            border-bottom: 2px solid #3498db;
            color: #2c3e50;
        }

        header h1 {
            margin: 0;
            font-size: 20px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 11px;
            color: #777;
            border-top: 1px solid #ccc;
        }

        .table-container {
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: 1px solid #2980b9;
        }

        td {
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #ecf0f1;
        }

        tr:nth-child(even) td {
            background-color: #dfe6e9;
        }
    </style>
</head>
<body>

    <header>
        <h1>Reporte de Pacientes</h1>
    </header>

    <footer>
        Clínica Veterinaria ODDY - Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </footer>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Especie</th>
                    <th>Raza</th>
                    <th>Edad</th>
                    <th>Peso</th>
                    <th>Propietario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pacientes as $index => $paciente)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $paciente->nombre }}</td>
                    <td>{{ $paciente->especie }}</td>
                    <td>{{ $paciente->raza ?? 'N/E' }}</td>
                    <td>{{ $paciente->edad }} años</td>
                    <td>{{ $paciente->peso }} kg</td>
                    <td>{{ $paciente->relPropietario->nombre }} {{ $paciente->relPropietario->apellido }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
