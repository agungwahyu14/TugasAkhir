<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FolderPathArsip extends Pivot
{
    protected $table = 'folder_path_arsip';

    protected $fillable = [
        'folder_id', 
        'path_arsip_id',
    ];
}
