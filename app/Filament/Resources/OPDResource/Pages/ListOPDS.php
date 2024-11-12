<?php

namespace App\Filament\Resources\OPDResource\Pages;

use App\Filament\Resources\OPDResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListOPDS extends ListRecords
{
    protected static string $resource = OPDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTitle(): string|Htmlable
    {
        return 'List OPD';
    }
}
