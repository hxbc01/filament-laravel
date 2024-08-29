<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unitkerja extends Model
{
    use HasFactory;
    
    protected $table = 'data_unker';
    protected $primaryKey = 'no';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'kode_satker',
        'satker',
        'kode_unker',
        'kojab',
        'unker',
        'ess',
        'unit',
        'jabatan',
        'pejabat'
    ];

    function pegawais(): HasMany {
        return $this->hasMany(Pegawai::class, 'unker','kode_unker');
    }
}
