<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

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
