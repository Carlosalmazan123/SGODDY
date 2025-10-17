<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contrato de Cirugía</title>
    <style>
        body {
            font-family: "Arial", Times, serif;
            font-size: 12pt;
            margin: 1cm; /* Margen APA 7: 1 pulgada (2.54 cm) en todos los lados */
            line-height: 1,5; /* Doble espacio */
            text-align: justify;
        }

        h1 {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 1.5em;
        }

        p {
            margin-bottom: 1em;
        }

        strong {
            font-weight: bold;
        }

        .signature-section {
            margin-top: 3em;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
            width: 45%;
        }

        .signature-line {
            margin-top: 3em;
            border-top: 1px solid black;
            width: 100%;
        }
    </style>
</head>
<body>
    <div style="text-align: right; margin-top: 20px;">
    <p><strong>#Consecutivo:</strong> {{ $numeroContrato }}</p>
</div>

    <h1>AUTORIZACIÓN PARA SEDACION / ANESTESIA / CIRUGÍA / PROCEDIMIENTO</h1>

 @php
    use Carbon\Carbon;
    $fecha = Carbon::parse($cita->fecha_cita)->locale('es');
@endphp

<p> {{ $fecha->day }} de {{ $fecha->translatedFormat('F') }} del {{ $fecha->year }}.</p>


    <p>
        Yo, <strong>{{ $propietario->nombre }} {{ $propietario->apellido }}</strong>, 
        N° identificación {{ $propietario->ci }}, domiciliado en {{ $propietario->direccion }}, 
        N° de contacto telefónico: {{ $propietario->telefono }}, en calidad de propietario de la mascota 
        {{ $paciente->nombre }}.
    </p>

    <p>
        Nombre: {{ $paciente->nombre }}, Especie: {{ $paciente->especie }}, Sexo: {{ $paciente->sexo }}, 
        Edad: {{ $paciente->edad }} años, Raza: {{ $paciente->raza }}, Color de pelaje: {{ $paciente->color }}.
    </p>

    <p>
        Autorizo al médico veterinario <strong>{{ $usuario->name }}</strong>, con N° Colegiado 
        <strong>0000</strong>, a efectuar el procedimiento de
        {{ $servicio->nombre }}, destinados a procurar salvaguardar la vida del paciente y/o procurar mejorar la salud del mismo.
    </p>

    <p>
        Dejo constancia y acepto que el profesional responsable me ha explicado personalmente, y entiendo los riesgos asociados al procedimiento, 
        que pueden afectar tanto a la fase anestésica, la fase quirúrgica, como el postoperatorio, que puede incluir, entre otros, 
        el fallecimiento del paciente y posibles complicaciones diferentes de los resultados esperados, así como complicaciones médicas 
        inesperadas donde el médico deberá actuar según el procedimiento adecuado del caso. Asimismo, se recomienda realizar exámenes 
        laboratoriales pertinentes previo a la cirugía.
    </p>

    <p>
        Me comprometo a seguir las indicaciones, tratamientos y prácticas que el Médico Veterinario considere convenientes.
    </p>

    <p>
        Certifico con mi firma que he leído y comprendido la presente autorización, prestando mi consentimiento para el procedimiento.
    </p>

    <div class="signature-section">
        <div class="signature">
            <div class="signature-line"></div>
            Firma del Propietario / Teléfono
        </div>
        
    </div>

</body>
</html>
