<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class PensiunRelationManager extends RelationManager
{
    protected static string $relationship = 'pensiun';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nip')
                    ->label('NIP Pegawai')
                    ->default(fn() => $this->getOwnerRecord()?->nip)
                    ->disabled()->dehydrated(),
                TextInput::make('nama')
                    ->label('Nama Pegawai')
                    ->default(fn() => $this->getOwnerRecord()?->nama_pegawai)
                    ->disabled()->dehydrated(),
                TextInput::make('tmt')
                    ->label('TMT Pensiun')
                    ->default(fn() => $this->getOwnerRecord()?->tmt_bup)
                    ->disabled()->dehydrated(),
                TextInput::make('golongan_akhir')
                    ->label('Golongan')
                    ->default(fn() => $this->getOwnerRecord()?->golongan)
                    ->disabled()->dehydrated(),
                TextInput::make('jabatan_akhir')
                    ->label('Jabatan')
                    ->default(fn() => $this->getOwnerRecord()?->jabatan)
                    ->disabled()->dehydrated(),
                TextInput::make('unit_kerja_akhir')
                    ->label('Unit Kerja')
                    ->default(fn() => $this->getOwnerRecord()?->unitKerja?->unit_kerja)
                    ->disabled()->dehydrated(),
                TextInput::make('nober')
                    ->label('No Arsip')
                    ->default(fn() => $this->getOwnerRecord()?->nober)
                    ->disabled()->dehydrated(),
                Select::make('jenis')
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
                TextColumn::make('number')->label('No.')->getStateUsing(function ($rowLoop, $livewire) {
                    return $rowLoop->index + 1;
                }),
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
