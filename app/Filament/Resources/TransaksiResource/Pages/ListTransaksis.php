<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use App\Imports\ImportTransaksis;
use App\Models\Transaksi;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    /**
     * Inisialisasi data saat halaman pertama kali dimuat.
     */
    public function getHeader(): ?View
    {
        $data['master'] = 'List Transaksi';
        $data['judul'] = 'Transaksi';
        return view('filament.custom.transaksi-header-custome', compact('data'));
    }
    
    /**
     * Unggah file baru dan prosesnya.
     */
    public $file = '';

    public function save()
    {
        if ($this->file) {
            Excel::import(new ImportTransaksis, $this->file);
            $this->file = '';
        }
    }
}
