<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'daf_peg';
    protected $primaryKey = 'no';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'nip',
        'nama',
        'jk',
        'alamat',
        'tpend',
        'glr_depan',
        'glr_blk',
        'templah',
        'tgllhr',
        'gol',
        'tmtgol',
        'jenpeg',
        'jenjab',
        'jabatan',
        'unker',
        'agama',
        'nober',
        'bup',
        'tmtbup',
    ];

}
