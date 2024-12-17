<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class PasanganRelationManager extends RelationManager
{
    protected static string $relationship = 'pasangan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_pasangan')
                    ->required()
                    ->maxLength(255),
                TextInput::make('nip')
                    ->label('NIP Pasangan')
                    ->default(fn() => $this->getOwnerRecord()?->nip)
                    ->disabled()->dehydrated(),
                TextInput::make('tempat_lahir')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('tanggal_lahir')
                    ->required(),
                DatePicker::make('tanggal_nikah')
                    ->required(),
                Select::make('status_pernikahan')
                    ->required()
                    ->options([
                        'Cerai' => 'Cerai',
                        'Menikah' => 'Menikah'
                    ]),
                TextInput::make('karsi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_pasangan')
            ->columns([
                TextColumn::make('number')->label('No.')->getStateUsing(function ($rowLoop, $livewire) {
                    return $rowLoop->index + 1;
                }),
                Tables\Columns\TextColumn::make('nama_pasangan'),
                Tables\Columns\TextColumn::make('status_pernikahan'),
                Tables\Columns\TextColumn::make('tanggal_nikah'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
