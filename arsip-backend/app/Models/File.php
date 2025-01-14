<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'extension',
        'size',
        'path',
        'folder_id',
    ];

    /**
     * Relasi File dengan Folder
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Relasi File dengan Arsip
     */
    public function arsip()
    {
        return $this->belongsTo(PathArsip::class, 'path_arsip_id');
    }
}
