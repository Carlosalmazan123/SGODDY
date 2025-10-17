<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autorización de Eutanasia</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 50px;
            text-align: justify;
        }
        h1 {
            text-align: center;
            font-weight: bold;
            font-size: 16pt;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        p {
            margin-bottom: 12px;
        }
        .right {
            text-align: right;
        }
        .firma-container {
            margin-top: 80px;
            display: flex;
            justify-content: space-between;
        }
        .firma {
            text-align: center;
            width: 40%;
        }
        .firma-linea {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 100%;
            display: inline-block;
        }
    </style>
</head>
<body>
<p class="right"><strong>#Consecutivo:</strong> {{ $numeroContrato }}</p>
    <h1>Autorización de Eutanasia</h1>

    
    <p class="right"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha_cita)->translatedFormat('d \d\e F \d\e Y') }}</p>

    <p>
        Yo, <strong>{{ $propietario->nombre }} {{ $propietario->apellido }}</strong>, 
        con identificación N° <strong>{{ $propietario->ci }}</strong>, 
        domiciliado en <strong>{{ $propietario->direccion }}</strong>, 
        N° de contacto telefónico: <strong>{{ $propietario->telefono }}</strong>.
    </p>

    <p>
        En calidad de propietario de la mascota <strong>{{ $paciente->nombre }}</strong>, 
        especie <strong>{{ $paciente->especie }}</strong>, 
        sexo <strong>{{ $paciente->sexo }}</strong>, 
        edad <strong>{{ $paciente->edad }} años</strong>, 
        raza <strong>{{ $paciente->raza }}</strong>, 
        color de pelaje <strong>{{ $paciente->color }}</strong>.
    </p>

    <p>
        Autorizo al Médico Veterinario <strong>{{ $usuario->name }}</strong>, 
        con N° Colegiado <strong>0000</strong>, 
        a practicar la Eutanasia Clínica de la mascota antes mencionada, 
        de conformidad con la técnica profesional habitual, bajo un método rápido, indoloro, 
        sin crueldad, maltrato o agonía prolongada.
    </p>

    <p>
        La medida a adoptarse es justificada a causa del diagnóstico: 
        <strong>{{ $diagnostico ?? '________________________' }}</strong>.
    </p>

    <p>
        Declaro bajo juramento que el animal a sacrificar es de mi propiedad y otorgo mi 
        consentimiento pleno para dicho procedimiento.
    </p>

    <div class="firma-container">
        <div class="firma">
            <span class="firma-linea"></span><br>
            Firma del Propietario
        </div>
       
    </div>

</body>
</html>
