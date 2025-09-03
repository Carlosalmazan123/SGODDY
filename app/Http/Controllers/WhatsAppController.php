<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public function enviarRecordatorio(Request $request)
    {
        $telefono = $request->telefono;
        $nombre   = $request->nombre;
        $mascota  = is_array($request->paciente) ? ($request->paciente['nombre'] ?? '') : $request->paciente;
 // string desde el onclick
        $fecha    = $request->fecha;
        $hora     = $request->hora;

        // 🔹 Validar datos obligatorios
        if (!$telefono || !$nombre || !$mascota || !$fecha || !$hora) {
            return response()->json([
                'success' => false,
                'message' => 'Faltan datos requeridos',
                'data' => compact('telefono', 'nombre', 'mascota', 'fecha', 'hora')
            ]);
        }

        // 🔹 Enviar plantilla de WhatsApp
        $response = Http::withToken(env('META_TOKEN'))->post(
            'https://graph.facebook.com/v22.0/' . env('META_PHONE_ID') . '/messages',
            [
                "messaging_product" => "whatsapp",
                "to" => $telefono, // ✅ usamos el número directamente
                "type" => "template",
                "template" => [
                    "name" => "recordatorio_cita", // nombre exacto de la plantilla creada en Meta
                    "language" => ["code" => "en"], // idioma de la plantilla
                    "components" => [[
                        "type" => "body",
                        "parameters" => [
                            ["type" => "text", "text" => (string) $nombre],
                            ["type" => "text", "text" => (string) $mascota],
                            ["type" => "text", "text" => (string) $fecha],
                            ["type" => "text", "text" => (string) $hora],
                        ]
                    ]]
                ]
            ]
        );

        // 🔹 Manejo de respuesta
        if ($response->successful()) {
            return response()->json(['success' => true]);
        } else {
            $error = $response->json();
            return response()->json([
                'success' => false,
                'message' => $error['error']['message'] ?? 'Error desconocido de WhatsApp API',
                'details' => $error
            ]);
        }
    }
}
