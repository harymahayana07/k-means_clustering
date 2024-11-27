<?php

namespace App\Filament\Resources\ReportingResource\Pages;

use App\Filament\Resources\ReportingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReporting extends EditRecord
{
    protected static string $resource = ReportingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
