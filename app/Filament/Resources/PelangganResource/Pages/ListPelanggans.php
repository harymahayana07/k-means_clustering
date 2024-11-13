<?php

namespace App\Filament\Resources\PelangganResource\Pages;

use App\Filament\Resources\PelangganResource;
use App\Imports\ImportPelanggans;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ListPelanggans extends ListRecords
{
    protected static string $resource = PelangganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $data['master'] = 'List Master Pelanggan';
        $data['judul'] = 'Pelanggan';
        return view('filament.custom.upload-file', compact('data'));
    }

    public $file = '';

    public function save()
    {
        if ($this->file != '') {
            Excel::import(new ImportPelanggans, $this->file);
        }
    }

}
