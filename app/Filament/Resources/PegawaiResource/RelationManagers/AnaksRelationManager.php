<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnaksRelationManager extends RelationManager
{
    protected static string $relationship = 'anaks';
    protected static ?string $recordTitleAttribute = 'nama_anak';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_anak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nip')
                    ->label('NIP Orang tua')
                    ->default(fn() => $this->getOwnerRecord()?->nip)
                    ->disabled()->dehydrated(),
                Forms\Components\DatePicker::make('tanggal_lahir_anak')
                    ->required(),
                Forms\Components\Select::make('status')
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
                Tables\Columns\TextColumn::make('nama_anak'),
                Tables\Columns\TextColumn::make('tanggal_lahir_anak'),
                Tables\Columns\TextColumn::make('status'),
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
