<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pegawai')->schema([
                    Grid::make(['sm' => 1, 'md' => 4]) // 3 columns grid
                        ->schema([
                            TextInput::make('nip')
                                ->required()
                                ->columnSpan(1)
                        ]),

                    Grid::make(['sm' => 1, 'md' => 4]) // 3 columns grid
                        ->schema([
                            TextInput::make('gelar_depan')
                                ->columnSpan(['sm' => 1, 'md' => 1]), // Occupies 1 column

                            TextInput::make('nama_pegawai')
                                ->required()
                                ->columnSpan(['sm' => 1, 'md' => 2]), // Occupies 2 columns

                            TextInput::make('gelar_belakang')
                                ->columnSpan(['sm' => 1, 'md' => 1]), // Occupies 1 column
                        ]),
                    Grid::make(['sm' => 1, 'md' => 4]) // 3 columns grid
                        ->schema([
                            TextInput::make('tempat_lahir')
                                ->required()
                                ->columnSpan(1),
                            DatePicker::make('tanggal_lahir')
                                ->required()
                                ->columnSpan(['md' => 2]),
                        ]),

                    Grid::make(['sm' => 1, 'md' => 4]) // 3 columns grid
                        ->schema([
                            Select::make('agama')
                                ->options([
                                    'ISLAM' => 'ISLAM',
                                    'KRISTEN' => 'KRISTEN',
                                    'KATHOLIK' => 'KATHOLIK',
                                    'HINDU' => 'HINDU',
                                    'BUDHA' => 'BUDHA',
                                ])
                        ]),
                    Textarea::make('alamat')

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('No.')->getStateUsing(function ($rowLoop, $livewire) {
                    return $rowLoop->index + 1;
                }),
                TextColumn::make('nip')->label('NIP')->sortable()->searchable(),
                TextColumn::make('nama_pegawai')->label('Nama Pegawai')->sortable()->searchable()->wrap()->size(20),
                TextColumn::make('golongan')->label('Gol')->sortable()->wrap()->size(4),
                TextColumn::make('jabatan')->label('Jabatan')->sortable()->wrap()->size(18),
                TextColumn::make('unitkerja.unit_kerja')->label('Unit Kerja')->wrap()->sortable()->searchable(),
            ])
            ->filters([
                Filter::make('nip')
                    ->label('NIP')
                    ->form([
                        TextInput::make('nip')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nip'],
                            fn($query, $nip) =>
                            $query->where('nip', 'like', "%{$nip}%")
                        );
                    }),
                Filter::make('nama')
                    ->label('Nama')
                    ->form([
                        TextInput::make('nama')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nama'],
                            fn($query, $nama) =>
                            $query->where('nama', 'like', "%{$nama}%")
                        );
                    })
            ], FiltersLayout::AboveContent)
            ->deferFilters()
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AnaksRelationManager::class,
            RelationManagers\PasanganRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}
