<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Unitkerja;
use App\Models\JenjangJabatan;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class JabatanRelationManager extends RelationManager
{
    protected static string $relationship = 'Jabatan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nip')
                    ->label('NIP Pegawai')
                    ->default(fn() => $this->getOwnerRecord()?->nip)
                    ->disabled()->dehydrated(),
                Select::make('jenjang_jabatan')
                    ->label('Jenjang Jabatan')
                    ->options(JenjangJabatan::all()->pluck('golongan', 'golongan'))
                    ->searchable()
                    ->required(),
                Select::make('id_unit_kerja')
                    ->label('Unit Kerja')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => Unitkerja::where('unit_kerja', 'like', "%{$search}%")->limit(50)->pluck('unit_kerja', 'id')->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => Unitkerja::find($value)?->unit_kerja)
                    ->required(),
                TextInput::make('jabatan')
                    ->columnSpan(['sm' => 1, 'md' => 1])
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('jabatan', strtoupper($state));
                    })
                    ->required(),
                TextInput::make('no_sk')
                    ->label('Nomor SK')
                    ->required(),
                DatePicker::make('tgl_sk')
                    ->label('Tanggal SK')
                    ->required(),
                DatePicker::make('tmt_jabatan')
                    ->label('Terhitung Mulai Tanggal')
                    ->required(),
                TextInput::make('bup')
                    ->label('Batas Usia Pensiun')
                    ->required(),
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
                TextColumn::make('jenjang_jabatan')->label('Jenjang Jabatan')->wrap()->sortable()->searchable(),
                TextColumn::make('jabatan')->label('Jabatan')->wrap()->sortable()->searchable(),
                TextColumn::make('unit_kerja')->label('Unit Kerja')->wrap()->sortable()->searchable(),
                TextColumn::make('no_sk')->label('No SK')->wrap()->sortable()->searchable(),
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
