<?php

// app/Http/Controllers/PasswordController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasswordController extends Controller
{
    public function cambiarContrasena(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);

        $username = $request->input('username');
        $newPassword = $request->input('new_password');

        $response = Http::post('http://localhost:8080/cambiarContrasena', [
            'username' => $username,
            'new_password' => $newPassword,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Contraseña cambiada exitosamente.');
        } else {
            return back()->withErrors(['error' => 'No se pudo cambiar la contraseña.']);
        }
    }
}
