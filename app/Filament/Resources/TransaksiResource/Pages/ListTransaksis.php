<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use App\Imports\ImportTransaksis;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    public function getHeader(): ?View
    {
        $data['master'] = 'List Master Transaksi';
        $data['judul'] = 'Transaksi';
        return view('filament.custom.upload-file', compact('data'));
    }

    public $file = '';

    public function save()
    {
        if ($this->file != '') {
            Excel::import(new ImportTransaksis, $this->file);
        }
    }
}
