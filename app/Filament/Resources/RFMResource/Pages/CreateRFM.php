<?php

namespace App\Filament\Resources\RFMResource\Pages;

use App\Filament\Resources\RFMResource;
use App\Models\RFM;
use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateRFM extends CreateRecord
{
    protected static string $resource = RFMResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        RFM::truncate();
        
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        
        $transaksiData = Transaksi::select('pelanggan_id', 'total_harga', 'created_at', 'tanggal_transaksi')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('pelanggan_id')
            ->get();
            
        $transaksiPerPelanggan = [];
        foreach ($transaksiData as $transaksi) {
            $pelangganId = $transaksi->pelanggan_id;

            if (!isset($transaksiPerPelanggan[$pelangganId])) {
                $transaksiPerPelanggan[$pelangganId] = [
                    'lastTransactionDate' => null,
                    'frequency' => 0,
                    'monetary' => 0,
                ];
            }

            $transaksiPerPelanggan[$pelangganId]['frequency'] += 1;
            $transaksiPerPelanggan[$pelangganId]['monetary'] += $transaksi->total_harga;

            if (is_null($transaksiPerPelanggan[$pelangganId]['lastTransactionDate']) || $transaksi->tanggal_transaksi > $transaksiPerPelanggan[$pelangganId]['lastTransactionDate']) {
                $transaksiPerPelanggan[$pelangganId]['lastTransactionDate'] = $transaksi->tanggal_transaksi;
            }
        }
        
        $dataCollection = [];
        foreach ($transaksiPerPelanggan as $pelangganId => $dataPelanggan) {
            if (is_null($pelangganId)) {
                Log::warning("Pelanggan ID null ditemukan, data RFM tidak akan disimpan");
                continue;
            }

            $recency = Carbon::parse($dataPelanggan['lastTransactionDate'])->diffInDays($endDate);
            $frequency = $dataPelanggan['frequency'];
            $monetary = $dataPelanggan['monetary'];

            $dataCollection[] = [
                'pelanggan_id' => $pelangganId,
                'recency' => $recency,
                'frequency' => $frequency,
                'monetary' => $monetary,
            ];
        }
        
        return $dataCollection;
    }

}