<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string|min:6',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Check Pegawai first
        $user = Pegawai::where('username', $email)
                      ->where('status', 'aktif')
                      ->first();
        $model = 'Pegawai';

        if (!$user) {
            // If not found in Pegawai, check Admin
            $user = Admin::where('username', $email)
                        ->where('status', 'aktif')
                        ->first();
            $model = 'Admin';
        }

        if (!$user) {
            return response()->json([
                'status_code' => 404,
                'success' => false,
                'message' => 'Email tidak ditemukan atau akun tidak aktif.',
            ], 404);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'status_code' => 401,
                'success' => false,
                'message' => 'Password salah.',
            ], 401);
        }

        // Create custom claims with model type
        $customClaims = [
            'model' => $model,
            'email' => $user->email,
            'status' => $user->status
        ];

        // Generate token with custom claims
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        return response()->json([
            'status_code' => 200,
            'success' => true,
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => $user,
        ]);
    }
}