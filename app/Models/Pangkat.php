<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pangkat extends Model
{
    use HasFactory;
    protected $table = 'riwayat_pangkat';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nip',
        'jenis_kp',
        'pangkat',
        'golongan',
        'no_sk',
        'tanggal_sk',
        'tmt_sk',
        'no_bkn',
        'tanggal_bkn',
        'angka_kredit',
        'mkgolt',
        'mkgolb',
        'id_pegawai',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
