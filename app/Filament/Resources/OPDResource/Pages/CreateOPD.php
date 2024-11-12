<?php

namespace App\Filament\Resources\OPDResource\Pages;

use App\Filament\Resources\OPDResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateOPD extends CreateRecord
{
    protected static string $resource = OPDResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Tambah OPD';
    }
}
