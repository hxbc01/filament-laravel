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

    protected $table = 'pegawai';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'nip',
        'nama_pegawai',
        'jenis_kelamin',
        'alamat',
        'tpend',
        'gelar_depan',
        'gelar_belakang',
        'tempat_lahir',
        'tanngal_lahir',
        'golongan',
        'tmtgol',
        'jenjang_pegawai',
        'jenjang_jabatan',
        'jabatan',
        'agama',
        'nober',
        'bup',
        'tmtbup',
        'id_unit_kerja'
    ];
    public function unitkerja(): BelongsTo {
        return $this->belongsTo(Unitkerja::class, 'id_unit_kerja','id');
    }

    public function anaks(): HasMany
    {
        return $this->hasMany(Anak::class, 'id_pegawai', 'id');
    }

    public function pasangan(): HasOne
    {
        return $this->hasOne(Sutri::class, 'id_pegawai', 'id');
    }

}
