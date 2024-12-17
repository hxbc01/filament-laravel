<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CutiResource\Pages;
use App\Models\Cuti;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Models\Pegawai;

class CutiResource extends Resource
{
    protected static ?string $model = Cuti::class;

    protected static ?string $navigationIcon = 'heroicon-s-calendar';
    protected static ?int $navigationSort = 2;

    public $nip;
    public $nama;

    public static function getNavigationLabel(): string
    {
        return 'Cuti Pegawai';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pegawai')->schema([
                    Grid::make(['sm' => 1, 'md' => 3])
                        ->schema([
                            Select::make('nip')
                                ->label('NIP')
                                ->options(Pegawai::all()->pluck('nip', 'nip'))
                                ->searchable()
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $pegawai = Pegawai::where('nip', $state)->first();
                                    $set('nama', $pegawai ? $pegawai->nama_pegawai : '');
                                }),
                            TextInput::make('nama')
                                ->label('Nama Pegawai')
                                ->disabled()->dehydrated(),
                        ]),

                    Grid::make(['sm' => 1, 'md' => 3])
                        ->schema([
                            Select::make('jenis_cuti')
                                ->required()
                                ->options([
                                    'CUTI TAHUNAN' => 'CUTI TAHUNAN',
                                    'CUTI MELAHIRKAN' => 'CUTI MELAHIRKAN',
                                    'CUTI BESAR' => 'CUTI BESAR',
                                    'CUTI SAKIT' => 'CUTI SAKIT',
                                ]),
                            Textarea::make('alasan_cuti')
                                ->required()
                                ->columnSpan(1),
                            DatePicker::make('tanggal_usul')
                                ->required(),
                        ]),
                    Grid::make(['sm' => 1, 'md' => 3]) 
                        ->schema([
                            DatePicker::make('mulai_tanggal')
                                ->required(),
                            DatePicker::make('sampai_tanggal')
                                ->required(),
                            DatePicker::make('tanggal_surat')
                                ->required(),
                        ]),
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
                TextColumn::make('nama')->label('Nama Pegawai')->sortable()->searchable()->wrap()->size(20),
                TextColumn::make('jenis_cuti')->label('Jenis Cuti')->sortable()->wrap()->size(18),
                TextColumn::make('alasan_cuti')->label('Alasan Cuti')->sortable()->wrap()->size(18),
                TextColumn::make('tanggal_usul')->label('Tanggal Usul')->sortable()->wrap()->size(4)
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->translatedFormat('j F Y')),
                TextColumn::make('mulai_tanggal')->label('Mulai Tanggal')->sortable()->wrap()->size(4)
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->translatedFormat('j F Y')),
                TextColumn::make('sampai_tanggal')->label('Sampai Tanggal')->sortable()->wrap()->size(4)
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->translatedFormat('j F Y')),
                TextColumn::make('tanggal_surat')->label('Tanggal Surat')->sortable()->wrap()->size(4)
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->translatedFormat('j F Y')),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCutis::route('/'),
            'create' => Pages\CreateCuti::route('/create'),
            'view' => Pages\ViewCuti::route('/{record}'),
            'edit' => Pages\EditCuti::route('/{record}/edit'),
        ];
    }
}
