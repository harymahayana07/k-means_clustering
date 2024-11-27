<?php

namespace App\Filament\Resources\HasilKmeansResource\Pages;

use App\Filament\Resources\HasilKmeansResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHasilKmeans extends EditRecord
{
    protected static string $resource = HasilKmeansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
