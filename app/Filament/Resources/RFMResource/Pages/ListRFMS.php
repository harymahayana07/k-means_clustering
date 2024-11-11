<?php

namespace App\Filament\Resources\RFMResource\Pages;

use App\Filament\Resources\RFMResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

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
}
