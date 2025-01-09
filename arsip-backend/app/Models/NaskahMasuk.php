<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Model;

class NaskahMasuk extends Model
{
    protected $table = 'naskah_masuks'; 
    protected $primaryKey = 'id_naskah_masuk'; 
    public $incrementing = false; 
    protected $keyType = 'int';

    protected $fillable = [
        'id_naskah_masuk',
        'id_pengguna',
        'no_naskah',
        'jenis_naskah',
        'perihal',
        'tujuan',
        'file',
        'tgl_naskah',
    ];

    /**
     * Relasi ke model Pegawai.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pengguna', 'nip');
    }

    /**
     * Relasi ke model Admin.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_pengguna', 'nip');
    }

    /**
     * Method untuk mendapatkan pengguna (Admin atau Pegawai).
     */
    public function pengguna()
    {
        return $this->pegawai ?? $this->admin;
    }
}
