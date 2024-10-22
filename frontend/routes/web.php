<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

//Rutas ""principal""
Route::get('/cambiarcontraseña', function () {
    return view('cambiarcontraseña'); // Vista para cambiar contraseña
});

Route::get('/soportechat', function () {
    return view('soportechat'); // Vista para soporte chat
});




//Index
Route::get('/', function () {
    return view('index');
});

//Rutas de login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


//Redireccion a chat
Route::get('/principal', [IndexController::class, 'mostrarPrincipal'])->name('principal');


//Rutas a flask
Route::post('/generate', [ChatController::class, 'generate'])->name('generate');

