<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Model;

class NaskahMasuk extends Model
{
    protected $table = 'naskah_masuks'; 
    public $timestamps = true; 
    protected $fillable = [
        'id_pengguna',
        'no_naskah',
        'jenis_naskah',
        'perihal',
        'tujuan',
        'file',
        'tgl_naskah',
        'status',
        'is_valid',
        'catatan',
        'updated_by',
    ];

    /**
     * Relasi ke model Admin.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_pengguna', 'nip');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pengguna', 'nip');
    }

    /**
     * Relasi ke model Admin sebagai updater.
     */
    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }

    /**
     * Scope untuk naskah dengan status tertentu.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk naskah validasi.
     */
    public function scopeIsValid($query, $isValid = true)
    {
        return $query->where('is_valid', $isValid);
    }
}
