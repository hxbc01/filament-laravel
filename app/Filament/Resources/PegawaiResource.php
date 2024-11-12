<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\Unitkerja;
use App\Models\Pensiun;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 1;

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
                                ->disabled(fn($record) => $record !== null)
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
                                ->required(),
                            Select::make('jenis_kelamin')
                                ->required()
                                ->options([
                                    'Laki - Laki' => 'Laki - Laki',
                                    'Perempuan' => 'Perempuan'
                                ]),
                            Select::make('agama')
                                ->required()
                                ->options([
                                    'ISLAM' => 'ISLAM',
                                    'KRISTEN' => 'KRISTEN',
                                    'KATHOLIK' => 'KATHOLIK',
                                    'HINDU' => 'HINDU',
                                    'BUDHA' => 'BUDHA',
                                    'KHONGHUCU' => 'KHONGHUCU'
                                ]),
                        ]),

                    Grid::make(['sm' => 1, 'md' => 4]) // 3 columns grid
                        ->schema([
                            Select::make('id_unit_kerja')
                                ->label('Unit Kerja')
                                ->required()
                                ->searchable()
                                ->columnSpan(2)
                                ->getSearchResultsUsing(fn(string $search): array => Unitkerja::where('unit_kerja', 'like', "%{$search}%")->limit(50)->pluck('unit_kerja', 'id')->toArray())
                                ->getOptionLabelUsing(fn($value): ?string => Unitkerja::find($value)?->unit_kerja),
                            Select::make('golongan')
                                ->label('Golongan')
                                ->options(Golongan::all()->pluck('golongan', 'golongan'))
                                ->searchable(),
                            TextInput::make('jabatan')
                                ->columnSpan(['sm' => 1, 'md' => 1])
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set) {
                                    $set('jabatan', strtoupper($state));
                                })
                        ]),
                    Textarea::make('alamat')
                        ->required()

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
                TextColumn::make('nip')->label('NIP')->wrap()->sortable()->searchable(),
                TextColumn::make('nama_pegawai')->label('Nama Pegawai')->sortable()->searchable()->wrap()->size(20),
                TextColumn::make('golongan')->label('Gol')->sortable()->wrap()->size(4),
                TextColumn::make('jabatan')->label('Jabatan')->sortable()->wrap()->size(18),
                TextColumn::make('unitkerja.unit_kerja')->label('Unit Kerja')->wrap()->sortable()->searchable(),
                TextColumn::make('pensiun.nip')
                    ->label('Status Pensiun')
                    ->formatStateUsing(function ($record) {
                        return Pensiun::where('nip', $record->nip)->exists() ? 'pensiun' : null;
                    })
                    ->badge()
                    ->colors([
                        'danger' => fn($state) => $state === 'pensiun',
                    ]),
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
                Filter::make('nama_pegawai')
                    ->label('Nama')
                    ->form([
                        TextInput::make('nama_pegawai')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nama_pegawai'],
                            fn($query, $nama_pegawai) =>
                            $query->where('nama_pegawai', 'like', "%{$nama_pegawai}%")
                        );
                    })
            ], FiltersLayout::AboveContent)
            ->deferFilters()
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalSubheading('Apakah kamu yakin ingin menghapus item ini?')
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
            RelationManagers\PendidikansRelationManager::class,
            RelationManagers\PensiunRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'view' => Pages\ViewPegawai::route('/{record}'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
    public static function getNavigationLabel(): string
    {
        return 'Data Pegawai';
    }
}
