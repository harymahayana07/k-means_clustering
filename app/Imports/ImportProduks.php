<?php

namespace App\Imports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportProduks implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Produk([
           'nama_produk' => $row[0],
           'kategori_id' => $row[1],
           'harga' => $row[2],
        ]);
    }
}
