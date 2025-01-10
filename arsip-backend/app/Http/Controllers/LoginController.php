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
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Ambil input
        $email = $request->email;
        $password = $request->password;

        // Cek di tabel Pegawai
        $user = Pegawai::where('email', $email)->first();

        if (!$user) {
            // Jika tidak ditemukan di Pegawai, cek di Admin
            $user = Admin::where('email', $email)->first();
        }

        // Jika user tidak ditemukan
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan.',
            ], 404);
        }

        // Verifikasi password
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah.',
            ], 401);
        }

        // Buat token JWT
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => $user,
        ]);
    }
}
