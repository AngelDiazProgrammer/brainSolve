<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

//Rutas de app

//Index
Route::get('/', function () {
    return view('index');
});

//Rutas de login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


//Redireccion a chat
Route::get('/chat', [IndexController::class, 'mostrarChat'])->name('chat');


//Rutas a flask
Route::post('/generate', [ChatController::class, 'generate'])->name('generate');

