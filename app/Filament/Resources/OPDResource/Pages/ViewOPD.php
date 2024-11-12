<?php

namespace App\Filament\Resources\OPDResource\Pages;

use App\Filament\Resources\OPDResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOPD extends ViewRecord
{
    protected static string $resource = OPDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
