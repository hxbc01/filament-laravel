<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenjangJabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan_pegawai';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'golongan',
        'kode_golongan',
    ];
}
