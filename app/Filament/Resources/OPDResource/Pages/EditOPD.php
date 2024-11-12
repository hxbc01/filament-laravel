<?php

namespace App\Filament\Resources\OPDResource\Pages;

use App\Filament\Resources\OPDResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOPD extends EditRecord
{
    protected static string $resource = OPDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
