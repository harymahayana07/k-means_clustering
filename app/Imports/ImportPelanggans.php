<?php

namespace App\Imports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPelanggans implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pelanggan([
           'id' => $row[0],
           'no_pelanggan' => $row[1],
           'nama_pelanggan' => $row[2],
        ]);
    }
}
