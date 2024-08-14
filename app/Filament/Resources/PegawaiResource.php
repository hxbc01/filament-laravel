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
use Filament\Tables\Columns\TextColumn;
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
                TextInput::make('nip')
                    ->numeric()
                    ->minValue(1)
                    ->label('NIP')
                    ->required()
                    ->maxLength(45),
                TextInput::make('nama')
                    ->label('Nama Pegawai')
                    ->required()
                    ->maxLength(255),
                TextInput::make('jk')
                    ->label('Jenis Kelamin')
                    ->required(),
                TextInput::make('alamat')
                    ->label('Alamat')
                    ->required(),
                TextInput::make('tpend')
                    ->label('Tpend')
                    ->required(),
                TextInput::make('glr_dpn')
                    ->label('Gelar Depan'),
                TextInput::make('glr_blk')
                    ->label('Gelar Belakang')
                    ->required(),
                TextInput::make('templah')
                    ->label('Tempat Tanggal Lahir')
                    ->required(),
                DatePicker::make('tgllhr')
                    ->label('Tanggal Lahir')
                    ->native(false)
                    ->firstDayOfWeek(7)
                    ->required(),
                TextInput::make('gol')
                    ->label('Golongan')
                    ->required(),
                DatePicker::make('tmtgol')
                    ->label('tmt gol')
                    ->native(false)
                    ->firstDayOfWeek(7)
                    ->required(),
                TextInput::make('jenpeg')
                    ->label('jen peg')
                    ->required(),
                TextInput::make('jenjab')
                    ->label('jen jab')
                    ->required(),
                TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->required(),
                TextInput::make('unker')
                    ->numeric()
                    ->minValue(1)
                    ->label('Unker')
                    ->required(),
                TextInput::make('agama')
                    ->label('Agama')
                    ->required(),
                TextInput::make('nober')
                    ->label('Nober')
                    ->required(),
                TextInput::make('bup')
                    ->label('BUP')
                    ->required(),
                DatePicker::make('tmtbup')
                    ->label('Tmt Bup')
                    ->native(false)
                    ->firstDayOfWeek(7)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Pegawai::query()
                ->join('anak', 'daf_peg.nip', '=', 'anak.nip')
                ->select('daf_peg.*', 'anak.nama as Nama_anak'))
            ->columns([
                TextColumn::make('nip')->label('NIP')->sortable()->searchable(),
                TextColumn::make('nama')->label('Nama Pegawai')->sortable()->searchable()->wrap()->size(20),
                TextColumn::make('jk')->label('Jenis Kelamin'),
                TextColumn::make('alamat')->label('Alamat')->wrap()->width(190),
                TextColumn::make('tpend'),
                TextColumn::make('glr_dpn')->label('Gelar Depan'),
                TextColumn::make('glr_blk')->label('Gelar Belakang'),
                TextColumn::make('templah')->label('Tempat Lahir'),
                TextColumn::make('tgllhr')->label('Tanggal Lahir'),
                TextColumn::make('gol')->label('Golongan'),
                TextColumn::make('tmtgol'),
                TextColumn::make('jenpeg'),
                TextColumn::make('jenjab'),
                TextColumn::make('jabatan')->label('Jabatan')->wrap()->width(100),
                TextColumn::make('unker'),
                TextColumn::make('agama')->label('Agama'),
                TextColumn::make('nober'),
                TextColumn::make('bup'),
                TextColumn::make('tmtbup'),
                TextColumn::make('Nama_anak')->label('Nama Anak'),
            ])
            ->filters([
                //
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
