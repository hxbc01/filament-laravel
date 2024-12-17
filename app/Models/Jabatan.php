<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'riwayat_jabatan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nip',
        'jenjang_jabatan',
        'unit_kerja',
        'jabatan',
        'no_sk',
        'tgl_sk',
        'tmt_jabatan',
        'bup',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
