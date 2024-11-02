<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TrainController extends Controller
{
    public function showTrainForm()
    {
        return view('train');
    }

    public function trainModel(Request $request)
    {
        $client = new Client();

        // Enviar los datos y parámetros al backend de Flask
        $response = $client->post('http://localhost:5000/train-gpt2', [
            'multipart' => [
                [
                    'name' => 'data_file',
                    'contents' => fopen($request->file('data_file')->getPathname(), 'r'),
                    'filename' => $request->file('data_file')->getClientOriginalName()
                ],
                [
                    'name' => 'learning_rate',
                    'contents' => $request->input('learning_rate')
                ],
                [
                    'name' => 'num_train_epochs',
                    'contents' => $request->input('num_train_epochs')
                ],
                [
                    'name' => 'batch_size',
                    'contents' => $request->input('batch_size')
                ],
                [
                    'name' => 'weight_decay',
                    'contents' => $request->input('weight_decay')
                ]
            ]
        ]);

        // Mostrar el mensaje de éxito al usuario
        $body = json_decode($response->getBody(), true);
        return back()->with('status', $body['message']);
    }

    public function rollbackModel(Request $request)
    {
        $client = new Client();

        // Enviar el nombre de la versión a restaurar al backend de Flask
        $response = $client->post('http://localhost:5000/rollback', [
            'form_params' => [
                'backup_version' => $request->input('backup_version')
            ]
        ]);

        // Mostrar el mensaje de éxito al usuario
        $body = json_decode($response->getBody(), true);
        return back()->with('status', $body['message']);
    }
}
