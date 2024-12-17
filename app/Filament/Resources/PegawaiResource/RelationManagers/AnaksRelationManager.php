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

class AnaksRelationManager extends RelationManager
{
    protected static string $relationship = 'anaks';
    protected static ?string $recordTitleAttribute = 'nama_anak';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_anak')
                    ->required()
                    ->maxLength(255),
                TextInput::make('nip')
                    ->label('NIP Orang tua')
                    ->default(fn() => $this->getOwnerRecord()?->nip)
                    ->disabled()->dehydrated(),
                DatePicker::make('tanggal_lahir_anak')
                    ->required(),
                Select::make('status')
                    ->options([
                        'Anak Kandung' => 'Anak Kandung',
                        'Anak Tiri' => 'Anak Tiri'
                    ]),
            ]);
    }

    public function beforeSave(Form $form, $record)
    {
        $record->nip = $this->getOwnerRecord()->nip;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_anak')
            ->columns([
                TextColumn::make('number')->label('No.')->getStateUsing(function ($rowLoop, $livewire) {
                    return $rowLoop->index + 1;
                }),
                TextColumn::make('nama_anak'),
                TextColumn::make('tanggal_lahir_anak'),
                TextColumn::make('status'),
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
