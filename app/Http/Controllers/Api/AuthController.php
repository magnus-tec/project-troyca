<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verificar las credenciales
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credenciales incorrectas',
            ], 401);
        }
        // $user = Auth::user();

        // // Verificar si el estado del usuario es 1
        // if ($user->status != 1) {
        //     return response()->json([
        //         'message' => 'El usuario está desactivado. Contacta con el administrador.',
        //     ], 403);  // Código de estado 403 para acceso prohibido
        // }
        // Obtener el usuario autenticado
        $user = Auth::user();
        $roles = $user->roles()->pluck('name');        // Generar el token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $user,
            'token' => $token,
            'roles' => $roles

        ], 200);
    }
}
