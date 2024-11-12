<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'unit_kerja';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'kode_satket',
        'satuan_kerja',
        'kode_unker',
        'unit_kerja',
    ];
}
