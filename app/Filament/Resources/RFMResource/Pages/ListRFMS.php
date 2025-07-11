<?php

namespace App\Filament\Resources\RFMResource\Pages;

use App\Filament\Resources\RFMResource;
use App\Models\RFM;
use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class ListRFMS extends ListRecords
{
    protected static string $resource = RFMResource::class;
    protected static ?string $navigationLabel = 'RFM';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $data['master'] = 'RFM Analisis Model';
        $data['judul'] = 'Perhitungan Recency Frequency Monetary';
        return view('filament.custom.header-rfm', compact('data'));
    }

    public $start_date = '';
    public $end_date = '';

    public function calculateRFM()
    {
        RFM::truncate();

        $startDate = $this->start_date;
        $endDate = $this->end_date;

        $transaksiData = Transaksi::select('pelanggan_id', 'total_harga', 'tanggal_transaksi')
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

            if (
                is_null($transaksiPerPelanggan[$pelangganId]['lastTransactionDate']) ||
                $transaksi->tanggal_transaksi > $transaksiPerPelanggan[$pelangganId]['lastTransactionDate']
            ) {
                $transaksiPerPelanggan[$pelangganId]['lastTransactionDate'] = $transaksi->tanggal_transaksi;
            }
        }

        $recencyValues = [];
        $frequencyValues = [];
        $monetaryValues = [];

        foreach ($transaksiPerPelanggan as $pelangganId => $dataPelanggan) {
            $recency = Carbon::parse($dataPelanggan['lastTransactionDate'])->diffInDays(Carbon::parse($endDate));
            $frequency = $dataPelanggan['frequency'];
            $monetary = $dataPelanggan['monetary'];

            $recencyValues[] = $recency;
            $frequencyValues[] = $frequency;
            $monetaryValues[] = $monetary;

            $transaksiPerPelanggan[$pelangganId]['recency'] = $recency;
            $transaksiPerPelanggan[$pelangganId]['frequency'] = $frequency;
            $transaksiPerPelanggan[$pelangganId]['monetary'] = $monetary;
        }

        $recencyQuartiles = $this->calculateQuartiles($recencyValues);
        $frequencyQuartiles = $this->calculateQuartiles($frequencyValues);
        $monetaryQuartiles = $this->calculateQuartiles($monetaryValues);

        $dataCollection = [];
        foreach ($transaksiPerPelanggan as $pelangganId => $dataPelanggan) {
            $recencyScore = $this->getQuartileScore($dataPelanggan['recency'], $recencyQuartiles, 'low');
            $frequencyScore = $this->getQuartileScore($dataPelanggan['frequency'], $frequencyQuartiles, 'high');
            $monetaryScore = $this->getQuartileScore($dataPelanggan['monetary'], $monetaryQuartiles, 'high');

            $rfmScore = "{$recencyScore}{$frequencyScore}{$monetaryScore}";

            $dataCollection[] = [
                'pelanggan_id' => $pelangganId,
                'recency' => $dataPelanggan['recency'],
                'frequency' => $dataPelanggan['frequency'],
                'monetary' => $dataPelanggan['monetary'],
                'rfm_score' => (int) $rfmScore,
            ];
        }

        if (!empty($dataCollection)) {
            RFM::insert($dataCollection);

            Notification::make()
                ->title('Sukses Menghitung Recency Frequency Monetary')
                ->success()
                ->send();
            return;

        }

        return $dataCollection;
    }

    /**
     * Hitung kuartil untuk array nilai
     */
    protected function calculateQuartiles(array $values): array
    {
        sort($values);
        $count = count($values);

        return [
            'Q1' => $values[(int) floor(($count - 1) * 0.25)],
            'Q2' => $values[(int) floor(($count - 1) * 0.5)], 
            'Q3' => $values[(int) floor(($count - 1) * 0.75)],
        ];
    }

    /**
     * Dapatkan skor berdasarkan kuartil
     */
    protected function getQuartileScore($value, $quartiles, $order = 'low'): int
    {
        if ($order === 'low') {
            if ($value <= $quartiles['Q1']) {
                return 5;
            } elseif ($value <= $quartiles['Q2']) {
                return 4;
            } elseif ($value <= $quartiles['Q3']) {
                return 3;
            } else {
                return 2;
            }
        } else {
            if ($value >= $quartiles['Q3']) {
                return 5;
            } elseif ($value >= $quartiles['Q2']) {
                return 4;
            } elseif ($value >= $quartiles['Q1']) {
                return 3;
            } else {
                return 2;
            }
        }
    }

}
