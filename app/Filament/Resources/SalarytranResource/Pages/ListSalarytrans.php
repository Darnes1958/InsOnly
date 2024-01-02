<?php

namespace App\Filament\Resources\SalarytranResource\Pages;

use App\Filament\Resources\SalarytranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalarytrans extends ListRecords
{
    protected static string $resource = SalarytranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
