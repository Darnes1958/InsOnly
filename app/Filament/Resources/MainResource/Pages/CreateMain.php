<?php

namespace App\Filament\Resources\MainResource\Pages;

use App\Filament\Resources\MainResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMain extends CreateRecord
{
    protected static string $resource = MainResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}
