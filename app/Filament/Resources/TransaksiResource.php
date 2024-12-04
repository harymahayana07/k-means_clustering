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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
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
                Tables\Columns\TextColumn::make('tanggal_transaksi')
                    ->date()
                    ->label('Tanggal Transaksi')
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
                // Filter Berdasarkan Tahun
                Filter::make('filter_tahun')
                    ->form([
                        Select::make('tahun')
                            ->label('Tahun')
                            ->options(
                                Transaksi::query()
                                    ->selectRaw('EXTRACT(YEAR FROM tanggal_transaksi) as tahun')
                                    ->distinct()
                                    ->orderBy('tahun', 'desc')
                                    ->pluck('tahun', 'tahun')
                                    ->toArray()
                            ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['tahun'],
                            fn (Builder $query, $tahun): Builder => $query->whereYear('tanggal_transaksi', $tahun),
                        );
                    }),
            
                // Filter Berdasarkan Bulan
                Filter::make('filter_bulan')
                    ->form([
                        Select::make('bulan')
                            ->label('Bulan')
                            ->options([
                                '1' => 'Januari',
                                '2' => 'Februari',
                                '3' => 'Maret',
                                '4' => 'April',
                                '5' => 'Mei',
                                '6' => 'Juni',
                                '7' => 'Juli',
                                '8' => 'Agustus',
                                '9' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['bulan'],
                            fn (Builder $query, $bulan): Builder => $query->whereMonth('tanggal_transaksi', $bulan),
                        );
                    }),
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
