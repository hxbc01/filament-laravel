<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $table = 'cuti_pegawai';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nip',
        'nama',
        'tanggal_usul',
        'jenis_cuti',
        'alasan_cuti',
        'mulai_tanggal',
        'sampai_tanggal',
        'tanggal_surat',

    ];
}
