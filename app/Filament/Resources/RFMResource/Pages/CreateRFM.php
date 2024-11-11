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

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Ambil `start_date` dan `end_date` dari data form
    //     $startDate = $data['start_date'];
    //     $endDate = $data['end_date'];

    //     // Ambil semua transaksi dalam periode waktu yang ditentukan
    //     $transaksiData = Transaksi::whereBetween('created_at', [$startDate, $endDate])
    //         ->get()
    //         ->groupBy('pelanggan_id'); // Group berdasarkan pelanggan_id untuk menghindari N+1

    //     // Loop melalui setiap pelanggan dan hitung nilai RFM
    //     foreach ($transaksiData as $pelangganId => $transaksi) {
    //         // Pastikan pelanggan_id tidak null atau kosong
    //         if (!$pelangganId) {
    //             Log::error("Pelanggan ID kosong atau null untuk transaksi dalam rentang waktu ini", ['start_date' => $startDate, 'end_date' => $endDate]);
    //             continue; // Lewati pelanggan yang tidak valid
    //         }

    //         // 1. Hitung Recency (selisih hari dari transaksi terakhir ke `end_date`)
    //         $lastTransactionDate = $transaksi->max('created_at'); // Mendapatkan tanggal transaksi terakhir
    //         $recency = Carbon::parse($lastTransactionDate)->diffInDays($endDate);

    //         // 2. Hitung Frequency (jumlah transaksi dalam periode waktu)
    //         $frequency = $transaksi->count();

    //         // 3. Hitung Monetary (total pengeluaran dalam periode waktu)
    //         $monetary = $transaksi->sum('total_harga');

    //         // Log hasil perhitungan RFM untuk setiap pelanggan
    //         Log::info('RFM calculated for pelanggan', [
    //             'pelanggan_id' => $pelangganId,
    //             'recency' => $recency,
    //             'frequency' => $frequency,
    //             'monetary' => $monetary,
    //         ]);

    //         // Simpan hasil perhitungan RFM untuk pelanggan ini dengan try-catch
    //         try {
    //             RFM::create([
    //                 'pelanggan_id' => $pelangganId,
    //                 'recency' => $recency,
    //                 'frequency' => $frequency,
    //                 'monetary' => $monetary,
    //             ]);
    //         } catch (\Exception $e) {
    //             Log::error("Gagal menyimpan RFM untuk pelanggan_id: $pelangganId", [
    //                 'pelanggan_id' => $pelangganId,
    //                 'recency' => $recency,
    //                 'frequency' => $frequency,
    //                 'monetary' => $monetary,
    //                 'error' => $e->getMessage(),
    //             ]);
    //         }
    //     }

    //     return $data;
    // }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil `start_date` dan `end_date` dari data form
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];

        // Ambil hanya kolom yang diperlukan untuk menghindari N+1
        $transaksiData = Transaksi::select('pelanggan_id', 'total_harga', 'created_at')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('pelanggan_id') // Memastikan data terurut berdasarkan pelanggan_id untuk pemrosesan lebih mudah
            ->get();

        // Inisialisasi array untuk menyimpan data transaksi per pelanggan
        $transaksiPerPelanggan = [];
        foreach ($transaksiData as $transaksi) {
            $pelangganId = $transaksi->pelanggan_id;
            
            // Inisialisasi array untuk pelanggan jika belum ada
            if (!isset($transaksiPerPelanggan[$pelangganId])) {
                $transaksiPerPelanggan[$pelangganId] = [
                    'lastTransactionDate' => null,
                    'frequency' => 0,
                    'monetary' => 0,
                ];
            }
            
            // Perbarui data transaksi untuk pelanggan ini
            $transaksiPerPelanggan[$pelangganId]['frequency'] += 1;
            $transaksiPerPelanggan[$pelangganId]['monetary'] += $transaksi->total_harga;
            
            // Perbarui tanggal transaksi terakhir jika transaksi ini lebih baru
            if (is_null($transaksiPerPelanggan[$pelangganId]['lastTransactionDate']) || $transaksi->created_at > $transaksiPerPelanggan[$pelangganId]['lastTransactionDate']) {
                $transaksiPerPelanggan[$pelangganId]['lastTransactionDate'] = $transaksi->created_at;
            }
        }

        // Loop melalui data transaksi per pelanggan untuk menghitung dan menyimpan RFM
        foreach ($transaksiPerPelanggan as $pelangganId => $dataPelanggan) {

            if (is_null($pelangganId)) {
                Log::warning("Pelanggan ID null ditemukan, data RFM tidak akan disimpan");
                continue; // Lewati jika pelanggan_id tidak valid
            }

            // Hitung Recency dari tanggal transaksi terakhir
            $recency = Carbon::parse($dataPelanggan['lastTransactionDate'])->diffInDays($endDate);

            // Ambil frequency dan monetary dari data yang sudah dihitung
            $frequency = $dataPelanggan['frequency'];
            $monetary = $dataPelanggan['monetary'];
            

            // Simpan hasil perhitungan RFM untuk pelanggan ini
            try {
                RFM::create([
                    'pelanggan_id' => $pelangganId,
                    'recency' => $recency,
                    'frequency' => $frequency,
                    'monetary' => $monetary,
                ]);
            } catch (\Exception $e) {
                Log::error("Gagal menyimpan RFM untuk pelanggan_id: $pelangganId", [
                    'pelanggan_id' => $pelangganId,
                    'recency' => $recency,
                    'frequency' => $frequency,
                    'monetary' => $monetary,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $data;
    }

}