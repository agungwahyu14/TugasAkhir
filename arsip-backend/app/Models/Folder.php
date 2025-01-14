<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'parent_id',
    ];

    /**
     * Relasi Folder dengan Folder Induk
     */
    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    /**
     * Relasi Folder dengan Folder Anak
     */
    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    /**
     * Relasi Folder dengan Arsip (melalui tabel pivot folder_path_arsip)
     */
    public function arsips()
    {
        return $this->belongsToMany(PathArsip::class, 'folder_path_arsip');
    }

    /**
     * Relasi Folder dengan Files
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
