<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sutri extends Model
{
    use HasFactory;

    protected $table = 'pasangan_pegawai';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'nip',
        'nama_pasangan',
        'tempat_lahir',
        'tanggal_lahir',
        'status_pernikahan',
        'id_pegawai',
        'tanggal_nikah',
        'karsi',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id');
    }
}
