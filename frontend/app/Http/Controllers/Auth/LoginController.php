<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validar las entradas
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Credenciales para la autenticación LDAP
        $credentials = [
            'samaccountname' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        // Intentar autenticar con LDAP
        if (Auth::attempt($credentials)) {
            // Autenticación exitosa, ahora obtenemos el usuario de LDAP
            $ldapUser = LdapUser::where('samaccountname', $request->input('username'))->first();

            if ($ldapUser) {
                // Guardar el nombre completo y la descripción en la sesión
                session([
                    'nombre_usuario' => $ldapUser->getFirstAttribute('cn'), // Nombre completo
                    'descripcion_usuario' => $ldapUser->getFirstAttribute('description'), // Descripción
                ]);
            }

            // Redirigir al dashboard o ruta deseada
            return redirect()->intended('principal');
        } else {
            // Fallo en la autenticación
            return back()->withErrors([
                'message' => 'Credenciales incorrectas o usuario no encontrado en el dominio.',
            ]);
        }
    }
}
