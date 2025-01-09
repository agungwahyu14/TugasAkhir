<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Model;

class NaskahKeluar extends Model
{
    protected $table = 'naskah_keluars'; 
    protected $primaryKey = 'id_naskah_keluar';
    public $incrementing = false; 
    protected $keyType = 'int';

    protected $fillable = [
        'id_naskah_keluar',
        'id_pengguna',
        'no_naskah',
        'jenis_naskah',
        'perihal',
        'asal_naskah',
        'tujuan',
        'file',
        'tgl_naskah',
    ];

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
