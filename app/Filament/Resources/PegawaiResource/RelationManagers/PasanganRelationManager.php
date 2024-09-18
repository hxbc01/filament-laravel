<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PasanganRelationManager extends RelationManager
{
    protected static string $relationship = 'pasangan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pasangan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nip')
                    ->label('NIP Pasangan')
                    ->default(fn() => $this->getOwnerRecord()?->nip)
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_nikah')
                    ->required(),
                Forms\Components\Select::make('status_pernikahan')
                    ->options([
                        'Cerai' => 'Cerai',
                        'Menikah' => 'Menikah'
                    ]),
                Forms\Components\TextInput::make('karsi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_pasangan')
            ->columns([
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
