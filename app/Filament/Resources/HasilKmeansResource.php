<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HasilKmeansResource\Pages;
use App\Filament\Resources\HasilKmeansResource\RelationManagers;
use App\Models\HasilKmeans;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HasilKmeansResource extends Resource
{
    protected static ?string $model = HasilKmeans::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationLabel = 'Hasil K-Means';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pelanggan_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('cluster_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pelanggan.nama_pelanggan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cluster_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cluster.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListHasilKmeans::route('/'),
            'create' => Pages\CreateHasilKmeans::route('/create'),
            'edit' => Pages\EditHasilKmeans::route('/{record}/edit'),
        ];
    }
}
