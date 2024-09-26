<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendidikansRelationManager extends RelationManager
{
    protected static string $relationship = 'pendidikans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->label('NIP Orang tua')
                    ->default(fn() => $this->getOwnerRecord()?->nip)
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('level')
                    ->label('Level')
                    ->maxLength(255),
                Forms\Components\Select::make('jenjang')
                    ->label('Jenjang')
                    ->options([
                        'Sekolah Dasar' => 'Sekolah Dasar',
                        'SLTP' => 'SLTP',
                        'SLTP Kejuruan' => 'SLTP Kejuruan',
                        'SLTA' => 'SLTA',
                        'SLTA Kejuruan' => 'SLTA Kejuruan',
                        'SLTA Keguruan' => 'SLTA Keguruan',
                        'Diploma I' => 'Diploma I',
                        'Diploma II' => 'Diploma II',
                        'Diploma III/Sarjana Muda' => 'Diploma III/Sarjana Muda',
                        'Diploma IV' => 'Diploma IV',
                        'S-1/Sarjana' => 'S-1/Sarjana',
                        'S-2' => 'S-2',
                        'S-3/Doktor' => 'S-3/Doktor',
                    ]),
                Forms\Components\TextInput::make('jurusan')
                    ->label('Jurusan')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tahun_lulus')
                    ->label('Tanggal Lulus'),
                Forms\Components\TextInput::make('no_ijazah')
                    ->label('No Ijazah')
                    ->maxLength(255),
                Forms\Components\TextInput::make('instansi_pendidikan')
                    ->label('Instansi Pendidikan')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nip')
            ->columns([
                Tables\Columns\TextColumn::make('nip'),
                Tables\Columns\TextColumn::make('level'),
                Tables\Columns\TextColumn::make('jenjang'),
                Tables\Columns\TextColumn::make('jurusan'),
                Tables\Columns\TextColumn::make('tahun_lulus'),
                Tables\Columns\TextColumn::make('no_ijazah'),
                Tables\Columns\TextColumn::make('instansi_pendidikan'),
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
