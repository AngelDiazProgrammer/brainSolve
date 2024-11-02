<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TrainController;

// Rutas de login y index que no están protegidas
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('/', function () {
    return view('index');
});

// Rutas protegidas por el middleware 'auth'
Route::group(['middleware' => 'auth'], function () {

    Route::get('/principal', [IndexController::class, 'mostrarPrincipal'])->name('principal');


    Route::get('/cambiarcontraseña', function () {
        return view('cambiarcontraseña'); // Vista para cambiar contraseña
    });

    Route::get('/soportechat', function () {
        return view('soportechat'); // Vista para soporte chat
    });

    Route::get('/train', function() {
        return view('train'); // Vista para entrenamiento del chat
    });

    Route::get('/rollback', function() {
        return view('rollback'); // Vista para retornar form para restaurar una versión del chat
    });

    // Cambiar contraseñas
    // Enviar solicitud POST al backend en Python
    Route::post('/cambiarContraseña', [PasswordController::class, 'cambiarContrasena']);

    // Redirección a chat
    Route::get('/principal', [IndexController::class, 'mostrarPrincipal'])->name('principal');

    // Rutas a Flask
    Route::post('/generate', [ChatController::class, 'generate'])->name('generate');

    // Rutas para entrenamiento desde la interfaz del usuario
    Route::get('/train', [TrainController::class, 'showTrainForm']);
    Route::post('/train-model', [TrainController::class, 'trainModel'])->name('train-model');
    Route::post('/rollback-model', [TrainController::class, 'rollbackModel'])->name('rollback-model');

    // Ruta para cerrar sesión
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

