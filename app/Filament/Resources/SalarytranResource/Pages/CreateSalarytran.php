<?php

namespace App\Filament\Resources\SalarytranResource\Pages;

use App\Filament\Resources\SalarytranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSalarytran extends CreateRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
    public static ?string $title = 'ادراج مرتب';
    protected static string $resource = SalarytranResource::class;
}
