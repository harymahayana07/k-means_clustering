<?php

namespace App\Filament\Pages;

use Filament\Resources\Pages\CreateRecord;

abstract class RytechCreateRecord extends CreateRecord
{
    /**
     * Override redirect setelah sukses create:
     * selalu ke index dari Resource yang dipakai.
     */
    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}
