<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OPDResource\Pages;
use App\Filament\Resources\OPDResource\RelationManagers;
use App\Models\OPD;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OPDResource extends Resource
{
    protected static ?string $model = OPD::class;

    protected static ?string $navigationIcon = 'heroicon-m-building-office-2';
    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return 'Organisasi Pemerintah Daerah';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi OPD')->schema([
                    Grid::make(['sm' => 1, 'md' => 2])
                        ->schema([
                            TextInput::make('kode_satker')
                                ->required()
                                ->columnSpan(['sm' => 1, 'md' => 2]),
                            TextInput::make('satuan_kerja')
                                ->required()
                                ->columnSpan(['sm' => 1, 'md' => 2]),
                        ]),

                    Grid::make(['sm' => 1, 'md' => 2])
                        ->schema([
                            TextInput::make('kode_unker')
                                ->required()
                                ->columnSpan(['sm' => 1, 'md' => 2]),
                            TextInput::make('unit_kerja')
                                ->required()
                                ->columnSpan(['sm' => 1, 'md' => 2]),
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
                TextColumn::make('kode_unker')->label('Kode Unker')->wrap()->sortable()->searchable(),
                TextColumn::make('unit_kerja')->label('Unit Kerja')->sortable()->searchable()->wrap()->size(20),
                TextColumn::make('satuan_kerja')->label('Satuan Kerja')->sortable()->wrap()->size(18),
            ])
            ->filters([
                Filter::make('unit_kerja')
                    ->label('Unit Kerja')
                    ->form([
                        TextInput::make('unit_kerja')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['unit_kerja'],
                            fn($query, $unit_kerja) =>
                            $query->where('unit_kerja', 'like', "%{$unit_kerja}%")
                        );
                    }),
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
            'index' => Pages\ListOPDS::route('/'),
            'create' => Pages\CreateOPD::route('/create'),
            'view' => Pages\ViewOPD::route('/{record}'),
            'edit' => Pages\EditOPD::route('/{record}/edit'),
        ];
    }
}
