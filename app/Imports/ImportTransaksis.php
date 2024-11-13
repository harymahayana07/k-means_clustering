<?php

namespace App\Imports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class ImportTransaksis implements ToModel, WithMapping
{
    /**
     * @param array $row
     * @return array
     */
    public function map($row): array
    {
        $tanggal_transaksi = is_numeric($row[2])
            ? Carbon::createFromFormat('Y-m-d', '1899-12-30')->addDays($row[2])->format('Y-m-d')
            : Carbon::createFromFormat('m/d/Y', $row[2])->format('Y-m-d');

        return [
            'pelanggan_id' => $row[1],
            'tanggal_transaksi' => $tanggal_transaksi,
            'produk_id' => $row[3],
            'jumlah' => $row[4],
            'harga' => $row[5],
            'total_harga' => $row[6],
        ];
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Transaksi([
            'pelanggan_id' => $row['pelanggan_id'],
            'tanggal_transaksi' => $row['tanggal_transaksi'],
            'produk_id' => $row['produk_id'],
            'jumlah' => $row['jumlah'],
            'harga' => $row['harga'],
            'total_harga' => $row['total_harga'],
        ]);
    }
}
