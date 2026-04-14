<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Handles API authentication.
 *
 * This controller is responsible for handling user login and issuing API tokens.
 */
class LoginController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param \App\Http\Requests\Api\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Credenciales inválidas',
                    'errors' => [
                        'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.']
                    ]
                ], 401);
            }

            $user = Auth::user();
            $deviceName = $request->input('device_name', 'auth_token');
            
            // Crear token Sanctum
            $token = $user->createToken($deviceName)->plainTextToken;

            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('LoginController::login - Error durante autenticación', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Error durante el proceso de autenticación',
                'error' => config('app.debug') ? $e->getMessage() : 'Contacta con el administrador',
            ], 500);
        }
    }
}
