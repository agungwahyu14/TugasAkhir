<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Models\Admin;
use App\Models\Pegawai;

class VerifyTokenJWT
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ditemukan di header Authorization.',
            ], 401);
        }

        try {
            // Get the token
            $token = substr($authHeader, 7);
            
            // Set the token
            JWTAuth::setToken($token);
            
            // Try to decode the token
            $payload = JWTAuth::getPayload();
            
            // Get the model type from the payload
            $model = $payload->get('model');
            
            // Authenticate based on model type
            if ($model === 'Admin') {
                $user = Admin::find($payload->get('sub'));
            } else if ($model === 'Pegawai') {
                $user = Pegawai::find($payload->get('sub'));
            } else {
                throw new JWTException('Invalid user type');
            }

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan.',
                ], 404);
            }

            // Add user to request
            $request->merge(['user' => $user]);
            
            return $next($request);

        } catch (TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token telah kedaluwarsa.',
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid.',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ditemukan atau terjadi kesalahan: ' . $e->getMessage(),
            ], 401);
        }
    }
}