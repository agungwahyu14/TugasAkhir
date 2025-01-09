<?php

namespace App\Models;

use App\Models\NaskahKeluar;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
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
    public function naskahKeluars()
    {
        return $this->hasMany(NaskahKeluar::class, 'id_pengguna', 'nip');
    }
    public function deactivate()
    {
        $this->update(['status' => 'tidak aktif']);
    }

    public function activate()
    {
        $this->update(['status' => 'aktif']);
    }
        
}
