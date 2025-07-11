<?php

namespace App\Filament\Resources\KMeansResource\Pages;

use App\Filament\Resources\KMeansResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKMeans extends EditRecord
{
    protected static string $resource = KMeansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
