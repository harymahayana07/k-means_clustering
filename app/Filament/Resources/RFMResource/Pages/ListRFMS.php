<?php

namespace App\Filament\Resources\RFMResource\Pages;

use App\Filament\Resources\RFMResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

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
        $data = Actions\CreateAction::make();
        $tab['master'] = 'Recency Frequency Monetary';
        $tab['judul'] = 'RFM';
        return view('filament.custom.header-rfm', compact('data','tab'));
    }
}
