<?php

namespace App\Filament\Resources\ProdukResource\Pages;

use App\Filament\Resources\ProdukResource;
use App\Imports\ImportProduks;
use App\Models\Produk;
use Filament\Actions;
use Illuminate\Contracts\View\View;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListProduks extends ListRecords
{
    protected static string $resource = ProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $data['master'] = 'List Master Produk';
        $data['judul'] = 'Produk';
        return view('filament.custom.upload-file', compact('data'));
    }

    public $file = '';

    public function save(){
        if($this->file != '') {
            Excel::import(new ImportProduks, $this->file);
        }
    }

}
