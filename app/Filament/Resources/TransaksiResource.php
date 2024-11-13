<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Produk;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationLabel = 'Transaksi';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pelanggan_id')
                    ->relationship('pelanggan', 'nama_pelanggan')
                    ->required(),
                Forms\Components\Select::make('produk_id')
                    ->relationship('produk', 'nama_produk')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $hargaSatuan = Produk::find($state)?->harga;
                        $set('harga', $hargaSatuan);
                    })
                    ->required(),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $get) {
                        $set('total_harga', $get('jumlah') * $get('harga'));
                    }),
                Forms\Components\TextInput::make('harga')
                    ->label('Harga')
                    ->readOnly()
                    ->reactive()
                    ->default(function ($get) {
                        return $get('harga');
                    }),
                Forms\Components\TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->readOnly()
                    ->reactive()
                    ->default(function ($get) {
                        return $get('total_harga');
                    })
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan.nama_pelanggan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('produk.nama_produk')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
