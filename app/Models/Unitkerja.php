<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unitkerja extends Model
{
    use HasFactory;

    protected $table = 'unit_kerja';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'kode_satker',
        'satuan_kerja',
        'kode_unker',
        'unit_kerja'
    ];

    function pegawais(): HasMany {
        return $this->hasMany(Pegawai::class, 'id_unit_kerja','id');
    }
}
