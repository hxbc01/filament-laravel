<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pensiun extends Model
{
    use HasFactory;
    protected $table = 'pensiun_pegawai';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nip',
        'nama',
        'golongan_akhir',
        'jabatan_akhir',
        'unit_kerja_akhir',
        'jenis',
        'tmt',
        'nober',

    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
