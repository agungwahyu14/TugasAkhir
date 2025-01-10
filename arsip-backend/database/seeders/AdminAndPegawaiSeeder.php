<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminAndPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'nip' => '123456789', // Ganti dengan NIP yang sesuai
            'id_admin' => 1, // ID Admin yang unik
            'nama' => 'Admin Example',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // Password di-hash menggunakan bcrypt
            'username' => 'adminuser',
            'bidang' => 'kadis',
            'status' => 'aktif',
        ]);

        // Membuat data Pegawai
        Pegawai::create([
            'nip' => '987654321', // Ganti dengan NIP yang sesuai
            'id_admin' => 2, // ID Admin yang unik
            'nama' => 'Pegawai Example',
            'email' => 'pegawai@example.com',
            'password' => Hash::make('password123'), // Password di-hash menggunakan bcrypt
            'username' => 'pegawaiuser',
            'bidang' => 'staff',
            'status' => 'aktif',
        ]);
    }
}
