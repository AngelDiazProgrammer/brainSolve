<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function mostrarPrincipal()
    {
        $nombre_usuario = session('nombre_usuario');
        return view('principal', compact('nombre_usuario')); // Retorna la vista chat
    }
}
