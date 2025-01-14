<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathArsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_berkas', 
        'no_berkas', 
        'perihal', 
        'jml_item', 
        'retensi_waktu'
    ];

    /**
     * Relasi Arsip dengan Folder (melalui tabel pivot folder_path_arsip)
     */
    public function folders()
    {
        return $this->belongsToMany(Folder::class, 'folder_path_arsip');
    }

    /**
     * Rela si Arsip dengan Files
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
