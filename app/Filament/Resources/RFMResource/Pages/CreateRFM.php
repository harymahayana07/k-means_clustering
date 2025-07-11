<?php

namespace App\Filament\Resources\RFMResource\Pages;

use App\Filament\Pages\RytechCreateRecord;
use App\Filament\Resources\RFMResource;
use App\Models\RFM;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CreateRFM extends RytechCreateRecord
{
    protected static string $resource = RFMResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'RFM Record Created Successfully!';
    }

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

            $recencyScore = $this->calculateRecencyScore($recency);
            $frequencyScore = $this->calculateFrequencyScore($frequency);
            $monetaryScore = $this->calculateMonetaryScore($monetary);

            $rfmScore = "{$recencyScore}{$frequencyScore}{$monetaryScore}";

            $dataCollection[] = [
                'pelanggan_id' => $pelangganId,
                'recency' => $recency,
                'frequency' => $frequency,
                'monetary' => $monetary,
                'rfm_score' => (int) $rfmScore,
            ];
        }

        return $dataCollection;
    }
    
    /**
     * Calculate Recency Score
     */
    protected function calculateRecencyScore(int $recency): int
    {
        if ($recency <= 7) {
            return 5; // Pelanggan sangat baru
        } elseif ($recency <= 30) {
            return 4;
        } elseif ($recency <= 90) {
            return 3;
        } elseif ($recency <= 180) {
            return 2;
        }
        return 1; // Pelanggan lama
    }

    /**
     * Calculate Frequency Score
     */
    protected function calculateFrequencyScore(int $frequency): int
    {
        if ($frequency >= 10) {
            return 5; // Pelanggan sangat aktif
        } elseif ($frequency >= 5) {
            return 4;
        } elseif ($frequency >= 3) {
            return 3;
        } elseif ($frequency >= 2) {
            return 2;
        }
        return 1; // Pelanggan tidak aktif
    }

    /**
     * Calculate Monetary Score
     */
    protected function calculateMonetaryScore(float $monetary): int
    {
        if ($monetary >= 1000000) {
            return 5; // Pelanggan dengan pengeluaran besar
        } elseif ($monetary >= 500000) {
            return 4;
        } elseif ($monetary >= 200000) {
            return 3;
        } elseif ($monetary >= 100000) {
            return 2;
        }
        return 1; // Pelanggan dengan pengeluaran kecil
    }

}
