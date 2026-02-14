<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login
     */
    public function login(Request $request)
    {
                
    

        $credentials = $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);
        

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Credenciales incorrectas'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }

    /**
     * Refresh Token
     */
    public function refresh()
    {
        $newToken = Auth::guard('api')->refresh();

        return $this->respondWithToken($newToken);
    }

    /**
     * Respuesta estándar
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user()
        ]);
    }
}
