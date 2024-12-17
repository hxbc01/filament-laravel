<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Golongan;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class PangkatRelationManager extends RelationManager
{
    protected static string $relationship = 'Pangkat';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nip')
                    ->label('NIP Pegawai')
                    ->default(fn() => $this->getOwnerRecord()?->nip)
                    ->disabled()->dehydrated(),
                Select::make('golongan')
                    ->label('Golongan')
                    ->options(Golongan::all()->pluck('golongan', 'golongan'))
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('pangkat', null);
                    }),
                Select::make('pangkat')
                    ->label('Pangkat')
                    ->options(fn(callable $get) => Golongan::where('golongan', $get('golongan'))->pluck('nama_pangkat', 'nama_pangkat'))
                    ->searchable()
                    ->reactive(),
                TextInput::make('no_sk')
                    ->label('Nomor SK')
                    ->required(),
                DatePicker::make('tanggal_sk')
                    ->label('Tanggal SK')
                    ->required(),
                DatePicker::make('tmt_sk')
                    ->label('Terhitung Mulai Tanggal')
                    ->required(),
                TextInput::make('no_bkn')
                    ->label('Nomor BKN')
                    ->required(),
                TextInput::make('angka_kredit')
                    ->label('Angka Kredit')
                    ->required(),
                TextInput::make('mkgolt')
                    ->label('mk golt')
                    ->required(),
                TextInput::make('mkgolb')
                    ->label('mk golb')
                    ->required(),
                TextInput::make('id_pegawai')
                    ->label('id Pegawai')
                    ->default(fn() => $this->getOwnerRecord()?->id)
                    ->disabled()->dehydrated(),
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
                TextColumn::make('nip')->label('NIP')->wrap()->sortable()->searchable(),
                TextColumn::make('pangkat')->label('Pangkat')->wrap()->sortable()->searchable(),
                TextColumn::make('golongan')->label('Golongan')->wrap()->sortable()->searchable(),
                TextColumn::make('no_sk')->label('NO SK')->wrap()->sortable()->searchable(),
                TextColumn::make('tanggal_sk')->label('Tanggal SK')->wrap()->sortable()->searchable(),
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
