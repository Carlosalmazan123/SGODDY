<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cita #{{ $cita->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .title { font-size: 18px; font-weight: bold; }
    </style>
</head>
<body>
    <h1 class="title">Detalle de Cita</h1>
    <p><strong>Paciente:</strong> {{ $cita->paciente->nombre }}</p>
    <p><strong>Propietario:</strong> {{ $cita->paciente->propietario->nombre }}</p>
    <p><strong>Servicio:</strong> {{ $cita->servicio->nombre }}</p>
    <p><strong>Fecha:</strong> {{ $cita->fecha_cita }}</p>
    <p><strong>Hora:</strong> {{ $cita->hora_cita }}</p>
</body>
</html>
