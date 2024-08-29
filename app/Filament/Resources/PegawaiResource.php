<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                            TextInput::make('glr_dpn')
                                ->required()
                                ->columnSpan(['sm' => 1, 'md' => 1]), // Occupies 1 column

                            TextInput::make('nama')
                                ->required()
                                ->columnSpan(['sm' => 1, 'md' => 2]), // Occupies 2 columns

                            TextInput::make('glr_blk')
                                ->required()
                                ->columnSpan(['sm' => 1, 'md' => 1]), // Occupies 1 column
                        ]),
                    Grid::make(['sm' => 1, 'md' => 4]) // 3 columns grid
                        ->schema([
                            TextInput::make('templah')
                                ->required()
                                ->columnSpan(1),
                            DatePicker::make('tgllhr')
                                ->required()
                                ->columnSpan(['md'=>2]),
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
                // TextInput::make('nip')
                //     ->numeric()
                //     ->minValue(1)
                //     ->label('NIP')
                //     ->required()
                //     ->maxLength(45)
                //     ->disabledOn('edit'),
                // TextInput::make('nama')
                //     ->label('Nama Pegawai')
                //     ->required()
                //     ->maxLength(255),
                // TextInput::make('jk')
                //     ->label('Jenis Kelamin')
                //     ->required(),
                // TextInput::make('alamat')
                //     ->label('Alamat')
                //     ->required(),
                // TextInput::make('tpend')
                //     ->label('Tpend')
                //     ->required(),
                // TextInput::make('glr_dpn')
                //     ->label('Gelar Depan'),
                // TextInput::make('glr_blk')
                //     ->label('Gelar Belakang')
                //     ->required(),
                // TextInput::make('templah')
                //     ->label('Tempat Tanggal Lahir')
                //     ->required(),
                // DatePicker::make('tgllhr')
                //     ->label('Tanggal Lahir')
                //     ->native(false)
                //     ->firstDayOfWeek(7)
                //     ->required(),
                // TextInput::make('gol')
                //     ->label('Golongan')
                //     ->required(),
                // DatePicker::make('tmtgol')
                //     ->label('tmt gol')
                //     ->native(false)
                //     ->firstDayOfWeek(7)
                //     ->required(),
                // TextInput::make('jenpeg')
                //     ->label('jen peg')
                //     ->required(),
                // TextInput::make('jenjab')
                //     ->label('jen jab')
                //     ->required(),
                // TextInput::make('jabatan')
                //     ->label('Jabatan')
                //     ->required(),
                // TextInput::make('unker')
                //     ->numeric()
                //     ->minValue(1)
                //     ->label('Unker')
                //     ->required(),
                // TextInput::make('agama')
                //     ->label('Agama')
                //     ->required(),
                // TextInput::make('nober')
                //     ->label('Nober')
                //     ->required(),
                // TextInput::make('bup')
                //     ->label('BUP')
                //     ->required(),
                // DatePicker::make('tmtbup')
                //     ->label('Tmt Bup')
                //     ->native(false)
                //     ->firstDayOfWeek(7)
                //     ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nip')->label('NIP')->sortable()->searchable(),
                TextColumn::make('nama')->label('Nama Pegawai')->sortable()->searchable()->wrap()->size(20),
                // TextColumn::make('jk')->label('Jenis Kelamin'),
                // TextColumn::make('alamat')->label('Alamat')->wrap()->width(190),
                // TextColumn::make('tpend'),
                // TextColumn::make('glr_dpn')->label('Gelar Depan'),
                // TextColumn::make('glr_blk')->label('Gelar Belakang'),
                // TextColumn::make('templah')->label('Tempat Lahir'),
                // TextColumn::make('tgllhr')->label('Tanggal Lahir'),
                // TextColumn::make('gol')->label('Golongan'),
                // TextColumn::make('tmtgol'),
                // TextColumn::make('jenpeg'),
                // TextColumn::make('agama')->label('Agama'),
                // TextColumn::make('nober'),
                // TextColumn::make('bup'),
                // TextColumn::make('tmtbup'),
                // TextColumn::make('anaks.nama')->label('Nama Anak')->wrap(),
                // TextColumn::make('pasangan.nama')->label('Nama Pasangan'),
                // TextColumn::make('unker'),
                TextColumn::make('unitkerja.unker')->label('OPD')->wrap()->sortable()->searchable(),
                TextColumn::make('jenjab'),
                TextColumn::make('jabatan')->label('Jabatan')->wrap()->width(100),
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
            //
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
