<?php

namespace App\Models;

use App\Models\NaskahKeluar;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Model implements JWTSubject
{
    protected $primaryKey = 'nip';
    public $incrementing = false; 
    protected $keyType = 'int';

    protected $fillable = [
        'nip',
        'id_admin',
        'nama',
        'email',
        'password',
        'username',
        'bidang',
        'status'
    ];

    // Relasi ke NaskahKeluar
    public function naskahKeluars()
    {
        return $this->hasMany(NaskahKeluar::class, 'id_pengguna', 'nip');
    }

    // Fungsi untuk mengubah status admin menjadi tidak aktif
    public function deactivate()
    {
        $this->update(['status' => 'tidak aktif']);
    }

    // Fungsi untuk mengubah status admin menjadi aktif
    public function activate()
    {
        $this->update(['status' => 'aktif']);
    }

    // JWT Auth: Mendapatkan identifier unik
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // JWT Auth: Menambahkan klaim tambahan ke token (opsional)
    public function getJWTCustomClaims()
    {
        return [];
    }
}
