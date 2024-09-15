<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');

        // Realizar la solicitud a la API Flask utilizando file_get_contents
        $url = 'http://localhost:5000/generate';
        $data = json_encode(['prompt' => $prompt]);
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => $data,
            ],
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        // Verificar si se pudo realizar la solicitud
        if ($response === false) {
            return response()->json(['error' => 'Error al realizar la solicitud a la API Flask'], 500);
        }

        // Decodificar la respuesta JSON
        $responseData = json_decode($response);

        return response()->json($responseData);
    }
}
