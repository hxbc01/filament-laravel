<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use App\Filament\Resources\PegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewPegawai extends ViewRecord
{
    protected static string $resource = PegawaiResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Detail Pegawai';
    }
}
