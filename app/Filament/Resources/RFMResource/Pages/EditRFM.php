<?php

namespace App\Filament\Resources\RFMResource\Pages;

use App\Filament\Resources\RFMResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRFM extends EditRecord
{
    protected static string $resource = RFMResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
