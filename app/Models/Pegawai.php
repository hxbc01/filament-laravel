<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function anaks(): HasMany
    {
        return $this->hasMany(Anak::class, 'nip', 'nip');
    }

    public function pasangan(): HasOne
    {
        return $this->hasOne(Sutri::class, 'nip', 'nip');
    }

    public function unitkerja(): BelongsTo {
        return $this->belongsTo(Unitkerja::class, 'unker','kode_unker');
    }

}
