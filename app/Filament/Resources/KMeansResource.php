<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KMeansResource\Pages;
use App\Filament\Resources\KMeansResource\RelationManagers;
use App\Models\KMeans;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KMeansResource extends Resource
{
    protected static ?string $model = KMeans::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationLabel = 'K-Means';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('iteration')
                ->label('Iteration')
                ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('centroids')
                ->label('Centroids')
                ->formatStateUsing(fn($state) => self::formatCentroids(json_decode($state, true)))
                    ->html(),

                Tables\Columns\TextColumn::make('clusters')
                ->label('Clusters')
                ->formatStateUsing(fn($state) => self::formatClusters(json_decode($state, true)))
                    ->html(),

                Tables\Columns\TextColumn::make('differences')
                ->label('Differences')
                ->formatStateUsing(fn($state) => self::formatDifferences(json_decode($state, true)))
                    ->html(),

                Tables\Columns\TextColumn::make('cluster_count')
                ->label('Cluster Count')
                ->sortable(),

            ])
            ->filters([
               //filter
            ])
            ->actions([])
            ->bulkActions([]);
    }

    /**
     * Format centroids untuk tampilan tabel.
     */
    protected static function formatCentroids(array $centroids): string
    {
        return collect($centroids)
            ->map(fn($centroid, $index) => '<strong>C' . ($index + 1) . ':</strong> [' . implode(', ', $centroid) . ']')
            ->implode('<br>');
    }

    /**
     * Format clusters untuk tampilan tabel.
     */
    protected static function formatClusters(array $clusters): string
    {
        return collect($clusters)
            ->map(fn($cluster, $index) => '<strong>Cluster ' . ($index + 1) . ':</strong> (' . count($cluster) . ' points)')
            ->implode('<br>');
    }

    /**
     * Format differences untuk tampilan tabel.
     */
    protected static function formatDifferences(array $differences): string
    {
        return collect($differences)
            ->map(fn($difference, $index) => '<strong>Change C' . ($index + 1) . ':</strong> ' . $difference)
            ->implode('<br>');
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
            'index' => Pages\ListKMeans::route('/'),
            'create' => Pages\CreateKMeans::route('/create'),
            'edit' => Pages\EditKMeans::route('/{record}/edit'),
        ];
    }
}
