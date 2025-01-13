<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    // Nama tabel
    protected $table = 'disposisis';

    // Primary key
    protected $primaryKey = 'id_disposisi';

    // Kolom yang dapat diisi
    protected $fillable = [
        'id_pengguna',
        'jenis_disposisi',
        'isi_disposisi',
        'perihal',
        'tujuan',
        'file',
        'tgl_waktu',
    ];

}
