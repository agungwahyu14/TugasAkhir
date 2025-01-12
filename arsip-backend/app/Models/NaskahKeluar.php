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
        'status',
        'is_valid',
        'catatan',
        'updated_by',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pengguna', 'nip');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_pengguna', 'nip');
    }

    public function pengguna()
    {
        return $this->pegawai ?? $this->admin;
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeIsValid($query, $isValid)
    {
        return $query->where('is_valid', $isValid);
    }
}
