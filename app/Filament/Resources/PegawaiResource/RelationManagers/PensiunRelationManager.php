<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PensiunRelationManager extends RelationManager
{
    protected static string $relationship = 'pensiun';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->label('NIP Pegawai')
                    ->default(fn() => $this->getOwnerRecord()?->nip)
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Pegawai')
                    ->default(fn() => $this->getOwnerRecord()?->nama_pegawai)
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('tmt')
                    ->label('TMT Pensiun')
                    ->default(fn() => $this->getOwnerRecord()?->tmt_bup)
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('golongan_akhir')
                    ->label('Golongan')
                    ->default(fn() => $this->getOwnerRecord()?->golongan)
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('jabatan_akhir')
                    ->label('Jabatan')
                    ->default(fn() => $this->getOwnerRecord()?->jabatan)
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('unit_kerja_akhir')
                    ->label('Unit Kerja')
                    ->default(fn() => $this->getOwnerRecord()?->unitKerja?->unit_kerja)
                    ->disabled()->dehydrated(),
                Forms\Components\TextInput::make('nober')
                    ->label('No Arsip')
                    ->default(fn() => $this->getOwnerRecord()?->nober)
                    ->disabled()->dehydrated(),
                Forms\Components\Select::make('jenis')
                    ->required()
                    ->options([
                        'BUP' => 'BUP',
                        'APS' => 'APS',
                        'Meninggal' => 'Meninggal',
                        'Hukuman Disiplin' => 'Hukuman Disiplin'
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nip')
            ->columns([
                Tables\Columns\TextColumn::make('nip'),
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('tmt'),
                Tables\Columns\TextColumn::make('golongan_akhir'),
                Tables\Columns\TextColumn::make('jabatan_akhir'),
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
