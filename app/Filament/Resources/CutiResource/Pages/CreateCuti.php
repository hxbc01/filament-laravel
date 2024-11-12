<?php

namespace App\Filament\Resources\CutiResource\Pages;

use App\Filament\Resources\CutiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateCuti extends CreateRecord
{
    protected static string $resource = CutiResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Cuti';
    }
}
